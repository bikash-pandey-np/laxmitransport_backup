<?php

namespace App\DataTables\SuperAdmin;

use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use function React\Promise\all;

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
            ->addColumn('full_name', function ($query) {
                return '<a href="' . route('super_admin.driver.show', $query->id) . '">' . $query->first_name . ' ' . $query->last_name . '</a> ';
            })
            ->editColumn('termination_date', function ($query) {
                if ($query->termination_date != null) {
                    return format_date($query->termination_date);
                }
                return null;
            })
            ->editColumn('hired_date', function ($query) {
                if ($query->hired_date != null) {
                    return format_date($query->hired_date);
                }
                return null;
            })
            ->addColumn('datetime', function ($query) {
                if ($query->available_date == null || $query->available_time == null) {
                    return "";
                }
                return format_date($query->available_date, 'Y-m-d') . " " . format_server_to_local($query->available_time);
            })
            ->addColumn('location', function ($query) {

                if (isset($query->currentWork->status) && in_array($query->currentWork->status, ['Unloaded'])) {
                    return $query->currentWork->workLocation->drop_house_number ?? "";
                } elseif (isset($query->currentWork->status) && in_array($query->currentWork->status, ['Loaded At Shipper', 'On Route To Delivered', 'On Site At Cosignee'])) {
                    return $query->currentWork->workLocation->pickup_house_number ?? "";
                }

                return $query->available_city . " " . $query->available_state . " " . $query->available_zip_code;

            })
            ->addColumn('action', function ($query) {
                return view('superadmin.theme_one.driver.button.action', ['row' => $query, 'base_route' => 'super_admin.driver']);
            })->rawColumns(['image', 'full_name', 'status', 'location', 'driver_status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Driver $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Driver $model)
    {
        if (request('driver_status')) {
            $model = $model->where('driver_status', request('driver_status'));
        }
        $request = request('status');
        if ($request == "pending") {
            $model = $model->where('admin_approve', 0);
        }
        if ($request == "available") {
            $model = $model->where('driver_status', 'Available')
                ->where('admin_approve', '!=', 0);
        }
        if ($request == "unavailable") {
            $model = $model->whereIn('driver_status', ['Not Available'])->where('admin_approve', '!=', 0);
        }
        if ($request == "retired") {
            $model = $model->whereIn('driver_status', ['Retired'])->where('admin_approve', '!=', 0);
        } else {
            $model = $model->where('driver_status', '!=', "Retired");
        }

        $model = $model->select(['*', DB::raw('unit_number IS NULL AS unit_numberNull')])->orderBy('unit_numberNull')->orderBy('unit_number');
        return $model->orderBy('unit_number', 'asc')->newQuery();
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
        if (request('status') == 'retired') {
            return [
                Column::make('unit_number'),
                Column::make('full_name'),
                Column::make('termination_date'),
                Column::make('mobile_number'),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            ];
        } else {
            return [
                Column::make('unit_number'),
                Column::make('full_name'),
                Column::make('hired_date'),
                Column::make('mobile_number'),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            ];
        }
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
