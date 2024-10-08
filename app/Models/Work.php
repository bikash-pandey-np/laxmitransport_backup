<?php

namespace App\Models;

use App\Scopes\DriverIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    const ON_ROUTE_TO_PICKUP = "On Route To Pickup";
    const ON_SITE_AT_PICKUP = "On Site At Pickup";
    const LOADED_AT_SHIPPER = "Loaded At Shipper";
    const ON_ROUTE_TO_DELIVERED = "On Route To Delivered";
    const ON_SITE_AT_COSIGNEE = "On Site At Cosignee";
    const UNLOADED = "Unloaded";
    const PENDING = "pending";

    protected $fillable = [
        'work_id',
        'notify_email',
        'status',
        'admin_status_approved',
        'delivery_pod_signed_by',
        'amount',
        'pieces',
        'weight',
        'miles',
        'user_type',
        'driver_id',
        'vehicle_id',
        'admin_load_notes',
        'driver_load_notes',
        'company_name',
        'actual_amount',
        'customer_id',
        'status_after_complete',

        'pro_number',
        'origin_destination',
        'drop_destination',

        'pickup_date_time',
        'pickup_city',
        'pickup_state',
        'pickup_zip_code',
        'picked_up_note',

        'delivery_date_time',
        'delivery_city',
        'delivery_state',
        'delivery_zip_code',
        'delivery_note',
        'work_id',

        'salse_actual_amount',
        'salse_status',
        'salse_date',
        'salse_admin_note',
    ];

    public function speedySales()
    {
        return $this->hasOne(SpeedySalse::class);
    }

    public function payroll()
    {
        return $this->hasOne(Payroll::class);
    }

    public function getBrokerageNameAttribute()
    {
        return $this->customer->name;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DriverIdScope);
    }

    public function getWorkIdAttribute()
    {
        return "SE-" . ((int)$this->id + 1000);
    }

    public function images()
    {
        return $this->hasMany(WorkDeliveryImage::class, 'work_id', 'id');
    }

    public function workLocations()
    {
        return $this->hasMany(WorkLocation::class, 'work_id', 'id');
    }

    public function workLocation()
    {
        return $this->hasOne(WorkLocation::class, 'work_id', 'id');
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class,'driver_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
