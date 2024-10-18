<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Custom;
use App\CustomerCase;
use App\CaseComment;
use App\MerchantBusiness;
use App\Http\Controllers\NotiMessController;
use Image;
use File;
use App\Classes\KycProcessApi;
use App\KycEsignResponse;
use App\User;

class KycDetailsController extends Controller
{
    public $date_time;
    public $spt_type = [];

    public function __construct()
    {

        $this->date_time = date("Y-m-d H:i:s");
    }

    public function index()
    {

        $api = new KycProcessApi();
        $request_data = array(
            "customer_pan_number" => 'ABICS9275R',
            "consent" => "Y",
            "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
        );
        $api->get_pan_lite($request_data);
        dd();
    }

    public function business_ifsc_check($info, $merchant_id)
    {

        if (isset($info['bank_ifsc_code'])) {

            $api = new KycProcessApi();
            $request_data = array(
                "ifsc" => $info['bank_ifsc_code'],
                "consent" => "Y",
                "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
            );

            $api->get_veify_kyc_lite($request_data, $merchant_id, 'bank_ifsc_code', $info['bank_ifsc_code'], 'utility/ifsc/lite');
        }

        return true;
    }

    public function business_details_check($info, $merchant_id)
    {

        $merchant_business = new MerchantBusiness();
        $mdata = $merchant_business->get_requested_columns(['comp_pan_number', 'mer_pan_number', 'comp_gst', 'comp_cin']);
        $userPan = $userCpan = $userGST = $userCIN = '';

        if (count($mdata)) {
            $mdata = $mdata[0];

            $userPan = $mdata->mer_pan_number;
            $userCpan = $mdata->comp_pan_number;
            $userGST = $mdata->comp_gst;
            $userCIN = $mdata->comp_cin;
        }
        $api = new KycProcessApi();

        if (isset($info['comp_pan_number'])) {
            if ($info['comp_pan_number'] != $userCpan) {
                $request_data = array(
                    "customer_pan_number" => $info['comp_pan_number'],
                    "consent" => "Y",
                    "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
                );
                $api->get_pan_lite($request_data, $merchant_id, 'comp_pan_number');
            }
        }

        if (isset($info['comp_cin'])) {

            if ($info['comp_cin'] != $userCIN) {
                $request_data = array(
                    "cin_number" => $info['comp_cin'],
                    "consent" => "Y",
                    "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
                );

                $api->get_veify_kyc_lite($request_data, $merchant_id, 'comp_cin', $info['comp_cin'], 'merchant/cin/advance');
            }
        }

        if (isset($info['mer_pan_number'])) {
            if ($info['mer_pan_number'] != $userPan) {
                $request_data = array(
                    "customer_pan_number" => $info['mer_pan_number'],
                    "consent" => "Y",
                    "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
                );
                $api->get_pan_lite($request_data, $merchant_id, 'mer_pan_number');
            }
        }

        if (isset($info['comp_gst'])) {
            if ($info['comp_gst'] != $userGST) {
                $request_data = array(
                    "business_gstin_number" => $info['comp_gst'],
                    "consent" => "Y",
                    "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
                );
                $api->get_gst_lite($request_data, $merchant_id, 'comp_gst');
            }
        }



        return true;
    }

    public function business_info_check($info, $merchant_id)
    {
        $merchant_business = new MerchantBusiness();
        $mdata = $merchant_business->get_requested_columns(['bank_acc_no', 'bank_ifsc_code']);

        $userIfsc = '';
        $userAccoun = '';
        if (count($mdata)) {
            $mdata = $mdata[0];
            $userIfsc = $mdata->bank_ifsc_code;
            $userAccoun = $mdata->bank_acc_no;
        }

        $api = new KycProcessApi();
        if (isset($info['bank_ifsc_code'])) {

            if ($info['bank_ifsc_code'] != $userIfsc) {
                $request_data = array(
                    "ifsc" => $info['bank_ifsc_code'],
                    "consent" => "Y",
                    "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
                );

                $api->get_veify_kyc_lite($request_data, $merchant_id, 'bank_ifsc_code', $info['bank_ifsc_code'], 'utility/ifsc/lite');
            }
        }


        if (isset($info['bank_acc_no'])) {
            if ($info['bank_acc_no'] != $userAccoun) {
                $request_data = array(
                    "account_number" => $info['bank_acc_no'],
                    "ifsc" => $info['bank_ifsc_code'],
                    "consent" => "Y",
                    "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
                );
                $api->get_veify_kyc_lite($request_data, $merchant_id, 'bank_acc_no', $info['bank_acc_no'], 'financial/bav/lite');
            }
        }







        return true;
    }


    public function okyc_send_otp($info, $merchant_id)
    {


        $output = array(
            'status' => true,
            'user_full_name' => '',
            'user_dob' => '',
            'message' => "Invalid Request! Please try again!",
            "data" => 3,
            'response_code' => 400,
            'request_id' => ''
        );



        if (isset($info['mer_aadhar_number'])) {
            $api = new KycProcessApi();
            $request_data = array(
                "customer_aadhaar_number" => $info['mer_aadhar_number'],
                "consent" => "Y",
                "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
            );
            if (0) {

                $output = array(
                    'status' => true,
                    'message' => "OTP Sent to Your Aadhar Linked mobile no.",
                    "data" => 5,
                    'response_code' => 100,
                    "request_id" => '354f56f4-68d7-4a53-9fb9-84da4e65cbfb'
                );
            } else {

                $response = $api->get_veify_kyc_lite_aadhar($request_data, $merchant_id, 'mer_aadhar_number_otp', $info['mer_aadhar_number'], 'identity/okyc/otp/request');

                if ($response['response_code'] == 100) {
                    $result = json_encode($response['result'], true);
                    $output = array(
                        'status' => true,
                        'message' => "OTP Sent to Your Aadhar Linked mobile no.",
                        "data" => 5,
                        'response_code' => $response['response_code'],
                        "request_id" => isset($response['request_id']) ? $response['request_id'] : ''
                    );
                } else {
                    $output = array(
                        'status' => true,
                        'user_full_name' => '',
                        'user_dob' => '',
                        'message' => "Invalid Aadhaar No or OTP, Please try again",
                        "data" => 4,
                        'response_code' => $response['response_code'],
                        "request_id" => isset($response['request_id']) ? $response['request_id'] : ''
                    );
                }
            }
        }
        return $output;
    }



    public function okyc_check_otp($info, $merchant_id)
    {

        $output = array(
            'status' => true,
            'user_full_name' => '',
            'user_dob' => '',
            'message' => "Invalid Request! Please try again!",
            "data" => 3,
            'response_code' => 400
        );
        $api = new KycProcessApi();
        if (isset($info['otp'])) {
            $request_data = array(
                "request_id" => $info['request_id'],
                "otp" => $info['otp'],
                "consent" => "Y",
                "consent_text" => "I hear by declare my consent agreement for fetching my information via ZOOP API."
            );
            if (1) {
                $response = $api->get_veify_kyc_lite_aadhar($request_data, $merchant_id, 'mer_aadhar_number', $info['mer_aadhar_number'], 'identity/okyc/otp/verify');

                if ($response['response_code'] == 100) {

                    $output = array(
                        'status' => true,
                        'user_full_name' => $response['result']['user_full_name'],
                        'user_dob' => $response['result']['user_dob'],
                        'message' => "Aadhaar No. is Validated, Please Click On Next Step/Submit form",
                        "data" => 5,
                        'response_code' => $response['response_code']
                    );
                } elseif ($response['response_code'] == 106) {

                    $output = array(
                        'status' => true,
                        'user_full_name' => "zyx",
                        'user_dob' => 123,
                        'message' => "Aadhaar No. is Validated, Please Click On Next Step/Submit form",
                        "data" => 5,
                        'response_code' => $response['response_code']
                    );
                } else {
                    $output = array(
                        'status' => true,
                        'user_full_name' => '',
                        'user_dob' => '',
                        'message' => "Invalid Aadhaar No or OTP, Please try again",
                        "data" => 4,
                        'response_code' => $response['response_code']
                    );
                }
            } else {
                $output = array(
                    'status' => true,
                    'user_full_name' => 'AAAAAAAAAAAAAA',
                    'user_dob' => 'xxxxxxxxxxxxxxxx',
                    'message' => "Aadhaar No. is Validated, Please Click On Next Step/Submit form",
                    "data" => 5,
                    'response_code' => 100
                );
            }
        }
        return $output;
    }

    public function esigndocument(Request $request, $request_id)
    {

        return view('ekyc.eSign_document')->with(["requestid" => $request_id, "loadscript" => "esign"]);
    }



    public function readpdf(Request $request)
    {



        $merchant_id = 40;
        $folder_name = User::get_merchant_gid($merchant_id);
        $task_id = Str::uuid()->toString();
        $file = "agreementfile.pdf";
        $filePath = storage_path('app/public/onboarding/agreement/' . $folder_name . "/" . $file);

        $filecode = file_get_contents($filePath);
        $data = base64_encode($filecode);
        $api = new KycProcessApi();
        $size = array(
            "page_num" => 1,
            "x_coord" => 70,
            "y_coord" => 60
        );
        $document = array(
            "data" => $data,
            "info" => "Merchant Agreement document",
            "sign" => array($size)
        );

        $request_data = array(
            "document" => $document,
            "task_id" => $task_id,
            "signer_name" => "Pankaj Ajayrao Kale",
            "signer_email" => "pankajkale2431@gmail.com",
            "signer_city" => "Nagpur",
            "purpose" => "To Insure the Aggrement",
            "response_url" => "https://pg.paymentsolution.in/sapi/kyc/esignwebhook",
            "redirect_url" => "https://pg.paymentsolution.in/kyc/esignresponse",
            "email_template" => array("org_name" => "S2 Payment Pvt Limited ")

        );




        $response = $api->initiate_esign_aadhar($request_data, $merchant_id);


        $kycsignInites = \App\kycEsignInites::where(['created_merchant' => $merchant_id])
            ->orderby('id', 'desc')
            ->first();

        $kycrequest_id = $kycsignInites['request_id'];
        //save in webhook table
        $KycEsign = new \App\KycEsignResponse();
        $cond1 = array('request_id' => $kycrequest_id, 'created_merchant' => $merchant_id);
        $KycEsignN = $KycEsign->where($cond1)->orderby('id', 'desc')
            ->first();
        if ($KycEsignN) {
            $KycEsign = $KycEsignN;
        }
        $KycEsign->request_id = $kycrequest_id;
        $KycEsign->created_merchant = $merchant_id;
        $KycEsign->save();

        //save in webhook table
        $KycStatus = new \App\kycEsignStatuses();
        $cond2 = array('request_id' => $kycrequest_id);
        $KycStatusN = $KycStatus->where($cond2)->orderby('id', 'desc')
            ->first();
        if ($KycStatusN) {
            $KycStatus = $KycStatusN;
        }
        $KycStatus->request_id = $kycrequest_id;
        $KycStatus->save();


        $api = new KycProcessApi();
        $request_id = $kycrequest_id;
        $response = $api->esign_aadhar_status($request_id);

        // Encode the image string data into base64

        // 


        // Display the output
        //echo $data;
    }
}
