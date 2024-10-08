<?php

namespace App\Http\Controllers\Carrier;



class DashboardController extends CarrierBaseController
{
    public $view_path = "dashboard";
    public $base_route = "dashboard";
    public $title = "Dashboard";

    public function index()
    {
        try {
            if (env('APP_ENV') == "local"){
                $ip = "27.34.22.35";
            }else{
                $ip = request()->ip();
            }
            $location = \Location::get($ip);

//            auth('driver')->user()->update([
//                'account_status'=>'active',
//                'driver_last_location_lat' => $location->latitude,
//                'driver_last_location_long' => $location->longitude,
//            ]);
        }catch (\Exception $e){
            $location = [];
        }
        return view(parent::__loadView('index'),compact('location'));
    }
}
