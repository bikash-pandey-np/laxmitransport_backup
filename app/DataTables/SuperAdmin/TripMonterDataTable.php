<?php

namespace App\DataTables\SuperAdmin;

use App\Models\Carrier;
use App\Models\Work;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use function React\Promise\all;

class TripMonterDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('status', function ($query) {

                if (!isset($query->status)){
                    return "";
                }

                $color = "red";
                if (in_array($query->status,['On Route To Pickup','On Route To Delivered'])){
                    $color = "orange";
                }elseif (in_array($query->status,['On Site At Pickup','On Site At Cosignee'])){
                    $color = "#78782c";
                }elseif (in_array($query->status,['Loaded At Shipper','uNLOADED'])){
                    $color = "green";
                }

                if ($color){
                    return '<a class="btn" style="background:'.$color.';color:#ffffff;">'.$query->status.'</a>';
                }

                return $query->status ?? "";
            })
            ->addColumn('order_no', function ($query) {
                return "SE-" . $query->id + 1000;
            })
            ->addColumn('brokerage_name', function ($query) {
                return $query->customer->name ?? "";
            })
            ->addColumn('unit_number', function ($query){
                if ($query->user_type == Carrier::class){
                    return "CU-".(1000+$query->carrier->id);
                }

                return $query->vehicle->driver->unit_number ?? "";
                return (isset($query->vehicle->vehicle_id))?'Unit - '.$query->vehicle->vehicle_id:"";
            })
            ->addColumn('company_name', function ($query){
                return $query->workLocation->company_name ?? "";
            })
            ->addColumn('pickup_date_time', function ($query){
                if (!isset($query->workLocation->pickup_date)){
                    return "";
                }
                $time = "";
                if (isset($query->workLocation->pickup_date) && isset($query->workLocation->pickup_time)){
                    $time = format_date(($query->workLocation->pickup_date ?? "")." ".($query->workLocation->pickup_time ?? ""),'m/d/Y H:i');
                }

                if (in_array($query->status,['Loaded At Shipper','On Route To Delivered','On Site At Cosignee','Unloaded'])){
                    return '<p style="background-color: green;color: #ffffff; padding: 5px;border-radius: 3px;">'.$time.'</p>';
                }

                return '<p style="background-color: #dc3545;color: #ffffff; padding: 5px;border-radius: 3px;">'.$time.'</p>';
            })
            ->addColumn('drop_date_time', function ($query){
                if (!isset($query->workLocation->drop_date)){
                    return "";
                }
                $time = "";
                if (isset($query->workLocation->drop_date) && isset($query->workLocation->drop_date)){
                    $time = format_date(($query->workLocation->drop_date ?? "")." ".($query->workLocation->drop_time ?? ""),'m/d/Y H:i');
                }

                if (in_array($query->status,['Unloaded'])){
                    return '<p style="background-color: green;color: #ffffff; padding: 5px;border-radius: 3px;">'.$time.'</p>';
                }

                return '<p style="background-color: #dc3545;color: #ffffff; padding: 5px;border-radius: 3px;">'.$time.'</p>';
            })
            ->addColumn('origin', function ($query){
                return $query->origin_destination;
            })
            ->addColumn('destination', function ($query){
                return $query->drop_destination;
            })
            ->addColumn('action', function ($query) {

                return view('superadmin.theme_one.work.button.action',['row' => $query,'base_route' => 'super_admin.work','loginbtn' => true]);
            })->rawColumns(['pickup_date_time','drop_date_time','current_location','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Work $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Work $model)
    {
        return $model->where('driver_id','!=',null)->whereIn('status',config('workstatus.trip_monitor'))->orderBy('created_at','DESC')->newQuery();
//        return $model->where('status','On Site At Pickup')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('driver-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->lengthMenu([config('app.page')])
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('order_no'),
            Column::make('unit_number'),
            Column::make('brokerage_name'),
            Column::make('pro_number'),
            Column::make('origin'),
            Column::make('destination'),
            Column::make('status'),
            Column::make('pickup_date_time'),
            Column::make('drop_date_time'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Work_' . date('YmdHis');
    }
}
