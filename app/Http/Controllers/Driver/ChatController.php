<?php

namespace App\Http\Controllers\Driver;



use App\Events\Chat;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\SuperAdmin;
use App\Services\ChatServices;
use Illuminate\Http\Request;

class ChatController extends DriverBaseController
{
    public $view_path = "chat";
    public $base_route = "chat";
    public $title = "Chat";

    public function __construct(ChatServices $chatServices)
    {
        $this->chatServices = $chatServices;
    }

    public function index()
    {
        return view(parent::__loadView('index'));
    }

    public function message($role,$id)
    {
        if ($role == 'super-admin'){
            if (!$user = SuperAdmin::find($id)){
                abort(404);
            }
        }else if($role == 'admin'){
            if (!$user = Admin::find($id)){
                abort(404);
            }
        }else{
            abort(404);
        }

        $messages = $this->chatServices->getMyMessages([
            'sender_type' => 'driver',
            'sender_id' => auth('driver')->id(),
            'receiver_id' => request('id'),
            'receiver_type' => request('role')
        ]);

        return view(parent::__loadView('message'),compact('user','messages'));
    }

    public function messageSend(Request $request)
    {
        $this->chatServices->sendMessage([
            'sender_type' => 'driver',
            'sender_id' => auth('driver')->id(),
            'receiver_id' => $request->id,
            'receiver_type' => $request->user_type,
            'message' => $request->message
        ]);

        $chatData = $request->only(['user_type','id','message']);
        $chatData['sender_image'] = auth('driver')->user()->image('50_50');
        $chatData['sender_user_type'] = 'driver';
        broadcast(new Chat($chatData));

        return response()->json([
            'sender_image' => auth('driver')->user()->image('50_50'),
            'message' => $request->message
        ],200);
    }

    public function userList()
    {
        return $this->chatServices->myChatList([
            'user_type' => 'driver',
            'user_id' => auth('driver')->id()
        ]);
    }
}
