<?php

namespace App\DataTables\SuperAdmin;

use App\Models\LoadBoard;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LoadBoardCompleteDataTable extends DataTable
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
            ->addColumn('pickup_date_time',function($query){
                return format_date($query->pickup_date).' '.format_server_to_local($query->pickup_time);
            })
            ->addColumn('drop_date_time',function($query){
                return format_date($query->drop_date).' '.format_server_to_local($query->drop_time);
            })
            ->addColumn('action', function ($query){
                return view('superadmin.theme_one.loadboard.button.action',['row' => $query,'base_route' => 'super_admin.loadboard']);
            })->rawColumns(['full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LoadBoard $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LoadBoard $model)
    {
        return $model->where([
            'table' => null,
            'table_id' => null,
        ])->orderBy('created_at','desc')->newQuery();
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
            Column::make('pickup_company_name'),
            Column::make('pickup_address'),
            Column::make('pickup_city_st_zip_code'),
            Column::make('pickup_date_time'),
            Column::make('drop_company_name'),
            Column::make('drop_address'),
            Column::make('drop_city_st_zip_code'),
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
        return 'LoadBoard_' . date('YmdHis');
    }
}
