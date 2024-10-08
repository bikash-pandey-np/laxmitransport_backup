<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkUpdate extends Model
{
    protected $table = "works";

    protected $fillable = [
        'amount',
        'driver_id',
    ];

    use HasFactory;
}
