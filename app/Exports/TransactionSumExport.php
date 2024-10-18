<?php
namespace App\Exports;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Payment;


class TransactionSumExport 
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
                    'GTV',
                    'Charged',
                    'GST',
                    'Total Charged',
                    'Net Settlement'
                ];
    }

     public function export($results,$fromdate,$todate,$file_name)
    {

       
          $i = 0;
           $writer = SimpleExcelWriter::streamDownload($file_name);
        $writer->addHeader($this->headings());
        foreach ($results->lazy(100) as $transactionamount) 
        {
        
             $row['srno']=1;
             $row['merchant_name']=$transactionamount->name;
             $row['merchant_id']=$transactionamount->merchant_gid;
             $row['gtv']=number_format((float)$transactionamount->transaction_amount, 2, '.', '');
             $row['charged']=number_format((float)$transactionamount->adjustment_charged_amount, 2, '.', '');
             $row['gst']=number_format((float)$transactionamount->gst_charged_amount, 2, '.', '');
             $row['total_charge']=number_format((float)$transactionamount->total_charged_amount, 2, '.', '');
             $row['net']=number_format((float)$transactionamount->total_adjustment, 2, '.', '');
            
            
            $writer->addRow($row);

            if ($i % 100 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }

        return $writer->toBrowser();

        
    }




    
}
