<?php

namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\WorkStatusDataTable;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Work;
use App\Models\WorkLocation;
use App\Models\WorkStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends SuperAdminBaseController
{
    public $view_path = "work_status";
    public $base_route = "configuration.status";
    public $title = "Status";

    public function __construct(WorkStatus $model)
    {
        $this->model = $model;
    }

    public function index(WorkStatusDataTable $dataTable)
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
            "title" => "required",
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
}
