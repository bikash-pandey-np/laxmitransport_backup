<?php

namespace App\DataTables\Driver;

use App\Models\BidingUser;
use App\Models\Carrier;
use App\Models\Driver;
use App\Models\LoadBoard;
use App\Models\LoadBoardUser;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LoadBoardDataTable extends DataTable
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
            ->editColumn('status', function ($query) {
                return ucwords(str_replace('_', ' ', $query->status));
            })
            ->editColumn('work_id', function ($query) {
                return "SE" . $query->id + 99;
            })
            ->addColumn('pickup_location', function ($query) {
                return $query->pickup_city_st_zip_code;
            })
            ->addColumn('drop_location', function ($query) {
                return $query->drop_city_st_zip_code;
            })
            ->addColumn('pickup_date_time', function ($query) {
                return $query->pickup_date.' '.$query->pickup_time;
            })
            ->addColumn('drop_date_time', function ($query) {
                return $query->drop_date.' '.$query->drop_time;
            })
            ->addColumn('action', function ($query) {
                return view('driver.theme_one.loadboard.button.action', ['row' => $query, 'base_route' => 'driver.work']);
            })->rawColumns(['image', 'full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LoadBoard $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LoadBoard $model)
    {
        $id = auth('driver')->id();
        $data = LoadBoardUser::where([
            'table_type' => Driver::class,
            'table_id' => $id
        ])->pluck('load_board_id')->toArray();
        return $model->where('table_id', null)->whereNotIn('id', $data)->orderBy('created_at', 'desc')->newQuery();
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
//            Column::make('pieces'),
//            Column::make('weight'),
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
