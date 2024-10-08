<?php

namespace App\DataTables\SuperAdmin;

use App\Models\Payroll;
use App\Models\Work;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PayrollDataTable extends DataTable
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
            ->addColumn('transaction_number', function ($query) {
                return $query->payroll->transaction_number ?? "";
            })
            ->addColumn('amount', function ($query) {
                return '$ '.($query->payroll->amount ?? 0);
            })
            ->addColumn('pay_date', function ($query) {
                return isset($query->payroll->date)?format_date($query->payroll->date) : "";
            })
            ->editColumn('statue', function ($query) {
                return $query->payroll->status ?? "";
            })
            ->addColumn('order_no', function ($query){
                return "SE-" . $query->id + 1000;
            })
            ->addColumn('unit_number', function ($query) {
                return $query->driver->unit_number ?? "";
            })
            ->addColumn('action', function ($query) {

                return view('superadmin.theme_one.payroll.button.action', ['row' => $query, 'base_route' => 'super_admin.account.payroll', 'loginbtn' => true]);
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
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('admin-table')
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
            Column::make('transaction_number'),
            Column::make('amount'),
            Column::make('pay_date'),
            Column::make('statue'),
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
        return 'Payroll_' . date('YmdHis');
    }
}
