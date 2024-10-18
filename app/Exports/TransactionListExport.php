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


class TransactionListExport implements FromQuery, WithHeadings,WithChunkReading,WithMapping,WithColumnFormatting
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
        $payment=new \App\Payment;
        $paymentTable=$payment->getTable();


       
      
        return $payment->query()->select(['transaction_gid',$paymentTable.'.created_merchant',
            'order_id',$paymentTable.'.created_date','merchant_business.state','merchant_business.business_name','transaction_mode','transaction_username','transaction_email','transaction_contact','transaction_amount','transaction_status','udf1' ])
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.created_merchant')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d') <='".$this->todate."'")
                ->where(function ($query) use($paymentTable) {
                     if($this->merchant_id){
                      $query->where($paymentTable.".created_merchant",$this->merchant_id);
                   }
                 
                if($this->status){
                    $query->where($paymentTable.".transaction_status",$this->status);
                }
                })->orderBy($paymentTable.".created_date",'DESC')
              
               ;
    }

    public function headings(): array
    {
        return [
            "Sr no",
                "Transaction Initiation Time",
                "Merchant Id",
                "Merchant Name",
                "Transaction Gid",
                "Merchant Order Id",
                "Mode",
                "Username",
                "Email",
                "Contact",
                "Amount",
                "Status"];
    }

     public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
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
    
        return [
            self::$count++,
            Carbon::parse($transaction->created_date)->format('d-M, Y h:i:s A'),
            $transaction->merchant->merchant_gid,
             $transaction->merchant->name,
             $transaction->transaction_gid,
            $transaction->udf1,
            $transaction->transaction_mode,
            $transaction->transaction_username,
            $transaction->transaction_email,
            $transaction->transaction_contact,
            $transaction->transaction_amount,
            $transaction->transaction_status
            
           
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
