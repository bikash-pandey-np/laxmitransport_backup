<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('business_address')->nullable();
            $table->string('city_st_zip')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('ext')->nullable();
            $table->string('email')->nullable();
            $table->string('usdot')->nullable();
            $table->string('broker_mc')->nullable();
            $table->string('admin_note')->nullable();

            $table->string('dispatch_name')->nullable();
            $table->string('dispatch_phone_number')->nullable();
            $table->string('dispatch_email')->nullable();
            $table->string('dispatch_admin_note')->nullable();
            $table->string('bill_info_name')->nullable();
            $table->string('bill_info_business_address')->nullable();
            $table->string('bill_info_phone_number')->nullable();
            $table->string('bill_info_accounting_email')->nullable();
            $table->string('bill_info_federal_tax_payer_id')->nullable();
            $table->timestamps();
        });

        Schema::table('works', function (Blueprint $table) {
            $table->foreign('customer_id')->on('customers')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
