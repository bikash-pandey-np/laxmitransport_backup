<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_group_id',
        'message',
        'file_type',
        'file',
        'sender_type',
        'sender_id',
        'seen',
        'message_user_type',
        'message_user_id',
    ];
}
