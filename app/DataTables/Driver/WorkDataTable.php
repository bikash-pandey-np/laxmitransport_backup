<?php

namespace App\DataTables\Driver;

use App\Models\Work;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WorkDataTable extends DataTable
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
            ->editColumn('status', function ($query){
                    return ucwords(str_replace('_',' ',$query->status));
            })
            ->editColumn('work_id', function ($query){
                return "SE-". ($query->id+1000);
            })
            ->addColumn('pickup_location', function ($query){
                return $query->pickup_city.' '.$query->pickup_state.' '.$query->pickup_zip_code;
            })
            ->addColumn('drop_location', function ($query){
                return $query->delivery_city.' '.$query->delivery_state.' '.$query->delivery_zip_code;
            })
            ->addColumn('drop_date_time', function ($query){
                return format_server_to_local($query->delivery_date_time,'m/d/Y H:i:s');
            })
            ->addColumn('approved_by_admin', function ($query){
                return $query->admin_status_approved ? "Yes" : "No";
            })
            ->addColumn('action', function ($query){
                    return view('driver.theme_one.work.button.action',['row' => $query,'base_route' => 'driver.work']);
            })->rawColumns(['image','full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Work $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Work $model)
    {
        $vehicles = [];
        foreach (auth('driver')->user()->vehicles as $vehicle) {
            array_push($vehicles,$vehicle->id);
        }
        if (request('status') == 'delivery'){
            return $model->whereIn('vehicleId', $vehicles)->whereIn('status', ['Unloaded','cancel','Cancel'])->orderBy('created_at','desc')->newQuery();
        }else{
            return $model->whereIn('vehicleId', $vehicles)->whereNotIn('status', ['Unloaded','cancel','Cancel'])->orderBy('created_at','desc')->newQuery();
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('work-table')
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
            Column::make('work_id'),
//            Column::make('pickup_location'),
//            Column::make('pickup_date_time'),
//            Column::make('drop_location'),
//            Column::make('drop_date_time'),
            Column::make('status'),
            Column::make('approved_by_admin'),
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
        return 'Work_' . date('YmdHis');
    }
}
