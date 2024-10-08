<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkStatusTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'status',
        'date',
        'time',
    ];
}
