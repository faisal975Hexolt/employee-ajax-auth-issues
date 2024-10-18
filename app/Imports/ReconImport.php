<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\Recon;
use App\Payment;
use Carbon\Carbon;
use App\Models\ReconFiles;
use App\Models\ReconMatchedTransactions;

class ReconImport implements ToCollection, WithChunkReading
{
    private $dispute = 0;
    private $notFound = 0;
    private $totalRecords = 0;
    protected $fileDetails;

    public function __construct($fileDetails)
    {
        $this->fileDetails = $fileDetails;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            try {
                if ($key > 0) {
                    if ($value[0] === null) {
                        continue;
                    }

                    $this->totalRecords++;
                    $find = Payment::where('transaction_gid', $value[9])
                        ->whereDate('transaction_date', $this->fileDetails->transaction_date)
                        ->first();

                    $dateStringWithoutOffset = substr($value[1], 0, 19);
                    $carbonDate = Carbon::createFromFormat('Y-m-d H:i:s', $dateStringWithoutOffset);
                    $sqlTimestamp = $carbonDate->toDateTimeString();

                    if ($find) {
                        ReconMatchedTransactions::insert([
                            'recon_file_id' => $this->fileDetails->id,
                            'transaction_gid' => $value[9],
                        ]);

                        if (strcasecmp($find->transaction_status, $value[7]) != 0) {
                            $this->dispute++;
                            Recon::insert($this->createReconData($value, $find, 'Conflict in Status', $sqlTimestamp));
                        } elseif (intval($find->transaction_amount) !== intval($value[5])) {
                            $this->dispute++;
                            Recon::insert($this->createReconData($value, $find, 'Conflict in Amount', $sqlTimestamp));
                        }
                    } else {
                        $this->notFound++;
                        Recon::insert([
                            'recon_file_id' => $this->fileDetails->id,
                            'merchant_id' => 1,
                            'merchant_name' => $value[0],
                            'bank_name' => 'fino bank',
                            'reason' => 'Not Found In Transactions',
                            'acquirer_txn_time' => $value[1],
                            'payer_name' => $value[2],
                            'vpa' => $value[3],
                            'mobile_number' => $value[4],
                            'acquirer_amount' => $value[5],
                            'acquirer_txn_id' => $value[6],
                            'acquirer_txn_status' => $value[7],
                            'acquirer_rrn' => $value[8],
                            'ref_id' => $value[9],
                        ]);
                    }
                }
            } catch (\Exception $e) {
                dd($value, $e);
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    private function createReconData($value, $find, $reason, $sqlTimestamp)
    {
        return [
            'recon_file_id' => $this->fileDetails->id,
            'merchant_id' => 1,
            'merchant_name' => $value[0],
            'bank_name' => 'fino bank',
            'reason' => $reason,
            'txn_time' => $find->transaction_date,
            'acquirer_txn_time' => $sqlTimestamp,
            'payer_name' => $value[2],
            'vpa' => $value[3],
            'mobile_number' => $value[4],
            'amount' => $find->transaction_amount,
            'acquirer_amount' => $value[5],
            'txn_id' => $find->transaction_gid,
            'acquirer_txn_id' => $value[6],
            'txn_status' => $find->transaction_status,
            'acquirer_txn_status' => $value[7],
            'rrn' => $find->bank_ref_no,
            'acquirer_rrn' => $value[8],
            'ref_id' => $value[9],
        ];
    }

    public function getDisputeCount()
    {
        return $this->dispute;
    }

    public function getNotFoundCount()
    {
        return $this->notFound;
    }

    public function getTotalRecordsCount()
    {
        return $this->totalRecords;
    }
}
