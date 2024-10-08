<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalseStatusOnWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->string('salse_actual_amount')->nullable();
            $table->string('salse_status')->nullable();
            $table->string('salse_date')->nullable();
            $table->string('salse_admin_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('salse_actual_amount');
            $table->dropColumn('salse_status');
            $table->dropColumn('salse_date');
            $table->dropColumn('salse_admin_note');
        });
    }
}
