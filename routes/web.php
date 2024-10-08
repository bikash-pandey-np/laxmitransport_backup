<?php

use Illuminate\Support\Facades\Route;
use \App\Events\Chat;
use App\Events\RealTimeMessage;
use Inertia\Inertia;
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
Route::get('test', function(){
 return Inertia::render('Test');
});
Route::get('/', 'HomeController@home')->name('home');
Route::get('/aboutus', 'HomeController@aboutus')->name('aboutus');
Route::get('/customer', 'HomeController@customer')->name('customer');
Route::get('/safety', 'HomeController@safety')->name('safety');
Route::get('/tracking', 'HomeController@tracking')->name('tracking');
Route::post('/order', 'HomeController@order')->name('quote.order');
// Route::redirect('/','driver/login');

Route::get('broadcase', function () {
    event(new RealTimeMessage([
        'name' => 'Hello World'
    ]));
    broadcast(new Chat());
});
