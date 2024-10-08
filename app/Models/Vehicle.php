<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'status',
        'vehicle_type',
        'posting_class',
        'dock_high',
        'payload',
        'gross_veh_weight',
        'box_dims_length',
        'box_dims_width',
        'box_dims_height',
        'door_dims_width',
        'door_dims_height',
        'door_type',
        'air_ride',
        'temp_control',
        'left_gate',
        'domicile',
        'can_cross_border',
        'team',
        'dispatch_board',
        'communication_system',
        'omnitracs_unit_no',
        'ivg_unit',
        'needs_trailer',
        'e_trac',
        'trailer_tracking',
        'door_sensors',
        'panis_button',
        'enable_for_nlm',
        'nlm_truck_size',
        'nlm_truck_class',
        'fuel_capacity',
        'fuel_source',
        'mpg',
        'date_hired',
        'who_hired',
        'hazmat_certified',
        'partial_space_available',
        'date_retired',
        'retired_by',
        'vin_no',
        'license_plate',
        'license_state',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'vehicle_color',
        'no_of_axles',
        'unladen_weight',
        'purchase_cost',
        'purchase_date',
        'lease_exp_date',
        'comments',
        'dispatch_note',
        'availability_note',
        'automatically_post_truck',
        'lic_plate_expiry_date',
        'last_pm_date',
        'next_pm_date',
        'insurance_type',
        'insurance_expires',
        'insurance_carrier',
        'non_truck_insurance_type',
        'non_truck_insurance_expires',
        'non_truck_insurance_carrier',
        'emission_test_due',
        'last_monthly_insp',
        'previous_dot_inspection_date',
        'next_dot_inspection_date',
        'fuel_tax_exempt',
        'fast_truck',
        'fast_transponder_no',
        'ifta_sticker_no',
        'ifta_sticker_expires',
        'odometer_when_hired',
        'odometer_when_retired',
        'refeer_mode',
    ];

    public function latestWork()
    {
        return $this->hasOne(Work::class)->whereIn('works.status',config('workstatus.trip_monitor'));
    }

    public function latestAllWork()
    {
        return $this->hasOne(Work::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
