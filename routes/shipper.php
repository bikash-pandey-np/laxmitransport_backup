<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shipper\AuthController;
use App\Http\Controllers\Shipper\LocationController;

use Inertia\Inertia;


Route::prefix('register')->group(function(){
    Route::get('/', [AuthController::class, 'register'])
        ->name('shipper.auth.register');

    Route::post('/', [AuthController::class, 'store']);
});


Route::prefix('location')->group(function(){
    Route::get('/states', [LocationController::class, 'getStates']);
    Route::get('/districts', [LocationController::class, 'getDistricts']);
    Route::get('/local-bodies', [LocationController::class, 'getLocalBodies']);
});
