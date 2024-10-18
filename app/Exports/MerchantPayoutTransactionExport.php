<?php

namespace App\Exports;

use App\PayoutTransaction;
use DB;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Auth;

class MerchantPayoutTransactionExport
{
    /**
     * @return \Illuminate\Support\Collection
     */
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
            "Initiation Time",
            "Transaction Time",
            "Transaction Id",
            "Merchant Order Id",
            "Utr",
            "Beneficiary Name",
            "Beneficiary Email",
            "Beneficiary Phone",
            "Beneficiary Acc",
            "Beneficiary Ifsc",
            "Amount",
            "Status",
            "Remark"
        ];
    }


    public function export_payment($report_filter, $file_name, $logId)
    {

        var_dump($report_filter);
        $this->fromdate = $report_filter['from'];
        $this->todate = $report_filter['to'];

        var_dump('payout export started');
        // Base query with filters
        $baseQuery = PayoutTransaction::join('merchant', 'payout_transactions.merchant_id', 'merchant.id')
            ->where('payout_transactions.merchant_id',  $report_filter['created_merchant'])
            ->whereDate('payout_transactions.created_at', '>=', $this->fromdate)
            ->whereDate('payout_transactions.created_at', '<=', $this->todate);

        if ($report_filter['status'] != 'all') {
            $baseQuery->where("payout_transactions.status", $report_filter['status']);
        }


        // Get the total number of records
        $totalRows = $baseQuery->count();
        var_dump($totalRows, "total rows");
        $chunkSize = 1000;
        $chunkCounter = 0;
        $processedRows = 0;

        // Create a temporary file path
        $temporaryFilePath = storage_path("app/public/" . $file_name);
        $writer = SimpleExcelWriter::create($temporaryFilePath);
        $writer->addHeader($this->headings());

        // Chunk and process records
        $baseQuery->select([
            'payout_transactions.transfer_id',
            'payout_transactions.merchant_orderId',
            'payout_transactions.response_error_message',
            'payout_transactions.payout_transaction_date',
            'payout_transactions.reference_id',
            'payout_transactions.utr',
            'payout_transactions.transfer_id',
            'merchant.merchant_gid',
            'merchant.name',
            'payout_transactions.orderId',
            'payout_transactions.status',
            'payout_transactions.ben_id',
            'payout_transactions.ben_name',
            'payout_transactions.ben_phone',
            'payout_transactions.ben_email',
            'payout_transactions.ben_ifsc',
            'payout_transactions.amount',
            'payout_transactions.created_at',
            'payout_transactions.ben_bank_acc'
        ])->chunk($chunkSize, function ($results) use ($writer, &$chunkCounter, $chunkSize, $logId, &$processedRows, $totalRows) {
            foreach ($results as $transaction) {
                $row = [
                    $transaction->created_at,
                    $transaction->payout_transaction_date,
                    $transaction->orderId,
                    $transaction->merchant_orderId,
                    $transaction->utr,
                    $transaction->ben_name,
                    $transaction->ben_email,
                    $transaction->ben_phone,
                    $transaction->ben_bank_acc,
                    $transaction->ben_ifsc,
                    (float)$transaction->amount,
                    $transaction->status,
                    $transaction->response_error_message
                ];
                $writer->addRow($row);
            }

            // Update progress
            $chunkCounter++;
            $processedRows = $chunkCounter * $chunkSize;
            $progress = min(100, number_format(($processedRows * 100) / $totalRows, 2));
            DB::table('payout_transaction_report_log')->where('id', $logId)->update(['progress' => $progress]);

            var_dump($progress, "total rows");
        });

        // Close the writer
        $writer->close();

        // Upload the file to S3
        $s3FilePath = 's3/payout_reports/' . $file_name;
        Storage::disk('s3')->put($s3FilePath, file_get_contents($temporaryFilePath));

        // Generate the download link from S3
        $url = Storage::disk('s3')->temporaryUrl($s3FilePath, now()->addHours(168));

        // Update the log with S3 file path and download link
        DB::table('payout_transaction_report_log')->where('id', $logId)->update([
            's3_file_path' => $s3FilePath,
            'progress' => 100,
            'download_link' => $url
        ]);

        // Optionally, delete the temporary file
        unlink($temporaryFilePath);
    }


    public function resellerheadings(): array
    {
        return [
            "Merchant Id",
            "Merchant Name",
            "Initiation Time",
            "Transaction Time",
            "Transaction Id",
            "Merchant Order Id",
            "Utr",
            "Beneficiary Name",
            "Beneficiary Email",
            "Beneficiary Phone",
            "Beneficiary Acc",
            "Beneficiary Ifsc",
            "Amount",
            "Status",
            "Remark"
        ];
    }

    public function reseller_export_payment($report_filter, $file_name, $logId)
    {

        var_dump($report_filter);
        $this->fromdate = $report_filter['from'];
        $this->todate = $report_filter['to'];

        var_dump('payout export started');
        // Base query with filters
        $baseQuery = PayoutTransaction::join('merchant', 'payout_transactions.merchant_id', 'merchant.id')
            ->whereDate('payout_transactions.created_at', '>=', $this->fromdate)
            ->whereDate('payout_transactions.created_at', '<=', $this->todate);


        if ($report_filter['created_merchant'] != 'all') {
            $baseQuery->where('payout_transactions.merchant_id',  $report_filter['created_merchant']);
        } else {
            $reseller = DB::table('payout_transaction_report_log')->where('id', $logId)->first();
            $merchantList = DB::table('merchant')->where('reseller_id', $reseller->show_to_reseller)->get()->pluck('id')->toArray();

            $baseQuery->whereIn('payout_transactions.merchant_id', $merchantList);
        }

        if ($report_filter['status'] != 'all') {
            $baseQuery->where("payout_transactions.status", $report_filter['status']);
        }


        // Get the total number of records
        $totalRows = $baseQuery->count();
        var_dump($totalRows, "total rows");
        $chunkSize = 1000;
        $chunkCounter = 0;
        $processedRows = 0;

        // Create a temporary file path
        $temporaryFilePath = storage_path("app/public/" . $file_name);
        $writer = SimpleExcelWriter::create($temporaryFilePath);
        $writer->addHeader($this->resellerheadings());

        // Chunk and process records
        $baseQuery->select([
            'payout_transactions.transfer_id',
            'payout_transactions.merchant_orderId',
            'payout_transactions.response_error_message',
            'payout_transactions.payout_transaction_date',
            'payout_transactions.reference_id',
            'payout_transactions.utr',
            'payout_transactions.transfer_id',
            'merchant.merchant_gid',
            'merchant.name',
            'payout_transactions.orderId',
            'payout_transactions.status',
            'payout_transactions.ben_id',
            'payout_transactions.ben_name',
            'payout_transactions.ben_phone',
            'payout_transactions.ben_email',
            'payout_transactions.ben_ifsc',
            'payout_transactions.amount',
            'payout_transactions.created_at',
            'payout_transactions.ben_bank_acc'
        ])->chunk($chunkSize, function ($results) use ($writer, &$chunkCounter, $chunkSize, $logId, &$processedRows, $totalRows) {
            foreach ($results as $transaction) {
                $row = [
                    $transaction->name,
                    $transaction->merchant_gid,
                    $transaction->created_at,
                    $transaction->payout_transaction_date,
                    $transaction->orderId,
                    $transaction->merchant_orderId,
                    $transaction->utr,
                    $transaction->ben_name,
                    $transaction->ben_email,
                    $transaction->ben_phone,
                    $transaction->ben_bank_acc,
                    $transaction->ben_ifsc,
                    (float)$transaction->amount,
                    $transaction->status,
                    $transaction->response_error_message
                ];
                $writer->addRow($row);
            }

            // Update progress
            $chunkCounter++;
            $processedRows = $chunkCounter * $chunkSize;
            $progress = min(100, number_format(($processedRows * 100) / $totalRows, 2));
            DB::table('payout_transaction_report_log')->where('id', $logId)->update(['progress' => $progress]);

            var_dump($progress, "total rows");
        });

        // Close the writer
        $writer->close();

        // Upload the file to S3
        $s3FilePath = 's3/payout_reports/' . $file_name;
        Storage::disk('s3')->put($s3FilePath, file_get_contents($temporaryFilePath));

        // Generate the download link from S3
        $url = Storage::disk('s3')->temporaryUrl($s3FilePath, now()->addHours(168));

        // Update the log with S3 file path and download link
        DB::table('payout_transaction_report_log')->where('id', $logId)->update([
            's3_file_path' => $s3FilePath,
            'progress' => 100,
            'download_link' => $url
        ]);

        // Optionally, delete the temporary file
        unlink($temporaryFilePath);
    }
}
