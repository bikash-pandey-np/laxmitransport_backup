<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_id');
            $table->string('picked_up_address')->nullable();
            $table->string('drip_address')->nullable();

            $table->string('pickup_date')->nullable();
            $table->string('pickup_time')->nullable();
            $table->string('drop_date')->nullable();
            $table->string('drop_time')->nullable();

            $table->text('pickup_note')->nullable();
            $table->text('drop_note')->nullable();
            $table->string('company_name')->nullable();

            $table->timestamps();

            $table->foreign('work_id')->on('works')->references('id')->onDelete('cascade');
        });

        Schema::table('work_delivery_images', function (Blueprint $table) {
            $table->foreign('work_location_id')->on('work_locations')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_locations');
    }
}
