<?php

namespace App\Console\Commands;

use App\Models\Work;
use Illuminate\Console\Command;

class WorkDataClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:db';

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
        $works = Work::all();
        foreach ($works as $work) {
            $work->delete();
        }

        Work::truncate();


        $this->info("work!");
    }
}
