<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',

        'pickup_city_st_zip_code',
        'pickup_date',
        'pickup_time',

        'drop_city_st_zip_code',
        'drop_date',
        'drop_time',

        'vehicle_type',
        'pieces',
        'weight',
        'dims',
        'email',
        'miles',
        'admin_note',

        'amount',
        'table',
        'table_id',
    ];

    public function getAmountAttribute($value)
    {
        return "$value";
    }

    public function loadBoardUsers()
    {
        return $this->hasMany(LoadBoardUser::class);
    }

    public function setPickupTimeAttribute($value)
    {
        $this->attributes['pickup_time'] = format_local_to_server($value);
    }

    public function setDropTimeAttribute($value)
    {
        $this->attributes['drop_time'] = format_local_to_server($value);
    }

}
