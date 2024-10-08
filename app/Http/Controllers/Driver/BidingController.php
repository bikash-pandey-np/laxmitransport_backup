<?php

namespace App\Http\Controllers\Driver;


use App\DataTables\Driver\BidingDataTable;
use App\DataTables\Driver\MyBidingDataTable;
use App\DataTables\Driver\WorkDataTable;
use App\Models\Biding;
use App\Models\BidingUser;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BidingController extends DriverBaseController
{
    public $view_path = "biding";
    public $base_route = "work";
    public $title = "Biding";

    public function index(BidingDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }

    public function myIndex(MyBidingDataTable $dataTable)
    {
        $this->title = "My Bidding";
        return $dataTable->render(parent::__loadView('index'));
    }

    public function create($id)
    {
        return view(parent::__loadView('create'));
    }

    public function store(Request $request,$id)
    {
        if (!$bid = Biding::where([
            'driver_id' => null,
            'id' => $id
        ])->first()){
            abort(404);
        }

        $request->validate([
            'amount' => 'required|numeric|max:9999999999'
        ]);

        if ($bidUser = BidingUser::where([
            'work_id' => $id,
            'driver_id' => auth('driver')->id(),
        ])->first()){
            $bidUser->update([
                'amount' => $request->amount
            ]);
        }else{
            $bidUser = BidingUser::create([
                'work_id' => $id,
                'driver_id' => auth('driver')->id(),
                'amount' => $request->amount
            ]);
        }

        return redirect()->route('driver.biding.my')->with('success','Bidding Successful');
    }

    public function edit($id)
    {
        if (!$row = Work::find($id)){
            abort(404);
        }
        return view(parent::__loadView('edit'),compact('row'));
    }

    public function show($id)
    {
        if (!$row = Work::find($id)){
            abort(404);
        }
        return view(parent::__loadView('show'),compact('row'));
    }

    public function update(Request $request,$id)
    {
        $rule = [];

        if ($request->status == 'picked_up'){
            $rule['pickup_city'] = 'required';
            $rule['pickup_state'] = 'required';
            $rule['pickup_zip_code'] = 'required';
        }

        if ($request->status == 'delivery'){
            $rule['delivery_city'] = 'required';
            $rule['delivery_state'] = 'required';
            $rule['delivery_zip_code'] = 'required';
        }

        $request->validate($rule);

        if (!$row = Work::find($id)){
            abort(404);
        }

        $data = $request->all();
        $data['admin_status_approved'] = 0;

        if ($row->status == 'on_site'){
            $status = 'picked_up';
            $data['pickup_date_time'] = Carbon::now();
        }

        if ($row->status == 'picked_up'){
            $status = 'delivery';
            $data['delivery_date_time'] = Carbon::now();
        }

        $row->update($data);

        $row->images()->where([
            'status_type' => $status
        ])->delete();

        if (isset($request->images) && is_array($request->images) && count($request->images)>0){
            foreach ($request->images as $image) {
                $row->images()->create([
                    'status_type' => $status,
                    'image' => $this->imageUploadByThumb($image)
                ]);
            }
        }

        return redirect()->route('driver.index')->with('success','Work Update Successful');
    }
}
