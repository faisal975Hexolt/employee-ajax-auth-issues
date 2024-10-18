<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MerchantTransactionExport implements FromCollection , WithHeadings
{


    public $transactionData;


    public function __construct($transactiondata){
        $this->transactionData = $transactiondata;
    }

    public function headings(): array
    {
        return ["Transaction ID",
        "Order ID", 
        "Mode",
        "Name",
        "Email",
        "Contact",
        "Amount",
        "Status",
        "Payment Mode",
        "Initiation Time",
        "Transaction Time"
    ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->transactionData);
    }

    
}
