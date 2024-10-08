<?php

namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\PayrollDataTable;
use App\Models\Payroll;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Work;
use App\Models\WorkLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends SuperAdminBaseController
{
    public $view_path = "payroll";
    public $base_route = "account.payroll";
    public $title = "Payroll";

    public function __construct(Payroll $model)
    {
        $this->model = $model;
    }

    public function index(PayrollDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function create()
    {
        $row = $this->model->where('work_id',request('id'))->first();
        return view(parent::__loadView('create'), compact('row'));
    }

    public function store(Request $request)
    {
        $this->dataValidation($request);
        $allData = $request->all();
        if (!$row = $this->model->where('work_id',$request->work_id)->first()){
            $row = $this->model->create($allData);
        }
        $row->update($allData);

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
        $works = Work::get();
        return view(parent::__loadView('edit'), compact('row', 'works'));
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
            "work_id" => "required|exists:works,id",
            "date" => "required|date_format:m/d/Y"
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
