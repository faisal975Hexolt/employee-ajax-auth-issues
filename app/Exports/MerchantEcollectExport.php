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


class MerchantEcollectExport implements FromQuery, WithHeadings,WithChunkReading,WithMapping,WithColumnFormatting
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
        $payment=new \App\PayoutEcollectTransaction();
        $paymentTable=$payment->getTable();


       
      
        return $payment->query()->select([$paymentTable.'.ecollect_transaction_date',   $paymentTable.'.transaction_status', $paymentTable.'.created_at',
                              $paymentTable.'.merchant_id',
                              $paymentTable.'.received_total_amount',
                              $paymentTable.'.received_amount',
                              $paymentTable.'.utr',
                              $paymentTable.'.transfer_id','merchant.merchant_gid','merchnat_ben_bank_acc','merchnat_ben_ifsc','merchnat_ben_name','reponse_error_message','transfer_mode',
                              'merchant_business.state','merchant_business.business_name','merchant.name as merchant_username' ])
                ->join('merchant', $paymentTable.'.merchant_id', 'merchant.id')
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.merchant_id')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".ecollect_transaction_date,'%Y-%m-%d %H:%i:%s') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".ecollect_transaction_date,'%Y-%m-%d %H:%i:%s') <='".$this->todate."'")
                ->where(function ($query) use($paymentTable) {
                     if($this->merchant_id){
                      $query->where($paymentTable.".merchant_id",$this->merchant_id);
                   }
                 
                if($this->status){
                    $query->where($paymentTable.".transaction_status",$this->status);
                }
                })->orderBy($paymentTable.".ecollect_transaction_date",'DESC')
              
               ;
    }

    public function headings(): array
    {
        return [
            "Sr no",
            "Initiated At",
            "Merchant Id",
            "Merchant Name",
            "Transfer Unique Number",
            "Beneficiary Account Number",
            "Beneficiary IFSC Code",
            "Beneficiary Name",
            "Transfer Type",
            "Transfer Amount",
            "Transaction Status",
            "Error Message",
            "Received at",
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
       
    $ecollect_received_date=Carbon::parse($transaction->ecollect_received_date)->format('jS M Y h:i:s A');
    $ecollect_transaction_date=Carbon::parse($transaction->ecollect_transaction_date)->format('jS M Y h:i:s A');
        return [
            self::$count++,
            $ecollect_transaction_date,
            $transaction->merchant_gid,
            $transaction->merchant_username,
            $transaction->transfer_id,
          
            $transaction->merchnat_ben_bank_acc,
            $transaction->merchnat_ben_ifsc,
            $transaction->merchnat_ben_name,
            $transaction->transfer_mode,
            $transaction->received_total_amount,
            ucwords($transaction->transaction_status),
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
