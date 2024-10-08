<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->string('front_citizenship')->nullable();
            $table->string('back_citizenship')->nullable();
            $table->string('license_number')->nullable();
            $table->string('social_security')->nullable();
            $table->string('unit_number')->nullable();
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->string('tag')->nullable();
            $table->string('vin')->nullable();
            $table->string('date_of_hire')->nullable();
            $table->string('date_of_termination')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->boolean('status')->default(0);

            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->text('zip')->nullable();
            $table->text('home_phone')->nullable();
            $table->text('emergency_contact')->nullable();
            $table->text('fax')->nullable();
            $table->text('domicile')->nullable();
            $table->text('can_cross_border')->nullable();
            $table->date('hired_date')->nullable();
            $table->string('termination_date')->nullable();
            $table->text('payroll_class')->nullable();
            $table->text('pay_target')->nullable();
            $table->text('target_attained')->nullable();
            $table->text('active_payroll')->nullable();
            $table->text('print_1099')->nullable();
            $table->text('mail_paycheck')->nullable();
            $table->text('billed_mileage_type')->nullable();
            $table->text('work_visa')->nullable();
            $table->text('work_visa_expires')->nullable();
            $table->text('pay_currency')->nullable();
            $table->text('last_physical_date')->nullable();
            $table->text('next_physical_date')->nullable();
            $table->text('hazmat_certificate')->nullable();
            $table->text('trained_hazmat_date')->nullable();
            $table->text('expires_hazmat_date')->nullable();
            $table->text('license_state')->nullable();
            $table->text('license_type')->nullable();
            $table->text('license_class')->nullable();
            $table->text('driving_since')->nullable();
            $table->text('drivers_lic_expires')->nullable();
            $table->text('abstract_due')->nullable();
            $table->text('last_review_date')->nullable();
            $table->text('next_review_date')->nullable();
            $table->text('workres_comp_expires')->nullable();
            $table->text('passed_security_clearance')->nullable();
            $table->text('passed_security_clearance_date')->nullable();
            $table->text('joined_company_insurance')->nullable();
            $table->text('terminated_company_insurance')->nullable();
            $table->text('fast_placard')->nullable();
            $table->text('fast_placard_no')->nullable();

            $table->text('tas_certified')->nullable();
            $table->text('tas_ref_no')->nullable();
            $table->text('tas_certified_date')->nullable();
            $table->text('tas_expiry_date')->nullable();

            $table->text('twic_certified')->nullable();
            $table->text('twic_ref_no')->nullable();
            $table->text('twic_certified_date')->nullable();
            $table->text('twic_expiry_date')->nullable();

            $table->text('random_drug_test')->nullable();
            $table->text('tanker_endorsement')->nullable();

            $table->string('account_status')->default('active');
            $table->text('deactive_reason')->nullable();

            $table->string('front_license')->nullable();
            $table->string('back_license')->nullable();
            $table->string('social_security_image')->nullable();
            $table->string('licence_state')->nullable();
            $table->string('driver_last_location')->nullable();
            $table->string('driver_last_location_lat')->nullable();
            $table->string('driver_last_location_long')->nullable();
            $table->string('username')->nullable();

            $table->string('driver_status')->default('available');

            $table->string('available_city')->nullable();
            $table->string('available_state')->nullable();
            $table->string('available_zip_code')->nullable();

            $table->boolean('admin_approve')->default(0);
            $table->string('admin_can_login')->default(1);
            $table->string('device_token')->nullable();

            $table->string('available_date')->nullable();
            $table->string('available_time')->nullable();

            $table->boolean('extra_signup')->default(0);
            $table->string('social_security_number')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('drivers');
    }
}
