<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Carbon\Carbon;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;

class EmployeeTransactionFastExport
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




    public function export_payment($report_filter, $file_name, $logId)
    {
        $this->fromdate = $report_filter['from'];
        $this->todate = $report_filter['to'];
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
        if ($report_filter['status'] != '') {
            $transactionResult->where($paymentTable . ".transaction_status", $report_filter['status']);
        }
        if ($report_filter['mode'] != '') {
            $transactionResult->where($paymentTable . ".transaction_mode", $report_filter['mode']);
        }
        if ($report_filter['created_merchant'] != '') {
            $transactionResult->where($paymentTable . ".created_merchant", $report_filter['created_merchant']);
        }

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

            // You can update the progress in your log or any other tracking system
            DB::table('transaction_report_log')->where('id', $logId)->update(['progress' => $progress]);

            var_dump($progress);
        });

        // Close the writer
        $writer->close();


        // return $writer->toBrowser();

        // Generate the download link
        // $fileUrl = Storage::url($file_name);

        // Upload the file to S3
        $s3FilePath = 's3/transactions_reports/' . $file_name;
        Storage::disk('s3')->put($s3FilePath, file_get_contents($temporaryFilePath));



        // // Generate the download link from S3
        $fileUrl = Storage::disk('s3')->url($s3FilePath);

        $url = Storage::disk('s3')->temporaryUrl($s3FilePath, now()->addHours(168));

        DB::table('transaction_report_log')->where('id', $logId)->update(['s3_file_path' => $s3FilePath, 'download_link' => $url]);

        var_dump($url);

        var_dump($fileUrl);

        // Optionally, delete the temporary file
        unlink($temporaryFilePath);
    }

    public function refundheadings(): array
    {
        return [
            'sr no',
            'Refund Id',
            'Merchant Id',
            'Merchant Name',
            'Payment Id',
            'Merchant Order Id',
            'Bank Ref No',
            'Amount',
            'Customer VPA',
            'Refund Bank Ref No',
            'Refund Status',
            'Adjusted Settlment ID',
            'Created at'

        ];
    }


    public function export_refund($report_filter, $file_name)
    {


        $this->fromdate = $report_filter['from'];
        $this->todate = $report_filter['to'];


        $payment = new \App\Refund;
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";

        $transactionResult = $payment->query()->select([$paymentTable . '.id', 'refund_gid', 'settlement_brief_gid', $paymentTable . '.created_merchant', $paymentTable . '.created_date', DB::raw("IF(business_name<>'',business_name,name) as merchant_name"), 'merchant.merchant_gid', 'payment_id', 'refund_amount', 'refund_amount_charges', 'refund_notes', 'refund_status', $paymentTable . '.updated_at'])
            ->join('merchant', 'merchant.id', '=', $paymentTable . '.created_merchant')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') >='" . $this->fromdate . "'")
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') <='" . $this->todate . "'");
        if ($report_filter['status'] != '') {
            $transactionResult->where($paymentTable . ".refund_status", $report_filter['status']);
        }

        if ($report_filter['created_merchant'] != '') {
            $transactionResult->where($paymentTable . ".created_merchant", $report_filter['created_merchant']);
        }



        $transactionResult->orderBy($paymentTable . ".id", 'asc');
        $results = $transactionResult->get();


        $i = 0;
        $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->refundheadings());
        foreach ($results->lazy(1000) as $transaction) {
            $transaction_gid = '';
            $orderId = '';
            $bank_ref_no = '';
            if (!empty($transaction->payment)) {
                $transaction_gid = $transaction->payment->transaction_gid;
                $bank_ref_no = $transaction->payment->bank_ref_no;
                if (!empty($transaction->payment->order)) {
                    $orderId = $transaction->payment->order->order_gid;
                }
            }

            $row = array(
                $i + 1,
                $transaction->refund_gid,
                $transaction->merchant_gid,
                $transaction->merchant_name,
                $transaction_gid,
                $orderId,
                $bank_ref_no,
                (float)$transaction->refund_amount,
                (string)get_transaction_upiIdById($transaction_gid),
                '',
                frefund_status($transaction->refund_status),
                $transaction->settlement_brief_gid,
                $transaction->created_date
            );


            $writer->addRow($row);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }

        return $writer->toBrowser();
    }

    public function orderHeadings(): array
    {
        return [
            'Sr no',
            'Order ID',
            'Amount',

            'Status',
            'Created At'

        ];
    }


    public function exportOrder($fromdate, $todate, $file_name)
    {
        $this->fromdate = $fromdate;
        $this->todate = $todate;
        $payment = new \App\Payment;
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";
        $transactionResult = $payment->query()->select([$paymentTable . '.id', 'transaction_gid', $paymentTable . '.udf1 as merchantorderId', 'transaction_type', $paymentTable . '.created_merchant', 'order.order_gid', 'order.order_amount', 'order.order_status', 'order.created_date'])
            ->join($order . " as order", 'order.id', '=', $paymentTable . '.order_id')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->whereRaw("DATE_FORMAT(order.created_date,'%Y-%m-%d %H:%i:%s') >='" . $this->fromdate . "'")
            ->whereRaw("DATE_FORMAT(order.created_date,'%Y-%m-%d %H:%i:%s') <='" . $this->todate . "'")
            ->where($paymentTable . ".created_merchant", Auth::user()->id)
            ->orderBy("order.id", 'asc');
        $results = $transactionResult->get();

        $i = 0;
        $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->orderHeadings());
        foreach ($results->lazy(1000) as $k => $transaction) {


            $row = array(
                $k,
                $transaction->order_gid,
                $transaction->order_amount,
                $transaction->order_status,
                $transaction->created_date,
            );
            $writer->addRow($row);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }

        return $writer->toBrowser();
    }

    public function settelmentheadings(): array
    {
        return [
            "Sr no",
            "Initiated At",
            "Merchant Id",
            "Merchant Name",
            "Settlement Id",
            "Period",
            "UTR No.",
            "Amount",
            "Charges",
            "Adjustments",
            "Refunds",
            "Settling Amount",
            "Status"
        ];
    }

    public function export_settlement($report_filter, $file_name)
    {


        $this->fromdate = $report_filter['from'];
        $this->todate = $report_filter['to'];
        $payment = new \App\SettlementBrief();
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";
        // DB::enableQueryLog();
        $transactionResult = $payment->query()->select([
            'settlement_brief_gid',
            $paymentTable . '.created_merchant',
            'transaction_form',
            'transaction_to',
            'transaction_amount',
            'transaction_gst_charged_amount',
            'transaction_adjustment_charged_amount',
            'transaction_total_charged_amount',
            'transaction_total_adjustment',
            'transaction_total_refunded',
            'transaction_total_settlement',
            'bank_utr',
            'settlement_status',
            $paymentTable . '.created_at',
            'merchant_business.state',
            'merchant_business.business_name',
            'merchant.name as merchant_username'
        ])
            ->join('merchant', $paymentTable . '.created_merchant', 'merchant.id')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_at,'%Y-%m-%d %H:%i:%s') >='" . $this->fromdate . "'")
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_at,'%Y-%m-%d %H:%i:%s') <='" . $this->todate . "'");
        if ($report_filter['status'] != '') {
            $transactionResult->where($paymentTable . ".settlement_status", $report_filter['status']);
        }

        if ($report_filter['created_merchant'] != '') {
            $transactionResult->where($paymentTable . ".created_merchant", $report_filter['created_merchant']);
        }



        $transactionResult->orderBy($paymentTable . ".created_at", 'DESC');
        $results = $transactionResult->get();

        //   dd(DB::getQueryLog());
        // dd($results);

        $i = 0;
        $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->settelmentheadings());
        foreach ($results->lazy(1000) as $transaction) {

            $from = Carbon::parse($transaction->transaction_form)->format('jS M Y h:i:s A');
            $to = Carbon::parse($transaction->transaction_to)->format('jS M Y h:i:s A');


            $row = array(
                $i + 1,
                Carbon::parse($transaction->created_at)->format('d-M, Y h:i:s A'),
                $transaction->merchant->merchant_gid,
                $transaction->merchant->name,
                $transaction->settlement_brief_gid,
                $from . " to " . $to,
                $transaction->bank_utr,
                $transaction->transaction_amount,
                $transaction->transaction_total_charged_amount,
                $transaction->transaction_total_adjustment,
                $transaction->transaction_total_refunded,
                $transaction->transaction_total_settlement,
                fsettlement_status($transaction->settlement_status)

            );


            $writer->addRow($row);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }

        return $writer->toBrowser();
    }

    public function export_reseller_settlement($report_filter, $file_name)
    {
        $this->fromdate = $report_filter['from'];
        $this->todate = $report_filter['to'];
        $payment = new \App\Payment;
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";

        $transactionResult = $payment->query()->select([
            'settlement_brief_gid',
            $paymentTable . '.created_merchant',
            'transaction_form',
            'transaction_to',
            'transaction_amount',
            'transaction_gst_charged_amount',
            'transaction_adjustment_charged_amount',
            'transaction_total_charged_amount',
            'transaction_total_adjustment',
            'transaction_total_refunded',
            'transaction_total_settlement',
            'bank_utr',
            'settlement_status',
            $paymentTable . '.created_at',
            'merchant_business.state',
            'merchant_business.business_name',
            'merchant.name as merchant_username'
        ])
            ->join('merchant', $paymentTable . '.created_merchant', '=', 'merchant.id')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_at,'%Y-%m-%d %H:%i:%s') >='" . $this->fromdate . "'")
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_at,'%Y-%m-%d %H:%i:%s') <='" . $this->todate . "'");

        if ($report_filter['status'] != '') {
            $transactionResult->where($paymentTable . ".settlement_status", $report_filter['status']);
        }

        if (!empty($report_filter['created_merchant'])) {
            if (is_array($report_filter['created_merchant'])) {
                $transactionResult->whereIn($paymentTable . ".created_merchant", $report_filter['created_merchant']);
            } else {
                $transactionResult->where($paymentTable . ".created_merchant", $report_filter['created_merchant']);
            }
        }

        $transactionResult->orderBy($paymentTable . ".created_at", 'DESC');
        $results = $transactionResult->get();

        $i = 0;
        $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->settelmentheadings());
        foreach ($results->lazy(1000) as $transaction) {
            $from = Carbon::parse($transaction->transaction_form)->format('jS M Y h:i:s A');
            $to = Carbon::parse($transaction->transaction_to)->format('jS M Y h:i:s A');

            $row = array(
                $i + 1,
                Carbon::parse($transaction->created_at)->format('d-M, Y h:i:s A'),
                $transaction->merchant_gid,
                $transaction->merchant_username,
                $transaction->settlement_brief_gid,
                $from . " to " . $to,
                $transaction->bank_utr,
                $transaction->transaction_amount,
                $transaction->transaction_total_charged_amount,
                $transaction->transaction_total_adjustment,
                $transaction->transaction_total_refunded,
                $transaction->transaction_total_settlement,
                fsettlement_status($transaction->settlement_status)
            );

            $writer->addRow($row);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }

        return $writer->toBrowser();
    }


    public function export_reseller_refund($report_filter, $file_name)
    {
        $this->fromdate = $report_filter['from'];
        $this->todate = $report_filter['to'];
        $payment = new \App\Refund();
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";

        $transactionResult = $payment->query()->select([
            $paymentTable . '.id',
            'refund_gid',
            'settlement_brief_gid',
            $paymentTable . '.created_merchant',
            $paymentTable . '.created_date',
            DB::raw("IF(business_name<>'',business_name,name) as merchant_name"),
            'merchant.merchant_gid',
            'payment_id',
            'refund_amount',
            'refund_amount_charges',
            'refund_notes',
            'refund_status',
            $paymentTable . '.updated_at'
        ])
            ->join('merchant', 'merchant.id', '=', $paymentTable . '.created_merchant')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') >='" . $this->fromdate . "'")
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') <='" . $this->todate . "'");

        if ($report_filter['status'] != '') {
            $transactionResult->where($paymentTable . ".refund_status", $report_filter['status']);
        }

        if (!empty($report_filter['created_merchant'])) {
            if (is_array($report_filter['created_merchant'])) {
                $transactionResult->whereIn($paymentTable . ".created_merchant", $report_filter['created_merchant']);
            } else {
                $transactionResult->where($paymentTable . ".created_merchant", $report_filter['created_merchant']);
            }
        }

        $transactionResult->orderBy($paymentTable . ".id", 'asc');
        $results = $transactionResult->get();

        $i = 0;
        $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->refundheadings());
        foreach ($results->lazy(1000) as $transaction) {
            $transaction_gid = '';
            $orderId = '';
            $bank_ref_no = '';
            if (!empty($transaction->payment)) {
                $transaction_gid = $transaction->payment->transaction_gid;
                $bank_ref_no = $transaction->payment->bank_ref_no;
                if (!empty($transaction->payment->order)) {
                    $orderId = $transaction->payment->order->order_gid;
                }
            }

            $row = array(
                $i + 1,
                $transaction->refund_gid,
                $transaction->merchant_gid,
                $transaction->merchant_name,
                $transaction_gid,
                $orderId,
                $bank_ref_no,
                (float)$transaction->refund_amount,
                (string)get_transaction_upiIdById($transaction_gid),
                '',
                frefund_status($transaction->refund_status),
                $transaction->settlement_brief_gid,
                $transaction->created_date
            );

            $writer->addRow($row);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }

        return $writer->toBrowser();
    }
}
