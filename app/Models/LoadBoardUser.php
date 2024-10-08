<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadBoardUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_type',
        'table_id',
        'load_board_id',
        'status',
        'amount',
    ];

    public function getUserTypeAttribute()
    {
        return $this->table_type == "App\Models\Carrier" ? "Carrier" : "Driver";
    }

    public function loadBoard()
    {
        return $this->belongsTo(LoadBoard::class,'load_board_id','id');
    }

    public function user()
    {
        return $this->belongsTo($this->table_type,'table_id','id');
    }
}
