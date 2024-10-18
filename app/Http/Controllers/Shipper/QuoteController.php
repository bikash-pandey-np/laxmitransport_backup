<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\QuoteStop;
use App\Models\QuoteStopItem;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class QuoteController extends Controller
{
    public function getQuotePage()
    {
        return Inertia::render('Shipper/Quote/Index', [
            'title' => 'Quotes - ' . env('SHIPPER_APP_NAME'),
        ]);
    }

    public function getQuoteForParcelandLtl(Request $request)
    {
        // Laravel Validation Rules
        $validator = Validator::make($request->all(), [
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'pickup_date' => 'required|date|after:today',
            'instructions' => 'nullable|string|max:500',

            'form_type' => 'required|in:parcel,ltl',
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

        try{

            DB::beginTransaction();

            $quote = Quote::create([
                'load_type' => $request->form_type,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'pickup_date' => $request->pickup_date,
                'instructions' => $request->instructions,
                'shipper_id' => auth()->guard('shipper')->user()->id,
            ]);

            foreach($request->items as $item){
                QuoteItem::create([
                    'quote_id' => $quote->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'weight' => $item['weight'],
                    'length' => $item['length'],
                    'width' => $item['width'],
                    'height' => $item['height'],
                    'is_stackable' => $item['isStackable'],
                    'is_hazardous' => $item['isHazard'],
                ]);
            }   

            DB::commit();

            return back()->with('success', 'Quote created successfully');
        }
        catch(Throwable $e){
            DB::rollBack();
            Log::error('Error QuoteController@getQuoteForParcelandLtl: '.$e->getMessage() . ' on line ' . $e->getLine());
            return back()->with('error', 'Something went wrong');
        }


    }

    public function getTruckLoadQuote(Request $request)
    {
        // Laravel Validation Rules
        $validator = Validator::make($request->all(), [
            'origin' => 'required|string|max:255',
            'pickup_date' => 'required|date|after:today',
            'form_type' => 'required|in:truckload',
            'stops' => 'required|array|min:1',
            'stops.*.destination' => 'required|string|max:255',
            'stops.*.instructions' => 'nullable|string|max:255',
            'stops.*.items' => 'required|array|min:1',
            'stops.*.items.*.description' => 'required|string|max:255',
            'stops.*.items.*.quantity' => 'required|integer|min:1',
            'stops.*.items.*.weight' => 'required|numeric|min:0',
            'stops.*.items.*.length' => 'required|numeric|min:0',
            'stops.*.items.*.width' => 'required|numeric|min:0',
            'stops.*.items.*.height' => 'required|numeric|min:0',
            'stops.*.items.*.isStackable' => 'required|boolean',
            'stops.*.items.*.isHazard' => 'required|boolean',
        ], [
            'origin.required' => 'Please enter a valid origin.',
            'pickup_date.required' => 'Please enter a valid pickup date.',
            'pickup_date.after' => 'The pickup date must be a date after today.',
            'form_type.required' => 'Please select a form type.',
            'stops.required' => 'Please enter at least one stop.',
            'stops.*.destination.required' => 'Please enter a valid destination.',
            'stops.*.instructions.max' => 'The instructions may not be greater than 255 characters.',
            
            'stops.*.items.required' => 'Please enter at least one item.',
            'stops.*.items.array' => 'The items must be an array.',
            'stops.*.items.min' => 'You must provide details for at least one item.',
            'stops.*.items.*.description.required' => 'Please enter a valid description.',
            'stops.*.items.*.quantity.required' => 'Please enter a valid quantity.',
            'stops.*.items.*.quantity.min' => 'The item quantity must be greater than 0.',
            'stops.*.items.*.weight.required' => 'Please enter a valid weight.',
            'stops.*.items.*.length.required' => 'Please enter a valid length.',
            'stops.*.items.*.width.required' => 'Please enter a valid width.',
            'stops.*.items.*.height.required' => 'Please enter a valid height.',
            'stops.*.items.*.isHazard.required' => 'Please enter a valid stackable status.',
            'stops.*.items.*.isStackable.required' => 'Please enter a valid hazard status.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try{

            DB::beginTransaction();

            $quote = Quote::create([
                'load_type' => 'truckload',
                'origin' => $request->origin,
                'pickup_date' => $request->pickup_date,
                'shipper_id' => auth()->guard('shipper')->user()->id,
            ]);

            foreach($request->stops as $stop){
                $quoteStop = QuoteStop::create([
                    'quote_id' => $quote->id,
                    'destination' => $stop['destination'],
                    'instructions' => $stop['instructions'],
                ]);

                foreach($stop['items'] as $item){
                    QuoteStopItem::create([
                        'quote_stop_id' => $quoteStop->id,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'weight' => $item['weight'],
                        'length' => $item['length'],
                        'width' => $item['width'],
                        'height' => $item['height'],
                        'is_stackable' => $item['isStackable'],
                        'is_hazardous' => $item['isHazard'],
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'Quote created successfully');

        }
        catch(Throwable $th)
        {
            DB::rollBack();
            Log::error('Error QuoteController@getTruckLoadQuote: '.$th->getMessage() . ' on line ' . $th->getLine());
            return back()->with('error', 'Something went wrong');
        }

    }
}
