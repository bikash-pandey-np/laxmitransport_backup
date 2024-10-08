<?php

namespace App\DataTables\Driver;

use App\Models\BidingUser;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MyBidingDataTable extends DataTable
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
            ->addColumn('pieces', function ($query) {
                return $query->work->pieces ?? "";
            })
            ->addColumn('weight', function ($query) {
                return $query->pickup_city . ' ' . $query->pickup_state . ' ' . $query->pickup_zip_code;
            })
            ->addColumn('action', function ($query) {
                return view('driver.theme_one.biding.button.my_action', ['row' => $query, 'base_route' => 'driver.work']);
            })->rawColumns(['image', 'full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BidingUser $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BidingUser $model)
    {
        return $model->where('driver_id', auth('driver')->id())->orderBy('created_at', 'desc')->newQuery();
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
            Column::make('pieces'),
            Column::make('weight'),
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
