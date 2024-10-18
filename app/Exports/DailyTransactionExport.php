<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Carbon\Carbon;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;

class DailyTransactionExport
{


    public $transactionData;



    public $fromdate;
    public $todate;


    public function __construct()
    {
        $this->fromdate = '';
        $this->todate = '';
    }

    public function headings(): array
    {
        return [
            'Initiation Time',
            'Merchant ID',
            'Merchant Name',
            'Sequence ID',
            'Payment ID',
            'Merchant Order ID',
            'Acquirer ID',
            'Acquirer Name',
            'Amount',
            'Transaction Time',
            'Payer Name',
            'Email',
            'Contact',
            'Status',
            'Mode',
            'TDR %',
            'TDR',
            'GST %',
            'GST',
            'Total TDR',
            'Net Settlment',
            'Bank Reference No',
            'UPI ID',
            'Customer IP',

        ];
    }




    public function export_payment($logId)
    {
        $yesterday = Carbon::yesterday();
        $from = $yesterday->startOfDay()->format('Y-m-d H:i:s');
        $to = $yesterday->endOfDay()->format('Y-m-d H:i:s');

        $yesterdayDate = Carbon::yesterday()->format('d-m-Y');

        $file_name = "DailyTranReport" . $yesterdayDate . "-" . rand(1, 9) . ".xlsx";

        $this->fromdate =  $from;
        $this->todate = $to;
        var_dump($this->fromdate, $this->todate);

        $payment = new \App\Payment;
        $paymentTable = 'live_payment';
        // $paymentTable = $payment->getTable();
        // list($prefix, $tname) = explode("_", $paymentTable);
        // $order = $prefix . "_order";
        $order =  "live_order";
        $transactionResult = DB::table('live_payment')->select([
            $paymentTable . '.id',
            'transaction_gid',
            $paymentTable . '.udf1 as merchantorderId',
            'transaction_type',
            $paymentTable . '.created_merchant',
            'order_id',
            $paymentTable . '.created_date',
            'merchant_business.state',
            'transaction_username',
            'transaction_email',
            'transaction_contact',
            'transaction_amount',
            'vendor_transaction_id',
            'acquirer_transaction_id',
            'vendor_bank.bank_name',
            'transaction_status',
            'transaction_mode',
            DB::raw('IF( ISNULL(transaction_date) ,' . $paymentTable . '.created_date,transaction_date) as transaction_date'),
            'merchant_ip',
            'customer_vpa',
            'transaction_gst_value',
            'transaction_gst_charged_per',
            'transaction_gst_charged_amount',
            'transaction_adjustment_charged_per',
            'transaction_adjustment_charged_amount',
            'transaction_total_charged_amount',
            'transaction_total_adjustment',
            'bank_ref_no',
            DB::raw("IF(business_name<>'',business_name,name) as merchant_name"),
            'merchant.merchant_gid'
        ])
           
            ->join('merchant', 'merchant.id', '=', $paymentTable . '.created_merchant')
            ->join('vendor_bank', 'vendor_bank.id', '=', $paymentTable . '.vendor_id')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') >='" . $this->fromdate . "'")
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') <='" . $this->todate . "'");


        $transactionResult->orderBy($paymentTable . ".id", 'asc');
        // Count the total number of rows to process
        $totalRows = $transactionResult->count();
        $chunkCounter = 0;
        $chunkSize = 500;

        var_dump($totalRows);

        // $file_name = "transactions_" . rand(0, 10000) . ".xlsx";

        // Create the writer and save the Excel file to a temporary path
        $temporaryFilePath = storage_path("app/public/" . $file_name);
        $writer = SimpleExcelWriter::create($temporaryFilePath);

        $writer->addHeader($this->headings());

        var_dump('chunk starting');

        $transactionResult->chunk($chunkSize, function ($transactions) use ($writer, $totalRows, &$chunkCounter, $chunkSize, $logId) {
            $chunkCounter++;
            foreach ($transactions as $transaction) {
                $transaction_adjustment_charged_per = $transaction->transaction_adjustment_charged_per ?: '';

                $row = [
                    $transaction->created_date,
                    $transaction->merchant_gid,
                    $transaction->merchant_name,
                    $transaction->id,
                    $transaction->transaction_gid,
                    $transaction->vendor_transaction_id,
                    $transaction->acquirer_transaction_id,
                    $transaction->bank_name,
                    (float)$transaction->transaction_amount,
                    $transaction->transaction_date,
                    $transaction->transaction_username,
                    $transaction->transaction_email,
                    $transaction->transaction_contact,
                    $transaction->transaction_status,
                    $transaction->transaction_mode,
                    $transaction_adjustment_charged_per,
                    (float)$transaction->transaction_adjustment_charged_amount,
                    $transaction->transaction_gst_value,
                    (float)$transaction->transaction_gst_charged_amount,
                    (float)$transaction->transaction_total_charged_amount,
                    (float)$transaction->transaction_total_adjustment,
                    (string)$transaction->bank_ref_no,
                    $transaction->customer_vpa,
                    $transaction->merchant_ip
                ];

                $writer->addRow($row);
            }

            // Calculate and update progress
            $processedRows = $chunkCounter * $chunkSize;
            $progress = min(100, number_format(($processedRows * 100) / $totalRows, 2));

            var_dump($progress);
        });

        // Close the writer
        $writer->close();


        // return $writer->toBrowser();

        // Generate the download link
        // $fileUrl = Storage::url($file_name);

        // Upload the file to S3
        $s3FilePath = 's3/daily_admin_payin_transactions_reports/' . $file_name;
        Storage::disk('s3')->put($s3FilePath, file_get_contents($temporaryFilePath));



        // // Generate the download link from S3
        $fileUrl = Storage::disk('s3')->url($s3FilePath);

        $url = Storage::disk('s3')->temporaryUrl($s3FilePath, now()->addHours(168));

        DB::table('daily_transaction_report_log')->where('id', $logId)->update(['s3_file_path' => $s3FilePath, 'download_link' => $url]);

        var_dump($url);

        var_dump($fileUrl);

        // Optionally, delete the temporary file
        unlink($temporaryFilePath);
    }
}
