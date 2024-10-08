<?php

namespace App\Http\Controllers\Driver;


use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Driver;

class AdminController extends DriverBaseController
{
    public $view_path = "driver";
    public $base_route = "driver";
    public $title = "Admin";

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
