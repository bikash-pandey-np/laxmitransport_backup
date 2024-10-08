<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function register()
    {
        return Inertia::render('Shipper/Auth/Register');
    }
}
