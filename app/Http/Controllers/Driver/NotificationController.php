<?php

namespace App\Http\Controllers\Driver;



class NotificationController extends DriverBaseController
{
    public $view_path = "notification";
    public $base_route = "notification";
    public $title = "Notification";

    public function index()
    {
        return view(parent::__loadView('index'));
    }
}
