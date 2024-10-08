<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

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
    ];
}
