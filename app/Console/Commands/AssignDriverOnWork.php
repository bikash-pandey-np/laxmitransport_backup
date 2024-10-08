<?php

namespace App\Console\Commands;

use App\Models\Work;
use Illuminate\Console\Command;

class AssignDriverOnWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'driver';

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
        $works = Work::get();
        foreach ($works as $work) {
            $work->update([
                'driver_id' => $work->vehicle->driver_id
            ]);
        }
    }
}
