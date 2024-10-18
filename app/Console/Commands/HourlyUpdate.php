<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CronTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an hourly email to all the users';

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
          DB::table('cron_test')->insert([
            'status'        => 1,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        $this->info('Hourly Update has been send successfully');

    }
}
