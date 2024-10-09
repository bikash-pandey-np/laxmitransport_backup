<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuoteController extends Controller
{
    public function getQuotePage()
    {
        return Inertia::render('Shipper/Quote/Index', [
            'title' => 'Quotes - ' . env('SHIPPER_APP_NAME'),
        ]);
    }
}
