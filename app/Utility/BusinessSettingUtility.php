<?php

namespace App\Utility;

use Illuminate\Support\Facades\Http;
use App\Classes\GenerateLogs;
use App\Models\BusinessSetting;
use DB;

class BusinessSettingUtility
{


    public static function generateIds($attribute)
    {

        $business_settings = BusinessSetting::select(['value'])->where('type', 'attribute_initial')->first();
        $attribute_initial = 'S2';
        if ($business_settings) {
            $attribute_initial = $business_settings->value;
        }

        $randomNumber = random_int(1000, 9999);
        $time = date('ymds') . $randomNumber;
        switch (strtolower($attribute)) {
            case "transaction":
                $for = 'T';
                break;
            case "refund":
                $for = "R";
                break;
            case "dispute":
                $for = "D";
                break;
            case "settlement_summary":
                $for = "SS";
                break;
            case "settlement":
                $for = "S";
                break;
            case "case":
                $for = "C";
                break;
            case "customer_case":
                $for = "CC";
                break;
            case "merchant_case":
                $for = "CM";
                break;
            case "admin_case":
                $for = "CA";
                break;
            case "direct_settlement":
                $for = "DS";
                break;
            case "account_settlement":
                $for = "AS";
                break;
            case "payout_ledger":
                $for = "PL";
                break;
            default:
                $for = "U";
        }

        return $attribute_initial . $for . $time;
    }
    public static function generateMerchantIds($attribute = '')
    {

        $x = 1;
        do {

            $x++;
        } while ($x <= rand(10, 9990));


        $prefixes = DB::table('prefixes')->first();

        if ($prefixes) {
            $attribute_initial = $prefixes->merchant_prefix;
        } else {
            $attribute_initial =  'YPG';
        }


        $userObject = new \App\User();

        $merchant_count = $userObject->getLastUserIndex();

        $merchant = $userObject->where('merchant_gid', 'LIKE', '%' . $attribute_initial . '%')->orderby('id', 'desc')->first();
        $merchant_gid = 1000;
        if ($merchant) {
            $merchant_gid = substr($merchant->merchant_gid, strlen($attribute_initial));
        }
        $merchant_gid = $merchant_gid + 1;
        $merchant_gid = $attribute_initial . str_pad($merchant_gid, 4, "0", STR_PAD_LEFT);
        return $merchant_gid;
    }
}
