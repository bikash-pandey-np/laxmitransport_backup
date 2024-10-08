<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'image',
    ];
}
