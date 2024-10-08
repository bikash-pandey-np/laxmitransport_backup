<?php

namespace App\DataTables\Admin;

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
            ->addColumn('light', function ($query){
                if ($query->status == 'delivery'){
                    return "<div class='green_light'></div>";
                } elseif($query->status == "on_site"){
                    return "<div class='yellow_light'></div>";
                } else{
                    return "<div class='red_light'></div>";
                }
            })
            ->addColumn('work_id', function ($query){
                return "SE-". $query->id+1000;
            })
            ->addColumn('action', function ($query){
                return view('admin.theme_one.work.button.action',['row' => $query,'base_route' => 'admin.work']);
            })->rawColumns(['image','light']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Work $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Work $model)
    {
        $this->unit = 0;
        $model = $model->orderBy('created_at','desc');
        if (request('status')){
            $model = $model->where('status',request('status'));
        }
        if (request('admin_status_approved')){
            $model = $model->where('admin_status_approved',request('admin_status_approved'));
        }
        return $model->newQuery();
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
            Column::make('light'),
            Column::make('work_id'),
            Column::make('amount'),
//            Column::make('pieces'),
            Column::make('company_name'),
            /*Column::make('pickup_date_time'),
            Column::make('delivery_date_time'),*/
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
