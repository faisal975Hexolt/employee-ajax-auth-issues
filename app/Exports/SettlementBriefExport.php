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


class SettlementBriefExport implements FromQuery, WithHeadings,WithChunkReading,WithMapping,WithColumnFormatting
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
        $this->merchant_id =  is_array($merchant_id) ? $merchant_id : array($merchant_id);
        $this->status = $status;
    }

    public function query()
    {
        $payment=new \App\SettlementBrief();
        $paymentTable=$payment->getTable();
        return $payment->query()->select(['settlement_brief_gid',$paymentTable.'.created_merchant',
            'transaction_form','transaction_to','transaction_amount','transaction_gst_charged_amount','transaction_adjustment_charged_amount','transaction_total_charged_amount','transaction_total_adjustment','transaction_total_refunded','transaction_total_settlement','bank_utr','settlement_status',$paymentTable.'.created_at','merchant_business.state','merchant_business.business_name','merchant.name as merchant_username' ])
                ->join('merchant', $paymentTable.'.created_merchant', 'merchant.id')
               ->join('merchant_business', 'merchant_business.created_merchant', '=', $paymentTable.'.created_merchant')
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_at,'%Y-%m-%d') >='".$this->fromdate."'")
               ->whereRaw("DATE_FORMAT(".$paymentTable.".created_at,'%Y-%m-%d') <='".$this->todate."'")
                ->where(function ($query) use($paymentTable) {
                     if($this->merchant_id){
                      $query->whereIn($paymentTable.".created_merchant",$this->merchant_id);
                   }
                 
                if($this->status){
                    $query->where($paymentTable.".settlement_status",$this->status);
                }
                })->orderBy($paymentTable.".created_at",'DESC');
    }

    public function headings(): array
    {
        return [
            "Sr no",
                "Initiated At",
                "Merchant Id",
                "Merchant Name",
                "Settlement Id",
                "Period",
                "UTR No.",
                "Amount",
                "Net TDR",
                "Net Settlement",
                "Refunds",
                "Settling Amount",
                "Status"
                ];
    }

     public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            
            'L' => NumberFormat::FORMAT_TEXT,
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

    $from=Carbon::parse($transaction->transaction_form)->format('jS M Y h:i:s A');
    $to=Carbon::parse($transaction->transaction_to)->format('jS M Y h:i:s A');
        return [
            self::$count++,
            Carbon::parse($transaction->created_at)->format('d-M, Y h:i:s A'),
            $transaction->merchant->merchant_gid,
            $transaction->merchant->name,
            $transaction->settlement_brief_gid,
            $from." to ".$to,
            $transaction->bank_utr,
            $transaction->transaction_amount,
            $transaction->transaction_total_charged_amount,
            $transaction->transaction_total_adjustment,
            $transaction->transaction_total_refunded,
            $transaction->transaction_total_settlement,
            ucwords($transaction->settlement_status)
            
           
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
