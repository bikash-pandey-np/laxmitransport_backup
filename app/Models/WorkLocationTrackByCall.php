<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLocationTrackByCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'date',
        'time',
    ];

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = format_local_to_server($value);
    }

    public function getDateTimeAttribute()
    {
        return format_date($this->date).' '.format_server_to_local($this->time);
    }
}
