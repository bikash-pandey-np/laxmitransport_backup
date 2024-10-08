<?php

namespace App\DataTables\SuperAdmin;

use App\Models\WorkStatus;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WorkStatusDataTable extends DataTable
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
            ->addColumn('bill_number',function($query){
                return "SB-".(1000+$query->id);
            })
            ->addColumn('action', function ($query){
                /*if ($query->status == 1){
                    return "";
                }*/
                return view('superadmin.theme_one.common.button.action',['row' => $query,'base_route' => 'super_admin.configuration.status']);
            })->rawColumns(['full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkStatus $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkStatus $model)
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
            Column::make('id'),
            Column::make('title'),
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
        return 'WorkStatus_' . date('YmdHis');
    }
}
