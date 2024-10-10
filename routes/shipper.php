<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shipper\AuthController;
use App\Http\Controllers\Shipper\LocationController;
use App\Http\Controllers\Shipper\DashboardController;
use App\Http\Controllers\Shipper\QuoteController;
use Inertia\Inertia;


Route::prefix('register')->group(function(){
    Route::get('/', [AuthController::class, 'register'])
        ->name('shipper.auth.register');

    Route::post('/', [AuthController::class, 'store']);
});

Route::prefix('login')->group(function(){
    Route::get('/', [AuthController::class, 'login'])
        ->name('shipper.auth.login');

    Route::post('/', [AuthController::class, 'handleLogin']);
});

Route::prefix('location')->group(function(){
    Route::get('/states', [LocationController::class, 'getStates']);
    Route::get('/districts', [LocationController::class, 'getDistricts']);
    Route::get('/local-bodies', [LocationController::class, 'getLocalBodies']);
});

//protected routes
Route::middleware('onlyShipper')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'getDashboard'])
    ->name('shipper.dashboard');
    
    Route::get('/quote', [QuoteController::class, 'getQuotePage'])
        ->name('shipper.quote');

    Route::post('/quote', [QuoteController::class, 'getQuote']);

});
