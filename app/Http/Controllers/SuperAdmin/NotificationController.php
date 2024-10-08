<?php

namespace App\Http\Controllers\SuperAdmin;



class NotificationController extends SuperAdminBaseController
{
    public $view_path = "notification";
    public $base_route = "notification";
    public $title = "Notification";

    public function index()
    {
        return view(parent::__loadView('index'));
    }
}
