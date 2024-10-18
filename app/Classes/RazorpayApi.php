<?php

namespace App\Classes;


use Illuminate\Http\Request;
use DB;


class RazorpayApi
 {

    public function __construct(){
         $this->date_time = date("Y-m-d H:i:s");   
         
      }


    public  function initiateRefundRazor($payment_id,$data,$merchant_id)
      {

        $razorpay = DB::table('mid_keys_razorpay')->
                  select('*')->
                  where(['merchant_id'=>$merchant_id])->first();
        
        $body=[];
        $output=array('status'=>false,'message'=>"error");
         $client = new \GuzzleHttp\Client();
           try {   


         $credentials = base64_encode($razorpay->key_id .':' . $razorpay->key_secret ) ;
         $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic '.$credentials.''
            ];
         $base_url="https://api.razorpay.com/v1/payments/{$payment_id}/refund";
        
         $data['speed']="normal";
       
          
            $response = $client->request('POST', $base_url, [
                 'body' => json_encode($data),
                 'headers' => $headers,
                 'http_errors' => false

                ]);

             $apiResponse =   json_decode($response->getBody(), true);

           } catch (ClientErrorResponseException $exception) {
                     $response = $exception->getResponse()->getBody(true);
                
            }
           if($response->getStatusCode()==200){

            $refund= new \App\RpRefund();
                $refund['merchant_id']=$merchant_id;
                $refund['payment_id']=$apiResponse['payment_id'];
                $refund['refund_id']=$apiResponse['id'];
                $refund['initiated_at']=\Carbon\Carbon::parse($apiResponse['created_at'])->format('Y-m-d h:i:s') ;;
                $refund['refund_amount']=$apiResponse['amount'];
                $refund['refund_currency']=$apiResponse['currency'];
                $refund['refund_note']=json_encode($apiResponse['notes']);
                $refund['refund_status']=$apiResponse['status'];
                $refund['entity']=$apiResponse['entity'];
                $refund['speed_processed']=$apiResponse['speed_processed'];
                $refund['speed_requested']=$apiResponse['speed_requested'];
                $refund['batch_id']=$apiResponse['batch_id'];
                $refund['acquirer_data']=json_encode($apiResponse['acquirer_data']);;
              
                $output=array('status'=>true,'message'=>"Refund Processed Successfully",'refund_status'=>$apiResponse['status'],'refund_arn'=>$apiResponse['acquirer_data']['rrn']);
                
                $refund->save();
           }else{
            $apiResponse=$apiResponse['error'];
                 $output=array('status'=>false,'message'=>$apiResponse['description'],'refund_status'=>'failed','refund_arn'=>"");
           }     
          return $output;

      }




 }