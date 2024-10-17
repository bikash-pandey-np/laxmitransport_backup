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

            'form_type' => 'required|in:parcel,ltl,truckload',
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
}
