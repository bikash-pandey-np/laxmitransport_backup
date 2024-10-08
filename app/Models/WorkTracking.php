<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'location',
        'date',
        'time',
        'admin_note'
    ];
}
