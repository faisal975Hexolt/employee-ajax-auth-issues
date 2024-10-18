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



class TransactionExport implements FromQuery, WithHeadings,WithChunkReading,WithMapping
{
    use Exportable;

    public $transactionData;

    public $fromdate;
    public $todate;


    public function __construct($fromdate,$todate){
        $this->fromdate = $fromdate;
        $this->todate = $todate;
    }

    public function query()
    {
        $payment=new \App\Payment;
        $paymentTable=$payment->getTable();
        //echo $paymentTable;die();
        return $payment->query()->select(['transaction_gid',$paymentTable.'.created_merchant',
            'order_id',$paymentTable.'.created_date','merchant_business.state'])
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.created_merchant')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d %H:%i:%s') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_date,'%Y-%m-%d %H:%i:%s') <='".$this->todate."'")
              
               ;
    }

    public function headings(): array
    {
        return ["Merchant GId", 
        "Merchant Name",  
        "Id",  
        "Transaction Id",
        "Transaction Order Id",
        "Transaction Amount",
        "Status",
        "Transaction Date",
        "Transaction Mode",
        "Transaction Type",
        "GST",
        "Percentage Charge",
        "Percntage Charged Amount",
        "GST Charged",
        "Adjustment Charged",
        "Total Adjustment Amount"];
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

        dd($transaction);
        return [
            $transaction->transaction_gid,
            $transaction->transaction_username,
             $transaction->transaction_amount,
            $transaction->name,
            $transaction->created_date,
           
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
