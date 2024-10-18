<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Payment;
use App\Order;
use Carbon\Carbon;
use App\Payout;
use App\Merchant;
use App\MerchantBusiness;
use App\SettlementBrief;
use App\KycEsignResponse;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Classes\SpayApi;
use File;
use App\Utility\BusinessSettingUtility;
use Illuminate\Support\Facades\Storage;
use App\Classes\KycProcessApi;

class CronApiController extends Controller
{

    protected $date_time;
    protected $gst_on_chargers = "18";

    public function __construct()

    {
        $this->date_time = date("Y-m-d H:i:s");
        $this->gst_on_chargers = "18";
    }

    public function transactionSettelment(Request $request)
    {

        $payment = new \App\Payment('live');


        $transactions = $payment->where(
            [
                'transaction_status' => 'success',
                // 'transaction_gst_charged_per'=>0,
                'transaction_gst_charged_amount' => 0,
                'transaction_adjustment_charged_per' => 0,
                'transaction_adjustment_charged_amount' => 0
            ]
        )->get();


        $this->process_transaction($transactions);

        //return true;

    }


    protected function process_transaction($transactions)
    {

        $adjustment_chargeObject = new \App\MerchantChargeDetail();
        $merchantvendor_bank = new \App\MerchantVendorBank();
        $Setup = new \App\Classes\TransactionSetup();
        $merchantBusiness = new MerchantBusiness();
        $payment = new \App\Payment('live');

        foreach ($transactions as $index => $object) {

            $merchant_id = $object->merchant_id;
            $businessGst = MerchantBusiness::merchantbusinessGst($merchant_id);

            $this->gst_on_chargers = $businessGst;

            $merchant_exist = $merchantvendor_bank->check_merchantbank_link_exists($object->created_merchant);

            if ($merchant_exist[0]->merchant_bank) {
                $object->transaction_mode = strtoupper($object->transaction_mode);

                switch ($object->transaction_mode) {
                    case 'CC':

                        $object->percentage_charge = $Setup->setup_get_card_charges($object->transaction_mode, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $Setup->setup_num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $Setup->setup_num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $Setup->setup_num_format($object->transaction_amount - $object->total_amt_charged);

                        break;

                    case 'DC':

                        $object->percentage_charge = $Setup->setup_get_card_charges($object->transaction_mode, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $Setup->setup_num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $Setup->setup_num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $Setup->setup_num_format($object->transaction_amount - $object->total_amt_charged);

                        break;

                    case 'NB':

                        $object->percentage_charge = $Setup->setup_get_netbanking_charges($object->transaction_mode, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $Setup->setup_num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $Setup->setup_num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $Setup->setup_num_format($object->transaction_amount - $object->total_amt_charged);
                        break;

                    case 'UPI':

                        $object->percentage_charge = $Setup->setup_get_other_charges($object->transaction_mode, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $Setup->setup_num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $Setup->setup_num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $Setup->setup_num_format($object->transaction_amount - $object->total_amt_charged);
                        break;


                    case 'MW':

                        $object->percentage_charge = $Setup->setup_get_other_charges($object->transaction_mode, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $Setup->setup_num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $Setup->setup_num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $Setup->setup_num_format($object->transaction_amount - $object->total_amt_charged);
                        break;
                    case 'WALLET':

                        $object->percentage_charge = $Setup->setup_get_other_charges($object->transaction_mode, $object->created_merchant, $adjustment_chargeObject);
                        $object->percentage_amount = $Setup->setup_num_format($object->percentage_charge / 100 * $object->transaction_amount);
                        $object->gst_charge = $Setup->setup_num_format($this->gst_on_chargers / 100 * $object->percentage_amount);
                        $object->total_amt_charged = $object->percentage_amount + $object->gst_charge;
                        $object->adjustment_total = $Setup->setup_num_format($object->transaction_amount - $object->total_amt_charged);
                        break;

                    default:
                        $object->percentage_charge = "";
                        $object->percentage_amount = "";
                        $object->gst_charge = "";
                        $object->total_amt_charged = "";
                        $object->adjustment_total = "";
                        break;
                }
            } else {


                $object->percentage_charge = "";
                $object->percentage_amount = "";
                $object->gst_charge = "";
                $object->total_amt_charged = "";
                $object->adjustment_total = "";
            }

            $business = $merchantBusiness->select(
                \DB::raw('(CASE 
							WHEN state = "36" THEN "IGST&SGST(%9+%9)" 
							ELSE "GST(%18)" 
						END) AS transaction_gst')
            )
                ->where(['created_merchant' => $object->created_merchant])
                ->first();

            $object->transaction_gst_value = $business->transaction_gst;


            $where["created_merchant"] = $object->created_merchant;
            $where["id"] = $object->id;
            $updatedata = array(
                'transaction_gst_value' => $object->transaction_gst_value,
                'transaction_gst_charged_per' => $this->gst_on_chargers,
                'transaction_gst_charged_amount' => $object->gst_charge,
                'transaction_adjustment_charged_per' => $object->percentage_charge,
                'transaction_adjustment_charged_amount' => $object->percentage_amount,
                'transaction_total_charged_amount' => $object->total_amt_charged,
                'transaction_total_adjustment' => $object->adjustment_total,
            );
            $payment->where($where)->update($updatedata);
        }
        return $transactions;
    }


    public function createSettlementCron(Request $request)
    {


        $crons_settings = \App\SettlementCronSetting::where('status', 'active')->get()->toArray();

        $currentTime = Carbon::now();

        $todatDate = $currentTime->format('Y-m-d');

        $pastDate = $currentTime->sub(1, 'day')->format('Y-m-d');


        foreach ($crons_settings as $key => $crons_setting) {

            $crons_settings[$key]['cron_time'] = date('Y-m-d H:i:s', strtotime($todatDate . $crons_setting['cron_time']));

            if ($crons_setting['transaction_form_day'] == 'yesterday') {
                $crons_settings[$key]['transaction_form'] = date('Y-m-d H:i:s', strtotime($pastDate . $crons_setting['transaction_form']));
            }

            if ($crons_setting['transaction_form_day'] == 'today') {
                $crons_settings[$key]['transaction_form'] = date('Y-m-d H:i:s', strtotime($todatDate . $crons_setting['transaction_form']));
            }


            if ($crons_setting['transaction_to_day'] == 'yesterday') {
                $crons_settings[$key]['transaction_to'] = date('Y-m-d H:i:s', strtotime($pastDate . $crons_setting['transaction_to']));
            }

            if ($crons_setting['transaction_to_day'] == 'today') {
                $crons_settings[$key]['transaction_to'] = date('Y-m-d H:i:s', strtotime($todatDate . $crons_setting['transaction_to']));
            }

            unset($crons_settings[$key]['transaction_to_day']);
            unset($crons_settings[$key]['transaction_form_day']);
        }


        $jsongFile = "settlement_cron_settings.json";
        File::put(storage_path("app/settlement/") . $jsongFile, json_encode($crons_settings));
        return true;
    }

    public function readSettlementSetting(Request $request)
    {

        $currentTime = Carbon::now();

        $presentDate = $currentTime->format('Y-m-d');;

        $jsongFile = "settlement_cron_settings.json";

        $file_name = storage_path("app/settlement/") . $jsongFile;
        if (file_exists($file_name)) {

            if (date("Y-m-d", filemtime($file_name)) === $presentDate) {
                // echo "modified: " . date ("Y-m-d H:i:s.", filemtime($file_name));die();
                $crons_settings = json_decode(file_get_contents($file_name), true);
                return $crons_settings;
            }
        }
        $this->createSettlementCron($request);
        $crons_settings = json_decode(file_get_contents($file_name), true);
        return $crons_settings;
    }


    public function paymentSettlementBrief(Request $request)
    {

        $currentTime = Carbon::now();
        $currentTime1 = Carbon::now();
        $sub = 30;
        $add = 30;
        $futureTime = $currentTime->addMinutes($add);

        $pasttime = $currentTime1->subMinutes($sub);

        $crons_settings = $this->readSettlementSetting($request);

        foreach ($crons_settings as $setting) {

            $setting['cron_time'];
            if ($pasttime <= $setting['cron_time'] and $futureTime >= $setting['cron_time']) {

                $payment = new \App\Payment('live');
                $paymentTable = $payment->getTable();
                list($table, $prifix) = explode('_', $paymentTable);

                $refund = new \App\Refund('live');
                $refundTable = $payment->getTable();
                list($refundtable, $refundprifix) = explode('_', $refundTable);
                $queryMt = $payment
                    ->select(['created_merchant'])
                    ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') >='" . $setting['transaction_form'] . "'")
                    ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') <='" . $setting['transaction_to'] . "'");
                $queryMt = $queryMt->where(['transaction_status' => 'success', 'is_settlement_done' => 'N'])
                    ->groupBy('created_merchant');

                $merchantTransactions = $queryMt->get();


                foreach ($merchantTransactions as $merchantTransaction) {

                    $selectArray = array(
                        'created_merchant',
                        DB::raw('SUM(transaction_amount) AS transaction_amount'),
                        DB::raw('SUM(transaction_gst_charged_amount) AS transaction_gst_charged_amount'),
                        DB::raw('SUM(transaction_adjustment_charged_amount) AS transaction_adjustment_charged_amount'),
                        DB::raw('SUM(transaction_total_charged_amount) AS transaction_total_charged_amount'),
                        DB::raw('SUM(transaction_total_adjustment) AS transaction_total_adjustment')

                    );
                    $queryt = $payment
                        ->select($selectArray)
                        ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') >='" . $setting['transaction_form'] . "'")
                        ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') <='" . $setting['transaction_to'] . "'");
                    $queryt = $queryt->where(['transaction_status' => 'success', 'is_settlement_done' => 'N', 'created_merchant' => $merchantTransaction['created_merchant']]);

                    $transaction = $queryt->first();


                    $selectRefundArray = array(
                        'created_merchant',
                        DB::raw('SUM(refund_amount) AS total_refund_amount'),
                        DB::raw('SUM(refund_amount_charges) AS total_refund_amount_charges')
                    );
                    $refundqueryt = $refund
                        ->select($selectRefundArray);
                    $refundqueryt = $refundqueryt
                        ->where([
                            'refund_status' => 'processing',
                            'created_merchant' => $merchantTransaction['created_merchant']
                        ])
                        ->whereNull('settlement_brief_gid');

                    $Refund = $refundqueryt->first();

                    if ($Refund) {
                        $total_refund_amount = $Refund->total_refund_amount;
                        $total_refund_amount_charges = $Refund->total_refund_amount_charges;
                        $transaction_total_refunded = $total_refund_amount + $total_refund_amount_charges;
                    } else {

                        $transaction_total_refunded = 0;
                    }

                    $settlementBrief = array();


                    $settlementBrief = new SettlementBrief('live');
                    $settlementBrief['created_merchant'] = $transaction->created_merchant;
                    $settlementBrief['transaction_amount'] = $transaction->transaction_amount;
                    $settlementBrief['transaction_gst_charged_amount'] = $transaction->transaction_gst_charged_amount;
                    $settlementBrief['transaction_adjustment_charged_amount'] = $transaction->transaction_adjustment_charged_amount;
                    $settlementBrief['transaction_total_charged_amount'] = $transaction->transaction_total_charged_amount;
                    $settlementBrief['transaction_total_adjustment'] = $transaction->transaction_total_adjustment;
                    $settlement_brief_gid = BusinessSettingUtility::generateIds('settlement_summary');
                    $settlementBrief['settlement_brief_gid'] = $settlement_brief_gid;
                    $settlementBrief['transaction_form'] = $setting['transaction_form'];
                    $settlementBrief['transaction_total_refunded'] = $transaction_total_refunded;

                    $settlementBrief['transaction_to'] = $setting['transaction_to'];

                    $transaction_total_settlement = $transaction->transaction_total_adjustment - $transaction_total_refunded;
                    $settlementBrief['transaction_total_settlement'] = $transaction_total_settlement;

                    $settlementBrief->save();


                    $payment = new \App\Payment('live');
                    $paymentTable = $payment->getTable();

                    $paymentUpdate = $payment
                        ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') >='" . $setting['transaction_form'] . "'")
                        ->whereRaw("DATE_FORMAT(" . $paymentTable . ".created_date,'%Y-%m-%d %H:%i:%s') <='" . $setting['transaction_to'] . "'")
                        ->where(['transaction_status' => 'success', 'is_settlement_done' => 'N', 'created_merchant' => $merchantTransaction['created_merchant']])
                        ->update(['is_settlement_done' => 'Y', 'settlement_brief_gid' => $settlement_brief_gid]);
                    if ($Refund) {
                        $refundUpdate = $refund
                            ->where(['refund_status' => 'processed'])
                            ->where(['created_merchant' => $merchantTransaction['created_merchant']])
                            ->whereNull('settlement_brief_gid')
                            ->update(['settlement_brief_gid' => $settlement_brief_gid]);
                    }
                }
            }
        }


        return response()->json(['status' => 'Success', 'message' => 'Settlement Created'], 200);
    }

    public function storeEsignwebhook(Request $request)
    {

        $data = ($request->all());
        $name_match_score = 0;
        $KycEsignobj = new KycEsignResponse();
        $KycEsign = $KycEsignobj->where(['request_id' => $data['request_id']])->first();
        if ($KycEsign) {



            $KycEsign->checking_for = "response_url";

            $KycEsign->success = isset($data['success']) ? $data['success'] : '';
            $KycEsign->response_code = isset($data['response_code']) ? $data['response_code'] : '';
            $KycEsign->response_message = isset($data['response_message']) ? $data['response_message'] : '';
            $KycEsign->white_label = isset($data['white_label']) ? $data['white_label'] : '';
            $KycEsign->metadata = isset($data['metadata']) ? json_encode($data['metadata']) : '';
            $KycEsign->response_recived = isset($data) ? json_encode($data) : '';
            if (isset($data['result'])) {
                if (isset($data['result']['document'])) {
                    $KycEsign->result_document = json_encode($data['result']['document']);
                }
                if (isset($data['result']['signer'])) {

                    $signerDetails = $data['result']['signer'];
                    if (isset($signerDetails['name_match_score'])) {
                        $name_match_score = $signerDetails['name_match_score'];
                    }
                    $KycEsign->result_signer = json_encode($data['result']['signer']);
                }
                if (isset($data['result']['auth_mode'])) {
                    $KycEsign->result_auth_mode = ($data['result']['auth_mode']);
                }
            }

            $KycEsign->link = isset($data['link']) ? $data['link'] : '';
            $KycEsign->request_timestamp = isset($data['request_timestamp']) ? \Carbon\Carbon::parse($data['request_timestamp'])->format('Y-m-d H:i:s') : '';
            $KycEsign->response_timestamp = isset($data['response_timestamp']) ? \Carbon\Carbon::parse($data['response_timestamp'])->format('Y-m-d H:i:s') : '';;

            $KycEsign->save();
            $created_merchant = $KycEsign->created_merchant;

            $merchantBusiness = new \App\MerchantBusiness();
            $merchantBusiness = $merchantBusiness->where(
                ['created_merchant' => $created_merchant]
            )->first();


            $merchantObject = new User();


            if ($name_match_score >= 0.9) {
                $update_details = ["onboarding_status" => ESIGN_DONE_ONBOARDING, 'account_status' => IN_PROCESS_ACCOUNT];
                $merchantObject->update_docverified_status(["id" => $created_merchant], $update_details);

                $merchantBusiness->agreement_esigned = 1;
            } else {
                $update_details = ["onboarding_status" => ESIGN_REJECTED_ONBOARDING, 'account_status' => IN_PROCESS_ACCOUNT];
                $merchantObject->update_docverified_status(["id" => $created_merchant], $update_details);

                $merchantBusiness->agreement_esigned = 0;
            }

            $signed_url = '';
           if (isset($data['result']['document'])) {
                if (isset($data['result']['document']['signed_url'])) {
                    $signed_url = $data['result']['document']['signed_url'];
                    $merchant_gid = $merchantObject->get_merchant_info($created_merchant, 'merchant_gid');
                    $file_name=$merchant_gid."_signedagreementfile.pdf";
                    $path = $signed_url;
                    $path_to_upload = "/public/onboarding/agreement/" . $merchant_gid . "/".$file_name;
                    Storage::put($path_to_upload, file_get_contents($path));

                    $merchantBusiness->agreement_esigned_file = $file_name;
                }
            }
            $merchantBusiness->agreement_esigned_at = $this->date_time;
            $merchantBusiness->agreement_signed_url = $signed_url;
            $merchantBusiness->agreement_esigned_task_id = $KycEsign->task_id;

            $merchantBusiness->save();

            $api = new KycProcessApi();
            $request_id = $data['request_id'];
            $response = $api->esign_aadhar_status($request_id);

            return response()->json(['status' => 'Success', 'message' => 'Webook data update'], 200);
        } else {
            return response()->json(['status' => 'Fail', 'message' => 'Something went wrong'], 200);
        }
    }
}