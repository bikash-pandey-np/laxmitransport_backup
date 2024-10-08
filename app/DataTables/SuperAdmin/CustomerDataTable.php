<?php

namespace App\DataTables\SuperAdmin;

use App\Models\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
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
            ->addColumn('crop_id', function ($query) {
                return "SEL-" . (1000 + $query->id);
            })
            ->addColumn('brokerage_name', function ($query) {
                return $query->name;
            })
            ->addColumn('action', function ($query) {
                /*if ($query->status == 1){
                    return "";
                }*/
                return view('superadmin.theme_one.customer.button.action', ['row' => $query, 'base_route' => 'super_admin.customer']);
            })->rawColumns(['full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
    {
        return $model->orderBy('name', 'ASC')->newQuery();
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
            Column::make('crop_id'),
            Column::make('brokerage_name'),
            // Column::make('business_address'),
            // Column::make('city_st_zip'),
            Column::make('phone_number'),
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
        return 'Customer_' . date('YmdHis');
    }
}
