<?php

namespace App\Classes;

use App\CfRefund;
use App\KycVerifyResponse;
use App\kycEsignInites;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class KycProcessConfig
{

    public static $appKey;
    public static $appId;
    // public static $appKey = "V9XR6HV-Z264WDG-PEP4V7G-F2HX0TY";
    // public static $appKey1 = "GPPFRT5-J494XNN-NWBBDKX-BW5EYE0";
    //  public static $appId = "64c2485fe08487002812832e";
    // public static $appId = "66a7737dccfb850028fb5dbc";
    public static $apiVersion = "2023-07-01";

    public static $V1baseTestUrl = "https://test.zoop.one/api/v1/in/";
    public static $V1baseOkycUrl = "https://test.zoop.one/in/";
    public static $V1EsignUrl = "https://test.zoop.one/contract/esign/v4/aadhaar/init";
    public static $V1EsignStatusUrl = "https://test.zoop.one/contract/esign/v4/aadhaar/fetch";

    public static function initialize()
    {
        $config = DB::table('zoop_verification_api')->first();
        self::$appKey = $config->app_key;
        self::$appId = $config->api_id ;

        // self::$appKey = "GPPFRT5-J494XNN-NWBBDKX-BW5EYE0";
        // self::$appId = "64c2485fe08487002812832e";
    }
}


class KycProcessApi
{

    protected $clientid;
    protected $clientsecret;

    public function __construct()
    {
        $this->date_time = date("Y-m-d H:i:s");
        KycProcessConfig::initialize();
    }



    public  function demo()
    {
        echo KycProcessConfig::$V1baseTestUrl;
    }


    public function dokPost($url, $headers, $data)
    {
        $curl = curl_init($url);
        $data = json_encode($data);

        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $resp = curl_exec($curl);
        if ($resp === false) {
            throw new \Exception("Unable to post to kyc");
        }
        $info = curl_getinfo($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $responseJson = json_decode($resp, true);
        curl_close($curl);
        return array("code" => $httpCode, "data" => $responseJson);
    }

    public function dokGet($url, $headers)
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);
        if ($resp === false) {
            throw new \Exception("Unable to get to kyc");
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $responseJson = json_decode($resp, true);
        curl_close($curl);
        return array("code" => $httpCode, "data" => $responseJson);
    }

    private function taskId()
    {
        return Str::uuid()->toString();
    }


    public  function get_pan_lite($request_data = [], $merchant_id, $feildName)
    {

        $postData = [];
        $get_url = "identity/pan/lite";

        $headers = array(
            "content-type: application/json",
            "api-key:" . KycProcessConfig::$appKey,
            "app-id:" . KycProcessConfig::$appId,
        );
        $postData = array(
            "data" => $request_data,
            "task_id" => $this->taskId()
        );

        // Insert Data
        $task_id = $this->taskId();
        $KycVerify = new KycVerifyResponse();
        $KycVerify->task_id = $task_id;
        $KycVerify->request_sent = json_encode($postData);
        $KycVerify->created_merchant = $merchant_id;

        $KycVerify->checking_for_attribute = $feildName;
        $KycVerify->checking_for_attribute_value = $request_data['customer_pan_number'];
        $KycVerify->save();

        //
        $url = KycProcessConfig::$V1baseTestUrl . $get_url;

        $res = $this->dokPost($url, $headers, $postData);

        //update data
        $KycVerify = KycVerifyResponse::where(['task_id' => $task_id])
            ->orderby('id', 'desc')
            ->first();
        $data = $res['data'];
        if ($data) {

            $KycVerify->request_id = isset($data['request_id']) ? $data['request_id'] : '';
            $KycVerify->group_id = isset($data['group_id']) ? $data['group_id'] : '';
            $KycVerify->success = isset($data['success']) ? $data['success'] : '';
            $KycVerify->response_code = isset($data['response_code']) ? $data['response_code'] : '';
            $KycVerify->response_message = isset($data['response_message']) ? $data['response_message'] : '';
            $KycVerify->metadata = isset($data['metadata']) ? json_encode($data['metadata']) : '';
            $KycVerify->result = isset($data['result']) ? json_encode($data['result']) : '';
            $KycVerify->request_timestamp = isset($data['request_timestamp']) ? \Carbon\Carbon::parse($data['request_timestamp'])->format('Y-m-d H:i:s') : '';
            $KycVerify->response_timestamp = isset($data['response_timestamp']) ? \Carbon\Carbon::parse($data['response_timestamp'])->format('Y-m-d H:i:s') : '';
        }
        $KycVerify->response_received = json_encode($data);
        $KycVerify->save();

        return 1;
    }

    public  function get_gst_lite($request_data = [], $merchant_id, $feildName)
    {

        $postData = [];
        $get_url = "merchant/gstin/lite";

        $headers = array(
            "content-type: application/json",
            "api-key:" . KycProcessConfig::$appKey,
            "app-id:" . KycProcessConfig::$appId,
        );
        $postData = array(
            "mode" => "sync",
            "data" => $request_data,
            "task_id" => $this->taskId()
        );

        // Insert Data
        $task_id = $this->taskId();
        $KycVerify = new KycVerifyResponse();
        $KycVerify->task_id = $task_id;
        $KycVerify->request_sent = json_encode($postData);
        $KycVerify->created_merchant = $merchant_id;

        $KycVerify->checking_for_attribute = $feildName;
        $KycVerify->checking_for_attribute_value = $request_data['business_gstin_number'];
        $KycVerify->save();

        //
        $url = KycProcessConfig::$V1baseTestUrl . $get_url;

        $res = $this->dokPost($url, $headers, $postData);

        //update data
        $KycVerify = KycVerifyResponse::where(['task_id' => $task_id])
            ->orderby('id', 'desc')
            ->first();
        $data = $res['data'];
        if ($data) {

            $KycVerify->request_id = isset($data['request_id']) ? $data['request_id'] : '';
            $KycVerify->group_id = isset($data['group_id']) ? $data['group_id'] : '';
            $KycVerify->success = isset($data['success']) ? $data['success'] : '';
            $KycVerify->response_code = isset($data['response_code']) ? $data['response_code'] : '';
            $KycVerify->response_message = isset($data['response_message']) ? $data['response_message'] : '';
            $KycVerify->metadata = isset($data['metadata']) ? json_encode($data['metadata']) : '';
            $KycVerify->result = isset($data['result']) ? json_encode($data['result']) : '';
            if (isset($data['result'])) {
                if ($data['result']) {
                    $KycVerify->document_status = $data['result']['current_registration_status'];
                }
            }
            $KycVerify->request_timestamp = isset($data['request_timestamp']) ? \Carbon\Carbon::parse($data['request_timestamp'])->format('Y-m-d H:i:s') : '';
            $KycVerify->response_timestamp = isset($data['response_timestamp']) ? \Carbon\Carbon::parse($data['response_timestamp'])->format('Y-m-d H:i:s') : '';
        }
        $KycVerify->response_received = json_encode($data);
        $KycVerify->save();

        return 1;
    }

    public  function get_veify_kyc_lite($request_data = [], $merchant_id, $feildName, $feildNameValue, $url)
    {

        $postData = [];
        $get_url = $url;

        $headers = array(
            "content-type: application/json",
            "api-key:" . KycProcessConfig::$appKey,
            "app-id:" . KycProcessConfig::$appId,
        );
        $postData = array(
            "mode" => "sync",
            "data" => $request_data,
            "task_id" => $this->taskId()
        );

        // Insert Data
        $task_id = $this->taskId();
        $KycVerify = new KycVerifyResponse();
        $KycVerify->task_id = $task_id;
        $KycVerify->request_sent = json_encode($postData);
        $KycVerify->created_merchant = $merchant_id;

        $KycVerify->checking_for_attribute = $feildName;
        $KycVerify->checking_for_attribute_value = $feildNameValue;
        $KycVerify->save();

        //
        $url = KycProcessConfig::$V1baseTestUrl . $get_url;

        $res = $this->dokPost($url, $headers, $postData);

        //update data
        $KycVerify = KycVerifyResponse::where(['task_id' => $task_id])
            ->orderby('id', 'desc')
            ->first();
        $data = $res['data'];
        if ($data) {

            $KycVerify->request_id = isset($data['request_id']) ? $data['request_id'] : '';
            $KycVerify->group_id = isset($data['group_id']) ? $data['group_id'] : '';
            $KycVerify->success = isset($data['success']) ? $data['success'] : '';
            $KycVerify->response_code = isset($data['response_code']) ? $data['response_code'] : '';
            $KycVerify->response_message = isset($data['response_message']) ? $data['response_message'] : '';
            $KycVerify->metadata = isset($data['metadata']) ? json_encode($data['metadata']) : '';
            $KycVerify->result = isset($data['result']) ? json_encode($data['result']) : '';
            $KycVerify->request_timestamp = isset($data['request_timestamp']) ? \Carbon\Carbon::parse($data['request_timestamp'])->format('Y-m-d H:i:s') : '';
            $KycVerify->response_timestamp = isset($data['response_timestamp']) ? \Carbon\Carbon::parse($data['response_timestamp'])->format('Y-m-d H:i:s') : '';
        }
        $KycVerify->response_received = json_encode($data);
        $KycVerify->save();

        return 1;
    }


    public  function get_veify_kyc_lite_aadhar($request_data = [], $merchant_id, $feildName, $feildNameValue, $url)
    {

        $postData = [];
        $get_url = $url;

        $headers = array(
            "content-type: application/json",
            "api-key:" . KycProcessConfig::$appKey,
            "app-id:" . KycProcessConfig::$appId,
        );
        $postData = array(

            "data" => $request_data,
            "task_id" => $this->taskId()
        );

        // Insert Data
        $task_id = $this->taskId();
        $KycVerify = new KycVerifyResponse();
        $KycVerify->task_id = $task_id;
        $KycVerify->request_sent = json_encode($postData);
        $KycVerify->created_merchant = $merchant_id;

        $KycVerify->checking_for_attribute = $feildName;
        $KycVerify->checking_for_attribute_value = $feildNameValue;
        $KycVerify->save();

        //
        $url = KycProcessConfig::$V1baseOkycUrl . $get_url;

        $res = $this->dokPost($url, $headers, $postData);

        //update data
        $KycVerify = KycVerifyResponse::where(['task_id' => $task_id])
            ->orderby('id', 'desc')
            ->first();
        $data = $res['data'];
        if ($data) {

            $KycVerify->request_id = isset($data['request_id']) ? $data['request_id'] : '';
            $KycVerify->group_id = isset($data['group_id']) ? $data['group_id'] : '';
            $KycVerify->success = isset($data['success']) ? $data['success'] : '';
            $KycVerify->response_code = isset($data['response_code']) ? $data['response_code'] : '';
            $KycVerify->response_message = isset($data['response_message']) ? $data['response_message'] : '';
            $KycVerify->metadata = isset($data['metadata']) ? json_encode($data['metadata']) : '';
            $KycVerify->result = isset($data['result']) ? json_encode($data['result']) : '';
            $KycVerify->request_timestamp = isset($data['request_timestamp']) ? \Carbon\Carbon::parse($data['request_timestamp'])->format('Y-m-d H:i:s') : '';
            $KycVerify->response_timestamp = isset($data['response_timestamp']) ? \Carbon\Carbon::parse($data['response_timestamp'])->format('Y-m-d H:i:s') : '';
        }
        $KycVerify->response_received = json_encode($data);
        $KycVerify->save();

        return $data;
    }



    public  function initiate_esign_aadhar($request_data = [], $merchant_id)
    {

        $postData = [];

        $headers = array(
            "content-type: application/json",
            "api-key:" . KycProcessConfig::$appKey,
            "app-id:" . KycProcessConfig::$appId,
        );
        //dd($request_data);
        // $request_data['task_id'] = $this->taskId();
        $postData = $request_data;

        // Insert Data
        $task_id = $request_data['task_id'];
        $KycVerify = new kycEsignInites();
        $KycVerify->task_id = $task_id;
        $KycVerify->request_sent = json_encode($postData);
        $KycVerify->created_merchant = $merchant_id;
        $KycVerify->save();


        //
        $url = KycProcessConfig::$V1EsignUrl;

        $res = $this->dokPost($url, $headers, $postData);

        //update data
        $KycVerify = kycEsignInites::where(['task_id' => $task_id])
            ->orderby('id', 'desc')
            ->first();

        $data = $res['data'];

        if ($data) {

            $KycVerify->request_id = isset($data['request_id']) ? $data['request_id'] : '';

            $KycVerify->success = isset($data['success']) ? $data['success'] : '';
            $KycVerify->response_code = isset($data['response_code']) ? $data['response_code'] : '';
            $KycVerify->response_message = isset($data['response_message']) ? $data['response_message'] : '';
            $KycVerify->webhook_security_key = isset($data['webhook_security_key']) ? ($data['webhook_security_key']) : '';
            $KycVerify->expires_at = isset($data['expires_at']) ? \Carbon\Carbon::parse($data['expires_at'])->format('Y-m-d H:i:s') : '';
            $KycVerify->request_timestamp = isset($data['request_timestamp']) ? \Carbon\Carbon::parse($data['request_timestamp'])->format('Y-m-d H:i:s') : '';
            $KycVerify->response_timestamp = isset($data['response_timestamp']) ? \Carbon\Carbon::parse($data['response_timestamp'])->format('Y-m-d H:i:s') : '';
            $KycVerify->metadata = isset($data['metadata']) ? json_encode($data['metadata']) : '';
            if (isset($data['success'])) {
                if (($data['success'])) {
                    $merchant = \App\MerchantBusiness::where('created_merchant', $merchant_id)->first();
                    $merchant->agreement_esigned_task_id = $task_id;
                    $merchant->save();
                }
            }
        }
        $KycVerify->response_received = json_encode($data);
        $KycVerify->save();

        return $data;
    }

    public  function esign_aadhar_status($request_id = '')
    {

        $postData = [];

        $headers = array(
            "content-type: application/json",
            "api-key:" . KycProcessConfig::$appKey,
            "app-id:" . KycProcessConfig::$appId,
        );



        //
        $url = KycProcessConfig::$V1EsignStatusUrl;
        $url .= "?req_id=" . $request_id;

        $res = $this->dokGet($url, $headers);


        $data = $res['data'];

        if ($data) {
            $request_id = $data['id'];
            $KycEsignobj = new \App\kycEsignStatuses();
            $KycEsign = $KycEsignobj->where(['request_id' => $request_id])->first();
            if ($KycEsign) {



                $KycEsign->response_url = isset($data['response_url']) ? $data['response_url'] : '';
                $KycEsign->env = isset($data['env']) ? $data['env'] : '';
                $KycEsign->signer_name = isset($data['signer_name']) ? $data['signer_name'] : '';
                $KycEsign->signer_email = isset($data['signer_email']) ? $data['signer_email'] : '';
                $KycEsign->signer_city = isset($data['signer_city']) ? ($data['signer_city']) : '';
                $KycEsign->purpose = isset($data['purpose']) ? ($data['purpose']) : '';
                $KycEsign->response_recived = isset($data) ? json_encode($data) : '';
                $KycEsign->transaction_status = isset($data['transaction_status']) ? ($data['transaction_status']) : '';
                if (isset($data['transaction_status'])) {
                    $KycEsign->success = ($data['transaction_status']) == 'SUCCESS' ? 1 : 0;
                }

                if (isset($data['document'])) {
                    $KycEsign->document = json_encode($data['document']);
                }
                if (isset($data['signer_aadhaar_details'])) {
                    $KycEsign->signer_aadhaar_details = json_encode($data['signer_aadhaar_details']);
                }

                $KycEsign->request_timestamp = isset($data['request_timestamp']) ? \Carbon\Carbon::parse($data['request_timestamp'])->format('Y-m-d H:i:s') : '';
                $KycEsign->response_timestamp = isset($data['response_timestamp']) ? \Carbon\Carbon::parse($data['response_timestamp'])->format('Y-m-d H:i:s') : '';;

                $KycEsign->save();
            }
        }
    }
}
