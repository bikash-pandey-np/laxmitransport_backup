<?php

namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\BillDataTable;
use App\DataTables\SuperAdmin\SpeedySalesDataTable;
use App\DataTables\SuperAdmin\SpeedySalesDetailDataTable;
use App\Models\Bill;
use App\Models\Driver;
use App\Models\SpeedySalse;
use App\Models\Vehicle;
use App\Models\Work;
use App\Models\WorkLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpeedySalesController extends SuperAdminBaseController
{
    public $view_path = "account";
    public $base_route = "account.bill";
    public $title = "Order";

    public function __construct(Bill $model)
    {
        $this->model = $model;
    }

    public function index(SpeedySalesDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('speedy_sales'));
    }

    public function viewPage($id)
    {
        $row = SpeedySalse::find(request('speedy_id'));
        return view(parent::__loadView('view-page'), compact('row', 'id'));
    }

    public function edit(SpeedySalesDetailDataTable $dataTable, $id)
    {
        $row = SpeedySalse::find(request('speedy_id'));
        return $dataTable->render(parent::__loadView('speedy_sales_edit'), compact('row', 'id'));
    }

    public function update(Request $request, $id)
    {
        if (!$work = Work::find($id)) {
            abort(404);
        }

        $work->update([
            'salse_actual_amount' => $request->actual_amount,
            'salse_status' => $request->status_after_complete,
            'salse_date' => $request->date,
            'salse_admin_note' => $request->admin_note,
        ]);

        if (!$row = SpeedySalse::find(request('speedy_id'))) {
            SpeedySalse::create([
                'work_id' => $id,
                'amount' => $request->actual_amount,
                'date' => $request->date,
                'admin_note' => $request->admin_note,
                'status' => $request->status_after_complete,
            ]);
            return redirect()->back()->with('success', 'Sales add successful.');
        } else {
            $row->update([
                'amount' => $request->actual_amount,
                'date' => $request->date,
                'admin_note' => $request->admin_note,
                'status' => $request->status_after_complete,
            ]);
        }

        return redirect()->back()->with('success', 'Sales update successful.');
    }

    public function destroy($id)
    {
        if (!$row = SpeedySalse::find(request('speedy_id'))) {
            abort(404);
        } else {
            $row->delete();
        }

        return redirect()->back()->with('success', 'Sales delete successful.');
    }

    public function yearToDateIncome()
    {
        $drivers = Driver::where('unit_number', '!=', null)
            ->when(request('unit_number'), function ($q) {
                $q->where('unit_number', request('unit_number'));
            })
            ->orderBy('unit_number', 'ASC')->paginate(50);
        return view(parent::__loadView('year_to_date_income'), compact('drivers'));
    }
}
