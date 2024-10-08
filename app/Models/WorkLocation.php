<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'company_name',
        'pickup_house_number',
        'pickup_street_name',
        'pickup_city_state_zipcode',
        'pickup_date',
        'pickup_time',
        'pickup_note',

        'consignee_name',
        'drop_house_number',
        'drop_street_name',
        'drop_city_state_zipcode',
        'drop_date',
        'drop_time',
        'drop_note',
    ];

    public function images()
    {
        return $this->hasMany(WorkDeliveryImage::class,'work_location_id','id');
    }

    public function getPickupDateTimeAttribute()
    {
        return $this->pickup_date." ".format_server_to_local($this->pickup_time);
    }

    public function getDropDateTimeAttribute()
    {
        return $this->drop_date." ".format_server_to_local($this->drop_time);
    }

    public function getDropFullLocationAttribute()
    {
        return $this->drop_street_name.", ".$this->drop_city_state_zipcode;
    }

    public function getPickupFullLocationAttribute()
    {
        return $this->pickup_street_name.", ".$this->pickup_city_state_zipcode;
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
