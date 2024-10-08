<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        Schema::table('works', function (Blueprint $table) {
            $table->string('status_after_complete')->nullable();
        });

        $datas = \App\Models\Work::whereNotIn('status', config('workstatus.work_status'))->get();
        foreach ($datas as $data) {
            $data->update([
                'status_after_complete' => $data->status,
                'status' => "Unloaded"
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
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('status_after_complete');
        });
        Schema::dropIfExists('work_statuses');
    }
}
