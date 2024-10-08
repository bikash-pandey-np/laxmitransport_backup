<?php

namespace App\Http\Controllers\Driver;



use App\Rules\OldPasswordValidationRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends DriverBaseController
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

        auth('driver')->user()->update($request->only(['first_name', 'last_name', 'email','mobile_number','address_one','address_two','admin_can_login']));

        return redirect()->route('driver.profile.index');
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

        auth('driver')->user()->update([
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
            'old_password' => ['required', new OldPasswordValidationRule('driver')],
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        auth('driver')->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->back()->with('success', 'Password change successful.');
    }

    public function changeStatusShow()
    {
        $ip = request()->ip();
        $location = \Location::get($ip);
        return view(parent::__loadView('change_status'),compact('location'));
    }

    public function changeStatus(Request $request)
    {

        $rule = [
            'driver_status' => [
                'required',
                Rule::in([
                    'Available',
                    'Not Available',
                    'Retired'
                ])
            ]
        ];

        $data = $request->only(["driver_status", "available_state", "available_city", "available_zip_code","available_date","available_time"]);

        if (in_array($request->driver_status,["Available"])){
            $rule['available_city'] = "required";
            $rule['available_date'] = "required";
            $rule['available_time'] = "required";

            $data['available_time'] = format_local_to_server($data['available_time']);

        }else{
            $data['available_state'] = null;
            $data['available_date'] = null;
            $data['available_time'] = null;
        }

        $request->validate($rule);

        auth('driver')->user()->update($data);

        if ($data['driver_status'] == "Retired"){

            auth('driver')->user()->update([
                'termination_date' => Carbon::now()
            ]);

            auth('driver')->logout();
            return redirect()->route('driver.login');
        }

        return redirect()->back()->with('success', 'Status change successful.');
    }

    public function deactiveAccountForm()
    {
        return view(parent::__loadView('deactive_account'));
    }

    public function deactiveAccount(Request $request)
    {


        auth('driver')->user()->update([
            'deactive_reason' => $request->deactive_reason,
            'account_status' => 'deactive'
        ]);

        auth('driver')->logout();
        return redirect()->route('driver.login_form');
    }
}
