<?php

namespace App\DataTables\SuperAdmin;

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
            ->addColumn('dimension', function ($query) {
                return '
                        <div style="margin-bottom: 15px;">
                            <p style="margin-bottom: -15px"><b>Length:</b> ' . $query->box_dims_length . '</p><br>
                            <p style="margin-bottom: -15px"><b>Width:</b> ' . $query->box_dims_width . '</p><br>
                            <p style="margin-bottom: -15px"><b>Height:</b> ' . $query->box_dims_height . '</p>
                        </div>
                    ';
            })
            ->addColumn('name', function ($query) {
                return $query->driver->full_name ?? "";
            })
            ->addColumn('mobile_number', function ($query) {
                return $query->driver->mobile_number ?? "";
            })
            ->addColumn('unit_number', function ($query) {
                return $query->driver->unit_number ?? "";
            })
            ->filter(function ($instance) {
                if (!empty(request('search')['value'])) {
                    $instance->where('drivers.unit_number','like','%'.request('search')['value'].'%');
                }
            })
            ->addColumn('date', function ($query) {
                if (isset($query->driver->available_date)) {
                    return "<p class='btn btn-primary'>" . $query->driver->available_date . " " . format_server_to_local($query->driver->available_time) . "</p>";
                }
                return "";
                $pickup = (isset($query->latestAllWork->workLocation->pickup_date_time)) ? "<p class='btn btn-primary'>" . format_server_to_local($query->latestAllWork->workLocation->pickup_date_time,'m/d/Y H:i:s') . "</p>" : "";
                $drop = (isset($query->latestAllWork->workLocation->drop_date_time)) ? "<p class='btn btn-secondary'>" . format_server_to_local($query->latestAllWork->workLocation->drop_date_time,'m/d/Y H:i:s') . "</p>" : "";
                return $pickup . '<br>' . $drop;
            })
            ->addColumn('location', function ($query) {
                return '<p class="btn btn-success">'.$query->driver->available_city.'</p>';
                if (isset($query->latestWork->status) && in_array($query->latestWork->status, config('workstatus.drop'))) {
                    $location = $query->latestWork->drop_destination ?? "";
                } elseif (isset($query->latestWork->status) && in_array($query->latestWork->status, config('workstatus.pickup'))) {
                    $location = $query->latestWork->origin_destination ?? "";
                } else {
                    $location = ($query->driver->available_city ?? "") . " " . ($query->driver->available_state ?? "") . " " . ($query->driver->available_zip_code ?? "");
                }
                if (isset($location) && ($location !== " " || $location !== "" || $location != null)) {
                    return $location;
                    return '<p class="btn btn-success">' . $location . '</p>';
                }
                return "";
            })
            ->addColumn('driver_status', function ($query) {

                if ($query->driver == null) {
                    return '<a href="' . route('super_admin.vehicle.edit', $query->id) . '">Add Driver</a>';
                }

                if (($query->driver->admin_approve ?? 0) == 0) {
                    return '<a href="' . route('driver.active.by.admin', $query->driver->id) . '">Approve this user</a>';
                }

                if ($query->driver->driver_status == "Available" && isset($query->latestWork->status)) {
                    return '<a class="btn btn-success" href="javascript:void(0)">Work On Speedy</a>';
                } elseif ($query->driver->driver_status == "Retired" || $query->driver->driver_status == "Not Available") {
                    return '<a class="btn btn-danger" style="background-color: blue;border-color: blue;" href="javascript:void(0)">' . $query->driver->driver_status . '</a>';
                } elseif ($query->driver->driver_status == "Available") {
                    return '<a class="btn btn-success" href="javascript:void(0)">' . $query->driver->driver_status . '</a>';
                }

                return $query->driver->driver_status;
            })
            ->editColumn('status', function ($query) {

                if (!isset($query->latestWork->status)) {
                    return '<a class="btn" style="background:red;color:white">Empty</a>';
                }
                $bgcolor = "black";
                $color = "white";
                if (in_array($query->latestWork->status, ['On Route To Pickup', 'On Route To Delivered'])) {
                    $bgcolor = "orange";
                    $color = "black";
                } elseif (in_array($query->latestWork->status, ['On Site At Pickup', 'On Site At Cosignee'])) {
                    $bgcolor = "yellow";
                    $color = "black";
                } elseif (in_array($query->latestWork->status, ['Loaded At Shipper', 'uNLOADED'])) {
                    $bgcolor = "green";
                    $color = "white";
                }

                if ($bgcolor) {
                    return '<a class="btn" style="background:' . $bgcolor . ';color:' . $color . '">' . $query->latestWork->status . '</a>';
                }

                return $query->latestWork->status ?? "";
            })
            ->addColumn('action', function ($query) {
                return view('superadmin.theme_one.vehicle.button.action', ['row' => $query, 'base_route' => 'super_admin.vehicle']);
            })->rawColumns(['image', 'dimension', 'driver_status', 'date', 'status', 'location']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Vehicle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Vehicle $model)
    {
        return $model->select([
            'vehicles.*'
        ])
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.id')
            ->whereNotIn('drivers.driver_status', ['Retired'])
            ->orderBy('drivers.unit_number', 'asc')->newQuery();
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
            Column::make('unit_number'),
            Column::make('mobile_number'),
            Column::make('date'),
            Column::make('location'),
            Column::make('dimension'),
            Column::make('payload'),
            Column::make('vehicle_type'),
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
        return 'Vehicle_' . date('YmdHis');
    }
}
