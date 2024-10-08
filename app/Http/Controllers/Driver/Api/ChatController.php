<?php

namespace App\Http\Controllers\Driver\Api;


use App\Events\Chat;
use App\Models\Admin;
use App\Models\ChatGroup;
use App\Models\SuperAdmin;
use App\Services\ChatServices;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ChatController extends BaseController
{
    public $view_path = "chat";
    public $base_route = "chat";
    public $title = "Chat";

    public function __construct(ChatServices $chatServices)
    {
        $this->chatServices = $chatServices;
    }

    public function message($id)
    {
        $messages = $this->chatServices->getMessageByGroupId($id);

        return response([
            'data' => $messages
        ],200);
    }

    public function returnableMessage($message)
    {

    }

    public function messageSend(Request $request)
    {
        if (!$group = $this->chatServices->chatGroup->find($request->id)){
            $uniqueId = $this->chatServices->uniqueIdGenerate([
                'sender_type' => 'driver',
                'sender_id' => auth('driver_api')->id(),
                'receiver_id' => SuperAdmin::first()->id,
                'receiver_type' => 'super-admin',
                'message' => $request->message
            ]);

            $group = $this->chatServices->chatGroup->where('unique_id',$uniqueId)->first();
            if (!isset($group)){
                $group = ChatGroup::create([
                    "unique_id" => $uniqueId,
                    'last_message_sender_type' => 'driver',
                    'last_message_sender_id' => auth('driver_api')->id(),
                    'last_message_receiver_type' => 'super-admin',
                    'last_message_receiver_id' => SuperAdmin::first()->id,
                    'last_message' => $request->message,
                    'total_unseen_number' => 1,
                    'seen' => 0,
                ]);
            }
        }

        $data = $this->chatServices->sendMessage([
            'sender_type' => 'driver',
            'sender_id' => auth('driver_api')->id(),
            'receiver_id' => $group->last_message_receiver_id,
            'receiver_type' => 'super-admin',
            'message' => $request->message
        ],$group)['sender'];

        $chatData = $request->only(['id', 'message']);
        $chatData['user_type'] = "super-admin";
        $chatData['sender_image'] = auth('driver_api')->user()->image('50_50');
        $chatData['sender_user_type'] = 'driver';
        broadcast(new Chat($chatData));

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function userList()
    {
        $data = $this->chatServices->myChatList([
            'user_type' => 'driver',
            'user_id' => auth('driver_api')->id()
        ]);

        return response([
            'data' => $data
        ],200);
    }
}
