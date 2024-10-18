<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CronApiController;
use Illuminate\Http\Request;

class DailyCronSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:createSettlementCron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create Settlement Cron json file';

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
        // $base_url="http://localhost/s2pay/spay_code_8_manage/sapi/cronSettlement";
        //  $headers= [
        //             'accept' => 'application/json',
        //             'content-type' => 'application/json'
        //         ];
        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', $base_url, [
        //             'headers' =>$headers,
        //     ]);
        //   $apiResponse =   json_decode($response->getBody(), true);
         // return array("code" => $response->getStatusCode(), "data" => $apiResponse);
         // return $apiResponse;

        $controller = new CronApiController(); // make sure to import the controller
        $controller->createSettlementCron($request);
        return 1;
    }
}
