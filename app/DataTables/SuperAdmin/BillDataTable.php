<?php

namespace App\DataTables\SuperAdmin;

use App\Models\Bill;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BillDataTable extends DataTable
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
            ->addColumn('bill_number', function ($query) {
                return "SB-" . (1000 + $query->id);
            })
            ->addColumn('amount', function ($query) {
                return "$ " . $query->amount;
            })
            ->addColumn('action', function ($query) {
                /*if ($query->status == 1){
                    return "";
                }*/
                return view('superadmin.theme_one.bill.button.action', ['row' => $query, 'base_route' => 'super_admin.account.bill']);
            })->rawColumns(['full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Bill $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bill $model)
    {
        return $model->orderBy('created_at', 'desc')->newQuery();
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
            Column::make('bill_number'),
            Column::make('name'),
            Column::make('amount'),
            Column::make('pay_date'),
            // Column::make('country'),
            // Column::make('admin_note'),
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
        return 'Bill_' . date('YmdHis');
    }
}
