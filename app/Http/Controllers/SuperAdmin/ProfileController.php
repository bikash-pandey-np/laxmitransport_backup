<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Rules\OldPasswordValidationRule;
use Illuminate\Http\Request;

class ProfileController extends SuperAdminBaseController
{
    public $view_path = "profile";
    public $base_route = "profile";
    public $title = "Profile";

    public function index()
    {
        return view(parent::__loadView('index'));
    }

    public function edit()
    {
        return view(parent::__loadView('edit'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        auth('super_admin')->user()->update($request->only(['first_name', 'last_name', 'email']));

        return redirect()->route('super_admin.profile.index');
    }

    public function profilePictureEdit()
    {
        return view(parent::__loadView('profile_picture_edit'));
    }

    public function profilePictureupdate(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        auth('super_admin')->user()->update([
            'image' => $this->imageUploadByThumb($request->image)
        ]);

        return redirect()->back()->with('success', 'Profile picture change successful.');
    }

    public function changePasswordShow()
    {
        return view(parent::__loadView('change_password'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new OldPasswordValidationRule()],
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        auth('super_admin')->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->back()->with('success', 'Password change successful.');
    }
}
