<?php



namespace App\Utility;

use Illuminate\Support\Facades\Http;

use App\Classes\GenerateLogs;



class SendSMSUtility

{

   public static function sendSMS($to,$text,$template_id='')
    { 


      $smsApi=new \App\SmsApi();

        $smskeys=$smsApi->where('status',1)->orderBy('id',"desc")->limit(1)->get();
        if(count($smskeys)){
            $smsrow=$smskeys[0];

            $args = array(
                    'APIKey' => $smsrow->api_key,
                    'senderid' => $smsrow->sms_sid,
                    'channel' => "Trans",
                    'DCS' => 8,  
                    'flashsms' => 0,
                    'number' => "91".$to,
                    'text' => urlencode($text),
                    'route' => 0
               );

               $data = array();
               foreach($args as $i => $arg){
                
                    $data[] = "$i=$arg";
               }

               $data = implode('&', $data);


               //$url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=s6oqrjpUukm3IPdv1C7QZA&senderid=".$sid."&channel=Trans&DCS=0&flashsms=0&number=91".$mobile_no."&text=".urlencode($msg)."&route=0";
                $baseUrl="http://cloud.smsindiahub.in/api/mt/SendSMS";
                $url=$baseUrl."?".$data;
                 // echo $url;die();
   
                $ch = curl_init();  
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                $output=curl_exec($ch);
                

               GenerateLogs::send_sms_log(date('Y-m-d H:i:s'), array($output),$url);
                
                curl_close($ch);
                return (['status' => 'Success', 'data' => $output]);

           }
        
                return (['status' => 'Failed', 'data' => $output]);



    }



	 public static function sendSMSOld($to, $text, $template_id)

    { 



    	 $APIKey = "XSLpB0kzl0eJwFcb7t5fwg";

        $channel = "Trans";

        $message = urlencode($text);

        $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$APIKey&senderid=PAYFLA&channel=$channel&DCS=0&flashsms=0&number=$to&text=$message&route=0";

       

           $ch = curl_init($url);

           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

           $curl_scraped_page = curl_exec($ch);

           curl_close($ch);

            //GenerateLogs::sms_sent_log($url, $ret);

			return true;

    }



}