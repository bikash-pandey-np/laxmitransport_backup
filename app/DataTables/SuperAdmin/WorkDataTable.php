<?php

namespace App\DataTables\SuperAdmin;

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
            ->addColumn('light', function ($query) {
                if ($query->status == 'delivery') {
                    return "<div class='green_light'></div>";
                } elseif ($query->status == "on_site") {
                    return "<div class='yellow_light'></div>";
                } else {
                    return "<div class='red_light'></div>";
                }
            })
            ->addColumn('brokerage_name', function ($query) {
                return $query->customer->name ?? "";
            })
            ->addColumn('order_no', function ($query) {
                return "SE-" . $query->id + 1000;
            })
            ->addColumn('unit_number', function ($query) {
                return $query->driver->unit_number ?? "";
                return (isset($query->vehicle->vehicle_id)) ? 'Unit - ' . $query->vehicle->vehicle_id : "";
            })
            ->addColumn('origin', function ($query) {
                return $query->origin_destination ?? "";
            })
            ->addColumn('destination', function ($query) {
                return $query->drop_destination ?? "";
            })
            ->editColumn('company_name', function ($query) {
                return $query->workLocations()->first()->company_name ?? "";
            })
            ->addColumn('action', function ($query) {
                return view('superadmin.theme_one.work.button.action', ['row' => $query, 'base_route' => 'super_admin.work']);
            })
            ->addColumn('pickup_date_time', function ($query) {
                if (!isset($query->workLocation->pickup_date)) {
                    return "";
                }
                $time = "";
                if (isset($query->workLocation->pickup_date) && isset($query->workLocation->pickup_time)) {
                    $time = format_date(($query->workLocation->pickup_date ?? "") . " " . ($query->workLocation->pickup_time ?? ""), 'm/d/Y H:i');
                }

                if (in_array($query->status, ['Loaded At Shipper', 'On Route To Delivered', 'On Site At Cosignee', 'Unloaded'])) {
                    return $time;
                }

                return $time;
            })
            ->addColumn('drop_date_time', function ($query) {
                if (!isset($query->workLocation->drop_date)) {
                    return "";
                }
                $time = "";
                if (isset($query->workLocation->drop_date) && isset($query->workLocation->drop_date)) {
                    $time = format_date(($query->workLocation->drop_date ?? "") . " " . ($query->workLocation->drop_time ?? ""), 'm/d/Y H:i');
                }

                if (in_array($query->status, ['Unloaded'])) {
                    return $time;
                }

                return $time;
            })
            ->rawColumns(['image', 'light']);
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
        $model = $model->orderBy('created_at', 'desc');
        if (request('status')) {
            if (request('status') == 'unloaded') {
                $model = $model->whereIn('status', [
                    'Unloaded',
                    'Cancel',
                ]);
            } else {
                $model = $model->where('status', request('status'));
            }
        } else {
            $model = $model->where(function ($q) {
                $q->where('status', '!=', "unloaded")->orWhere('admin_status_approved', 0);
            });
        }
        if (request('admin_status_approved')) {
            $model = $model->where('admin_status_approved', request('admin_status_approved'));
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
        $data = [
            Column::make('order_no'),
            Column::make('unit_number'),
            Column::make('brokerage_name'),
            Column::make('pro_number'),
            Column::make('pickup_date_time'),
            Column::make('drop_date_time'),
        ];
        if (request('status') !== 'unloaded') {
            //            array_push($data,Column::make('company_name'));
        }
        return array_merge($data, [
            Column::make('origin'),
            Column::make('destination'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ]);
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
