<?php
namespace App\Exports;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Payment;


class TransactionCountExport 
{
   

    public $transactionData;

    public $fromdate;
    public $todate;
     public static $count=1;

    public function __construct(){
        
    }

  
    public function headings(): array
    {
           return [
                    'Sno',
                    'Merchant Name',
                    'Merchant Id',
                    'Total No Of Transactions',
                    'No Of Authorized Transaction',
                    'No Of Successful Transaction',
                    'No Of Failed Transaction',
                    'Success Ratio'
                ];
    }

     public function export($results,$fromdate,$todate,$file_name)
    {

       
          $i = 0;
           $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->headings());
        foreach ($results->lazy(100) as $transaction) 
        {
            $number=($transaction->no_of_success/$transaction->no_of_transaction)*100;
             $row['srno']=1;
             $row['merchant_name']=$transaction->name;
             $row['merchant_id']=$transaction->merchant_gid;
             $row['total']=$transaction->no_of_transaction;
             $row['authorized']=$transaction->no_of_authorized;
             $row['success']=$transaction->no_of_success;
             $row['failed']=$transaction->no_of_failed;
             $row['ratio']=number_format((float)$number, 2, '.', '');
            
            
            $writer->addRow($row);

            if ($i % 100 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }

        return $writer->toBrowser();

        
    }




    
}
