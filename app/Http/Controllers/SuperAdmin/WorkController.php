<?php

namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\WorkDataTable;
use App\Models\Carrier;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Work;
use App\Models\WorkLocation;
use App\Models\WorkTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class WorkController extends SuperAdminBaseController
{
    public $view_path = "work";
    public $base_route = "work";
    public $title = "Order";

    public function __construct(Work $model)
    {
        $this->model = $model;
    }

    public function index(WorkDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function create()
    {
        $drivers = Driver::select(['drivers.id as id', 'first_name', 'last_name'])
            ->get();

        $carriers = Carrier::get();

        $customers = Customer::select(['name', 'id'])
            ->orderBy('name', 'ASC')
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

        $notAvailableIds = Vehicle::orderBy('vehicles.created_at', 'desc')
            ->select([
                'vehicles.*'
            ])
            ->leftJoin('works', 'vehicles.id', '=', 'works.vehicle_id')
            ->whereIn('works.status', config('workstatus.trip_monitor'))
            ->pluck('id')->toArray();
        $vehicles = Vehicle::whereNotIn('id', $notAvailableIds)->whereHas('driver', function ($q) {
            return $q->whereIn('driver_status', ['available', 'Available']);
        })->where('driver_id', '!=', 0)->with('driver')->get(['id', 'vehicle_type', 'driver_id']);
        return view(parent::__loadView('create'), compact('drivers', 'vehicles', 'customers', 'carriers'));
    }

    public function store(Request $request)
    {
        $this->dataValidation($request);
        $allData = $request->all();
        $allData['status'] = Work::PENDING;
        $allData['work_id'] = $this->getWorkId();
        $driver_id = Vehicle::where('id', $request->vehicle_id)->pluck('driver_id')->first();
        if ($allData['user_type'] == Carrier::class) {
            $allData['driver_id'] = $allData['carrier_id'];
        } else {
            $allData['driver_id'] = $driver_id;
        }
        //        if (!Work::where('work_id', $allData['work_id'])->first()) {
        $work = $this->model->create($allData);

        //        $locations = $request->location_type == "single" ? $request->single_location : $request->location;
        $locations = $request->single_location;

        if (isset($locations) && count($locations) > 0) {
            foreach ($locations as $location) {
                $location['work_id'] = $work->id;
                WorkLocation::create($location);
            }
        }

        $token = Driver::where('id', $allData['driver_id'])->pluck('device_token')->first();
        fireBaseNotificationForCreateOrder($token, "Create new order", $work);

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

        $customers = Customer::select(['name', 'id'])
            ->orderBy('name', 'ASC')
            ->get();

        $carriers = Carrier::get();

        $notAvailableIds = Vehicle::orderBy('vehicles.created_at', 'desc')
            ->select([
                'vehicles.*'
            ])
            ->leftJoin('works', 'vehicles.id', '=', 'works.vehicle_id')
            ->whereIn('works.status', config('workstatus.trip_monitor'))
            ->where('vehicles.id', '!=', $row->vehicle_id)
            ->pluck('id')->toArray();
        $vehicles = Vehicle::whereNotIn('id', $notAvailableIds)->where('driver_id', '!=', 0)->with('driver')->get();
        return view(parent::__loadView('edit'), compact('row', 'drivers', 'vehicles', 'customers', 'carriers'));
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

            if (isset($allData['token'])) {
                unset($allData['token']);
            }

            $driver_id = Vehicle::where('id', $request->vehicle_id)->pluck('driver_id')->first();
            if ($allData['user_type'] == Carrier::class) {
                $allData['driver_id'] = $allData['carrier_id'];
            } else {
                $allData['driver_id'] = $driver_id;
            }

            $row->update($allData);

            $oldIds = [];

            //            if ($request->location_type == "single"){
            $locations = $request->single_location;
            //            }else{
            //                $locations = $request->location;
            //            }

            if (isset($locations) && count($locations) > 0) {
                foreach ($locations as $key => $location) {
                    if (isset($location['id']) && $data = WorkLocation::find($location['id'])) {
                        $data->update($location);
                        array_push($oldIds, $location['id']);
                    } else {
                        $location['work_id'] = $row->id;
                        $location = WorkLocation::create($location);
                        array_push($oldIds, $location['id']);
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
            'vehicle_id' => 'required|exists:vehicles,id',
            'amount' => 'required|numeric|max:90000000000',
            'drop_address' => 'nullable|string|max:255',
            //            'pieces' => 'required|numeric|max:90000000000',
            'weight' => 'nullable|string|max:255',
            'miles' => 'nullable|string|max:255',
            'pickup_address' => 'nullable|string|max:255',

        ];

        if ($request->user_type == Carrier::class) {
            $rule['vehicle_id'] = '';
            $rule['carrier_id'] = 'required|exists:carriers,id';
        }

        //        if ($request->location_type == "single"){
        $rule['single_location'] = 'required|array';
        $rule['single_location.*.company_name'] = 'required|string|max:255';
        $rule['single_location.*.consignee_name'] = 'required|string|max:255';
        //        }else{
        //            $rule['location'] = 'required|array';
        //            $rule['location.*.company_name'] = 'required|string|max:255';
        //            $rule['location.*.consignee_name'] = 'required|string|max:255';
        //        }

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

    public function trackLocationDelete($id)
    {
        if (!$data = WorkTracking::find($id)) {
            abort(404);
        }

        $data->delete();

        return redirect()->back()->with([
            'success' => 'Location deleted.',
            'type' => "track"
        ]);
    }

    public function trackLocationStore(Request $request)
    {
        $all = $request->all();
        if (isset($all['time'])) {
            $all['time'] = format_local_to_server($all['time']);
        }
        WorkTracking::create($all);
        return redirect()->back()->with([
            'success' => 'Location added.',
            'type' => "track"
        ]);
    }
}
