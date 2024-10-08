<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Changes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('door_dims_width');
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('door_dims_width')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('door_dims_width');
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('door_dims_width')->nullable();
        });
    }
}
