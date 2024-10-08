<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordTokenOnCarriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carriers', function (Blueprint $table) {
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->boolean('status')->default(0);
            $table->string('device_token')->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carriers', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('token');
            $table->dropColumn('status');
            $table->dropColumn('device_token');
            $table->dropColumn('remember_token');
        });
    }
}
