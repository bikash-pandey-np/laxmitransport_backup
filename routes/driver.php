<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web', 'auth:driver']], function () {
    Route::get('extra-signup', 'AuthController@extraSignup')->name('extra_signup.index');
    Route::post('extra-signup', 'AuthController@extraSignupPost')->name('extra_signup.post');
    Route::post('logout', 'AuthController@logout')->name('logout');
});

Route::group(['middleware' => ['web', 'auth:driver','extra_signup']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('index');

    Route::get('super-admin/{id}', 'SuperAdminController@show')->name('super-admin.show');
    Route::get('admin/{id}', 'AdminController@show')->name('admin.show');

    Route::get('work/{status?}', 'WorkController@status')->name('work.index');
    Route::get('work/{id}/show', 'WorkController@show')->name('work.show');
    Route::get('work/{id}/edit', 'WorkController@edit')->name('work.edit');
    Route::put('work/{id}/update', 'WorkController@update')->name('work.update');

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::post('profile/edit', 'ProfileController@update')->name('profile.update');

    Route::get('profile/picture/edit', 'ProfileController@profilePictureEdit')->name('profile.picture.edit');
    Route::post('profile/picture/edit', 'ProfileController@profilePictureupdate')->name('profile.picture.update');

    Route::post('location/store', function (\Illuminate\Http\Request $request) {
        if (isset($request->lat) && isset($request->long)) {
            \App\Models\UserLocation::create([
                'user_id' => auth('driver')->id(),
                'latitude' => $request->lat,
                'longitude' => $request->long
            ]);

            auth('driver')->user()->update([
                'driver_last_location_lat' => $request->lat,
                'driver_last_location_long' => $request->long
            ]);
        }
    });

    Route::get('profile/deactive/account', 'ProfileController@deactiveAccountForm')->name('profile.deactive.account');
    Route::post('profile/deactive/account', 'ProfileController@deactiveAccount')->name('profile.deactive_account');

    Route::get('loadboard', 'LoadBoardController@index')->name('loadboard.index');
    Route::get('my-loadboard', 'LoadBoardController@myIndex')->name('loadboard.my');
    Route::get('loadboard/{id}/create', 'LoadBoardController@create')->name('loadboard.create');
    Route::post('loadboard/{id}/store', 'LoadBoardController@store')->name('loadboard.store');

    Route::get('biding', 'BidingController@index')->name('biding.index');
    Route::get('my-biding', 'BidingController@myIndex')->name('biding.my');
    Route::get('biding/{id}/create', 'BidingController@create')->name('biding.create');
    Route::post('biding/{id}/store', 'BidingController@store')->name('biding.store');

    Route::get('change/password', 'ProfileController@changePasswordShow')->name('change.password');
    Route::post('change/password', 'ProfileController@changePassword')->name('change.password.update');

    Route::get('change/status', 'ProfileController@changeStatusShow')->name('change.status');
    Route::post('change/status', 'ProfileController@changeStatus')->name('change.status.update');

    Route::get('chat', 'ChatController@index')->name('chat.index');
    Route::get('chat/user/list', 'ChatController@userList');
    Route::get('chat/{role}/{id}', 'ChatController@message')->name('chat.message');
    Route::post('chat', 'ChatController@messageSend')->name('chat.message.send');

    Route::get('notification', 'NotificationController@index')->name('notification.index');
    Route::get('search', 'SearchController@index')->name('search.index');
});

Route::group(['middleware' => ['web', 'guest:driver']], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('login', 'AuthController@showLoginForm')->name('login_form');

    Route::post('register', 'AuthController@register')->name('register');
    Route::get('register', 'AuthController@showRegisterForm')->name('register_form');

    Route::post('forget-password', 'AuthController@forgetPassword')->name('forget_password');
    Route::get('forget-password', 'AuthController@showForgetPasswordForm')->name('forget_password_form');

    Route::post('setup-password/{token}', 'AuthController@setupPassword')->name('setup_password');
    Route::get('setup-password/{token}', 'AuthController@showSetupPasswordForm')->name('setup_password_form');
});

Route::get('active/by/admin/{driver}', 'AuthController@activeByAdmin')->name('active.by.admin')->middleware('web');
Route::get('active/account/{token}', 'AuthController@verifyEmail')->name('active.account')->middleware('web');

Route::group(['prefix' => 'api', 'middleware' => ['api'], 'namespace' => "Api\\"], function () {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('forgot-password', 'AuthController@forgotPassword');
    Route::post('forgot-password-token-verify', 'AuthController@tokenVerify');
    Route::post('reset-password', 'AuthController@resetPassword');

});

Route::group(['prefix' => 'api', 'middleware' => ['api', 'auth:driver_api'], 'namespace' => "Api\\"], function () {


    Route::post('current-location-update', 'AuthController@updateCurrentLocation');
    Route::post('location-update', 'AuthController@updateLocation');
    Route::post('device-token', 'AuthController@deviceToken');
    Route::delete('me', 'AuthController@deleteProfile');

    Route::get('profile', 'AuthController@detail');
    Route::post('change-current-status', 'AuthController@changeCurrentStatus');

    Route::get('available-work', 'WorkController@availableWork');
    Route::post('work/{id}/change-status', 'WorkController@changeStatus');

    Route::get('load-board', 'LoadBoardController@loadBoard');
    Route::post('load-board/{id}', 'LoadBoardController@loadBoardStore');
    Route::get('my-load-board', 'LoadBoardController@myLoadBoard');

    Route::post('message', 'ChatController@messageSend');
    Route::get('message/{id}', 'ChatController@message');
    Route::get('user-list', 'ChatController@userList');

});

Route::fallback(function () {

    if (request()->is('driver/api/*') || request()->is('admin/api/*') || request()->is('super-admin/api/*')) {
        return response()->json(['status' => 'error', 'message' => 'Page Not Found'], 404);
    } else {
        abort(404);
    }
});

