<?php

use App\Http\Controllers\SuperAdmin\SpeedySalesController;
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

Route::get('/admin-test', function(){
  return 'this is admin test';
});

Route::group(['middleware' => 'auth:super_admin'], function () {
    Route::get('change/timezone/{timezone}', function ($timeZone) {
        if (in_array($timeZone, [
            'kathmandu',
            'pacific',
            'mountain',
            'central',
            'eastern',
        ])) {
            if ($timeZone == "kathmandu") {
                session()->put('timezone', "asia/" . $timeZone);
            } else {
                session()->put('timezone', "us/" . $timeZone);
            }
        }

        return redirect()->back();

    })->name('change.timezone');
    Route::group(['prefix' => 'account', 'as' => "account."], function () {
        Route::get('speedy-sales/{id}/view', [SpeedySalesController::class,'viewPage']);
        Route::resource('speedy-sales', 'SpeedySalesController');
        Route::resource('payroll', 'PayrollController');
        Route::get('year-to-date-income', 'SpeedySalesController@yearToDateIncome')->name('year_to_date_income');
        Route::resource('bill', 'BillController');
        Route::resource('inventory', 'BillController');
    });

    Route::post('work-tracking/store', 'WorkController@trackLocationStore')->name('work_tracking.store');
    Route::delete('work-tracking/{id}/destroy', 'WorkController@trackLocationDelete')->name('work_tracking.destroy');

    Route::resource('customer', 'CustomerController');
    Route::post('carrier/{carrier}/login', 'CarrierController@login')->name('carrier.login');
    Route::resource('carrier', 'CarrierController');

    Route::get('loadboard/approve/{userid}', 'LoadBoardController@approveApply')->name('loadboard.approve');
    Route::get('loadboard/reject/{userid}', 'LoadBoardController@rejectApply')->name('loadboard.reject');
    Route::get('loadboard/complete', 'LoadBoardController@complete')->name('loadboard.complete');
    Route::get('loadboard/trip-monitor', 'LoadBoardController@tripMonitor')->name('loadboard.trip_monitor');
    Route::get('loadboard/applier', 'LoadBoardController@applier')->name('loadboard.applier');
    Route::get('loadboard/awarded', 'LoadBoardController@awarded')->name('loadboard.awarded');
    Route::resource('loadboard', 'LoadBoardController');

    Route::group(['prefix' => 'configuration', 'as' => "configuration."], function () {
        Route::resource('status', 'StatusController');
    });

    Route::get('dashboard', 'DashboardController@index')->name('index');
    Route::get('dashboard/google-map', 'DashboardController@getAddresses')->name('dashboard.google-map');
    Route::get('admin/{admin}/change/status', 'AdminController@changeStatus')->name('admin.change.status');
    Route::resource('admin', 'AdminController');

    Route::get('vehicle/available', 'VehicleController@available')->name('vehicle.available');
    Route::get('vehicle/not-available', 'VehicleController@notAvailable')->name('vehicle.not_available');
    Route::resource('vehicle', 'VehicleController');

    Route::get('trip-monter', 'DriverController@tripMonter')->name('trip.monter.index');
    Route::post('driver/{driver}/login', 'DriverController@login')->name('driver.login');
    Route::get('driver/track', 'DriverController@allTrack')->name('driver.all.track');
    Route::get('driver/{driver}/track', 'DriverController@track')->name('driver.track');
    Route::resource('driver', 'DriverController');

    Route::get('work/add/location', 'WorkController@addLocation');
    Route::get('work/{work}/approve', 'WorkController@approve')->name('work.approve');
    Route::get('work/{work}/reject', 'WorkController@reject')->name('work.reject');
    Route::resource('work', 'WorkController');

    Route::post('bid/{id}/approved', 'BidingController@bidApproved')->name('bid.approved');
    Route::resource('biding', 'BidingController');

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::post('profile/edit', 'ProfileController@update')->name('profile.update');

    Route::get('profile/picture/edit', 'ProfileController@profilePictureEdit')->name('profile.picture.edit');
    Route::post('profile/picture/edit', 'ProfileController@profilePictureupdate')->name('profile.picture.update');

    Route::get('change/password', 'ProfileController@changePasswordShow')->name('change.password');
    Route::post('change/password', 'ProfileController@changePassword')->name('change.password.update');

    Route::get('chat', 'ChatController@index')->name('chat.index');
    Route::get('chat/user/list', 'ChatController@userList');
    Route::get('chat/{role}/{id}', 'ChatController@message')->name('chat.message');
    Route::post('chat', 'ChatController@messageSend')->name('chat.message.send');

    Route::get('notification', 'NotificationController@index')->name('notification.index');
    Route::get('search', 'SearchController@index')->name('search.index');
    Route::post('logout', 'AuthController@logout')->name('logout');

    Route::resource('quote', 'QuoteOrderController');
});

Route::group(['middleware' => 'guest:super_admin'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('login', 'AuthController@showLoginForm')->name('login_form');

    Route::post('setup-password/{token}', 'AuthController@setupPassword')->name('setup_password');
    Route::get('setup-password/{token}', 'AuthController@showSetupPasswordForm')->name('setup_password_form');
});
