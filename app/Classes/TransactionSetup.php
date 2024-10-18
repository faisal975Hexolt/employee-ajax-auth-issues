<?php

namespace App\Classes;

use Illuminate\Http\Request;
use App\MerchantChargeDetail;

class TransactionSetup{


    public function __construct(){
         $this->date_time = date("Y-m-d H:i:s");   
        
      }

      public function setup_get_card_charges($transaction_type, $merchant_id, MerchantChargeDetail $adjustment_chargeObject)
    {

        $card_charge = "";
        if (!empty($transaction_type)) {
            switch ($transaction_type) {

                case 'VISA':
                    $card_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "cc_visa");
                    break;

                case 'MASTER':
                    $card_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "cc_master");
                    break;

                case 'MAESTRO':
                    $card_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "cc_master");
                    break;

                case 'RUPAY':
                    $card_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "cc_rupay");
                    break;

                default:
                    $card_charge = "1.00";
                    break;
            }
        }

        return $card_charge;
    }

    public function setup_get_netbanking_charges($transaction_type, $merchant_id, MerchantChargeDetail $adjustment_chargeObject)
    {

        $net_charge = "";
        if (!empty($transaction_type)) {

            switch ($transaction_type) {

                case '1002':
                case '3022':
                case 'ICIC':
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_icici");
                    break;

                case '1005':
                case '1013':
                case '3033':
                case '3058':
                case 'YESB':
                case 'KTB':
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_yes_kotak");
                    break;

                case '1006':
                case '3021':
                case 'HDFC':
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_hdfc");
                    break;

                case '1014':
                case '3044':
                case 'SBIN':
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_sbi");
                    break;

                default:
                    $net_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "net_others");
                    break;
            }
        }
        return $net_charge;
    }

    public function setup_get_other_charges($transaction_type, $merchant_id, MerchantChargeDetail $adjustment_chargeObject)
    {
        $other_charge = "";
        if (!empty($transaction_type)) {
            switch ($transaction_type) {

                case 'qrcode':
                    $other_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "qrcode");
                    break;

                case '4004':
                    $other_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "wallet");
                    break;

                default:
                    $other_charge = $adjustment_chargeObject->get_adjustment_charge_by_card($merchant_id, "upi");
                    break;
            }
        }
        return $other_charge;
    }


     public function setup_num_format($amount)
    {
        return number_format($amount, 2, '.', '');
    }


}


?>