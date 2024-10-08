<?php

namespace App\Models;

use App\Scopes\DriverIdNotScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biding extends Model
{
    protected $table = "works";

    protected $fillable = [
        'work_id',
        'status',
        'admin_status_approved',
        'delivery_pod_signed_by',
        'amount',
        'pieces',
        'weight',
        'miles',
        'driver_id',
        'vehicle_id',
        'admin_load_notes',
        'driver_load_notes',
        'company_name',
        'brokerage_name',

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
    ];

    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DriverIdNotScope);
    }

    public function getWorkIdAttribute()
    {
        return "SE-".((int) $this->id+1000);
    }

    public function images()
    {
        return $this->hasMany(WorkDeliveryImage::class,'work_id','id');
    }

    public function workLocation()
    {
        return $this->hasOne(WorkLocation::class,'work_id','id');
    }

    public function workLocations()
    {
        return $this->hasMany(WorkLocation::class,'work_id','id');
    }

    public function bidingUsers()
    {
        return $this->hasMany(BidingUser::class,'work_id');
    }
}
