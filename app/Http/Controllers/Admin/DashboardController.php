<?php

namespace App\Http\Controllers\Admin;



use App\Models\Driver;

class DashboardController extends AdminBaseController
{
    public $view_path = "dashboard";
    public $base_route = "dashboard";
    public $title = "Dashboard";

    public function index()
    {
        $totalAvailableDrivers = 0;
        foreach (Driver::where('account_status','active')->get() as $item) {
            if (!count($item->activeWorks) > 0){
                $totalAvailableDrivers++;
            }
        }
        return view(parent::__loadView('index'),compact('totalAvailableDrivers'));
    }
}
