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



class MerchantPayoutLedgerExport implements FromQuery, WithHeadings,WithChunkReading,WithMapping,WithColumnFormatting
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
        $payment=new \App\PayoutLedger();
         $paymentTable=$payment->getTable();
        $table=$paymentTable;


       
      
        return $payment->query()->select([$paymentTable.'.ledger_id',$paymentTable.'.created',
                              $paymentTable.'.merchant_id',
                              $paymentTable.'.payout_transaction_id',
                              $paymentTable.'.payout_ecollect_transaction_id',
                              $paymentTable.'.credit',
                              $paymentTable.'.debit',
                              $paymentTable.'.description',
                              $paymentTable.'.current_balance',
                              $paymentTable.'.modified',
                              $paymentTable.'.created_by',
                              $paymentTable.'.modified_by','merchant.merchant_gid',
                              'merchant_business.state','merchant_business.business_name','merchant.name as merchant_username' ])
                ->join('merchant', $paymentTable.'.merchant_id', 'merchant.id')
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.merchant_id')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created,'%Y-%m-%d %H:%i:%s') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created,'%Y-%m-%d %H:%i:%s') <='".$this->todate."'")
                ->where(function ($query) use($paymentTable) {
                     if($this->merchant_id){
                      $query->where($paymentTable.".merchant_id",$this->merchant_id);
                   }
                 
                if($this->status){
                    $query->where($paymentTable.".status",$this->status);
                }
                })->with('Fundtransfer','Ecollect')->orderBy($paymentTable.".created",'DESC')
              
               ;
    }

    public function headings(): array
    {
        return [
           "Sr no",
           "Transaction Date Time",
           "Merchant Id",
            "Merchant Name",
           "Ledger Id",
           "Debit",
           "Credit",
            "TDR Charged",
            "GST Charged",
            "Transfer Type",
            "Description",
            "Balance",
            "Reference Number",
            "Merchant Reference Number",
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
       
 
    $created=Carbon::parse($transaction->created)->format('jS M Y h:i:s A');

                             $t_tdr=0;
                                   if($transaction->Fundtransfer){
                                        $t_tdr=$transaction->Fundtransfer->payout_tdr_charged_amount;
                                   }elseif($transaction->Ecollect){
                                        $t_tdr=$transaction->Ecollect->received_adjustment_charged_amount;
                                   }
                                      $t_tdr= $t_tdr>0?$t_tdr:'';

                         $t_gst=0;
                                   if($transaction->Fundtransfer){
                                        $t_gst=$transaction->Fundtransfer->payout_gst_charged_amount;
                                   }elseif($transaction->Ecollect){
                                        $t_gst=$transaction->Ecollect->received_gst_charged_amount;
                                   }

                                      $t_gst= $t_gst>0?$t_gst:'';

                        $transfer_mode='';
                                   if($transaction->Fundtransfer){
                                        $transfer_mode=$transaction->Fundtransfer->transfer_mode;
                                   }elseif($transaction->Ecollect){
                                        $transfer_mode=$transaction->Ecollect->transfer_mode;
                                   }

                                    

                         $refreance_no='';
                                   if($transaction->Fundtransfer){
                                        $refreance_no=$transaction->Fundtransfer->system_reference_number;
                                   }elseif($transaction->Ecollect){
                                        $refreance_no=$transaction->Ecollect->system_reference_number;
                                   }

                                    
                         $merchant_refreance_no='';
                                   if($transaction->Fundtransfer){
                                        $merchant_refreance_no=$transaction->Fundtransfer->reference_id;
                                   }elseif($transaction->Ecollect){
                                        $merchant_refreance_no=$transaction->Ecollect->reference_id;
                                   }

                                   
        return [
            self::$count++,
            $created,
            $transaction->merchant_gid,
            $transaction->merchant_username,
            $transaction->ledger_id,
            $transaction->debit,
            $transaction->credit,
            $t_tdr,
            $t_gst,
            ucwords($transfer_mode),
            ucwords($transaction->description),
            ucwords($transaction->current_balance),
            ucwords($refreance_no),
            ucwords($merchant_refreance_no)
            
           
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
