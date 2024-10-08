<?php

namespace App\Console\Commands;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Work;
use Illuminate\Console\Command;
use phpseclib3\File\ASN1\Maps\Attribute;

class DriverDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'driver:delete {id}';

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
        $drivers = Driver::where('unit_number',null)
            ->orWhereIn('unit_number',[
                '0','1001','1010','1000'
            ])->get();

        if (isset($drivers) && count($drivers)>0){
            foreach ($drivers as $driver) {
                if ($vehicle = Vehicle::where('driver_id',$driver->id)->first()){
                    $vehicle->delete();
                }

                $load = Work::where('driver_id',$driver->id)->get();
                if (isset($load) && count($load)>0){
                    foreach ($load as $item) {
                        $item->delete();
                    }
                }
                $driver->delete();

                $this->info("success");
            }
        }

    }
}
