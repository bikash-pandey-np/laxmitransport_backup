<?php

namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\BidingDataTable;
use App\Models\Biding;
use App\Models\BidingUser;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Work;
use App\Models\WorkLocation;
use App\Models\WorkUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidingController extends SuperAdminBaseController
{
    public $view_path = "biding";
    public $base_route = "biding";
    public $title = "Biding";

    public function __construct(Biding $model)
    {
        $this->model = $model;
    }

    public function index(BidingDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function create()
    {
        $drivers = Driver::select(['drivers.id as id', 'first_name', 'last_name'])
            ->get();

        $lastDriver = [];
        $driverId = [];
        foreach ($drivers as $driver) {
//            if (!in_array($driver['id'],$driverId)){
            array_push($driverId, $driver['id']);
            array_push($lastDriver, $driver);
//            }
        }

        $drivers = $lastDriver;

        $vehicles = Vehicle::get(['id', 'vehicle_id', 'vehicle_type']);
        return view(parent::__loadView('create'), compact('drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $this->dataValidation($request);

        $allData = $request->all();
        $allData['status'] = 'on_site';
        $allData['work_id'] = $this->getWorkId();
//        if (!Work::where('work_id', $allData['work_id'])->first()) {
            $work = $this->model->create($allData);
            if (isset($request->location) && count($request->location) > 0) {
                foreach ($request->location as $location) {
                    $location['work_id'] = $work->id;
                    WorkLocation::create($location);
                }
            }

            $tokens = Driver::where('device_token','!=',null)->pluck('device_token')->toArray();
            fireBaseNotificationForCreateBiding($tokens,"Create new bidding",$work);

            return $this->returnBack($request);
//        }else{
//            return redirect()->back()->with('error','Something want wrong.');
//        }
    }

    public function getWorkId()
    {
        if ($oldWorkId = Work::orderBy('id', 'DESC')->pluck('work_id')->first()) {
            $arr = explode('SE', $oldWorkId);
            if (isset($arr[1])) {
                return 'SE' . ((int)$arr[1] + 1);
            }
        }

        return 'SE100';
    }

    public function show($id)
    {
        if (!$row = $this->model->find($id)) {
            abort(404);
        }

        return view(parent::__loadView('show'), compact('row'));
    }

    public function edit($id)
    {
        if (!$row = $this->model->find($id)) {
            abort(404);
        }
        $drivers = Driver::get(['id', 'first_name', 'last_name']);
        $vehicles = Vehicle::get(['id', 'vehicle_id', 'vehicle_type']);
        return view(parent::__loadView('edit'), compact('row', 'drivers', 'vehicles'));
    }

    public function update(Request $request, $id)
    {
        if (!$row = $this->model->find($id)) {
            abort(404);
        }

        $this->dataValidation($request, $id);

        DB::beginTransaction();
        try {
            $allData = $request->all();
            if (isset($allData['password'])) {
                unset($allData['password']);
            }
            if (isset($allData['status'])) {
                unset($allData['status']);
            }
            if (isset($allData['_token'])) {
                unset($allData['_token']);
            }
            if (isset($allData['_method'])) {
                unset($allData['_method']);
            }

            if (isset($allData['image'])) {
                $this->unlinkAllImage($row->image);
                $allData['image'] = $this->imageUploadByThumb($allData['image']);
            }
            if (isset($allData['front_citizenship'])) {
                $this->unlinkAllImage($row->front_citizenship);
                $allData['front_citizenship'] = $this->imageUploadByThumb($allData['front_citizenship']);
            }
            if (isset($allData['back_citizenship'])) {
                $this->unlinkAllImage($row->back_citizenship);
                $allData['back_citizenship'] = $this->imageUploadByThumb($allData['back_citizenship']);
            }

            $row->update($allData);

            $oldIds = [];
            if (isset($request->location) && count($request->location) > 0) {
                foreach ($request->location as $key => $location) {
                    if (isset($location->id) && $data = WorkLocation::where($location->id)) {
                        $data->update($location);
                        array_push($oldIds, $location->id);
                    } else {
                        $location['work_id'] = $row->id;
                        $location = WorkLocation::create($location);
                        array_push($oldIds, $location->id);
                    }
                }
            }

            WorkLocation::where('work_id', $row->id)->whereNotIn('id', $oldIds)->delete();

            DB::commit();
            return $this->returnBackUpdate($request);
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500);
        }
    }

    public function dataValidation($request, $id = null)
    {
        $rule = [
            'drop_address' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'miles' => 'nullable|string|max:255',
            'pickup_address' => 'nullable|string|max:255'
        ];

        $this->validate($request, $rule, [
            'amount.max' => 'Amount is not valid',
            'pieces.max' => 'Pieces is not valid',
        ]);
    }

    public function destroy($id)
    {
        if (!$row = $this->model->find($id)) {
            abort(404);
        }

        $this->unlinkAllImage($row->image);
        $this->unlinkAllImage($row->front_citizenship);
        $this->unlinkAllImage($row->back_citizenship);

        $row->delete();

        return redirect()->back()->with('success', $this->title . ' Delete Successful.');
    }

    public function bidApproved($id)
    {
        if (!$bidUser = BidingUser::with('work')->find($id)){
            abort(404);
        }

        if (!$biding = WorkUpdate::find($bidUser->work_id)){
            abort(404);
        }

        $biding->update([
            'driver_id' => $bidUser->driver_id,
            'amount' => $bidUser->amount
        ]);

        foreach ($bidUser->work->bidingUsers as $bidingUserdelete) {
            $bidingUserdelete->delete();
        }

        return redirect()->route('super_admin.work.index');
    }

    public function approve($id)
    {
        if (!$work = $this->model->find($id)) {
            abort(404);
        }

        if ($work->status == 'on_site') {
            $work->update([
                'status' => 'picked_up',
                'admin_status_approved' => 1
            ]);
        } else if ($work->status == 'picked_up') {
            $work->update([
                'status' => 'delivery',
                'admin_status_approved' => 1
            ]);
        }
        return redirect()->back()->with('success', 'Approve Status');
    }

    public function reject($id)
    {
        if (!$work = $this->model->find($id)) {
            abort(404);
        }

        $work->update([
            'admin_status_approved' => 1
        ]);

        return redirect()->back()->with('success', 'Reject Status');
    }

    public function addLocation()
    {
        $uniqueId = uniqid();
        return view(parent::__loadView('ajax.location'), compact('uniqueId'));
    }
}
