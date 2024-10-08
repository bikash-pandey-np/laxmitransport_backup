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

//Route::group(['middleware' => ['auth:admin','active_admin']],function() {
//    Route::get('dashboard', 'DashboardController@index')->name('index');
//    Route::resource('vehicle', 'VehicleController');
//    Route::resource('driver', 'DriverController');
//    Route::get('super-admin/{id}', 'SuperAdminController@show')->name('super-admin.show');
//
//    Route::get('work/add/location','WorkController@addLocation');
//    Route::get('work/{work}/approve','WorkController@approve')->name('work.approve');
//    Route::get('work/{work}/reject','WorkController@reject')->name('work.reject');
//    Route::resource('work','WorkController');
//
//    Route::get('profile', 'ProfileController@index')->name('profile.index');
//    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
//    Route::post('profile/edit', 'ProfileController@update')->name('profile.update');
//
//    Route::get('profile/picture/edit', 'ProfileController@profilePictureEdit')->name('profile.picture.edit');
//    Route::post('profile/picture/edit', 'ProfileController@profilePictureupdate')->name('profile.picture.update');
//
//    Route::get('change/password', 'ProfileController@changePasswordShow')->name('change.password');
//    Route::post('change/password', 'ProfileController@changePassword')->name('change.password.update');
//
//    Route::get('chat', 'ChatController@index')->name('chat.index');
//    Route::get('chat/user/list', 'ChatController@userList');
//    Route::get('chat/{role}/{id}', 'ChatController@message')->name('chat.message');
//    Route::post('chat', 'ChatController@messageSend')->name('chat.message.send');
//
//    Route::get('notification', 'NotificationController@index')->name('notification.index');
//    Route::get('search', 'SearchController@index')->name('search.index');
//    Route::post('logout', 'AuthController@logout')->name('logout');
//});
//
//
//Route::group(['middleware' => 'guest:admin'],function() {
//    Route::post('login', 'AuthController@login')->name('login');
//    Route::get('login', 'AuthController@showLoginForm')->name('login_form');
//
//    Route::post('forget-password', 'AuthController@forgetPassword')->name('forget_password');
//    Route::get('forget-password', 'AuthController@showForgetPasswordForm')->name('forget_password_form');
//
//    Route::post('setup-password/{token}', 'AuthController@setupPassword')->name('setup_password');
//    Route::get('setup-password/{token}', 'AuthController@showSetupPasswordForm')->name('setup_password_form');
//});


