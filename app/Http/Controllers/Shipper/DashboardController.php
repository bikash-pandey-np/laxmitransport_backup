<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        return Inertia::render('Shipper/Dashboard/Index', [
            'title' => 'Dashboard - ' . env('SHIPPER_APP_NAME'),
        ]);
    }
}
