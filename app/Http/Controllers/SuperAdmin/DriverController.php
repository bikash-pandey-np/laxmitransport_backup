<?php

namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\DriverDataTable;
use App\DataTables\SuperAdmin\TripMonterDataTable;
use App\Jobs\DriverCreateJob;
use App\Mail\DriverCreateMail;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class DriverController extends SuperAdminBaseController
{
    public $view_path = "driver";
    public $base_route = "driver";
    public $title = "Driver";

    public function __construct(Driver $model)
    {
        $this->model = $model;
    }

    public function index(DriverDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function create()
    {
        return view(parent::__loadView('create'));
    }

    public function track($id)
    {
        if (!$row = $this->model->find($id)){
            abort(404);
        }

        return view(parent::__loadView('track'),compact('row'));
    }

    public function allTrack()
    {
        return view(parent::__loadView('all_track'));
    }

    public function tripMonter(TripMonterDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('trip_monter'));
    }

    public function store(Request $request)
    {
        $this->dataValidation($request);

        foreach (config('form.driver') as $name => $vendor) {
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
        $rules['unit_number'] = "required|unique:drivers,unit_number";

        $request->validate($rules);

        $allData = $request->all();

        if (isset($allData['image'])){
            $allData['image'] = $this->imageUploadByThumb($allData['image']);
        }
        if (isset($allData['front_citizenship'])){
            $allData['front_citizenship'] = $this->imageUploadByThumb($allData['front_citizenship']);
        }
        if (isset($allData['back_citizenship'])){
            $allData['back_citizenship'] = $this->imageUploadByThumb($allData['back_citizenship']);
        }
        if (isset($allData['front_license'])){
            $allData['front_license'] = $this->imageUploadByThumb($allData['front_license']);
        }
        if (isset($allData['back_license'])){
            $allData['back_license'] = $this->imageUploadByThumb($allData['back_license']);
        }

        $allData['password'] = null;
        $allData['status'] = 0;
        $allData['token'] = uniqid(rand(1000,9999));

        $driver = $this->model->create($allData);
        Mail::to($driver->email)->send(new DriverCreateMail($driver));
//        dispatch(new DriverCreateJob($driver))->delay(now());

        return $this->returnBack($request);
    }

    public function show($id)
    {
        if (!$row = $this->model->find($id)){
            abort(404);
        }

        return view(parent::__loadView('show'),compact('row'));
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

        foreach (config('form.driver') as $name => $vendor) {
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

        if ($row->unit_number !== (int) $request->unit_number){
            $rules['unit_number'] = "required|unique:drivers,unit_number,".$id;
        }

        $request->validate($rules);

        DB::beginTransaction();
        try{
            $allData = $request->all();
            if (isset($allData['password'])){
                unset($allData['password']);
            }
            if (isset($allData['status'])){
                unset($allData['status']);
            }
            if (isset($allData['token'])){
                unset($allData['token']);
            }

            if (isset($allData['image'])){
                $this->unlinkAllImage($row->image);
                $allData['image'] = $this->imageUploadByThumb($allData['image']);
            }
            if (isset($allData['front_citizenship'])){
                $this->unlinkAllImage($row->front_citizenship);
                $allData['front_citizenship'] = $this->imageUploadByThumb($allData['front_citizenship']);
            }
            if (isset($allData['back_citizenship'])){
                $this->unlinkAllImage($row->back_citizenship);
                $allData['back_citizenship'] = $this->imageUploadByThumb($allData['back_citizenship']);
            }
            if (isset($allData['front_license'])){
                $this->unlinkAllImage($row->front_license);
                $allData['front_license'] = $this->imageUploadByThumb($allData['front_license']);
            }
            if (isset($allData['back_license'])){
                $this->unlinkAllImage($row->back_license);
                $allData['back_license'] = $this->imageUploadByThumb($allData['back_license']);
            }
            if (isset($allData['social_security_image'])){
                $this->unlinkAllImage($row->social_security_image);
                $allData['social_security_image'] = $this->imageUploadByThumb($allData['social_security_image']);
            }

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
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'nullable|date_format:m/d/Y',
            'mobile_number' => 'required',
//            'mobile_number' => 'required|regex:/^\d{10}$/',
            'email' => 'required|email|unique:admins,email,'.$id,
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

        if (count($row->works)>0){
            return redirect()->back()->with('error', 'The driver use on works');
        }

        if (count($row->vehicles)>0){
            return redirect()->back()->with('error', 'The driver use on vehicles');
        }

        $this->unlinkAllImage($row->image);
        $this->unlinkAllImage($row->front_citizenship);
        $this->unlinkAllImage($row->back_citizenship);

        $row->delete();

        return redirect()->back()->with('success', $this->title . ' Delete Successful.');
    }

    public function login($id)
    {
        if (!$row = $this->model->find($id)){
            abort(404);
        }

        if ($row->admin_can_login == 0){
//            abort(403);
        }

        auth('driver')->login($row);
        return redirect('driver/dashboard');
    }
}
