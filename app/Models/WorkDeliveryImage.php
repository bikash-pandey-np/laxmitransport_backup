<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkDeliveryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_location_id',
        'status_type',
        'image',
    ];

    public function image($test)
    {
        if ($this->image == null) {
            return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
        }
        if ($test == "upload"){
            return asset('storage/' . $this->image);
        }
        return asset('storage/' . $test . '/' . $this->image);
    }

}
