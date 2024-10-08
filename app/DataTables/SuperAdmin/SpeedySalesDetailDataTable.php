<?php

namespace App\DataTables\SuperAdmin;

use App\Models\SpeedySalse;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use function React\Promise\all;

class SpeedySalesDetailDataTable extends DataTable
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
            ->addColumn('order_no', function ($query) {
                return "SE-" . $query->work->id + 1000;
            })
            ->addColumn('brokerage_name', function ($query) {
                return $query->work->brokerage_name ?? "";
            })
            ->addColumn('mobile_number', function ($query) {
                return $query->work->customer->phone_number ?? "";
            })
            ->addColumn('billing_email', function ($query) {
                return $query->work->customer->bill_info_accounting_email ?? "";
            })
            ->editColumn('date', function ($query) {
                return ($query->date == null)?"":format_date($query->date);
            })
            ->editColumn('amount', function ($query) {
                return '$ '.$query->amount;
            })
            ->addColumn('action', function ($query) {
                return view('superadmin.theme_one.account.button.edit_action', ['row' => $query, 'base_route' => 'super_admin.account.speedy-sales', 'loginbtn' => true]);
            })->rawColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SpeedySalse $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SpeedySalse $model)
    {
        return $model->where('work_id', request('speedy_sale'))->orderBy('created_at', 'DESC')->newQuery();
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
            Column::make('mobile_number'),
            Column::make('amount'),
            Column::make('date'),
            Column::make('billing_email'),
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
        return 'SpeedySalse_' . date('YmdHis');
    }
}
