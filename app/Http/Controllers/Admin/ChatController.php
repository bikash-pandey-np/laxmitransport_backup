<?php

namespace App\Http\Controllers\Admin;



use App\Events\Chat;
use App\Models\Driver;
use App\Models\SuperAdmin;
use App\Services\ChatServices;
use Illuminate\Http\Request;

class ChatController extends AdminBaseController
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
        if ($role == 'driver'){
            if (!$user = Driver::find($id)){
                abort(404);
            }
        }else if($role == 'super-admin'){
            if (!$user = SuperAdmin::find($id)){
                abort(404);
            }
        }else{
            abort(404);
        }

        $messages = $this->chatServices->getMyMessages([
            'sender_type' => 'admin',
            'sender_id' => auth('admin')->id(),
            'receiver_id' => $id,
            'receiver_type' => $role
        ]);

        return view(parent::__loadView('message'),compact('user','messages'));
    }

    public function messageSend(Request $request)
    {
        $this->chatServices->sendMessage([
            'sender_type' => 'admin',
            'sender_id' => auth('admin')->id(),
            'receiver_id' => $request->id,
            'receiver_type' => $request->user_type,
            'message' => $request->message
        ]);

        $chatData = $request->only(['user_type','id','message']);
        $chatData['sender_image'] = auth('admin')->user()->image('50_50');
        $chatData['sender_user_type'] = 'admin';
        broadcast(new Chat($chatData));

        return response()->json([
            'sender_image' => auth()->user()->image("50_50"),
            'message' => $request->message
        ],200);
    }

    public function userList()
    {
        return $this->chatServices->myChatList([
            'user_type' => 'admin',
            'user_id' => auth('admin')->id()
        ]);
    }
}
