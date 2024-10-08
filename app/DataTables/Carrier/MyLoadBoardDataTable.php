<?php

namespace App\DataTables\Carrier;

use App\Models\Carrier;
use App\Models\LoadBoardUser;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MyLoadBoardDataTable extends DataTable
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
            ->addColumn('pickup_location', function ($query) {
                return $query->loadboard->pickup_city_st_zip_code ?? "";
            })
            ->addColumn('drop_location', function ($query) {
                return $query->loadboard->drop_city_st_zip_code ?? '';
            })
            ->editColumn('amount', function ($query) {
                return '$ '.($query->amount ?? 0);
            })
            ->addColumn('pickup_date_time', function ($query) {
                if (isset($query->loadboard->pickup_date) && isset($query->loadboard->pickup_time)){
                    return $query->loadboard->pickup_date.' '.$query->loadboard->pickup_time;
                }
                return "";
            })
            ->addColumn('drop_date_time', function ($query) {
                if (isset($query->loadboard->drop_date) && isset($query->loadboard->drop_time)) {
                    return $query->loadboard->drop_date . ' ' . $query->loadboard->drop_time;
                }
                return "";
            })
            ->addColumn('action', function ($query) {
                return view('carrier.theme_one.loadboard.button.my_action', ['row' => $query, 'base_route' => 'carrier.work']);
            })->rawColumns(['image', 'full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LoadBoardUser $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LoadBoardUser $model)
    {
        return $model->where('table_type', Carrier::class)
            ->where('table_id', auth('carrier')->id())->orderBy('created_at', 'desc')->newQuery();
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
            Column::make('id'),
            Column::make('pickup_location'),
            Column::make('drop_location'),
            Column::make('pickup_date_time'),
            Column::make('drop_date_time'),
            Column::make('amount'),
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
