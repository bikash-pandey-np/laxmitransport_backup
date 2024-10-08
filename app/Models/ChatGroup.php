<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'last_message_sender_type',
        'last_message_sender_id',
        'last_message_receiver_type',
        'last_message_receiver_id',
        'last_message',
        'total_unseen_number',
        'seen',
    ];
}
