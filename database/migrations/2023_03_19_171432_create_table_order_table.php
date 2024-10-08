<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_table', function (Blueprint $table) {
            $table->id();
            $table->string('actual_amount')->nullable();
            $table->string('pieces')->nullable();
            $table->string('weight')->nullable();
            $table->string('miles')->nullable();
            $table->string('pro_number')->nullable();
            $table->string('pickup_company_name')->nullable();
            $table->string('pickup_company_address')->nullable();
            $table->string('pickup_company_city_zip_code')->nullable();
            $table->string('pickup_date')->nullable();
            $table->string('pickup_time')->nullable();
            $table->string('consignee_name')->nullable();
            $table->string('drop_address')->nullable();
            $table->string('drop_city_zip_code')->nullable();
            $table->string('drop_date')->nullable();
            $table->string('drop_time')->nullable();
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
        Schema::dropIfExists('table_order');
    }
}
