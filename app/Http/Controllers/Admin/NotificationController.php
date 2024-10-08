<?php

namespace App\Http\Controllers\Admin;



class NotificationController extends AdminBaseController
{
    public $view_path = "notification";
    public $base_route = "notification";
    public $title = "Notification";

    public function index()
    {
        return view(parent::__loadView('index'));
    }
}
