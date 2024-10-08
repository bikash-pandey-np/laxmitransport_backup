<?php

namespace App\Http\Controllers\SuperAdmin;

use App\DataTables\SuperAdmin\AdminDataTable;
use App\Jobs\AdminCreateJob;
use App\Mail\AdminCreateMail;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class AdminController extends SuperAdminBaseController
{
    public $view_path = "admin";
    public $base_route = "admin";
    public $title = "Admin";
    public $model;

    public function __construct(SuperAdmin $admin)
    {
        $this->model = $admin;
    }

    public function index(AdminDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function create()
    {
        return view(parent::__loadView('create'));
    }

    public function store(Request $request)
    {
        $this->dataValidation($request);
        DB::beginTransaction();
        try {
            $admin = $request->all();
            $admin['password'] = null;
            $admin['status'] = 0;
            $admin['token'] = uniqid(rand(1000, 9999));
            $admin = SuperAdmin::create($admin);

            Mail::to($admin->email)->send(new AdminCreateMail($admin));
            //            dispatch(new AdminCreateJob($admin))->delay(now());
            DB::commit();
            return $this->returnBack($request);
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500);
        }
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

        return view(parent::__loadView('edit'), compact('row'));
    }

    public function update(Request $request, $id)
    {
        if (!$row = $this->model->find($id)) {
            abort(404);
        }

        $this->dataValidation($request, $id);

        DB::beginTransaction();
        try {
            $admin = $request->all();
            if (isset($admin['password'])) {
                unset($admin['password']);
            }
            if (isset($admin['status'])) {
                unset($admin['status']);
            }
            if (isset($admin['token'])) {
                unset($admin['token']);
            }

            if ($row->role == 'super_admin' && isset($admin['email'])) {
                unset($admin['email']);
            }


            $row->update($admin);

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
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|regex:/^\d{10}$/',
            'email' => 'required|email|unique:admins,email,' . $id,
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

        if ($row->role == 'super_admin') {
            abort(403);
        }

        $row->delete();

        return redirect()->back()->with('success', $this->title . ' Delete Successful.');
    }

    public function changeStatus($id)
    {
        if (!$row = $this->model->find($id)) {
            abort(404);
        }

        if ($row->status == 0) {
            $row->update([
                'status' => 1
            ]);
            $status = "Unblock";
        } else {
            $row->update([
                'status' => 0
            ]);
            $status = "Block";
        }

        return redirect()->back()->with('success', 'Admin ' . $status . ' Successful');
    }
}
