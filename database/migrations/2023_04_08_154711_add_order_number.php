<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('load_boards', function (Blueprint $table) {
            $table->dropColumn('pickup_company_name');
            $table->dropColumn('pickup_address');
            $table->dropColumn('drop_company_name');
            $table->dropColumn('drop_address');
            $table->string('order_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('load_boards', function (Blueprint $table) {
            $table->dropColumn('order_number');
            $table->string('drop_company_name')->nullable();
            $table->string('drop_address')->nullable();
            $table->string('pickup_company_name')->nullable();
            $table->string('pickup_address')->nullable();
        });
    }
}
