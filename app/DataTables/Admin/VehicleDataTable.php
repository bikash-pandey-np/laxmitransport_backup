<?php

namespace App\DataTables\Admin;

use App\Models\Vehicle;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VehicleDataTable extends DataTable
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
            ->addColumn('dimension',function($query){
                return '
                        <div style="margin-bottom: 15px;">
                            <p style="margin-bottom: -15px"><b>Length:</b> '.$query->box_dims_length.'</p><br>
                            <p style="margin-bottom: -15px"><b>Width:</b> '.$query->box_dims_width.'</p><br>
                            <p style="margin-bottom: -15px"><b>Height:</b> '.$query->box_dims_height.'</p>
                        </div>
                    ';
            })
            ->editColumn('unit_number',function($query){
                return 'Unit - '.$query->vehicle_id;
            })
            ->addColumn('action', function ($query){
                return view('admin.theme_one.common.button.action',['row' => $query,'base_route' => 'admin.vehicle']);
            })->rawColumns(['image','dimension']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Vehicle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Vehicle $model)
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
                    ->setTableId('vehicle-table')
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
            Column::make('dimension'),
            Column::make('vehicle_type'),
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
        return 'Vehicle_' . date('YmdHis');
    }
}
