<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusOnLoadboardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('load_board_users', function (Blueprint $table) {
            $table->string('status')->nullable();
        });

        Schema::table('load_boards', function (Blueprint $table) {
            $table->string('amount')->nullable();
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
            $table->dropColumn('amount');
        });
        Schema::table('load_board_users', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
