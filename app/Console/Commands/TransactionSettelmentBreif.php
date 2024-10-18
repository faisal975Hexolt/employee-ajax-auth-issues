<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CronApiController;
use Illuminate\Http\Request;


class TransactionSettelmentBreif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settelement:TransactionSettelmentBreif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transaction Settelment breif as per cron job settings';

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
     public function handle(Request $request)
    {
        $controller = new CronApiController(); // make sure to import the controller
        $controller->paymentSettlementBrief($request);
        return 1;
    }
}
