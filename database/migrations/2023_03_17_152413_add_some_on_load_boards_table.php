<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeOnLoadBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('load_boards', function (Blueprint $table) {
            $table->string('miles')->nullable();
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
        Schema::table('load_boards', function (Blueprint $table) {
            $table->dropColumn('miles');
            $table->dropColumn('admin_note');
        });
    }
}
