<?php

use App\Utility\SendSMSUtility;
use App\VendorBank;
use App\BusinessSubCategory;


if (!function_exists('get_auth_user_id')) {

    function get_auth_user_id()

    {

        return 1233;;
    }
}

function setupNumFormat($amount)
{
    return number_format($amount, 2, '.', '');
}

function getbusinessSubcategoryHelper($cat_id = 1)
{
    $subcat = new BusinessSubCategory();
    return $subcat->get_sel_business_subcategory($cat_id);
}

if (!function_exists('getDocumentName')) {

    function getDocumentName($key)
    {
        $documents_name = [

            "comp_pan_card" => "Company Pan Card",
            "comp_gst_doc" => "Company GST",
            "bank_statement" => "Bank Statement",
            "aoa_doc" => "AOA Doc",
            "mer_pan_card" => "Authorized Signatory Pan Card",
            "mer_aadhar_card" => "Authorized Signatory Aadhar Card",
            "moa_doc" => "MOA Doc",
            "cancel_cheque" => "Cancel Cheque",
            "cin_doc" => "Certificate of Incorporation",
            "partnership_deed" => "Partnership Deed",
            "llp_agreement" => "LLP Agreement",
            "registration_doc" => "Registration Doc",
            "no_objection_doc" => "No Objection Document",
            "trust_constitutional" => "Trust Constitutional",
            "income_tax_doc" => "Income Tax",
            "ccrooa_doc" => "CCROOA Doc",
            "current_trustees" => "Current Trusties",
            "mer_br_document" => "BR Document",
        ];

        return $documents_name[$key];
    }
}







if (!function_exists('sendSMS')) {

    function sendSMS($to, $text, $template_id)

    {

        return SendSMSUtility::sendSMS($to, $text, $template_id);
    }
}


function testhelper()
{
    echo "Helper works";
}


function get_domain()
{

    return $_SERVER['SERVER_NAME'];
}



/**
 * @param array $parameters
 * @param string $salt
 * @param string $hashing_method
 * @return null|string
 */
function generateS2payHashKey($parameters, $salt = '', $hashing_method = 'sha512')
{
    $salt = env('S2PAY_SALT');
    $secure_hash = null;
    ksort($parameters);
    $hash_data = $salt;
    foreach ($parameters as $key => $value) {
        if (strlen($value) > 0) {
            $hash_data .= '|' . trim($value);
        }
    }
    if (strlen($hash_data) > 0) {
        $secure_hash = strtoupper(hash($hashing_method, $hash_data));
    }
    return $secure_hash;
}



function responseHashCheck($salt, $response_array)
{
    /* If hash field is null no need to check hash for such response */
    if (is_null($response_array['hash'])) {
        return true;
    }
    $response_hash = $response_array['hash'];
    unset($response_array['hash']);
    /* Now we have response json without the hash */
    $calculated_hash = hashCalculate($salt, $response_array);
    return ($response_hash == $calculated_hash) ? true : false;
}


function get_vendor_name($id)
{

    $bank = VendorBank::where('id', $id)->first();

    $vendor_name = '';
    if ($bank != null) {
        $vendor_name = $bank->bank_name;
    }

    return $vendor_name;
}

function get_transaction_upiId($row)
{

    $response = \App\PythruWebhookResponse::where('merchantTranId', $row['transaction_gid'])->orderBy('id', "desc")->get();
    if ($response) {
        return $response[0]->PayerVA ?? '';
    } else {
        return '';
    }
}

function get_transaction_upiIdById($transaction_gid)
{

    $response = \App\PythruWebhookResponse::where('merchantTranId', $transaction_gid)->orderBy('id', "desc")->get();
    if ($response) {
        return $response[0]->PayerVA ?? '';
    } else {
        return '';
    }
}


function getBusinessType()
{
    $businesstype = DB::table('business_type')->get();
    return $businesstype;
}

function getbusinessCategory()
{
    $businessCategory = DB::table('business_category')->get();
    return $businessCategory;
}

function getbusinessSubcategory()
{
    $businessSubcategory = DB::table('business_sub_category')->get();
    return $businessSubcategory;
}

function getbusinessSubcategoryByCat($category_id)
{
    $businessSubcategory = DB::table('business_sub_category')->where('category_id', $category_id)->get();
    return $businessSubcategory;
}

function getmonthlyExpenditure()
{
    $monthlyExpenditure = DB::table('app_option')->where('module', 'merchant_business')->get();
    return $monthlyExpenditure;
}


function get_merchnat_list()
{

    $merchnat = \App\User::orderby('name', 'asc')->get();

     return $merchnat;
}
function gst_status()
{
    $status = array('active', 'suspended', 'rejected');
    return $status;
}
function get_transaction_status()
{
    $status = array('authorized', 'success', 'failed', 'captured', 'refunded', 'cancelled', 'pending');
    return $status;
}

function get_settlement_status()
{
    $status = array('proccessing', 'processed');
    return $status;
}

function get_merchant_block_status()
{
    $status = array('blocked', 'processed', 'completed');
    return $status;
}

function type_status()
{
    $status = array('active', 'inactive', 'deleted');
    return $status;
}


function payout_status()
{
    $status = array('enabled', 'disabled');
    return $status;
}

function settelmentCronDays()
{
    $status = array('today', 'yesterday');
    return $status;
}


function gstCronDays()
{
    $status = [];
    for ($i = 1; $i <= 31; $i++) {
        $status[] = $i;
    }

    return $status;
}


function get_ecollect_status()
{
    $status = array('initiated', 'credited', 'failed');
    return $status;
}

function get_business_status()
{
    $status = array('active', 'inactive', 'deleted');
    return $status;
}

function get_merchnant_app_status()
{
    if (Auth::check()) {
        return Auth::user()->app_mode;
    }
    return 0;
}


function get_random_num($length = 0)
{

    $characters = str_shuffle('0123456789');

    $string = '';

    for ($p = 0; $p < $length; $p++) {

        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}


function getMerchantServiceStatus($menu)
{
    $status = 1;

    if ($menu->merchant_services_check) {
        $status = 0;
        $storedPermissions = DB::table('merchant_services')->where('merchant_id', Auth::user()->id)->first();
        if ($storedPermissions) {
            $servcieName = strtolower($menu->menu_name);
            if ($storedPermissions->$servcieName) {
                $status = 1;
            }
        }
    }
    return $status;
}

function getBladeView($data, $column)
{
    $val = '';
    if (isset($data->$column)) {
        $val = $data->$column;
    }
    return $val;
}


function frefund_status($status, $span = '')
{
    switch ($status) {
        case "processed":
            $status = 'refunded';
            break;

        default:
            $status = $status;
            break;
    }
    $status = ucwords($status);
    if ($span) {
        if ($status == "Refunded") {
            $status = '<span class="btn btn-success btn-sm">' . $status . '</span>';
        } elseif ($status == "Failed") {
            $status = '<span class="btn btn-danger btn-sm">' . $status . '</span>';
        } else {
            $status = '<span class="btn btn-warning btn-sm">' . $status . '</span>';
        }
    }

    return $status;
}



function fsettlement_status($status, $span = '')
{
    switch ($status) {
        case "processed":
            $status = 'Settled';
            break;

        default:
            $status = $status;
            break;
    }
    $status = ucwords($status);
    if ($span) {
        if ($status == "Settled") {
            $status = '<span class="btn btn-success btn-sm">' . $status . '</span>';
        } elseif ($status == "Failed") {
            $status = '<span class="btn btn-danger btn-sm">' . $status . '</span>';
        } else {
            $status = '<span class="btn btn-warning btn-sm">' . $status . '</span>';
        }
    }

    return $status;
}

function ftype_status($status, $span = '')
{
    switch ($status) {
        case "active":
            $status = 'Active';
            break;

        default:
            $status = $status;
            break;
    }
    $status = ucwords($status);
    if ($span) {
        if ($status == "Active") {
            $status = '<span class="btn btn-success btn-sm">' . $status . '</span>';
        } elseif ($status == "Inactive") {
            $status = '<span class="btn btn-danger btn-sm">' . $status . '</span>';
        } else {
            $status = '<span class="btn btn-warning btn-sm">' . $status . '</span>';
        }
    }

    return $status;
}


function payout_status_html($status, $span = '')
{
    switch ($status) {
        case 1:
            $status = 'enabled';
            break;

        default:
            $status = 'disabled';
            break;
    }
    $status = ucwords($status);
    if ($span) {
        if ($status == "Enabled") {
            $status = '<span class="btn btn-success btn-sm">' . $status . '</span>';
        } elseif ($status == "Disabled") {
            $status = '<span class="btn btn-danger btn-sm">' . $status . '</span>';
        } else {
            $status = '<span class="btn btn-warning btn-sm">' . $status . '</span>';
        }
    }

    return $status;
}