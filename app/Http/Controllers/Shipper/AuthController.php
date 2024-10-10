<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Shipper;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Otp;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register()
    {
        return Inertia::render('Shipper/Auth/Register', [
            'title' => 'Register - ' . env('SHIPPER_APP_NAME'),
        ]);
    }

    public function login()
    {
        return Inertia::render('Shipper/Auth/Login', [
            'title' => 'Login - ' . env('SHIPPER_APP_NAME'),
        ]);
    }

    public function handleLogin(Request $request)
    {
        $rules = [
            'email' => 'required|exists:shippers,email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if account is blocked
        $shipper = Shipper::where('email', $request->email)->first();
        if (!$shipper->is_active) {
            return back()->with('error', 'Your account is not active');
        }

        if (!(Auth::guard('shipper')->attempt($request->only('email', 'password')))) {
            return back()->with('error', 'Invalid credentials');
        }

        return redirect()->route('shipper.dashboard')->with('success', 'Login successful');
    }

    public function store(Request $request)
    {
        $rules = [
            'business_name' => 'required',
            'vat_no' => 'required|unique:shippers,vat_no',
            'email' => 'required|email|unique:shippers,email',
            'phone' => 'required|unique:shippers,phone',
            'state' => 'required|exists:states,id',
            'district' => 'required|exists:districts,id',
            'localbody' => 'required|exists:local_bodies,id',
            'street_address' => 'required',
            'ward_no' => 'required',
            'password' => 'required|min:8|confirmed',
        ];
        $msg = [
            'business_name.required' => 'Please enter your business name.',
            'business_name.unique' => 'This business name is already registered.',
            'vat_no.required' => 'VAT number is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required.',
            'state.required' => 'Please select your state.',
            'district.required' => 'Please select your district.',
            'localbody.required' => 'Local body information is required.',
            'street_address.required' => 'Street address is required.',
            'ward_no.required' => 'Ward number is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];

        $validator = Validator::make($request->all(), $rules, $msg);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = Shipper::create([
                'business_name' => $request->business_name,
                'vat_no' => $request->vat_no,
                'email' => $request->email,
                'phone' => $request->phone,
                'state_id' => $request->state,
                'district_id' => $request->district,
                'localbody_id' => $request->localbody,
                'street_address' => $request->street_address,
                'ward_no' => $request->ward_no,
                'password' => Hash::make($request->password),
            ]);

            Auth::guard('shipper')->login($user);

            return redirect()->route('shipper.dashboard')->with('success', 'Shipper registered successfully');
        } catch (Throwable $th) {
            Log::error('AuthController@store', ['error' => $th->getMessage()]);
            return back()->with('error', 'Something went wrong')->withErrors(['form_error' => 'Something went wrong']);
        }
    }

    public function logout()
    {
        Auth::guard('shipper')->logout();
        return redirect()->route('shipper.auth.login')->with('success', 'You have been logged out');
    }

    public function getVerifyPage()
    {
        return Inertia::render('Shipper/Auth/VerifyEmail', [
            'title' => 'Verify Email - ' . env('SHIPPER_APP_NAME'),
            'email' => Auth::guard('shipper')->user()->email,
        ]);
    }

    public function sendEmail()
    {
        
        $email = Auth::guard('shipper')->user()->email;

        // Only allow their own email
        if ($email != Auth::guard('shipper')->user()->email) {
            return response()->json([
                'error' => true,
                'status' => 400,
                'message' => 'Only Own email is allowed'
            ], 200);
        }

        // Check email is already verified or not
        $shipper = Shipper::where('email', $email)->first();
        if ($shipper->is_email_verified) {
            request()->session()->flash('success', 'Email already verified');
            return response()->json([
                'error' => false,
                'status' => 201,
                'message' => 'Email already verified'
            ], 200);
        }

        try {
            // Check if otp is already sent
            $exists = Otp::where('email', $email)->exists();

            if ($exists) {
                $otp = Otp::where('email', $email)->first();
                $otp->delete();
            }

            $otp = Otp::create([
                'email' => $email,
                'otp' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            ]);

           

            return response()->json([
                'error' => false,
                'status' => 200,
                'message' => 'Email sent successfully',
            ], 200);
        } catch (Throwable $th) {
            Log::error('AuthController@sendEmail', ['error' => $th->getMessage()]);
            return response()->json([
                'error' => true,
                'status' => 500,
                'message' => 'Something went wrong',
            ], 200);
        }
    }
}
