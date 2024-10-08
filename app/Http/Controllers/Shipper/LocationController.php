<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\District;
use App\Models\LocalBody;

class LocationController extends Controller
{
    public function getStates()
    {
        $states = State::all();
        return response()->json($states);
    }

    public function getDistricts(Request $request)
    {

        if($request->has('state_id') && $request->state_id != ''){
            $districts = District::where('state_id', $request->state_id)->get();
        }else{
            $districts = District::all();
        }
        return response()->json($districts);
    }

    public function getLocalBodies(Request $request)
    {
        if($request->has('district_id') && $request->district_id != ''){
            $localBodies = LocalBody::where('district_id', $request->district_id)->get();
        }else{
            $localBodies = LocalBody::all();
        }
        return response()->json($localBodies);
    }
}
