<?php

namespace App\Classes;

use Illuminate\Http\Request;
use Auth;
use App\MerchantBusiness;

class MerchantValidate{


public static function validateWebhook()
{
	
	if(Auth::user()->onboarding_status==VERIFIED_ONBOARDING && Auth::user()->app_mode==1){
		return true;
	}else{
		return false;
	}

}


public static function documentStatus()
{
	
	if(Auth::user()->documents_upload=="Y" && Auth::user()->onboarding_status==SENT_FOR_CORRECTION_ONBOARDING){
		return true;
	}else{
		return false;
	}

}

public static function documentEsignStatus()
{
	$status=false;
	if(in_array(Auth::user()->onboarding_status, array(ESIGN_PENDING_ONBOARDING,ESIGN_REJECTED_ONBOARDING))){
		$business=new MerchantBusiness();
		$mbusiness=$business->get_merchant_business_details(Auth::user()->id);
		
		if(count($mbusiness)){
			$mbusiness=$mbusiness[0];
			if($mbusiness->agreement_file){
				$status= true;
			}
		}
		
	}
	return $status;
}


public static function iSdocumentEsignRejected()
{
	
	if(Auth::user()->onboarding_status==ESIGN_REJECTED_ONBOARDING){
		return true;
	}else{
		return false;
	}

}

public static function validateApiKey()
{
	
	if(Auth::user()->onboarding_status==VERIFIED_ONBOARDING && Auth::user()->app_mode==1){
		return true;
	}else{
		return false;
	}

}

public static function validateMenu()
{
	
	if(Auth::user()->onboarding_status==VERIFIED_ONBOARDING && Auth::user()->app_mode==1){
		return true;
	}else{
		return false;
	}

}




}