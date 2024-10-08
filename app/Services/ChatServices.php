<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\ChatGroup;
use App\Models\Driver;
use App\Models\Message;
use App\Models\SuperAdmin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatServices
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(ChatGroup $chatGroup, Message $message)
    {
        $this->chatGroup = $chatGroup;
        $this->message = $message;
    }

    public function getMyMessages($request)
    {
        $uniqueId = $this->uniqueIdGenerate($request);

        if (!$chatGroup = $this->chatGroup->where('unique_id', $uniqueId)->first()) {
            $chatGroup = $this->chatGroup->create([
                'unique_id' => $uniqueId,
                'last_message_sender_type' => $request['sender_type'],
                'last_message_sender_id' => $request['sender_id'],
                'last_message_receiver_type' => $request['receiver_type'],
                'last_message_receiver_id' => $request['receiver_id'],
                'last_message' => null,
                'seen' => 0,
                'update_at' => Carbon::now()
            ]);
        }

        $messages =  $this->message->where([
            'chat_group_id' => $chatGroup->id,
            'message_user_type' => $request['sender_type'],
        ])->get();
        return $messages;
    }

    public function getMessageByGroupId($id)
    {
        $data = $this->message->where([
            'chat_group_id' => $id,
            'message_user_type' => 'driver'
        ])->get();

        return $data;
    }

    public function sendMessage($request,$chatGroup = null)
    {

        if ($chatGroup == null){
            $uniqueId = $this->uniqueIdGenerate($request);

            if ($chatGroup = $this->chatGroup->where('unique_id', $uniqueId)->first()) {
                $chatGroup->update([
                    'last_message' => $request['message'],
                    'seen' => 0,
                    'update_at' => Carbon::now()
                ]);
            } else {
                $chatGroup = $this->chatGroup->create([
                    'unique_id' => $uniqueId,
                    'last_message_sender_type' => $request['sender_type'],
                    'last_message_sender_id' => $request['sender_id'],
                    'last_message_receiver_type' => $request['receiver_type'],
                    'last_message_receiver_id' => $request['receiver_id'],
                    'last_message' => $request['message'],
                    'seen' => 0,
                    'update_at' => Carbon::now()
                ]);
            }
        }

        $returnData['sender'] = $this->message->create([
            'chat_group_id' => $chatGroup->id,
            'message' => $request['message'],
            'sender_type' => $request['sender_type'],
            'sender_id' => $request['sender_id'],
            'message_user_type' => $request['sender_type'],
            'message_user_id' => $request['sender_id'],
        ]);

        $returnData['receiver'] = $this->message->create([
            'chat_group_id' => $chatGroup->id,
            'message' => $request['message'],
            'sender_type' => $request['sender_type'],
            'sender_id' => $request['sender_id'],
            'message_user_type' => $request['receiver_type'],
            'message_user_id' => $request['receiver_id'],
        ]);

        return $returnData;
    }

    public function myChatList($request)
    {
        $one = $this->chatGroup->where([
            'last_message_sender_type' => $request['user_type'],
            'last_message_sender_id' => $request['user_id']
        ])->pluck('id')->toArray();

        $two = $this->chatGroup->Where([
            'last_message_receiver_type' => $request['user_type'],
            'last_message_receiver_id' => $request['user_id']
        ])->pluck('id')->toArray();

        $ids = array_merge($one, $two);

        $chatGroups = $this->chatGroup->whereIn('id', $ids)->orderBy('updated_at', 'DESC')->get();

        $friends = [];
        foreach ($chatGroups as $chatGroup) {

            if ($chatGroup['last_message_sender_type'] == $request['user_type']) {
                $friendType = $chatGroup['last_message_receiver_type'];
                $friendId = $chatGroup['last_message_receiver_id'];
            } else {
                $friendType = $chatGroup['last_message_sender_type'];
                $friendId = $chatGroup['last_message_sender_id'];
            }

            if ($friendType == 'admin') {
                $friend = Admin::find($friendId);
            } elseif ($friendType == 'driver') {
                $friend = Driver::find($friendId);
            } else {
                $friend = SuperAdmin::find($friendId);
            }

            if (isset($friend)) {
                array_push($friends, [
                    'id' => $friend['id'],
                    'unit_number' => $friend['unit_number'] ?? "",
                    'full_name' => $friend['full_name'],
                    'image' => $friend->image('50_50'),
                    'type' => $friendType,
                    'chat_id' => $chatGroup['id'],
                    'last_message' => $chatGroup['last_message'],
                    'total_unseen_number' => $chatGroup['total_unseen_number'],
                    'last_message_time' => $chatGroup['updated_at'],
                ]);
            }
        }

        return $friends;
    }

    public function uniqueIdGenerate($request)
    {
        if ($request['sender_type'] == 'super-admin' && $request['receiver_type'] == 'driver') {
            $id = $request['sender_type'] . $request['sender_id'] . $request['receiver_type'] . $request['receiver_id'];
        } elseif ($request['sender_type'] == 'super-admin' && $request['receiver_type'] == 'admin') {
            $id = $request['receiver_type'] . $request['receiver_id'] . $request['sender_type'] . $request['sender_id'];
        } elseif ($request['sender_type'] == 'admin' && $request['receiver_type'] == 'driver') {
            $id = $request['sender_type'] . $request['sender_id'] . $request['receiver_type'] . $request['receiver_id'];
        } elseif ($request['sender_type'] == 'admin' && $request['receiver_type'] == 'super-admin') {
            $id = $request['sender_type'] . $request['sender_id'] . $request['receiver_type'] . $request['receiver_id'];
        } elseif ($request['sender_type'] == 'driver' && $request['receiver_type'] == 'admin') {
            $id = $request['receiver_type'] . $request['receiver_id'] . $request['sender_type'] . $request['sender_id'];
        } elseif ($request['sender_type'] == 'driver' && $request['receiver_type'] == 'super-admin') {
            $id = $request['receiver_type'] . $request['receiver_id'] . $request['sender_type'] . $request['sender_id'];
        } else {
            $id = uniqid(rand(10, 99));
        }

        return $id;
    }
}
