<?php

namespace App\Http\Controllers\Driver\Api;


use App\Http\Controllers\Driver\DriverBaseController;
use App\Http\Resources\WorkResource;
use App\Models\Biding;
use App\Models\BidingUser;
use App\Models\Work;
use App\Models\WorkLocation;
use App\Models\WorkStatusTime;
use App\Traits\JsonMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class NotificationController extends DriverBaseController
{

    use JsonMessages;

    public function availableWorks()
    {
        $work = WorkLocation::select([
            'w.*',
            'work_locations.pickup_city_state_zipcode',
            'work_locations.pickup_street_name',
            'work_locations.pickup_house_number',
            'work_locations.drop_city_state_zipcode',
            'work_locations.drop_street_name',
            'work_locations.drop_house_number',
        ])
            ->join('works as w', 'w.id', '=', 'work_locations.work_id')
            ->where('w.driver_id', auth('driver_api')->id())
            ->whereIn('w.status', ['pending', 'On Route To Pickup', 'On Site At Pickup', 'Loaded At Shipper', 'On Route To Delivered', 'On Site At Cosignee'])
            ->paginate(5);

        return $this->returnMultipleData([
            'data' => new WorkResource($work),
            'pagenation' => $this->pagenationData($work)
        ]);
    }

    public function availableWork()
    {
        $work = Work::select([
            'works.*',
            'work_locations.pickup_city_state_zipcode',
            'work_locations.pickup_street_name',
            'work_locations.pickup_house_number',
            'work_locations.drop_city_state_zipcode',
            'work_locations.drop_street_name',
            'work_locations.drop_house_number',
        ])
            ->join('work_locations', 'works.id', '=', 'work_locations.work_id')
            ->where('works.driver_id', auth('driver_api')->id())
            ->whereNotIn('status', ['Unloaded','cancel'])
            ->orderBy('created_at', 'desc')->paginate(5);
        return $this->returnMultipleData([
            'data' => new WorkResource($work),
            'pagenation' => $this->pagenationData($work)
        ]);
    }

    public function biding()
    {
        $id = auth('driver_api')->id();
        $data = BidingUser::where('driver_id', $id)->pluck('work_id')->toArray();
        $work = Biding::select([
            'works.*',
            'work_locations.pickup_city_state_zipcode',
            'work_locations.pickup_street_name',
            'work_locations.pickup_house_number',
            'work_locations.drop_city_state_zipcode',
            'work_locations.drop_street_name',
            'work_locations.drop_house_number',
        ])
            ->join('work_locations', 'works.id', '=', 'work_locations.work_id')
            ->where('works.driver_id', null)->whereNotIn('works.id', $data)->orderBy('created_at', 'desc')->paginate(5);

        return $this->returnMultipleData([
            'data' => new WorkResource($work),
            'pagenation' => $this->pagenationData($work)
        ]);
    }

    public function bidingStore(Request $request)
    {
        if (!$bid = Biding::where([
            'driver_id' => null,
            'id' => $request->id
        ])->first()) {
            return $this->returnNotFoundError();
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|max:9999999999'
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError($validator->errors());
        }

        if ($bidUser = BidingUser::where([
            'work_id' => $request->id,
            'driver_id' => auth('driver_api')->id(),
        ])->first()) {
            $bidUser->update([
                'amount' => $request->amount
            ]);
        } else {
            $bidUser = BidingUser::create([
                'work_id' => $request->id,
                'driver_id' => auth('driver_api')->id(),
                'amount' => $request->amount
            ]);
        }

        return $this->successMessage("Biding successful.");
    }

    public function myBiding()
    {
        $work = Biding::select([
            'works.*',
            'work_locations.pickup_city_state_zipcode',
            'work_locations.pickup_street_name',
            'work_locations.pickup_house_number',
            'work_locations.drop_city_state_zipcode',
            'work_locations.drop_street_name',
            'work_locations.drop_house_number',
        ])
            ->join('work_locations', 'works.id', '=', 'work_locations.work_id')
            ->where('driver_id', auth('driver_api')->id())->orderBy('created_at', 'desc')->paginate(5);

        return $this->returnMultipleData([
            'data' => new WorkResource($work),
            'pagenation' => $this->pagenationData($work)
        ]);
    }

    public function changeStatus(Request $request,$id)
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

        if (!$work = Work::find($id)) {
            return $this->returnNotFoundError();
        }

        $row = $work->workLocation;

        if ($row->work->admin_status_approved == 0) {
//            return $this->returnNotPermissionError();
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

            auth('driver_api')->user()->update([
                'available_city' => $row->work->origin_destination,
                'available_date' => $request->date,
                'available_time' => format_local_to_server($request->time),
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

            auth('driver_api')->user()->update([
                'available_city' => $row->work->drop_destination,
                'available_date' => $request->date,
                'available_time' => format_local_to_server($request->time),
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

        return $this->successMessage("Status Update Successful.");
    }

}
