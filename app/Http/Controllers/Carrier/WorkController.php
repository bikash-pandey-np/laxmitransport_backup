<?php

namespace App\Http\Controllers\Carrier;


use App\Models\Carrier;
use App\Models\Work;
use App\Models\WorkLocation;
use App\Models\WorkStatusTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkController extends CarrierBaseController
{
    public $view_path = "work";
    public $base_route = "work";
    public $title = "Work";

    public function status($status)
    {
        if (request('status') == 'delivery') {
            $works = Work::with("workLocations")->where([
                'driver_id' => auth('carrier')->id(),
                'user_type' => Carrier::class,
            ])->whereIn('status', ['Unloaded','Cancel'])->orderBy('id', 'desc')->get();
        } else {
            $works = Work::with("workLocations")->where([
                'driver_id' => auth('carrier')->id(),
                'user_type' => Carrier::class,
            ])->whereNotIn('status', [ 'Unloaded','Cancel'])->orderBy('id', 'desc')->get();
        }
        return view(parent::__loadView('index'), compact('works'));
    }

    public function edit($id)
    {
        if (!$location = WorkLocation::find($id)) {
            abort(404);
        }

        $row = $location->work;

        return view(parent::__loadView('edit'), compact('row', 'location'));
    }

    public function show($id)
    {
        if (!$row = Work::find($id)) {
            abort(404);
        }
        return view(parent::__loadView('show'), compact('row'));
    }

    public function update(Request $request, $id)
    {

        $rule = [
            'status' => [
                'required',
                Rule::in([
                    'On Route To Pickup',
                    'On Site At Pickup',
                    'Loaded At Shipper',
                    'On Route To Delivered',
                    'On Site At Cosignee',
                    'Cancel',
                    'Unloaded'
                ])
            ]
        ];
        if ($request->status !== "Cancel") {
            $rule['date'] = 'required|date_format:m/d/Y';
            $rule['time'] = 'required';
        }

        $request->validate($rule);

        if (!$row = WorkLocation::find($id)) {
            abort(404);
        }

        if ($row->work->admin_status_approved == 0) {
            return abort(403);
        }

        $row->work->update([
            'status' => $request->status,
            'admin_status_approved' => ($request->status !== "Cancel") ? 0 : 1
        ]);

        if ($workStatusTime = WorkStatusTime::where([
            'work_id' => $row->work_id,
            'status' => $request->status
        ])->first()) {
            $workStatusTime->update([
                'date' => $request->date ?? date('Y-m-d'),
                'time' => format_local_to_server($request->time) ?? date('H:i:s'),
            ]);
        } else {
            WorkStatusTime::create([
                'date' => $request->date ?? date('Y-m-d'),
                'time' => format_local_to_server($request->time) ?? date('H:i:s'),
                'work_id' => $row->work_id,
                'status' => $request->status
            ]);
        }

        if ($request->status == "Loaded At Shipper") {
            $row->update([
                'pickup_date' => $request->date,
                'pickup_time' => format_local_to_server($request->time),
                'pickup_note' => $request->pickup_note
            ]);
        }

        if ($request->status == "Unloaded") {
            $row->update([
                'drop_date' => $request->date,
                'drop_time' => format_local_to_server($request->time),
                'drop_note' => $request->drop_note
            ]);

            $row->work->update([
                'delivery_pod_signed_by' => $request->delivery_pod_signed_by
            ]);
        }

        $row->images()->where([
            'status_type' => $request->status
        ])->delete();

        if (isset($request->images) && is_array($request->images) && count($request->images) > 0) {
            foreach ($request->images as $image) {
                $row->images()->create([
                    'status_type' => $request->status,
                    'image' => $this->imageUploadByThumb($image)
                ]);
            }
        }

        return redirect()->route('carrier.work.index', 'on_site')->with('success', 'Update Successful');
    }
}
