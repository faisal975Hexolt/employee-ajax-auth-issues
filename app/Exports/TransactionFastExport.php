<?php

namespace App\Exports;

use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Payment;
use App\SettlementBrief;
use DB;
use Carbon\Carbon;

class TransactionFastExport
{

    public function __construct()
    {

        $this->date_time = date("Y-m-d H:i:s");
        $this->invoice_date = date("Ymd");
        $this->today = date('d-m-Y');
    }


    public function test()
    {

        echo "test";
    }

    public function headings(): array
    {
        return [
            "Merchant GId",
            "Merchant Name",
            "Sequence ID",
            "Payment ID",
            "Transaction Order Id",
            "Merchant Order Id",
            "Amount",
            "Transaction Time",
            "Payer Name",
            "Email",
            "Contact",
            "Status",
            "Mode",
            "Type",
            'TDR %',
            'TDR',
            'GST %',
            'GST',
            'Total TDR',
            'Net Settlment',
            "Bank Reference No",
            "UPI ID",
            "Customer IP"
        ];
    }


    public function export($results, $fromdate, $todate, $file_name)
    {





        $i = 0;
        $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->headings());
        foreach ($results->lazy(1000) as $transaction) {

            $row['merchant_gid'] = $transaction->merchant_gid;
            $row['name'] = $transaction->name;
            $row['id'] = $transaction->id;
            $row['transaction_gid'] = $transaction->transaction_gid;
            $row['orderId'] = $transaction->orderId;
            $row['udf1'] = $transaction->merchantorderId;

            $row['transaction_amount'] = (float)$transaction->transaction_amount;
            $row['transaction_date'] = $transaction->transaction_date;
            $row['uname'] = $transaction->uname;
            $row['uemail'] = $transaction->uemail;
            $row['ucontact'] = $transaction->ucontact;


            $row['transaction_status'] = $transaction->transaction_status;

            $row['transaction_mode'] = $transaction->transaction_mode;
            $row['transaction_type'] = $transaction->transaction_type;

            $row['percentage_charge'] = (float)$transaction->transaction_adjustment_charged_per;
            $row['percentage_amount'] = (float)$transaction->transaction_adjustment_charged_amount;
            $row['gst_charge'] = $transaction->transaction_gst_value;
            $row['transaction_gst'] = (float)$transaction->transaction_gst_charged_amount;
            $row['transaction_adjustment_charged_amount'] = (float)$transaction->transaction_total_charged_amount;
            $row['total_amt_charged'] = (float)$transaction->transaction_total_adjustment;
            $row['bank_ref_no'] = (string)$transaction->bank_ref_no;
            $row['uPI'] = get_transaction_upiIdById($transaction->transaction_gid);
            $row['uip'] = $transaction->uip;


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
            'Merchant ID',
            'Merchant Name',
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
            'Percentage Charge%',
            'Charge Amount',
            'GST',
            'GST Charge%',
            'Amount Charged',
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
                $transaction->merchant_gid,
                $transaction->merchant_name,
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


    public function export_refund($brief_id, $file_name)
    {



        $payment = new \App\Refund;
        $paymentTable = $payment->getTable();
        list($prefix, $tname) = explode("_", $paymentTable);
        $order = $prefix . "_order";

        $transactionResult = $payment->query()->select([$paymentTable . '.id', 'refund_gid', 'settlement_brief_gid', $paymentTable . '.created_merchant', $paymentTable . '.created_date', DB::raw("IF(business_name<>'',business_name,name) as merchant_name"), 'merchant.merchant_gid', 'payment_id', 'refund_amount', 'refund_amount_charges', 'refund_notes', 'refund_status', $paymentTable . '.updated_at'])
            ->join('merchant', 'merchant.id', '=', $paymentTable . '.created_merchant')
            ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable . '.created_merchant')
            ->where(['settlement_brief_gid' => $brief_id]);



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
