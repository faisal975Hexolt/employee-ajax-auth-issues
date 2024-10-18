<?php



namespace App\Classes;



use Illuminate\Http\Request;



class Helpers

{


    public static function transaction_report_types($type='')

    {
        $types=array("transaction",
            "refund",
        "settlement"
        );
        return $types;

    }

    public static function payment_report_status($type='')

    {
        $types=array("success","authorized","pending",
        "failed",
        "cancelled");
        return $types;

    }

    public static function payment_report_mode($type='')

    {
        $types=array(
            "UPI"=>"Upi",
            "NB"=>"Net Banking",
            "CC"=>"Credit Card",
            "DC"=>"Debit Card",
            "WALLET"=>"Wallet",
            "QRCODE"=>"Qr Code"
        );
        return $types;

    }

    public static function refund_report_status($type='')

    {
        $types=array(
            'processed','processing','failed'
        );
        return $types;

    }

    public static function settlement_report_status($type='')

    {
        $types=array(
            // 'authorized','captured','refunded','failed','cancelled','success',
            'pending','proccessing','processed'
        );
        return $types;

    }




	 public static function payment_mode($mode)

    {

    	$payment_mode='-';
        $mode=strtoupper($mode);
    	if($mode=='UPI'){

    			$payment_mode='UPI';

    	}elseif($mode=='NB'){

    			$payment_mode='Net Banking';

    	}if($mode=='CC'){

    			$payment_mode='Credit Card';

    	}if($mode=='DC'){

    			$payment_mode='Debit Card';

    	}if($mode=='WALLET'){

    			$payment_mode='Wallet';

    	}if($mode=='QRCODE'){

    			$payment_mode='QR CODE';

    	}

    	return $payment_mode;

        

    }



    public static function transaction_status($status)

    {

    	$transaction_status='All';

    	if($status=='success'){

    			$transaction_status='Success';

    	}elseif($status=='pending'){

    			$transaction_status='Pending';

    	}if($status=='failed'){

    			$transaction_status='Failed';

    	}if($status=='cancelled'){

    			$transaction_status='Cancelled';

    	}

    	return $transaction_status;

        

    }





    public static function support_type(){

        $support_type =  array(

            "1" => "Complaint",

            "2" => "No Information",

            "3" => "Others",

            "4" => "Refund"

        );



        return $support_type;

    }



}