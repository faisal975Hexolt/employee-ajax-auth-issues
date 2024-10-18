<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Carbon\Carbon;
use Auth;
use DB;

class EmployeeRefundFastExport 
{


    public $transactionData;
  


    public $fromdate;
    public $todate;
    

    public function __construct(){
        $this->fromdate = '';
        $this->todate = '';
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


    public function export_refund($report_filter,$file_name)
    {


        $this->fromdate = $report_filter['from'];
        $this->todate = $report_filter['to'];
        $payment=new \App\Refund;
        $paymentTable=$payment->getTable();
        list($prefix,$tname)=explode("_",$paymentTable);
        $order=$prefix."_order";
       
        $transactionResult= $payment->query()->select([$paymentTable.'.id','refund_gid','settlement_brief_gid',$paymentTable.'.created_merchant',$paymentTable.'.created_date',DB::raw("IF(business_name<>'',business_name,name) as merchant_name"),'merchant.merchant_gid','payment_id','refund_amount','refund_amount_charges','refund_notes','refund_status',$paymentTable.'.updated_at'])
               ->join('merchant', 'merchant.id', '=', $paymentTable.'.created_merchant')
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.created_merchant')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d %H:%i:%s') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d %H:%i:%s') <='".$this->todate."'");
                if($report_filter['status']!=''){
                    $transactionResult->where($paymentTable.".refund_status",$report_filter['status']);
                }
              
                if($report_filter['created_merchant']!=''){
                    $transactionResult->where($paymentTable.".created_merchant",$report_filter['created_merchant']);
                }

               
               
               $transactionResult->orderBy($paymentTable.".id",'asc');
               $results=$transactionResult->get(); 
              
               
               $i = 0;
           $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->refundheadings());
        foreach ($results->lazy(1000) as $transaction) 
        {
            $transaction_gid='';
            $orderId='';
            $bank_ref_no='';
            if(!empty($transaction->payment)){
                $transaction_gid=$transaction->payment->transaction_gid;
                $bank_ref_no=$transaction->payment->bank_ref_no;
                if(!empty($transaction->payment->order)){
                    $orderId=$transaction->payment->order->order_gid;
                }
            }
            
             $row=array(
                $i+1,
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
                $transaction->created_date);


                $writer->addRow($row);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }

        return $writer->toBrowser();
    }

    

   

    
}
