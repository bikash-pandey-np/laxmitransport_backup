<?php

namespace App\Http\Controllers\Admin;


use App\Mail\AdminEmailResetMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        return view('admin.theme_one.auth.login');
    }

    public function login()
    {
        if ($this->guard()->attempt(['email' => request('email'), 'password' => request('password')])) {

            if ($this->guard()->user()->status == 0){
                $this->guard()->logout();
                return redirect()->back()->with('error', "Your Account Was Block. Please Contact Super Admin.");
            }

            if (Session::get('admin_auth_url')){
                return redirect(Session::get('admin_auth_url'));
            }
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with('error', "Email Or Password Doesn't Match");
    }

    public function showForgetPasswordForm()
    {
        return view('admin.theme_one.auth.forget_password');
    }

    public function forgetPassword(Request $request)
    {
        if (!$admin = Admin::where('email',$request->registerEmail)->first()){
            return redirect()->back()->with('error','Email doesnot match');
        }

        $admin->update([
            'token' => uniqid(rand(100000,999999))
        ]);

        Mail::to($admin->email)->send(new AdminEmailResetMail($admin));

        return redirect('/admin/login')->with('success','reset link send on email');
    }

    public function showSetupPasswordForm()
    {
        return view('admin.theme_one.auth.password_setup');
    }

    public function setupPassword(Request $request,$token)
    {
        if (!$user = Admin::where('token',$token)->first()){
            abort(404);
        }

        $user->update([
            'status' => 1,
            'token' => null,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/admin/login')->with('success','Your password was setup successful. Now you can login.');
    }

    public function logout()
    {
        $this->guard()->logout();
        Session::forget('admin_auth_url');
        return redirect()->route('admin.login_form');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }
}
