<?php

namespace App\Http\Controllers\Carrier;

use App\Mail\CarrierRegisterMail;
use App\Mail\CarrierEmailResetMail;
use App\Models\Carrier;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        return view('carrier.theme_one.auth.login');
    }

    public function login()
    {
        if ($this->guard()->attempt(['email' => request('email'), 'password' => request('password')])) {
//
//            if ($this->guard()->user()->status == 0) {
//                $this->guard()->logout();
//                return redirect()->back()->with('error', "Please verify your email first.");
//            }

            if (Session::get('carrier_auth_url')) {
                return redirect(Session::get('carrier_auth_url'));
            }

            if ($this->guard()->user()->driver_status == "Retired"){
                $this->guard()->user()->update([
                    'driver_status' => "Not Available"
                ]);
            }

            return redirect()->route('carrier.index');
        }

        return redirect()->back()->with('error', "Email Or Password Doesn't Match");
    }

    public function showRegisterForm()
    {
        return view('carrier.theme_one.auth.register');
    }

    public function showForgetPasswordForm()
    {
        return view('carrier.theme_one.auth.forget_password');
    }

    public function forgetPassword(Request $request)
    {
        if (!$carrier = Carrier::where('email', $request->registerEmail)->first()) {
            return redirect()->back()->with('error', 'Email doesnot match');
        }

        $carrier->update([
            'token' => uniqid(rand(100000, 999999))
        ]);

        Mail::to($carrier->email)->send(new CarrierEmailResetMail($carrier));

        return redirect('/carrier/login')->with('success', 'Reset link send on email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:carriers,email',
            'password' => 'required',
        ]);
        $user = $request->all();
        $user['password'] = bcrypt($user['password']);
        $user['token'] = uniqid(rand(100000, 999999));
        $carrier = Carrier::create($user);
        Mail::to($carrier->email)->send(new CarrierRegisterMail($carrier));
//        dispatch(new Carrier
//
//
//($carrier))->delay(now());
        return redirect()->route('carrier.login')->with('success', 'Signup Successful. Please verify your email');
    }

    public function verifyEmail($token)
    {
        if (!$user = Carrier::where('token', $token)->first()) {
            abort(404);
        }

        $user->update([
            'token' => null,
            'status' => 1
        ]);

//        $this->guard()->login($user);

        return redirect()->route('carrier.login')->with('success', 'Email Verify Successful. Please wait for admin approve.');
    }

    public function showSetupPasswordForm()
    {
        return view('carrier.theme_one.auth.password_setup');
    }

    public function setupPassword(Request $request, $token)
    {
        if (!$user = Carrier::where('token', $token)->first()) {
            abort(404);
        }

        $user->update([
            'status' => 1,
            'token' => null,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/carrier/login')->with('success', 'Your password was setup successful. Now you can login.');
    }

    public function logout()
    {
        $this->guard()->logout();
        Session::forget('carrier_auth_url');
        return redirect()->route('carrier.login_form');
    }

    public function activeByAdmin($id)
    {
        if (!$carrier = Carrier::find($id)) {
            abort(404);
        }

        if (auth('admin')->check() || auth('super_admin')->check()) {
            $carrier->update([
                'status' => 1,
                'admin_approve' => 1,
                'driver_status' => "Not Available",
                'token' => null
            ]);

            return redirect()->back()->with('success', 'Carrier Activated Successful');
        }

        abort(404);
    }

    public function extraSignup()
    {
        return view('carrier.theme_one.auth.extra_signup');
    }

    public function extraSignupPost(Request $request)
    {
        $request->validate([
            'date_of_birth' => 'date_format:m/d/Y'
        ]);

        $all = $request->only(["address_one", "city", "state", "date_of_birth", "emergency_contact", "license_number", "license_state", "social_security_number", "license_class", "billed_mileage_type"]);
        $all['extra_signup'] = 1;
        $this->guard()->user()->update($all);

        return redirect()->route('carrier.index')->with('success','Signup Complete');
    }

    public function guard()
    {
        return Auth::guard('carrier');
    }
}
