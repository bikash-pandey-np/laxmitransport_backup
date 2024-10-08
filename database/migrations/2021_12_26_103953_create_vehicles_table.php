<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_id')->unique();
            $table->string('status')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('posting_class')->nullable();
            $table->string('dock_high')->nullable();
            $table->integer('payload')->nullable();
            $table->integer('gross_veh_weight')->nullable();
            $table->integer('box_dims_length')->nullable();
            $table->integer('box_dims_width')->nullable();
            $table->integer('box_dims_height')->nullable();
            $table->integer('door_dims_width')->nullable();
            $table->integer('door_dims_height')->nullable();
            $table->string('door_type')->nullable();
            $table->string('air_ride')->nullable();
            $table->string('temp_control')->nullable();
            $table->string('left_gate')->nullable();
            $table->string('domicile')->nullable();
            $table->string('can_cross_border')->nullable();
            $table->string('team')->nullable();
            $table->string('dispatch_board')->nullable();
            $table->string('communication_system')->nullable();
            $table->string('omnitracs_unit_no')->nullable();
            $table->string('ivg_unit')->nullable();
            $table->string('needs_trailer')->nullable();
            $table->string('e_trac')->nullable();
            $table->string('trailer_tracking')->nullable();
            $table->string('door_sensors')->nullable();
            $table->string('panis_button')->nullable();
            $table->string('enable_for_nlm')->nullable();
            $table->string('nlm_truck_size')->nullable();
            $table->string('nlm_truck_class')->nullable();
            $table->string('fuel_capacity')->nullable();
            $table->string('fuel_source')->nullable();
            $table->string('mpg')->nullable();
            $table->string('date_hired')->nullable();
            $table->string('who_hired')->nullable();
            $table->string('hazmat_certified')->nullable();
            $table->string('partial_space_available')->nullable();
            $table->string('date_retired')->nullable();
            $table->string('retired_by')->nullable();

            $table->string('vin_no')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('license_state')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->string('vehicle_color')->nullable();
            $table->string('no_of_axles')->nullable();
            $table->string('unladen_weight')->nullable();
            $table->integer('purchase_cost')->nullable();
            $table->string('purchase_date')->nullable();
            $table->string('lease_exp_date')->nullable();
            $table->longText('comments')->nullable();
            $table->longText('dispatch_note')->nullable();
            $table->longText('availability_note')->nullable();
            $table->string('automatically_post_truck')->nullable();
            $table->string('lic_plate_expiry_date')->nullable();
            $table->string('last_pm_date')->nullable();
            $table->string('next_pm_date')->nullable();
            $table->string('insurance_expires')->nullable();
            $table->string('emission_test_due')->nullable();
            $table->string('last_monthly_insp')->nullable();
            $table->string('previous_dot_inspection_date')->nullable();
            $table->string('next_dot_inspection_date')->nullable();
            $table->string('fast_transponder_no')->nullable();
            $table->string('ifta_sticker_no')->nullable();
            $table->string('ifta_sticker_expires')->nullable();
            $table->string('odometer_when_hired')->nullable();
            $table->string('odometer_when_retired')->nullable();
            $table->unsignedInteger('driver_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
