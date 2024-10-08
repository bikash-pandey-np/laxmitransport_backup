<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'short_description',
        'description',
        'url',
        'seen',

        'sender_type',
        'sender_id',

        'receiver_type',
        'receiver_id',
    ];
}
