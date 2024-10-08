<?php

namespace App\Http\Controllers\Admin;


use App\DataTables\Admin\DriverDataTable;
use App\Jobs\DriverCreateJob;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends AdminBaseController
{
    public $view_path = "driver";
    public $base_route = "driver";
    public $title = "Super Admin";

    public function __construct(Driver $model)
    {
        $this->model = $model;
    }

    public function show($id)
    {
        if (!$row = $this->model->find($id)){
            abort(404);
        }

        return view(parent::__loadView('show'),compact('row'));
    }
}
