<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class MerchantPayoutTransactionExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $report_filter;
    public $filename;
    public $logId;
    public function __construct($report_filter, $filename, $logId)
    {
        $this->report_filter = $report_filter;
        $this->filename = $filename;
        $this->logId = $logId;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        var_dump('Merchant Payout job hit start');
        $mtans = new \App\Exports\MerchantPayoutTransactionExport();
        return $mtans->export_payment($this->report_filter, $this->filename, $this->logId);
    }


    public function failed(Exception $exception)
    {
        // Print the exception message to the console
        error_log('Job failed with exception: ' . $exception->getMessage());

        // Optionally, you can print the entire stack trace
        error_log($exception->getTraceAsString());
    }
}
