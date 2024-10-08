<?php

namespace App\Http\Controllers\Carrier;



use App\Rules\OldPasswordValidationRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends CarrierBaseController
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

        auth('carrier')->user()->update($request->only(['first_name', 'last_name', 'email','mobile_number','address_one','address_two','admin_can_login']));

        return redirect()->route('carrier.profile.index');
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

        auth('carrier')->user()->update([
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
            'old_password' => ['required', new OldPasswordValidationRule('carrier')],
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        auth('carrier')->user()->update([
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
            'carrier_status' => [
                'required',
                Rule::in([
                    'Available',
                    'Not Available',
                    'Retired'
                ])
            ]
        ];

        $data = $request->only(["carrier_status", "available_state", "available_city", "available_zip_code","available_date","available_time"]);

        if (in_array($request->carrier_status,["Available"])){
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

        auth('carrier')->user()->update($data);

        if ($data['carrier_status'] == "Retired"){
            auth('carrier')->logout();
            return redirect()->route('carrier.login');
        }

        return redirect()->back()->with('success', 'Status change successful.');
    }

    public function deactiveAccountForm()
    {
        return view(parent::__loadView('deactive_account'));
    }

    public function deactiveAccount(Request $request)
    {


        auth('carrier')->user()->update([
            'deactive_reason' => $request->deactive_reason,
            'account_status' => 'deactive'
        ]);

        auth('carrier')->logout();
        return redirect()->route('carrier.login_form');
    }
}
