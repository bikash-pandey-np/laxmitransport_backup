<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataToStringOnAllDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('date_of_birth');
            $table->dropColumn('hired_date');
            $table->dropColumn('date_of_termination');
            $table->dropColumn('date_of_hire');
        });
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('date_of_birth')->nullable();
            $table->string('hired_date')->nullable();
            $table->string('date_of_termination')->nullable();
            $table->string('date_of_hire')->nullable();
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('pay_date');
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->string('pay_date')->nullable();
        });
    }

    public function changeStr_type($table)
    {

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            //
        });
    }
}
