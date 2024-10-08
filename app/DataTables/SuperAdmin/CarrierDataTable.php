<?php

namespace App\DataTables\SuperAdmin;

use App\Models\Carrier;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CarrierDataTable extends DataTable
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
            ->addColumn('carrier_id',function($query){
                return "CU-".(1000+$query->id);
            })
            ->addColumn('carrier_name',function($query){
                return $query->name;
            })
            ->addColumn('action', function ($query){
                /*if ($query->status == 1){
                    return "";
                }*/
                return view('superadmin.theme_one.carrier.button.action',['row' => $query,'base_route' => 'super_admin.carrier']);
            })->rawColumns(['full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Carrier $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Carrier $model)
    {
        return $model->orderBy('created_at','desc')->newQuery();
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
            Column::make('carrier_id'),
            Column::make('carrier_name'),
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
        return 'Carrier_' . date('YmdHis');
    }
}
