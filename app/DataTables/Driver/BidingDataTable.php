<?php

namespace App\DataTables\Driver;

use App\Models\Biding;
use App\Models\BidingUser;
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
            ->editColumn('status', function ($query) {
                return ucwords(str_replace('_', ' ', $query->status));
            })
            ->editColumn('work_id', function ($query) {
                return "SE" . $query->id + 99;
            })
            ->addColumn('pickup_location', function ($query) {
                return $query->pickup_city . ' ' . $query->pickup_state . ' ' . $query->pickup_zip_code;
            })
            ->addColumn('action', function ($query) {
                return view('driver.theme_one.biding.button.action', ['row' => $query, 'base_route' => 'driver.work']);
            })->rawColumns(['image', 'full_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Biding $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Biding $model)
    {
        $id = auth('driver')->id();
        $data = BidingUser::where('driver_id', $id)->pluck('work_id')->toArray();
        return $model->where('driver_id', null)->whereNotIn('id', $data)->orderBy('created_at', 'desc')->newQuery();
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
            Column::make('work_id'),
            Column::make('pieces'),
            Column::make('weight'),
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
