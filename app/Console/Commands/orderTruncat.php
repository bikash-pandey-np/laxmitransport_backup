<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\LoadBoard;
use App\Models\LoadBoardUser;
use App\Models\Payroll;
use App\Models\SpeedySalse;
use App\Models\Work;
use App\Models\WorkBill;
use App\Models\WorkDeliveryImage;
use App\Models\WorkLocation;
use App\Models\WorkStatusTime;
use App\Models\WorkTracking;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class orderTruncat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Schema::table('work_delivery_images',function (Blueprint $table){
            $table->dropForeign(['work_location_id']);
        });
        Schema::table('work_bills',function (Blueprint $table){
            $table->dropForeign(['work_id']);
        });
        Schema::table('work_locations',function (Blueprint $table){
            $table->dropForeign(['work_id']);
        });
        Schema::table('work_status_times',function (Blueprint $table){
            $table->dropForeign(['work_id']);
        });
        Schema::table('speedy_salses',function (Blueprint $table){
            $table->dropForeign(['work_id']);
        });

        Schema::table('work_trackings',function (Blueprint $table){
            $table->dropForeign(['work_id']);
        });

        Schema::table('payrolls',function (Blueprint $table){
            $table->dropForeign(['work_id']);
        });

        Payroll::truncate();
        WorkTracking::truncate();
        SpeedySalse::truncate();
        WorkBill::truncate();
        WorkDeliveryImage::truncate();
        WorkLocation::truncate();
        WorkStatusTime::truncate();
        Work::truncate();
        Bill::truncate();
        LoadBoard::truncate();
        LoadBoardUser::truncate();

        Schema::table('work_bills',function (Blueprint $table){
            $table->foreign('work_id')->on('works')->references('id')->onDelete('cascade');
        });
        Schema::table('work_locations',function (Blueprint $table){
            $table->foreign('work_id')->on('works')->references('id')->onDelete('cascade');
        });
        Schema::table('work_status_times',function (Blueprint $table){
            $table->foreign('work_id')->on('works')->references('id')->onDelete('cascade');
        });
        Schema::table('work_delivery_images',function (Blueprint $table){
            $table->foreign('work_location_id')->on('work_locations')->references('id')->cascadeOnDelete();
        });
        Schema::table('speedy_salses',function (Blueprint $table){
            $table->foreign('work_id')->on('works')->references('id')->cascadeOnDelete();
        });

        return true;
    }
}
