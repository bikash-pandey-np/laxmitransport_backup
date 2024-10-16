<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
class QuoteController extends Controller
{
    public function getQuotePage()
    {
        return Inertia::render('Shipper/Quote/Index', [
            'title' => 'Quotes - ' . env('SHIPPER_APP_NAME'),
        ]);
    }

    public function getQuote(Request $request)
    {
        dd($request->all());
        // Laravel Validation Rules
        $validator = Validator::make($request->all(), [
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'pickup_date' => 'required|date|after:today',
            'instructions' => 'nullable|string|max:500',

            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.weight' => 'required|numeric|min:0',
            'items.*.length' => 'required|numeric|min:0',
            'items.*.width' => 'required|numeric|min:0',
            'items.*.height' => 'required|numeric|min:0',
        ],[
            'origin.required' => 'The origin field is required.',
            'destination.required' => 'The destination field is required.',
            'pickup_date.required' => 'The pickup date field is required.',
            'pickup_date.after' => 'The pickup date must be a date after today.',
            'instructions.max' => 'The instructions may not be greater than 500 characters.',
        
            'items.required' => 'You must provide at least one item.',
            'items.array' => 'The items must be an array.',
            'items.min' => 'You must provide details for at least one item.',
            'items.*.description.required' => 'The item description is required.',
            'items.*.quantity.required' => 'The item quantity is required.',
            'items.*.quantity.min' => 'The item quantity must be greater than 0.',
            'items.*.weight.required' => 'The item weight is required.',
            'items.*.length.required' => 'The item length is required.',
            'items.*.width.required' => 'The item width is required.',
            'items.*.height.required' => 'The item height is required.',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        dd('validation passed');
    }
}
