<?php

namespace App\DataTables\SuperAdmin;

use App\Models\LoadBoard;
use App\Models\LoadBoardUser;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AwardedLoadBoardDataTable extends DataTable
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
            ->editColumn('user_type',function($query){
                return $query->user_type;
            })
            ->editColumn('status',function($query){
                return "Approved";
            })
            ->addColumn('unit_number',function($query){
                return $query->user->unit_number ?? "";
            })
            ->addColumn('email',function($query){
                return $query->loadBoard->email ?? "";
            })
            ->addColumn('order_number',function($query){
                return $query->loadBoard->order_number ?? "";
            })
            ->addColumn('location',function($query){
                return $query->user->available_city ?? "";
            })
            ->addColumn('origin',function($query){
                return $query->loadBoard->pickup_city_st_zip_code ?? "";
            })
            ->addColumn('destination',function($query){
                return $query->loadBoard->drop_city_st_zip_code ?? "";
            })
            ->addColumn('offer', function ($query){
                return view('superadmin.theme_one.loadboard.button.offer',['row' => $query,'base_route' => 'super_admin.loadboard']);
            })
            ->addColumn('action', function ($query){
                return view('superadmin.theme_one.loadboard.button.offer_action',['row' => $query,'base_route' => 'super_admin.loadboard']);
            })->rawColumns(['full_name','offer']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LoadBoard $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LoadBoardUser $model)
    {
        return $model->where('status','approved')->orderBy('created_at','desc')->newQuery();
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
            Column::make('unit_number'),
            Column::make('order_number'),
            Column::make('origin'),
            Column::make('destination'),
            Column::make('email'),
            Column::make('amount'),
            Column::make('status')
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
