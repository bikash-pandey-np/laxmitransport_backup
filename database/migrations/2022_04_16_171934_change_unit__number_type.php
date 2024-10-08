<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUnitNumberType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $drivers = \App\Models\Driver::get(['id', 'unit_number'])->toArray();

        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('unit_number');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->integer('unit_number')->nullable();
        });

        foreach ($drivers as $driver) {
            $data = \App\Models\Driver::find($driver['id']);
            $data->update([
                'unit_number' => $driver['unit_number']
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
