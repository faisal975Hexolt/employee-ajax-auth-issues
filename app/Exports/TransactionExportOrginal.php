<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class TransactionExport implements FromCollection , WithHeadings,WithChunkReading,WithMapping
{


    public $transactionData;


    public function __construct($transactiondata){
        $this->transactionData = $transactiondata;
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
        return 500;
    }

    public function batchSize(): int
    {
        return 50;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->transactionData);
    }

    public function map($transaction): array
    {
        return [
            $transaction->merchant_gid,
            $transaction->name,
             $transaction->id,
            $transaction->transaction_gid,
            $transaction->orderId,
            $transaction->transaction_amount,
            $transaction->transaction_status,
            $transaction->transaction_date,
            $transaction->transaction_mode,
            $transaction->transaction_type,
            $transaction->transaction_gst,
            $transaction->percentage_charge,
            $transaction->percentage_amount,
            $transaction->gst_charge,
            $transaction->total_amt_charged,
            $transaction->adjustment_total
           
        ];
    }

    
}
