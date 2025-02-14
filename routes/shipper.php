<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shipper\AuthController;
use App\Http\Controllers\Shipper\LocationController;
use App\Http\Controllers\Shipper\DashboardController;
use App\Http\Controllers\Shipper\QuoteController;
use Inertia\Inertia;

// Route::domain('shipper.laxmicloud.com')->group(function () {
    Route::prefix('register')->group(function () {
        Route::get('/', [AuthController::class, 'register'])
            ->name('shipper.auth.register')
            ->middleware('shipper_already_logged_in');
        Route::post('/', [AuthController::class, 'store']);
    });

    Route::prefix('login')->group(function () {
        Route::get('/', [AuthController::class, 'login'])
            ->name('shipper.auth.login')
            ->middleware('shipper_already_logged_in');
        Route::post('/', [AuthController::class, 'handleLogin']);
    });

    Route::prefix('location')->group(function () {
        Route::get('/states', [LocationController::class, 'getStates']);
        Route::get('/districts', [LocationController::class, 'getDistricts']);
        Route::get('/local-bodies', [LocationController::class, 'getLocalBodies']);
    });

    Route::middleware(['onlyShipper'])->group(function () {
        Route::prefix('verify-email')->group(function () {
            Route::get('/', [AuthController::class, 'getVerifyPage'])
                ->name('shipper.auth.verify');
            Route::post('/send-email', [AuthController::class, 'sendEmail']);
        });

        Route::post('/verify', [AuthController::class, 'verifyEmail']);
    });

    // Protected routes
    Route::middleware(['onlyShipper'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('shipper.dashboard');
        });

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('shipper.logout');

        Route::get('/dashboard', [DashboardController::class, 'getDashboard'])
            ->name('shipper.dashboard');

        Route::get('/quote', [QuoteController::class, 'getQuotePage'])
            ->name('shipper.quote');

        Route::post('/quote', [QuoteController::class, 'getQuoteForParcelandLtl']);

        Route::post('/truckload-quote', [QuoteController::class, 'getTruckLoadQuote']);
    });


// });
