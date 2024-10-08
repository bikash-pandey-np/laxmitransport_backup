<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shipper\AuthController;
use Inertia\Inertia;

Route::get('/register', [AuthController::class, 'register'])
    ->name('shipper.auth.register');
