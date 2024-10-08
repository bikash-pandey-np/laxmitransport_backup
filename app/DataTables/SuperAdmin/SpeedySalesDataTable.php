<?php

namespace App\DataTables\SuperAdmin;

use App\Models\Work;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use function React\Promise\all;

class SpeedySalesDataTable extends DataTable
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
            ->addColumn('work_id', function ($query) {
                return "SE- " . $query->id + 99;
            })
            ->addColumn('status', function ($query) {
                if ($query->salse_status !== null) {
                    $status = $query->salse_status;
                }else{
                    $status = $query->status;
                }

                if ($status == 'Factored'){
                    $bg = 'blue';
                }elseif($status == 'Paid To Factoring'){
                    $bg = 'green';
                }elseif($status == 'Direct Invoice'){
                    $bg = 'orange';
                }elseif($status == 'Payment Settled') {
                    $bg = 'green';
                }else{
                    $bg = 'red';
                }

                return '<a class="btn btn-info" style="background-color: '.$bg.'">'.$status.'</a>';
            })
            ->addColumn('brokerage_name', function ($query) {
                return $query->customer->name ?? "";
            })
            ->addColumn('order_no', function ($query){
                return "SE-" . $query->id + 1000;
            })
            ->addColumn('unit_number', function ($query) {
                return $query->driver->unit_number ?? "";
            })
            ->addColumn('company_name', function ($query) {
                return $query->workLocation->company_name ?? "";
            })
            ->addColumn('driver_amount', function ($query) {
                return '<a class="btn btn-warning">$ '.($query->amount ?? 0.00).'</a>';
            })
            ->editColumn('actual_amount', function ($query) {
                return '<a class="btn btn-success">$ '.($query->salse_actual_amount ?? 0.00).'</a>';
            })
            ->addColumn('pickup_date_time', function ($query) {
                if (!isset($query->workLocation->pickup_date)) {
                    return "";
                }
                $time = "";
                if (isset($query->workLocation->pickup_date) && isset($query->workLocation->pickup_time)) {
                    $time = format_date(($query->workLocation->pickup_date ?? ""), 'Y-m-d').' '.format_server_to_local($query->workLocation->pickup_time ?? "");
                }

                if (in_array($query->status, ['Loaded At Shipper', 'On Route To Delivered', 'On Site At Cosignee', 'Unloaded'])) {
                    return '<p style="background-color: green;color: #ffffff; padding: 5px;border-radius: 3px;">' . format_server_to_local($time) . '</p>';
                }

                return '<p style="background-color: #dc3545;color: #ffffff; padding: 5px;border-radius: 3px;">' . format_server_to_local($time) . '</p>';
            })
            ->addColumn('drop_date_time', function ($query) {
                if (!isset($query->workLocation->drop_date)) {
                    return "";
                }
                $time = "";
                if (isset($query->workLocation->drop_date) && isset($query->workLocation->drop_date)) {
                    $time = format_date(($query->workLocation->drop_date ?? ""), 'Y-m-d').' '.format_server_to_local($query->workLocation->drop_time ?? "");
                }

                if (in_array($query->status, ['Unloaded'])) {
                    return '<p style="background-color: green;color: #ffffff; padding: 5px;border-radius: 3px;">' . format_server_to_local($time) . '</p>';
                }

                return '<p style="background-color: #dc3545;color: #ffffff; padding: 5px;border-radius: 3px;">' . format_server_to_local($time) . '</p>';
            })
            ->addColumn('origin', function ($query) {
                return $query->origin_destination;
                return view('superadmin.theme_one.work.button.current_location', ['row' => $query]);
            })
            ->addColumn('destination', function ($query) {
                return $query->drop_destination;
                return view('superadmin.theme_one.work.button.current_location', ['row' => $query]);
            })
            ->addColumn('action', function ($query) {

                return view('superadmin.theme_one.account.button.action', ['row' => $query, 'base_route' => 'super_admin.account.speedy-sales', 'loginbtn' => true]);
            })->rawColumns(['pickup_date_time', 'drop_date_time', 'current_location', 'status','driver_amount','actual_amount']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Work $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Work $model)
    {
        return $model->where('driver_id', '!=', null)->whereIn('status', ['cancel', 'Unloaded'])->orderBy('created_at', 'DESC')->newQuery();
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
            Column::make('brokerage_name'),
            Column::make('pro_number'),
            Column::make('origin'),
            Column::make('destination'),
            Column::make('actual_amount'),
            Column::make('status'),
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
