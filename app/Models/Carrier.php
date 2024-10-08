<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Carrier extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'business_address',
        'city_st_zip',
        'phone_number',
        'ext',
        'email',
        'usdot',
        'broker_mc',
        'admin_note',

        'dispatch_name',
        'dispatch_phone_number',
        'dispatch_email',
        'dispatch_admin_note',

        'bill_info_name',
        'bill_info_business_address',
        'bill_info_phone_number',
        'bill_info_accounting_email',
        'bill_info_federal_tax_payer_id',

        'insurance_name',
        'policy_number',
        'policy_effective_date',
        'policy_expire_date',
        'coi',

        'password',
        'token',
        'status',
        'device_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'token',
        'status'
    ];

    public function getCarrierIdAttribute()
    {
        return "CU-".(1000+$this->id);
    }

    public function image($test)
    {
        return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }
}
