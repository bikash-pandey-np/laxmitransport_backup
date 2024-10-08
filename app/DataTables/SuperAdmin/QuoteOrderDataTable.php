<?php

namespace App\DataTables\SuperAdmin;

use App\Models\QuoteOrder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class QuoteOrderDataTable extends DataTable
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
            ->addColumn('action', function ($query){
                return view('superadmin.theme_one.admin.button.action',['row' => $query,'base_route' => 'super_admin.admin']);
            })->rawColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\QuoteOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(QuoteOrder $model)
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
            Column::make('pickup_company_address'),
            Column::make('pickup_company_city_zip_code'),
            Column::make('pickup_date'),
            Column::make('drop_address'),
            Column::make('drop_city_zip_code'),
            Column::make('drop_date')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'QuoteOrder_' . date('YmdHis');
    }
}
