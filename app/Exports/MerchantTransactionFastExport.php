<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\SettlementBrief;
use Carbon\Carbon;
use Auth;
use DB;



class MerchantTransactionFastExport
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
            'Sequence ID',
            'Payment ID',
            'Merchant Order ID',
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




    public function export($fromdate, $todate, $file_name)
    {
        $this->fromdate = $fromdate;
        $this->todate = $todate;
        $payment = new \App\Payment;
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";
        $transactionResult = $payment->query()->select([
            $paymentTable . '.id', 'transaction_gid', $paymentTable . '.udf1 as merchantorderId', 'transaction_type', $paymentTable . '.created_merchant',
            'order_id', $paymentTable . '.created_date', 'merchant_business.state', 'transaction_username', 'transaction_email', 'transaction_contact', 'transaction_amount', 'transaction_status', 'transaction_mode', DB::raw('IF( ISNULL(transaction_date) ,' . $paymentTable . '.created_date,transaction_date) as transaction_date'), 'merchant_ip', 'transaction_gst_value', 'transaction_gst_charged_per', 'transaction_gst_charged_amount', 'transaction_adjustment_charged_per', 'transaction_adjustment_charged_amount', 'transaction_total_charged_amount', 'transaction_total_adjustment', 'bank_ref_no'
        ])
            ->join($order . " as order", 'order.id', '=', $paymentTable . '.order_id')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') >='" . $this->fromdate . "'")
            ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') <='" . $this->todate . "'")
            ->where($paymentTable . ".created_merchant", Auth::user()->id)
            ->where($paymentTable . ".transaction_status", 'success')
            ->orderBy($paymentTable . ".id", 'asc');
        $results = $transactionResult->get();
        $i = 0;
        $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->headings());
        foreach ($results->lazy(1000) as $transaction) {

            $row = array(
                $transaction->created_date,
                $transaction->id,
                $transaction->transaction_gid,
                $transaction->merchantorderId,
                (float)$transaction->transaction_amount,
                $transaction->transaction_date,
                $transaction->transaction_username,
                $transaction->transaction_email,
                $transaction->transaction_contact,
                $transaction->transaction_status,
                $transaction->transaction_mode,
                (float)$transaction->transaction_adjustment_charged_per,
                (float)$transaction->transaction_adjustment_charged_amount,
                $transaction->transaction_gst_value,
                (float)$transaction->transaction_gst_charged_amount,
                (float)$transaction->transaction_total_charged_amount,
                (float)$transaction->transaction_total_adjustment,
                (string)$transaction->bank_ref_no,
                (string)get_transaction_upiId($transaction),
                $transaction->merchant_ip
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


    public function headingsSettled(): array
    {
        return [
            'Initiation Time',
            'Processed Time',
            'UTR No.',
            'Sequence ID',
            'Payment ID',
            'Merchant Order ID',
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
            'Tootal TDR',
            'Net Settlment',
            'Bank Reference No',
            'UPI ID',
            'Customer IP',

        ];
    }


    public function exportSettled($brief_id, $file_name)
    {

        $payment = new \App\Payment;
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";
        $transactionResult = $payment->query()->select([
            $paymentTable . '.id', 'transaction_gid', $paymentTable . '.udf1 as merchantorderId', 'transaction_type', $paymentTable . '.created_merchant',
            'order_id', $paymentTable . '.created_date', 'merchant_business.state', 'transaction_username', 'transaction_email', 'transaction_contact', 'transaction_amount', 'transaction_status', 'transaction_mode', DB::raw('IF( ISNULL(transaction_date) ,' . $paymentTable . '.created_date,transaction_date) as transaction_date'), 'merchant_ip', 'transaction_gst_value', 'transaction_gst_charged_per', 'transaction_gst_charged_amount', 'transaction_adjustment_charged_per', 'transaction_adjustment_charged_amount', 'transaction_total_charged_amount', 'transaction_total_adjustment', 'bank_ref_no', DB::raw("IF(business_name<>'',business_name,name) as merchant_name"), 'merchant.merchant_gid'
        ])
            ->join($order . " as order", 'order.id', '=', $paymentTable . '.order_id')
            ->join('merchant', 'merchant.id', '=', $paymentTable . '.created_merchant')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')

            ->where(['settlement_brief_gid' => $brief_id]);


        $transactionResult->orderBy($paymentTable . ".id", 'asc');
        $results = $transactionResult->get();


        $settlement = SettlementBrief::where(['settlement_brief_gid' => $brief_id])->first();
        $InitiationTime = '';
        $ProcessedTime = '';
        $UTRNo = '';

        if ($settlement) {
            $InitiationTime = Carbon::parse($settlement->created_at)->format('jS M Y h:i:s A');
            if ($settlement->bank_utr) {
                $ProcessedTime = Carbon::parse($settlement->updated_at)->format('jS M Y h:i:s A');
                $UTRNo = $settlement->bank_utr;
            }
        }





        $i = 0;
        $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->headingsSettled());
        foreach ($results->lazy(1000) as $transaction) {

            $row = array(
                $InitiationTime,
                $ProcessedTime,
                $UTRNo,
                $transaction->id,

                $transaction->transaction_gid,
                $transaction->merchantorderId,
                (float)$transaction->transaction_amount,
                $transaction->transaction_date,
                $transaction->transaction_username,
                $transaction->transaction_email,
                $transaction->transaction_contact,
                $transaction->transaction_status,
                $transaction->transaction_mode,
                (float)$transaction->transaction_adjustment_charged_per,
                (float)$transaction->transaction_adjustment_charged_amount,
                $transaction->transaction_gst_value,
                (float)$transaction->transaction_gst_charged_amount,
                (float)$transaction->transaction_total_charged_amount,
                (float)$transaction->transaction_total_adjustment,
                (string)$transaction->bank_ref_no,
                (string)get_transaction_upiId($transaction),
                $transaction->merchant_ip
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
