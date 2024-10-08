<?php

namespace App\Http\Controllers\Driver\Api;


use App\Http\Resources\LoadBoardResource;
use App\Http\Resources\MyLoadBoardResource;
use App\Jobs\DriverRegisterJob;
use App\Mail\DriverEmailResetMail;
use App\Mail\DriverRegisterMail;
use App\Models\Biding;
use App\Models\BidingUser;
use App\Models\Driver;
use App\Models\LoadBoard;
use App\Models\LoadBoardUser;
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

class LoadBoardController extends BaseController
{

    use JsonMessages;

    public function loadBoard()
    {

        $id = auth('driver')->id();
        $data = LoadBoardUser::where([
            'table_type' => Driver::class,
            'table_id' => $id
        ])->pluck('load_board_id')->toArray();

        $work = LoadBoard::where('table_id', null)->whereNotIn('id', $data)->orderBy('created_at', 'desc')->paginate(request('items') ?? 100000000);

        return $this->returnMultipleData([
            'data' => LoadBoardResource::collection($work),
            'pagenation' => $this->pagenationData($work)
        ]);
    }

    public function loadBoardStore(Request $request,$id)
    {
        if (!$loadBoard = LoadBoard::where([
            'id' => $id
        ])->first()){
            abort(404);
        }

        $request->validate([
            'amount' => 'required|numeric|max:9999999999'
        ]);

        if ($bidUser = LoadBoardUser::where([
            'load_board_id' => $id,
            'table_type' => Driver::class,
            'table_id' => auth('driver_api')->id(),
        ])->first()){
            $bidUser->update([
                'amount' => $request->amount
            ]);
        }else{
            LoadBoardUser::create([
                'load_board_id' => $id,
                'table_type' => Driver::class,
                'table_id' => auth('driver_api')->id(),
                'amount' => $request->amount
            ]);
        }

        return $this->successMessage("Apply successful.");
    }

    public function myLoadBoard()
    {

        $works = LoadBoardUser::where('table_type', Driver::class)
            ->with('loadBoard')
            ->where('table_id', auth('driver_api')->id())->orderBy('created_at', 'desc')->paginate(request('items') ?? 100000000);

        return $this->returnMultipleData([
            'data' => MyLoadBoardResource::collection($works),
            'pagenation' => $this->pagenationData($works)
        ]);
    }

}
