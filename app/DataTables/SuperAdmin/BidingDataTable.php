<?php

namespace App\DataTables\SuperAdmin;

use App\Models\Biding;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BidingDataTable extends DataTable
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
            ->addColumn('company_name', function ($query){
                return $query->workLocation->company_name ?? "";
            })
            ->addColumn('order_no', function ($query){
                return "SE-" . $query->work->id + 99;
            })
            ->addColumn('pickup_date_time', function ($query){
                if (!isset($query->workLocation->pickup_date)){
                    return "";
                }
                $time = format_date(($query->workLocation->pickup_date ?? "")." ".($query->workLocation->pickup_time ?? ""),'Y-m-d H:i');

                if (in_array($query->status,['Loaded At Shipper','On Route To Delivered','On Site At Cosignee','Unloaded'])){
                    return '<p style="background-color: green;color: #ffffff; padding: 5px;border-radius: 3px;">'.$time.'</p>';
                }

                return '<p style="background-color: #dc3545;color: #ffffff; padding: 5px;border-radius: 3px;">'.$time.'</p>';
            })
            ->addColumn('drop_date_time', function ($query){
                if (!isset($query->workLocation->drop_date)){
                    return "";
                }
                $time = format_date(($query->workLocation->drop_date ?? "")." ".($query->workLocation->drop_time ?? ""),'Y-m-d H:i');

                if (in_array($query->status,['Unloaded'])){
                    return '<p style="background-color: green;color: #ffffff; padding: 5px;border-radius: 3px;">'.$time.'</p>';
                }

                return '<p style="background-color: #dc3545;color: #ffffff; padding: 5px;border-radius: 3px;">'.$time.'</p>';
            })
            ->addColumn('action', function ($query){
                return view('superadmin.theme_one.biding.button.action',['row' => $query,'base_route' => 'super_admin.biding']);
            })
            ->rawColumns(['pickup_date_time','drop_date_time']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Biding $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Biding $model)
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
            Column::make('order_no'),
            Column::make('company_name'),
            Column::make('pro_number'),
            Column::make('origin_destination'),
            Column::make('drop_destination'),
            Column::make('pickup_date_time'),
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
        return 'Biding_' . date('YmdHis');
    }
}
