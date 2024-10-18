<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Auth;
use DB;

class MerchantTransactionExport implements FromQuery, WithHeadings,WithChunkReading,WithMapping
{


    public $transactionData;
    use Exportable;


    public $fromdate;
    public $todate;
    

    public function __construct($fromdate,$todate){
        $this->fromdate = $fromdate;
        $this->todate = $todate;
    }

    public function headings(): array
    {
        return [
            'Initiation Time',
            'Transaction Sequence ID',
            'Payment ID',
            'Order ID',
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
            'Customer IP',

    ];
    }


     public function query()
    {
        $payment=new \App\Payment;
        $paymentTable=$payment->getTable();
        list($prefix,$tname)=explode("_",$paymentTable);
        $order=$prefix."_order";
        return $payment->query()->select([$paymentTable.'.id','transaction_gid',$paymentTable.'.udf1 as merchantorderId','transaction_type',$paymentTable.'.created_merchant',
            'order_id',$paymentTable.'.created_date','merchant_business.state','transaction_username','transaction_email','transaction_contact','transaction_amount','transaction_status','transaction_mode', DB::raw('IF( ISNULL(transaction_date) ,'.$paymentTable.'.created_date,transaction_date) as transaction_date'),'merchant_ip','transaction_gst_value','transaction_gst_charged_per','transaction_gst_charged_amount','transaction_adjustment_charged_per','transaction_adjustment_charged_amount','transaction_total_charged_amount','transaction_total_adjustment','bank_ref_no'])
               ->join($order." as order" , 'order.id', '=', $paymentTable.'.order_id')
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.created_merchant')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d %H:%i:%s') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d %H:%i:%s') <='".$this->todate."'")
               ->where($paymentTable.".created_merchant",Auth::user()->id)
               ->orderBy($paymentTable.".id",'asc');
              
               ;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 50;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return collect($this->transactionData);
    // }

    public function map($transaction): array
    {

        return [
            $transaction->created_date,
            $transaction->id,
            $transaction->transaction_gid,
            $transaction->merchantorderId,
            $transaction->transaction_amount,
            $transaction->transaction_date,
            $transaction->transaction_username,
            $transaction->transaction_email,
            $transaction->transaction_contact,
            $transaction->transaction_status,
            $transaction->transaction_mode,
            $transaction->transaction_adjustment_charged_per,
            $transaction->transaction_adjustment_charged_amount,
            $transaction->transaction_gst_value,
            $transaction->transaction_gst_charged_amount,
            $transaction->transaction_total_charged_amount,
            $transaction->transaction_total_adjustment,
            $transaction->bank_ref_no,
            $transaction->merchant_ip

           
        ];
    }



     public function fields(): array
    {
        return [
            'Initiation Time',
            'Transaction Sequence ID',
            'amount',
            'transaction_email',
            'created_date'
        ];
    }

    
}
