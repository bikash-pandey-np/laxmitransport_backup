<?php

namespace App\Http\Controllers\Driver;


use App\Jobs\DriverRegisterJob;
use App\Mail\DriverEmailResetMail;
use App\Mail\DriverRegisterMail;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        return view('driver.theme_one.auth.login');
    }

    public function login()
    {
        if ($this->guard()->attempt(['email' => request('email'), 'password' => request('password')])) {

            if ($this->guard()->user()->status == 0) {
                $this->guard()->logout();
                return redirect()->back()->with('error', "Please verify your email first.");
            }

            if ($this->guard()->user()->admin_approve == 0) {
                $this->guard()->logout();
                return redirect()->back()->with('error', "Sorry admin is not verified your account. Please contact to admin.");
            }

            if (Session::get('driver_auth_url')) {
                return redirect(Session::get('driver_auth_url'));
            }

            if ($this->guard()->user()->driver_status == "Retired"){
                $this->guard()->user()->update([
                    'driver_status' => "Not Available"
                ]);
            }

            return redirect()->route('driver.index');
        }

        return redirect()->back()->with('error', "Email Or Password Doesn't Match");
    }

    public function showRegisterForm()
    {
        return view('driver.theme_one.auth.register');
    }

    public function showForgetPasswordForm()
    {
        return view('driver.theme_one.auth.forget_password');
    }

    public function forgetPassword(Request $request)
    {
        if (!$driver = Driver::where('email', $request->registerEmail)->first()) {
            return redirect()->back()->with('error', 'Email doesnot match');
        }

        $driver->update([
            'token' => uniqid(rand(100000, 999999))
        ]);

        Mail::to($driver->email)->send(new DriverEmailResetMail($driver));

        return redirect('/driver/login')->with('success', 'Reset link send on email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:drivers,email',
            'password' => 'required',
        ]);
        $user = $request->all(['first_name', 'last_name', 'email', 'password', 'mobile_number']);
        $user['password'] = bcrypt($user['password']);
        $user['token'] = uniqid(rand(100000, 999999));
        $driver = Driver::create($user);
        Mail::to($driver->email)->send(new DriverRegisterMail($driver));
//        dispatch(new DriverRegisterJob($driver))->delay(now());
        return redirect()->route('driver.login')->with('success', 'Signup Successful. Please verify your email');
    }

    public function verifyEmail($token)
    {
        if (!$user = Driver::where('token', $token)->first()) {
            abort(404);
        }

        $user->update([
            'token' => null,
            'status' => 1
        ]);

//        $this->guard()->login($user);

        return redirect()->route('driver.login')->with('success', 'Email Verify Successful. Please wait for admin approve.');
    }

    public function showSetupPasswordForm()
    {
        return view('driver.theme_one.auth.password_setup');
    }

    public function setupPassword(Request $request, $token)
    {
        if (!$user = Driver::where('token', $token)->first()) {
            abort(404);
        }

        $user->update([
            'status' => 1,
            'token' => null,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/driver/login')->with('success', 'Your password was setup successful. Now you can login.');
    }

    public function logout()
    {
        $this->guard()->logout();
        Session::forget('driver_auth_url');
        return redirect()->route('driver.login_form');
    }

    public function activeByAdmin($id)
    {
        if (!$driver = Driver::find($id)) {
            abort(404);
        }

        if (auth('admin')->check() || auth('super_admin')->check()) {
            $driver->update([
                'status' => 1,
                'admin_approve' => 1,
                'driver_status' => "Not Available",
                'token' => null
            ]);

            return redirect()->back()->with('success', 'Driver Activated Successful');
        }

        abort(404);
    }

    public function extraSignup()
    {
        return view('driver.theme_one.auth.extra_signup');
    }

    public function extraSignupPost(Request $request)
    {
        $request->validate([
            'date_of_birth' => 'date_format:m/d/Y'
        ]);

        $all = $request->only(["address_one", "city", "state", "date_of_birth", "emergency_contact", "license_number", "license_state", "social_security_number", "license_class", "billed_mileage_type"]);
        $all['extra_signup'] = 1;
        $this->guard()->user()->update($all);

        return redirect()->route('driver.index')->with('success','Signup Complete');
    }

    public function guard()
    {
        return Auth::guard('driver');
    }
}
