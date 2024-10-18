<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Recon;
use App\Models\ReconAcquirer;
use App\Models\ReconFiles;
use App\Models\ReconMatchedTransactions;
use App\Models\Accountant;
use App\Models\MerchantAccountants;
use App\Exports\ReconExport;
use App\Exports\ReconExportCsv;
use Illuminate\Support\Facades\Log;
use App\Payment;
use Exception;

class ImportReconJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $fileDetails;

    /**
     * Create a new job instance.
     *
     * @param $request
     */
    public function __construct($request, $fileDetails)
    {
        $this->request = $request;
        $this->fileDetails = $fileDetails;
    }


    public function queue()
    {
        return 'recon';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::channel(null)->info('Your queue job is processing.');
        // ini_set('memory_limit', '-1');
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // set_time_limit(-1);
        try {


            dd('This will be printed to the console');

            // Set the chunk size
            $chunkSize = 100;

            $request = $this->request;

            $fileId = 1;

            // Set the skip and limit values
            $skip = 0; // Start point

            // Get the total number of records that match your criteria
            // $total = DB::table('recon_raw')->where('file_id', $fileId)->count();

            $total = 2000;

            $diffRows = [];

            // Use a while loop to process chunks within the skip and limit range
            while ($skip < $total) {
                $transactions =  DB::table('recon_raw')->where('file_id', $fileId)->skip($skip)->take($chunkSize)->get();

                $diffStatusRows = [];
                $diffAmountRows = [];
                $notFoundInDatabase = [];

                foreach ($transactions as $transaction) {
                    // Determine the corresponding database status
                    $expectedStatus = $transaction->Txn_Status == 'SUCCESS' ? 'success' : 'failed';

                    // Fetch the matching records from the live_payment table
                    $transactionGid = substr($transaction->REF_ID, strpos($transaction->REF_ID, '-') + 1);
                    $matchingPayment = Payment::where('transaction_gid', $transactionGid)->first();

                    if ($matchingPayment === null) {
                        $notFoundInDatabase[] = [
                            'recon' => $transaction,
                            'matching_payment' => $matchingPayment
                        ];
                    } else {
                        // Check if the transaction status does not match
                        if ($matchingPayment->transaction_status !== $expectedStatus) {

                            $diffStatusRows[] = [
                                'recon' => $transaction,
                                'matching_payment' => $matchingPayment
                            ];
                        } else if (intval($matchingPayment->transaction_amount) !== intval($transaction->Txn_Amt)) {

                            $diffAmountRows[] = [
                                'recon' => $transaction,
                                'matching_payment' => $matchingPayment
                            ];
                        }
                    }
                }

                //entering conflict in statuses 
                $modifiedTransactions = array_map(function ($diffStatusRows) use ($fileId) {
                    return [
                        'recon_file_id' => $fileId,
                        'merchant_id' => 1, // Assuming you have merchant_id
                        'merchant_name' => $diffStatusRows['recon']->Merchant_Name ?? null, // Assuming you have merchant_name
                        'bank_name' => 'Fino', // Assuming you have bank_name
                        'reason' => 'Conflict in Status', // Assuming you have reason
                        'txn_time' => $diffStatusRows['matching_payment']->transaction_date,
                        'acquirer_txn_time' => $diffStatusRows['recon']->txn_org_time,
                        'payer_name' => $diffStatusRows['recon']->Payer_Name,
                        'vpa' => $diffStatusRows['recon']->Payer_VPA,
                        'mobile_number' => $diffStatusRows['recon']->Payer_Mobile_number,
                        'amount' => $diffStatusRows['matching_payment']->transaction_amount,
                        'acquirer_amount' => $diffStatusRows['recon']->Txn_Amt ?? null, // Assuming you have acquirer_amount
                        'txn_id' => $diffStatusRows['matching_payment']->transaction_gid,
                        'acquirer_txn_id' => $diffStatusRows['recon']->Txn_Id ?? null, // Assuming you have acquirer_txn_id
                        'txn_status' => $diffStatusRows['matching_payment']->transaction_status,
                        'acquirer_txn_status' => $diffStatusRows['recon']->Txn_Status ?? null, // Assuming you have acquirer_txn_status
                        'rrn' => $diffStatusRows['matching_payment']->bank_ref_no,
                        'acquirer_rrn' => $diffStatusRows['recon']->RRN ?? null, // Assuming you have acquirer_rrn
                        'ref_id' => $diffStatusRows['recon']->REF_ID,
                        'payee_resp_code' => $diffStatusRows['recon']->payee_resp_code
                    ];
                }, $diffStatusRows);

                $modifiedDiffAmountRows = array_map(function ($diffAmountRows) use ($fileId) {
                    return [
                        'recon_file_id' => $fileId,
                        'merchant_id' => 1, // Assuming you have merchant_id
                        'merchant_name' => $diffAmountRows['recon']->Merchant_Name ?? null, // Assuming you have merchant_name
                        'bank_name' => 'Fino', // Assuming you have bank_name
                        'reason' => 'Conflict in Amount', // Assuming you have reason
                        'txn_time' => $diffAmountRows['matching_payment']->transaction_date,
                        'acquirer_txn_time' => $diffAmountRows['recon']->txn_org_time,
                        'payer_name' => $diffAmountRows['recon']->Payer_Name,
                        'vpa' => $diffAmountRows['recon']->Payer_VPA,
                        'mobile_number' => $diffAmountRows['recon']->Payer_Mobile_number,
                        'amount' => $diffAmountRows['matching_payment']->transaction_amount,
                        'acquirer_amount' => $diffAmountRows['recon']->Txn_Amt ?? null, // Assuming you have acquirer_amount
                        'txn_id' => $diffAmountRows['matching_payment']->transaction_gid,
                        'acquirer_txn_id' => $diffAmountRows['recon']->Txn_Id ?? null, // Assuming you have acquirer_txn_id
                        'txn_status' => $diffAmountRows['matching_payment']->transaction_status,
                        'acquirer_txn_status' => $diffAmountRows['recon']->Txn_Status ?? null, // Assuming you have acquirer_txn_status
                        'rrn' => $diffAmountRows['matching_payment']->bank_ref_no,
                        'acquirer_rrn' => $diffAmountRows['recon']->RRN ?? null, // Assuming you have acquirer_rrn
                        'ref_id' => $diffAmountRows['recon']->REF_ID,
                        'payee_resp_code' => $diffAmountRows['recon']->payee_resp_code
                    ];
                }, $diffAmountRows);

                $modifiedNotFoundInDatabase = array_map(function ($notFoundInDatabase) use ($fileId) {
                    return [
                        'recon_file_id' => $fileId,
                        'merchant_id' => 1, // Assuming you have merchant_id
                        'merchant_name' => $notFoundInDatabase['recon']->Merchant_Name ?? null, // Assuming you have merchant_name
                        'bank_name' => 'Fino', // Assuming you have bank_name
                        'reason' => 'Not Found In Transactions', // Assuming you have reason
                        'txn_time' => '',
                        'acquirer_txn_time' => $notFoundInDatabase['recon']->txn_org_time,
                        'payer_name' => $notFoundInDatabase['recon']->Payer_Name,
                        'vpa' => $notFoundInDatabase['recon']->Payer_VPA,
                        'mobile_number' => $notFoundInDatabase['recon']->Payer_Mobile_number,
                        'amount' => '',
                        'acquirer_amount' => $notFoundInDatabase['recon']->Txn_Amt ?? null, // Assuming you have acquirer_amount
                        'txn_id' => '',
                        'acquirer_txn_id' => $notFoundInDatabase['recon']->Txn_Id ?? null, // Assuming you have acquirer_txn_id
                        'txn_status' => '',
                        'acquirer_txn_status' => $notFoundInDatabase['recon']->Txn_Status ?? null, // Assuming you have acquirer_txn_status
                        'rrn' => '',
                        'acquirer_rrn' => $notFoundInDatabase['recon']->RRN ?? null, // Assuming you have acquirer_rrn
                        'ref_id' => $notFoundInDatabase['recon']->REF_ID,
                        'payee_resp_code' => $notFoundInDatabase['recon']->payee_resp_code
                    ];
                }, $notFoundInDatabase);


                $diffRows = array_merge($modifiedTransactions, $modifiedDiffAmountRows, $modifiedNotFoundInDatabase);



                Recon::insert($diffRows);

                // $updateFileDetails = ReconFiles::where('id', $fileId)->update([
                //     'conflict' =>  count($diffRows),
                // ]);

                $skip += $chunkSize;
            }






            // $dispute = count($modifiedDiffAmountRows) + count($modifiedTransactions);
            // $notFoundDB = count($modifiedNotFoundInDatabase);
            // $notFoundFile = count($modifiedNotFoundInFile);
            $totalRecords = DB::table('recon_raw')->where('file_id', $fileId)->count();


            // $insertFileDetails = ReconFiles::where('id', $fileId)->update([
            //     'conflict' =>  $dispute,
            //     'not_found' => $notFoundDB,
            //     'missing_from_file' => $notFoundFile,
            //     'total_record' =>  $totalRecords,
            //     'status' => 'completed',
            //     'created_At' => Carbon::now()
            // ]);


            $delete = DB::table('recon_raw')->where('file_id', $fileId)->delete();
        } catch (Exception $e) {
            // Log or handle the exception
            throw $e;
        }
    }
}
