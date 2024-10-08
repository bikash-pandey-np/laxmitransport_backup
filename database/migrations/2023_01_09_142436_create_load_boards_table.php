<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('load_boards', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_company_name')->nullable();
            $table->string('pickup_address')->nullable();
            $table->string('pickup_city_st_zip_code')->nullable();
            $table->string('pickup_date')->nullable();
            $table->string('pickup_time')->nullable();

            $table->string('drop_company_name')->nullable();
            $table->string('drop_address')->nullable();
            $table->string('drop_city_st_zip_code')->nullable();
            $table->string('drop_date')->nullable();
            $table->string('drop_time')->nullable();

            $table->string('vehicle_type')->nullable();
            $table->string('pieces')->nullable();
            $table->string('weight')->nullable();
            $table->string('dims')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('load_boards');
    }
}
