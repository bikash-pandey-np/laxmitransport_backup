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

    public function getQuote(Request $request)
    {
        // Laravel Validation Rules
        $rules = [
            'loadType' => 'required|in:Parcel,LTL,TruckLoad',
            'loadOrigin' => 'required',
            'pickupDate' => 'required|date',
            'deliverDestination' => 'required',
            'items' => 'required_if:loadType,Parcel,LTL|array|min:1',
            'items.*.description' => 'required',
            'items.*.packagingType' => 'required',
            'items.*.isStackable' => 'required|in:yes,no',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.totalWeight' => 'required|numeric|min:0',
            'items.*.length' => 'required|numeric|min:0',
            'items.*.width' => 'required|numeric|min:0',
            'items.*.height' => 'required|numeric|min:0',
            'truckType' => 'required_if:loadType,TruckLoad',
            'deliveryDate' => 'required_if:loadType,TruckLoad',
            'stops' => 'required_if:loadType,TruckLoad|array|min:1',
            'stops.*.address' => 'required_if:loadType,TruckLoad',
            'stops.*.items' => 'required_if:loadType,TruckLoad|array|min:1',
            'stops.*.items.*.description' => 'required',
            'stops.*.items.*.quantity' => 'required|integer|min:1',
            'stops.*.items.*.totalWeight' => 'required|numeric|min:0',
            'stops.*.items.*.length' => 'required|numeric|min:0',
            'stops.*.items.*.width' => 'required|numeric|min:0',
            'stops.*.items.*.height' => 'required|numeric|min:0',
            'stops.*.items.*.packagingType' => 'required',
            'stops.*.items.*.isStackable' => 'required|in:yes,no',
            'specialDeliveryInstruction' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        dd('validation passed');
    }
}
