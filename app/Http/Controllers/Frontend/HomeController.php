<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\WorkTracking;
use Illuminate\Http\Request;
use App\Models\QuoteOrder;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        return view('frontend.theme_one.home');
    }

    public function aboutus()
    {
        return view('frontend.theme_one.aboutus');
    }

    public function customer()
    {
        return view('frontend.theme_one.customer');
    }

    public function safety()
    {
        return view('frontend.theme_one.safety');
    }

    public function tracking()
    {
        if (request()->work_id) {
            $order_arr  = explode('-', request()->work_id);
            $order_id = $order_arr[1] ?? $order_arr[0];
            $id = 'null';
            if (is_numeric($order_id) && $order_id > 1000) {
                $id = $order_id - 1000;
            }
            if ($id == 'null') {
                return redirect()->route('tracking')->with('error', 'Cannot find order with this id. Please enter the right one.');
            } else {
                $tracker_data = WorkTracking::where('work_id', $id)->get();
                return view('frontend.theme_one.tracking', compact('tracker_data'));
            }
        }
        return view('frontend.theme_one.tracking');
    }

    public function order(Request $request)
    {
        //    dd($request->all());
        $new_order = $request->all([
            "pickup_company_address",
            "pickup_company_city_zip_code",
            "pickup_date",
            "drop_address",
            "drop_city_zip_code",
            "drop_date"
        ]);
        $order = QuoteOrder::create($new_order);
        return redirect()->route('home')->with('success', 'Quote Submitted Successful.');
    }
}
