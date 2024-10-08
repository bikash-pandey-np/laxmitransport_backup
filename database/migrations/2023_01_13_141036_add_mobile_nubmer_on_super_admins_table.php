<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileNubmerOnSuperAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('super_admins', 'mobile_number')) {
            Schema::table('super_admins', function (Blueprint $table) {
                $table->string('mobile_number')->nullable();
            });
        }
        if (!Schema::hasColumn('super_admins', 'role')) {
            Schema::table('super_admins', function (Blueprint $table) {
                $table->string('role')->default('super_admin');
            });
        }
        Schema::table('super_admins', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('super_admins', function (Blueprint $table) {
            //
        });
    }
}
