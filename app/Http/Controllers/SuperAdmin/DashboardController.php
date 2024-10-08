<?php

namespace App\Http\Controllers\SuperAdmin;



use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Work;

class DashboardController extends SuperAdminBaseController
{
    public $view_path = "dashboard";
    public $base_route = "dashboard";
    public $title = "Dashboard";

    public function index()
    {
        $totalAvailableDrivers = 0;
        foreach (Driver::where('driver_status','Available')->get() as $item) {
            if (!count($item->activeWorks) > 0){
                $totalAvailableDrivers++;
            }
        }

        $notAvailableIds = Vehicle::orderBy('vehicles.created_at','desc')
            ->select([
                'vehicles.*'
            ])
            ->leftJoin('works','vehicles.id','=','works.vehicle_id')
            ->whereIn('works.status',config('workstatus.trip_monitor'))
            ->pluck('id')->toArray();
        $totalAvailableDrivers = Vehicle::whereNotIn('vehicles.id',$notAvailableIds)
            ->select('vehicles.*')
            ->join('drivers','vehicles.driver_id','=','drivers.id')
            ->whereIn('drivers.driver_status',['available','Available'])
            ->orderBy('drivers.unit_number','asc')->count();

        return view(parent::__loadView('index'),compact('totalAvailableDrivers'));
    }

    public function getAddresses()
    {
        $driver_id = Work::where('driver_id','!=',null)->where('user_type',Driver::class)->whereIn('status',config('workstatus.trip_monitor'))->pluck('id')->toArray();
        $drivers = Driver::whereIn('id',$driver_id)->get();
$arr = [];
        foreach ($drivers as $driver) {
          array_push($arr,[
              $driver->full_name,
              $driver->driver_last_location_lat,
              $driver->driver_last_location_long,
          ]);
        }

        return $arr;
    }
}
