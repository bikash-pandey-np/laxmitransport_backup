<?php

namespace App\Http\Controllers\Admin;


use App\DataTables\Admin\VehicleDataTable;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VehicleController extends AdminBaseController
{
    public $view_path = "vehicle";
    public $base_route = "vehicle";
    public $title = "Vehicle";

    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    public function index(VehicleDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function create()
    {
        return view(parent::__loadView('create'));
    }

    public function store(Request $request)
    {
        $allData = config('vendor');
        $rules = [];
        foreach (config('form.vehicle') as $name => $vendor) {
            if ($vendor == 'number'){
                $rules[$name] = 'nullable|numeric';
            }elseif($vendor == 'yes_no'){
                $rules[$name] = [
                    'nullable',
                    Rule::in(['yes','no'])
                ];
            }elseif($vendor == 'datepicker'){
                $rules[$name] = 'nullable|date_format:m/d/Y';
            }else{
                $rules[$name] = 'nullable';
            }
        }

        $rules['vehicle_id'] = 'required';

        $request->validate($rules);

        $this->model->create($request->all());

        return redirect()->back()->with('vehicle created successful.');
    }

    public function edit($id)
    {
        if (!$row = $this->model->find($id)){
            abort(404);
        }

        return view(parent::__loadView('edit'),compact('row'));
    }

    public function update(Request $request,$id)
    {
        if (!$row = $this->model->find($id)){
            abort(404);
        }

        $this->dataValidation($request,$id);

        DB::beginTransaction();
        try{
            $allData = $request->all();
            $row->update($allData);

            DB::commit();
            return $this->returnBackUpdate($request);
        }catch (\Exception $e){
            DB::rollBack();
            abort(500);
        }
    }

    public function dataValidation($request,$id=null)
    {
        $rule = [
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'mobile_number' => 'required|regex:/^\d{10}$/',
//            'email' => 'required|email|unique:admins,email,'.$id,
        ];

        $this->validate($request, $rule,[
            'mobile_number.regex' => 'Enter the valid mobile number.'
        ]);
    }

    public function destroy($id)
    {
        if (!$row = $this->model->find($id)){
            abort(404);
        }

        $row->delete();

        return redirect()->back()->with('success', $this->title . ' Delete Successful.');
    }
}
