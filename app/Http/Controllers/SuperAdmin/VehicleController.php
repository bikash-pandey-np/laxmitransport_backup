<?php

namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\AvailableVehicleDataTable;
use App\DataTables\SuperAdmin\NotAvailableVehicleDataTable;
use App\DataTables\SuperAdmin\VehicleDataTable;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VehicleController extends SuperAdminBaseController
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

    public function available(AvailableVehicleDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function notAvailable(NotAvailableVehicleDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function create()
    {
        $existingDriverIds = Vehicle::pluck('driver_id')->toArray();
        $drivers = Driver::where('status', '!=', 'retired')->whereNotIn('id', $existingDriverIds)->get();
        return view(parent::__loadView('create'), compact('drivers'));
    }

    public function store(Request $request)
    {

        $rules = [];
        foreach (config('form.vehicle') as $name => $vendor) {
            if ($vendor == 'number') {
                $rules[$name] = 'nullable|numeric';
            } elseif ($vendor == 'yes_no') {
                $rules[$name] = [
                    'nullable',
                    Rule::in(['yes', 'no'])
                ];
            } elseif ($vendor == 'datepicker') {
                $rules[$name] = 'nullable|date_format:m/d/Y';
            } else {
                $rules[$name] = 'nullable';
            }
        }

        $rules['driver_id'] = 'required|exists:drivers,id';

        $request->validate($rules);

        $all = $request->all();
        $all['vehicle_id'] = 0;
        $this->model->create($all);

        return redirect()->back()->with('success', 'vehicle created successful.');
    }

    public function edit($id)
    {
        if (!$row = $this->model->find($id)) {
            abort(404);
        }

        $existingDriverIds = Vehicle::where('id', '!=', $id)->pluck('driver_id')->toArray();
        $drivers = Driver::where('status', '!=', 'retired')->whereNotIn('id', $existingDriverIds)->get();

        return view(parent::__loadView('edit'), compact('row', 'drivers'));
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
            $row->update($allData);

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
            //            'first_name' => 'required',
            //            'last_name' => 'required',
            //            'mobile_number' => 'required|regex:/^\d{10}$/',
            //            'email' => 'required|email|unique:admins,email,'.$id,
        ];

        $this->validate($request, $rule, [
            'mobile_number.regex' => 'Enter the valid mobile number.'
        ]);
    }

    public function destroy($id)
    {
        if (!$row = $this->model->find($id)) {
            abort(404);
        }

        $row->delete();

        return redirect()->back()->with('success', $this->title . ' Delete Successful.');
    }
}
