<?php

namespace App\DataTables\SuperAdmin;

use App\Models\SuperAdmin;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminDataTable extends DataTable
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
            ->addColumn('full_name', function ($query) {
                return '<a href="' . route('super_admin.admin.show', $query->id) . '">' . $query->first_name . ' ' . $query->last_name . '</a>';
            })
            ->addColumn('action', function ($query) {
                /*if ($query->status == 1){
                    return "";
                }*/
                return view('superadmin.theme_one.admin.button.action', ['row' => $query, 'base_route' => 'super_admin.admin']);
            })->rawColumns(['full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SuperAdmin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SuperAdmin $model)
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
            Column::make('full_name'),
            Column::make('mobile_number'),
            Column::make('email'),
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
        return 'SuperAdmin_' . date('YmdHis');
    }
}
