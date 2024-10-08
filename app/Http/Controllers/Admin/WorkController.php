<?php

namespace App\Http\Controllers\Admin;


use App\DataTables\Admin\WorkDataTable;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Work;
use App\Models\WorkLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class WorkController extends AdminBaseController
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
        $drivers = Driver::get(['id', 'first_name', 'last_name']);
        $vehicles = Vehicle::get(['id','vehicle_id','vehicle_type']);
        return view(parent::__loadView('create'), compact('drivers', 'vehicles'));
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

    public function store(Request $request)
    {
        $this->dataValidation($request);

        $allData = $request->all();
        $allData['status'] = 'on_site';
        $allData['work_id'] = $this->getWorkId();

//        if (Work::where('work_id', $allData['work_id'])->first()) {
//            return redirect()->back()->with('error','Something want wrong.');
//        }

        $work = $this->model->create($allData);
        if (isset($request->location) && count($request->location)>0){
            foreach ($request->location as $location) {
                $location['work_id'] = $work->id;
                WorkLocation::create($location);
            }
        }

        return $this->returnBack($request);
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
        $vehicles = Vehicle::get(['id','vehicle_id','vehicle_type']);
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
            if (isset($request->location) && count($request->location)>0){
                foreach ($request->location as $key => $location) {
                    if (isset($location->id) && $data = WorkLocation::where($location->id)){
                        $data->update($location);
                        array_push($oldIds,$location->id);
                    }else{
                        $location['work_id'] = $row->id;
                        $location = WorkLocation::create($location);
                        array_push($oldIds,$location->id);
                    }
                }
            }

            WorkLocation::where('work_id', $row->id)->whereNotIn('id',$oldIds)->delete();

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
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'amount' => 'required|numeric|max:90000000000',
            'drop_address' => 'nullable|string|max:255',
//            'pieces' => 'required|numeric|max:90000000000',
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
        }else if ($work->status == 'picked_up') {
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
