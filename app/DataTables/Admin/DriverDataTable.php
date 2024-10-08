<?php

namespace App\DataTables\Admin;

use App\Models\Driver;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DriverDataTable extends DataTable
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
            ->addColumn('full_name',function($query){
                return '<a href="'.route('admin.driver.show',$query->id).'">'.$query->first_name.' '.$query->last_name.'</a>';
            })
            ->addColumn('status',function($query){
                if ($query->admin_approve == 0) {
                    return '<a href="' . route('driver.active.by.admin', $query->id) . '">Approve this user</a>';
                }

                if ($query->account_status == 'active') {
                    if (count($query->activeWorks) > 0) {
                        return '<a href="#" class="btn btn-sm btn-warning">On Load</a>';
                    }
                    return '<a href="javascript:void(0)" class="btn btn-sm btn-success">Active</a>';
                } else {
                    return '<a href="javascript:void(0)" title="' . $query->deactive_reason . '" class="btn btn-sm btn-danger">Inactive</a>';
                }
            })
            ->addColumn('location',function($query){
                return $query->available_city." ".$query->available_state." ".$query->available_zip_code;
            })
            ->addColumn('image',function($query){
                return '<img style="width:50px;height:50px;" src="'.$query->image('50_50').'" \>';
            })
            ->addColumn('action', function ($query){
                return view('admin.theme_one.driver.button.action',['row' => $query,'base_route' => 'admin.driver']);
            })->rawColumns(['image','full_name','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Driver $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Driver $model)
    {
        $model = $model->orderBy('created_at','desc');
        if (request('driver_status')){
            $model = $model->where('driver_status',request('driver_status'));
        }
        $request = request('status');
        if ($request == "pending"){
            $model = $model->where('admin_approve',0);
        }
        if ($request == "available"){
            $model = $model->where('driver_status','available');
        }
        return $model->orderBy('unit_number','asc')->newQuery();
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
            Column::make('full_name'),
            Column::make('mobile_number'),
            Column::make('email'),
            Column::make('location'),
            Column::make('status'),
            Column::make('driver_status'),
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
        return 'Driver_' . date('YmdHis');
    }
}
