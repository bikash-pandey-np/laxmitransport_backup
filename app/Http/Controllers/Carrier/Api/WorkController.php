<?php

namespace App\Http\Controllers\Driver\Api;


use App\Http\Resources\WorkResource;
use App\Jobs\DriverRegisterJob;
use App\Mail\DriverEmailResetMail;
use App\Mail\DriverRegisterMail;
use App\Models\Biding;
use App\Models\BidingUser;
use App\Models\Driver;
use App\Models\Work;
use App\Models\WorkLocation;
use App\Models\WorkStatusTime;
use App\Traits\JsonMessages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WorkController extends BaseController
{

    use JsonMessages;

    /**
     *
     * @OA\Info(title="My First API", version="0.1")
     *
     * @OA\Post(
     *      path="/driver/api/login",
     *      operationId="logindriver",
     *      tags={"Driver Auth"},
     *      summary="Login a driver",
     *      description="Returns authindation token",
     *      @OA\RequestBody(
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
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
            abort(404);
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

        $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'On Route To Pickup',
                    'On Site At Pickup',
                    'Loaded At Shipper',
                    'On Route To Delivered',
                    'On Site At Cosignee',
                    'Unloaded'
                ])
            ],
            'date' => 'required|date_format:m/d/Y',
            'time' => 'required',
        ]);

        if (!$row = WorkLocation::find($id)){
            return $this->returnNotFoundError();
        }

        if ($row->work->admin_status_approved == 0 || $row->work->status == "pending"){
//            return $this->returnNotPermissionError();
        }

        $row->work->update([
            'status' => $request->status,
            'admin_status_approved' => 0
        ]);

        if ($workStatusTime = WorkStatusTime::where([
            'work_id' => $row->work_id,
            'status' => $request->status
        ])->first()){
            $workStatusTime->update([
                'date' => $request->date,
                'time' => format_local_to_server($request->time),
            ]);
        }else{
            WorkStatusTime::create([
                'date' => $request->date,
                'time' => format_local_to_server($request->time),
                'work_id' => $row->work_id,
                'status' => $request->status
            ]);
        }

        if($request->status == "Loaded At Shipper"){
            $row->update([
                'pickup_date' => $request->date,
                'pickup_time' => format_local_to_server($request->time),
                'pickup_note' => $request->pickup_note
            ]);
        }

        if($request->status == "Unloaded"){
            $row->update([
                'drop_date' => $request->date,
                'drop_time' => format_local_to_server($request->time),
                'drop_note' => $request->drop_note
            ]);
        }

        $row->images()->where([
            'status_type' => $request->status
        ])->delete();

        if (isset($request->images) && is_array($request->images) && count($request->images)>0){
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
