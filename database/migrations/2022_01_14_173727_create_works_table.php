<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('work_id')->nullable();
            $table->string('status')->nullable();
            $table->decimal('amount',8,2)->nullable();
            $table->string('pieces')->nullable();
            $table->string('weight')->nullable();
            $table->string('miles')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->timestamp('load_pickup_date')->nullable();
            $table->timestamp('load_deliver_date')->nullable();
            $table->string('pickup_address')->nullable();
            $table->string('drop_address')->nullable();
            $table->longText('admin_load_notes')->nullable();
            $table->longText('driver_load_notes')->nullable();

            $table->string('pickup_date_time')->nullable();
            $table->string('pickup_city')->nullable();
            $table->string('pickup_state')->nullable();
            $table->string('pickup_zip_code')->nullable();

            $table->string('delivery_date_time')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_state')->nullable();
            $table->string('delivery_zip_code')->nullable();

            $table->string('company_name')->nullable();

            $table->longText('picked_up_note')->nullable();
            $table->longText('delivery_note')->nullable();
            $table->boolean('admin_status_approved')->default(1);

            $table->string('delivery_pod_signed_by')->nullable();
            $table->string('pro_number')->nullable();
            $table->string('origin_destination')->nullable();
            $table->string('drop_destination')->nullable();
            $table->decimal('actual_amount',8,2)->nullable();

            $table->unsignedBigInteger('customer_id')->nullable();

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
        Schema::dropIfExists('works');
    }
}
