<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;

class DailyTransactionExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $insertLog = DB::table('daily_transaction_report_log')->insertGetId([
            'date' => $yesterday,
            'report_type' => 'Transaction',
            'created_date' => Carbon::now(),
        ]);

        var_dump($insertLog);

        $mtans = new \App\Exports\DailyTransactionExport();

        $mtans->export_payment($insertLog);


        //delete week old reports
        $oneWeekAgo = Carbon::now()->subWeek();

        // GET records older than one week
        $dailyTranReports =  DB::table('daily_transaction_report_log')->where('created_date', '<', $oneWeekAgo)->get();

        $PayinTranReports =  DB::table('transaction_report_log')->where('created_date', '<', $oneWeekAgo)->get();

        $PayoutTranReports =  DB::table('payout_transaction_report_log')->where('created_date', '<', $oneWeekAgo)->get();

        // Initialize an array to store s3_file_path values
        $s3FilePaths = [];

        // Extract s3_file_path from each collection
        foreach ($dailyTranReports as $report) {
            if (isset($report->s3_file_path)) {
                $s3FilePaths[] = $report->s3_file_path;
            }
        }

        foreach ($PayinTranReports as $report) {
            if (isset($report->s3_file_path)) {
                $s3FilePaths[] = $report->s3_file_path;
            }
        }

        foreach ($PayoutTranReports as $report) {
            if (isset($report->s3_file_path)) {
                $s3FilePaths[] = $report->s3_file_path;
            }
        }


        // Initialize the S3 disk
        $s3Disk = Storage::disk('s3');

        var_dump($s3FilePaths);

        foreach ($s3FilePaths as $filePath) {
            if ($s3Disk->exists($filePath)) {
                $s3Disk->delete($filePath);
                var_dump("Deleted file: $filePath\n");
            } else {
                var_dump("File not found file: $filePath\n");
            }
        }


        // GET records older than one week
        $dailyTranReports =  DB::table('daily_transaction_report_log')->where('created_date', '<', $oneWeekAgo)->delete();

        $PayinTranReports =  DB::table('transaction_report_log')->where('created_date', '<', $oneWeekAgo)->delete();

        $PayoutTranReports =  DB::table('payout_transaction_report_log')->where('created_date', '<', $oneWeekAgo)->delete();
    }
}
