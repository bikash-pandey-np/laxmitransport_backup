<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'transaction_number',
        'amount',
        'date',
        'status',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
