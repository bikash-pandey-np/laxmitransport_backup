<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInsuranceOnCarriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carriers', function (Blueprint $table) {
            $table->string('insurance_name')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('policy_effective_date')->nullable();
            $table->string('policy_expire_date')->nullable();
            $table->string('coi')->nullable()->comment('yes or no');
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
            $table->dropColumn('insurance_name');
            $table->dropColumn('policy_number');
            $table->dropColumn('policy_effective_date');
            $table->dropColumn('policy_expire_date');
            $table->dropColumn('coi');
        });
    }
}
