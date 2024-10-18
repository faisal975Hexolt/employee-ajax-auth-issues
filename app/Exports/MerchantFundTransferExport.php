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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use Carbon\Carbon;
use DB;


class MerchantFundTransferExport implements FromQuery, WithHeadings,WithChunkReading,WithMapping,WithColumnFormatting
{
    use Exportable;

    public $transactionData;

    public $fromdate;
    public $todate;
    public $merchant_id=1;
    public $status;
    public static $count=1;


    public function __construct($fromdate,$todate,$merchant_id,$status){
        $this->fromdate = $fromdate;
        $this->todate = $todate;
        $this->merchant_id = $merchant_id;
        $this->status = $status;
    }

    public function query()
    {
        $payment=new \App\PayoutTransaction();
        $paymentTable=$payment->getTable();


       
      
        return $payment->query()->select([$paymentTable.'.payout_transaction_date',   $paymentTable.'.status', $paymentTable.'.created_at',
                              $paymentTable.'.merchant_id',
                              $paymentTable.'.amount',
                              $paymentTable.'.payout_amount',
                              $paymentTable.'.payout_gst_value',
                              $paymentTable.'.payout_gst_charged_per',
                              $paymentTable.'.payout_gst_charged_amount',
                              $paymentTable.'.payout_tdr_charged_per',
                              $paymentTable.'.payout_tdr_charged_amount',
                              $paymentTable.'.payout_total_charged_amount',
                              $paymentTable.'.payout_total_debited',
                              $paymentTable.'.reference_id',
                              $paymentTable.'.system_reference_number',
                              
                              $paymentTable.'.utr',
                              $paymentTable.'.transfer_id','merchant.merchant_gid','ben_bank_acc','ben_ifsc','ben_name','reponse_error_message','transfer_mode','ben_upi',
                              'merchant_business.state','merchant_business.business_name','merchant.name as merchant_username' ])
                ->join('merchant', $paymentTable.'.merchant_id', 'merchant.id')
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.merchant_id')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".payout_transaction_date,'%Y-%m-%d %H:%i:%s') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".payout_transaction_date,'%Y-%m-%d %H:%i:%s') <='".$this->todate."'")
                ->where(function ($query) use($paymentTable) {
                     if($this->merchant_id){
                      $query->where($paymentTable.".merchant_id",$this->merchant_id);
                   }
                 
                if($this->status){
                    $query->where($paymentTable.".status",$this->status);
                }
                })->orderBy($paymentTable.".payout_transaction_date",'DESC')
              
               ;
    }

    public function headings(): array
    {
        return [
                                    "Sr no",
                                    "Payout Date & Time",
                                    "Merchant Id",
                                   "Merchant Name",
                                    "Transaction ID",
                                    "Merchant Ref Number",
                                     "Status",
                                      "Transfer Type",
                                    "Amount Transferred",
                                    "TDR Charged",
                                    "GST Charged",
                                    "Amount Debited",
								     "Bank Ref Number",
                                    "Virtual Payee Address",
                                    "Account Name",
                                    "Account Number",
                                    "IFSC Code",
                                                       
                                    "Error",
                ];
    }

     public function columnFormats(): array
    {
        return [
            
            'J' => NumberFormat::FORMAT_TEXT
        ];
    }

      public function chunkSize(): int
    {
        return 5000;
    }

    public function batchSize(): int
    {
        return 500;
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
       
 
    $payout_transaction_date=Carbon::parse($transaction->payout_transaction_date)->format('jS M Y h:i:s A');
        return [
            self::$count++,
            $payout_transaction_date,
            $transaction->merchant_gid,
            $transaction->merchant_username,
            $transaction->system_reference_number,
            $transaction->reference_id,
             ucwords($transaction->status),
              ucwords($transaction->transfer_mode),
          
            $transaction->payout_amount,
            $transaction->payout_tdr_charged_amount,
            $transaction->payout_gst_charged_amount,
            $transaction->payout_total_debited,
            
           
            ucwords($transaction->utr),
            ucwords($transaction->ben_upi),
            ucwords($transaction->ben_name),
            ucwords($transaction->ben_bank_acc),
            ucwords($transaction->ben_ifsc),
            ucwords($transaction->reponse_error_message)
            
           
        ];
    }



     public function fields(): array
    {
        return [
            'id',
            'description',
            'amount',
            'transaction_email',
            'created_date'
        ];
    }

    
}
