<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidingUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id','amount','work_id'
    ];

    public function work()
    {
        return $this->belongsTo(Biding::class,'work_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }
}
