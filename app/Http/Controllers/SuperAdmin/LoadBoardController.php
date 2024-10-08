<?php

namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\ApplierLoadBoardDataTable;
use App\DataTables\SuperAdmin\AwardedLoadBoardDataTable;
use App\DataTables\SuperAdmin\LoadBoardCompleteDataTable;
use App\DataTables\SuperAdmin\LoadBoardDataTable;
use App\DataTables\SuperAdmin\LoadBoardTriPMonitorDataTable;
use App\Models\LoadBoard;
use App\Models\Driver;
use App\Models\LoadBoardUser;
use App\Models\Vehicle;
use App\Models\Work;
use App\Models\WorkLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoadBoardController extends SuperAdminBaseController
{
    public $view_path = "loadboard";
    public $base_route = "loadboard";
    public $title = "Load Board";

    public function __construct(LoadBoard $model)
    {
        $this->model = $model;
    }

    public function index(LoadBoardDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function applier(ApplierLoadBoardDataTable $dataTable)
    {
        $this->title = "Appliers";
        return $dataTable->render(parent::__loadView('index'));
    }

    public function awarded(AwardedLoadBoardDataTable $dataTable)
    {
        $this->title = "Awardeds";
        return $dataTable->render(parent::__loadView('index'));
    }

    public function tripMonitor(LoadBoardTriPMonitorDataTable $dataTable)
    {
        $this->title = "Trip Monitor";
        return $dataTable->render(parent::__loadView('index'));
    }

    public function complete(LoadBoardCompleteDataTable $dataTable)
    {
        $this->title = "Complete";
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
        $vehicles = Vehicle::get(['id', 'vehicle_type']);

        $token = Driver::pluck('device_token')->toArray();
        fireBaseJustNotification($token, "Bid Available","New bidding available.");

        return view(parent::__loadView('create'), compact('drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $this->dataValidation($request);
        $allData = $request->all();
        $this->model->create($allData);
        return $this->returnBack($request);
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
        $vehicles = Vehicle::get(['id', 'vehicle_type']);
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
            if (isset($allData['token'])) {
                unset($allData['token']);
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
                        dd('update');
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
            "pickup_date" => "nullable|date_format:m/d/Y",
            "pickup_time" => "nullable|date_format:H:i",
            "drop_date" => "nullable|date_format:m/d/Y",
            "drop_time" => "nullable|date_format:H:i",
        ];

        $this->validate($request, $rule, [

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

    public function approve($id)
    {
        if (!$work = $this->model->find($id)) {
            abort(404);
        }

        $work->update([
            'admin_status_approved' => 1
        ]);

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

    public function approveApply($id)
    {
        if(!$loadBoardUser = LoadBoardUser::find($id)){
            abort(404);
        }

        $lb = $loadBoardUser->loadBoard;

        if ($loadBoardUser->table_type == Driver::class){
            $vehicle = Vehicle::where('driver_id',$loadBoardUser->table_id)->first();
            $token = Driver::where('id', $loadBoardUser->table_id)->pluck('device_token')->first();
            fireBaseJustNotification($token, "Bid Approve","Your bid has approved.");
        }

        $work = Work::create([
            'amount' => $loadBoardUser->amount,
            'pieces' => $lb->pieces,
            'weight' => $lb->weight,
            'miles' => $lb->miles,
            'user_type' => $loadBoardUser->table_type,
            'driver_id' => $loadBoardUser->table_id,
            'vehicle_id' => $vehicle->id ?? "",
            'admin_load_notes' => $lb->admin_note,
            'company_name' => $lb->pickup_company_name,
            'origin_destination' => $lb->pickup_city_st_zip_code,
            'drop_destination' => $lb->drop_city_st_zip_code,

            'pickup_date_time' => $lb->pickup_date." ".$lb->pickup_time,
            'pickup_city' => $lb->pickup_city_st_zip_code,
            'delivery_city' => $lb->drop_city_st_zip_code,
            'status' => 'pending',
        ]);

        WorkLocation::create([
            'work_id' => $work->id,
            'company_name' => $lb->pickup_company_name,
            'pickup_city_state_zipcode' => $lb->pickup_city_st_zip_code,
            'pickup_date' => $lb->pickup_date,
            'pickup_time' => $lb->pickup_time,

            'consignee_name' => $lb->drop_company_name,
            'drop_city_state_zipcode' => $lb->drop_city_st_zip_code,
            'drop_date' => $lb->drop_date,
            'drop_time' => $lb->drop_time,
        ]);

        $loadBoardUser->LoadBoard()->update([
            'table' => $loadBoardUser->table_type,
            'table_id' => $loadBoardUser->table_id,
            'amount' => $loadBoardUser->amount,
            'work_id' => $work->id,
        ]);

        $allLoadboardUser = LoadBoardUser::where('load_board_id',$lb->id)->get();
        foreach ($allLoadboardUser as $item) {
            $item->update([
                'status' => 'reject'
            ]);
        }

        $loadBoardUser->update([
            'status' => 'approved'
        ]);

        return redirect()->back()->with('success','User Approve');
    }

    public function rejectApply($id)
    {
        if(!$loadBoardUser = LoadBoardUser::find($id)){
            abort(404);
        }

        $loadBoardUser->update([
            'status' => 'reject'
        ]);

        return redirect()->back()->with('success','User Reject');
    }
}
