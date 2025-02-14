<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeedySalse extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'amount',
        'status',
        'date',
        'admin_note',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
