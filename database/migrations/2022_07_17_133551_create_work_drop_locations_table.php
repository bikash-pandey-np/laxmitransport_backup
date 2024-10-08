<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkDropLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_locations', function (Blueprint $table) {
            $table->dropColumn('picked_up_address');
            $table->dropColumn('drip_address');
            $table->string('pickup_house_number')->nullable();
            $table->string('pickup_street_name')->nullable();
            $table->string('pickup_city_state_zipcode')->nullable();
            $table->string('consignee_name')->nullable();
            $table->string('drop_house_number')->nullable();
            $table->string('drop_street_name')->nullable();
            $table->string('drop_city_state_zipcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_locations', function (Blueprint $table) {
            $table->string('picked_up_address')->nullable();
            $table->string('drip_address')->nullable();
            $table->dropColumn('pickup_house_number');
            $table->dropColumn('pickup_street_name');
            $table->dropColumn('pickup_city_state_zipcode');
            $table->dropColumn('consignee_name');
            $table->dropColumn('drop_house_number');
            $table->dropColumn('drop_street_name');
            $table->dropColumn('drop_city_state_zipcode');
        });
    }
}
