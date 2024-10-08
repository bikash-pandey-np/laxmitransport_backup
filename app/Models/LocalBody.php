<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\State;

class LocalBody extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'district_id', 'ward_count', 'state_id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
}
