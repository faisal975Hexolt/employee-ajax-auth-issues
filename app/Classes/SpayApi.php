<?php

namespace App\Classes;
use App\CfRefund;

use Illuminate\Http\Request;

class SpayConfig {
   

    public static $V1baseUrl = "https://api.cashfree.com/api/v1";
    public static $V2baseUrl = "https://api.cashfree.com/pg";
    public static $returnHost = "https://f63818bab708.ngrok.io";

}

class SpayApi
 {

     protected $clientSalt;
     protected $clientApiKEY;

      public function __construct(){
         $this->date_time = date("Y-m-d H:i:s");   
         $this->clientSalt = env('S2PAY_SALT');;
         $this->clientApiKEY = env('S2PAY_APIKEY');
      }



      public function getAccountBalance($parameters){

           $parameters['api_key']=$this->clientApiKEY;
           $s2payHash=generateS2payHashKey($parameters);

           $parameters['hash']=$s2payHash;
        
                if(1){
                      $url="https://pg.s2pay.in/v3/fundtransfer/getbalance";
                      $ch = curl_init($url);
                      curl_setopt($ch, CURLOPT_POST, true);
                      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
                      curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                      $result_json = curl_exec($ch);
                      
                      curl_close($ch);
                     
                      $result =  json_decode($result_json, true);
                  }

                return $result;
      }



      public function getTransactionStatus($parameters){

           $parameters['api_key']=$this->clientApiKEY;
           $s2payHash=generateS2payHashKey($parameters);

           $parameters['hash']=$s2payHash;
        
                  if(1){
                      $url="https://pg.s2pay.in/v3/fundtransferstatus";
                      $ch = curl_init($url);
                      curl_setopt($ch, CURLOPT_POST, true);
                      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
                      curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                      $result_json = curl_exec($ch);
                      
                      curl_close($ch);
                     
                      
                  }

                     $result =  json_decode($result_json, true);

                return $result;
      }


       public function transferAmount($parameters){

           $parameters['api_key']=$this->clientApiKEY;
           $s2payHash=generateS2payHashKey($parameters);

           $parameters['hash']=$s2payHash;


          // echo json_encode($parameters);die();
        
                  if(1){
                      $url="https://pg.s2pay.in/v3/fundtransfer";
                      $ch = curl_init($url);
                      curl_setopt($ch, CURLOPT_POST, true);
                      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
                      curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                      $result_json = curl_exec($ch);
                      
                      curl_close($ch);
                     
                      
                  }

                     $result =  json_decode($result_json, true);

                return $result;
      }








      

     
  }
    
?>