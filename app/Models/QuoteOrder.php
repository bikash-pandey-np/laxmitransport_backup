<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'actual_amount',
        'pieces',
        'weight',
        'miles',
        'pro_number',
        'pickup_company_name',
        'pickup_company_address',
        'pickup_company_city_zip_code',
        'pickup_date',
        'pickup_time',
        'consignee_name',
        'drop_address',
        'drop_city_zip_code',
        'drop_date',
        'drop_time',
    ];
}
