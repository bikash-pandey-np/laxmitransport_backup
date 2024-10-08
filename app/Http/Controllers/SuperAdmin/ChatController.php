<?php

namespace App\Http\Controllers\SuperAdmin;



use App\Events\Chat;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\Message;
use App\Models\SuperAdmin;
use App\Services\ChatServices;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends SuperAdminBaseController
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

    public function message($role, $id)
    {
        if ($role == 'driver') {
            if (!$user = Driver::find($id)) {
                abort(404);
            }
        } else if ($role == 'admin') {
            if (!$user = SuperAdmin::find($id)) {
                abort(404);
            }
        } else if ($role == 'super-admin') {
            if (!$user = SuperAdmin::find($id)) {
                abort(404);
            }
        } else {
            abort(404);
        }

        $messages = $this->chatServices->getMyMessages([
            'sender_type' => 'super-admin',
            'sender_id' => auth('super_admin')->id(),
            'receiver_id' => request('id'),
            'receiver_type' => request('role')
        ]);

        return view(parent::__loadView('message'), compact('user', 'messages'));
    }

    public function messageSend(Request $request)
    {
        $data = $this->chatServices->sendMessage([
            'sender_type' => 'super-admin',
            'sender_id' => auth('super_admin')->id(),
            'receiver_id' => $request->id,
            'receiver_type' => $request->user_type,
            'message' => $request->message
        ])['receiver'];

        $chatData = $request->only(['user_type', 'id', 'message']);
        $chatData['sender_user_type'] = 'super-admin';
        $chatData['sender_image'] = auth('super_admin')->user()->image('50_50');
        broadcast(new Chat($chatData));

        if ($request->user_type == "driver") {
            $token = Driver::where('id', $request->id)->pluck('device_token')->first();
            fireBaseNotificationForMessage($token, auth('super_admin')->user()->full_name, $data);
        }

        return response()->json([
            'sender_image' => auth()->user()->image('50_50'),
            'message' => $request->message,
            'data' => $data
        ], 200);
    }

    public function userList()
    {
        return $this->chatServices->myChatList([
            'user_type' => 'super-admin',
            'user_id' => auth('super_admin')->id()
        ]);
    }
}
