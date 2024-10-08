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
    return redirect('/carrier/login');
});

Route::group(['middleware' => ['web', 'auth:carrier']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('index');
    Route::post('logout', 'AuthController@logout')->name('logout');

    Route::get('super-admin/{id}', 'SuperAdminController@show')->name('super-admin.show');
    Route::get('admin/{id}', 'AdminController@show')->name('admin.show');

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::post('profile/edit', 'ProfileController@update')->name('profile.update');

    Route::get('profile/deactive/account', 'ProfileController@deactiveAccountForm')->name('profile.deactive.account');
    Route::post('profile/deactive/account', 'ProfileController@deactiveAccount')->name('profile.deactive_account');

    Route::get('profile/picture/edit', 'ProfileController@profilePictureEdit')->name('profile.picture.edit');
    Route::post('profile/picture/edit', 'ProfileController@profilePictureupdate')->name('profile.picture.update');

    Route::get('change/password', 'ProfileController@changePasswordShow')->name('change.password');
    Route::post('change/password', 'ProfileController@changePassword')->name('change.password.update');

    Route::get('work/{status?}', 'WorkController@status')->name('work.index');
    Route::get('work/{id}/show', 'WorkController@show')->name('work.show');
    Route::get('work/{id}/edit', 'WorkController@edit')->name('work.edit');
    Route::put('work/{id}/update', 'WorkController@update')->name('work.update');

    Route::get('chat', 'ChatController@index')->name('chat.index');
    Route::get('chat/user/list', 'ChatController@userList');
    Route::get('chat/{role}/{id}', 'ChatController@message')->name('chat.message');
    Route::post('chat', 'ChatController@messageSend')->name('chat.message.send');

    Route::get('loadboard', 'LoadBoardController@index')->name('loadboard.index');
    Route::get('my-loadboard', 'LoadBoardController@myIndex')->name('loadboard.my');
    Route::get('loadboard/{id}/create', 'LoadBoardController@create')->name('loadboard.create');
    Route::post('loadboard/{id}/store', 'LoadBoardController@store')->name('loadboard.store');

    Route::get('notification', 'NotificationController@index')->name('notification.index');
    Route::get('search', 'SearchController@index')->name('search.index');
});

Route::group(['middleware' => ['web', 'guest:carrier']], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('login', 'AuthController@showLoginForm')->name('login_form');

    Route::post('register', 'AuthController@register')->name('register');
    Route::get('register', 'AuthController@showRegisterForm')->name('register_form');

    Route::post('forget-password', 'AuthController@forgetPassword')->name('forget_password');
    Route::get('forget-password', 'AuthController@showForgetPasswordForm')->name('forget_password_form');

    Route::post('setup-password/{token}', 'AuthController@setupPassword')->name('setup_password');
    Route::get('setup-password/{token}', 'AuthController@showSetupPasswordForm')->name('setup_password_form');
});

Route::get('active/by/admin/{carrier}', 'AuthController@activeByAdmin')->name('active.by.admin')->middleware('web');
Route::get('active/account/{token}', 'AuthController@verifyEmail')->name('active.account')->middleware('web');

Route::fallback(function () {

    if (request()->is('carrier/api/*')) {
        return response()->json(['status' => 'error', 'message' => 'Page Not Found'], 404);
    } else {
        abort(404);
    }
});

