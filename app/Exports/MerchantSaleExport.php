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
use DB;


class MerchantSaleExport implements FromQuery, WithHeadings,WithChunkReading,WithMapping
{
    use Exportable;

    public $transactionData;

    public $fromdate;
    public $todate;
    public static $count=1;


    public function __construct($fromdate,$todate){
        $this->fromdate = $fromdate;
        $this->todate = $todate;
    }

    public function query()
    {
        $payment=new \App\Payment;
        $paymentTable=$payment->getTable();
      
        return $payment->query()->with(['merchant' => function ($q) {
                    $q->orderBy('name', 'asc');
                }])->select('transaction_gid',$paymentTable.'.created_merchant',
            'order_id',$paymentTable.'.created_date','merchant_business.state',DB::raw('COUNT(transaction_status) as no_of_transactions'),DB::raw('SUM(transaction_amount) as transaction_amount'),'merchant_business.business_name' )
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.created_merchant')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d %H:%i:%s') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d %H:%i:%s') <='".$this->todate."'")
               ->where($paymentTable.'.transaction_status',"success")
               ->groupBy('created_merchant')
              
               ;
    }

    public function headings(): array
    {
        return [
            "Sr no",
            "Merchant Gid", 
        "Business Name",  
        "Merchant Name",  
        "No Of Transaction",
        "Transaction Amount"];
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
            $transaction->merchant->merchant_gid,
            $transaction->business_name,
             $transaction->merchant->name,
            $transaction->no_of_transactions,
            $transaction->transaction_amount,
           
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
