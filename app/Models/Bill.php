<?php

namespace App\Models;

use App\Scopes\DriverIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'amount',
        'pay_date',
        'country',
        'admin_note',
        'image',
    ];

    public function image($test)
    {
        if ($this->image == null) {
            return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
        }
        return asset('storage/' . $test . '/' . $this->image);
    }
}
