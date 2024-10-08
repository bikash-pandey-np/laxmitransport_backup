<?php

namespace App\Http\Controllers\Driver\Api;


use App\Events\Chat;
use App\Models\Admin;
use App\Models\SuperAdmins;
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
        $group = $this->chatServices->chatGroup->find($request->id);

        $data = $this->chatServices->sendMessage([
            'sender_type' => 'driver',
            'sender_id' => auth('driver_api')->id(),
            'receiver_id' => $group->last_message_receiver_id,
            'receiver_type' => 'super-admin',
            'message' => $request->message
        ])['sender'];

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
