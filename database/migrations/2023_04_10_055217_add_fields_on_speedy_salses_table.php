<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOnSpeedySalsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('speedy_salses', function (Blueprint $table) {
            $table->string('date')->nullable();
            $table->longText('admin_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('speedy_salses', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('admin_note');
        });
    }
}
