<?php
namespace App\Utility;

use App\SmsTemplate;
use App\User;
use App\Utility\SendSMSUtility;
class SmsUtility
{
    public static function phone_number_verification($to = '',$otp='')
    {
        $sms_template   = SmsTemplate::where('identifier','phone_number_verification')->first();
        $sms_body       = $sms_template->sms_body;
        $sms_body       = str_replace('[[code]]', $otp, $sms_body);
        $sms_body       = str_replace('[[site_name]]', env('APP_NAME'), $sms_body);
        $template_id    = $sms_template->template_id;
        try {
             return SendSMSUtility::sendSMS($to, $sms_body);
            
        } catch (\Exception $e) {

        }
    }

     public static function paylink_notification($to = '',$user='',$link='')
    {
        $sms_template   = SmsTemplate::where('identifier','paylink_notification')->first();
        $sms_body       = $sms_template->sms_body;
        $sms_body       = str_replace('[[user]]', $user, $sms_body);
        $sms_body       = str_replace('[[site_name]]', env('APP_NAME'), $sms_body);
        $sms_body       = str_replace('[[link]]', $link, $sms_body);

        
        $template_id    = $sms_template->template_id;
        try {
             return SendSMSUtility::sendSMS($to, $sms_body);
            
        } catch (\Exception $e) {

        }
    }


     public static function reset_password($to = '',$user='')
    {
        $sms_template   = SmsTemplate::where('identifier','reset_password')->first();
        $sms_body       = $sms_template->sms_body;
        $sms_body       = str_replace('[[user]]', $user." ,", $sms_body);
        $sms_body       = str_replace('[[site_name]]', env('APP_NAME'), $sms_body);
        $sms_body       = str_replace('[[admin_contact]]', " :".env('SUPPORT_CONTATCT'), $sms_body);

        
        $template_id    = $sms_template->template_id;
        try {
             return SendSMSUtility::sendSMS($to, $sms_body);
            
        } catch (\Exception $e) {

        }
    }



    public static function reset_password_alert($to = '',$user='')
    {
        $sms_template   = SmsTemplate::where('identifier','reset_password_alert')->first();
        $sms_body       = $sms_template->sms_body;
        $sms_body       = str_replace('[[user]]', $user." ,", $sms_body);
        $sms_body       = str_replace('[[site_name]]', env('APP_NAME'), $sms_body);
        $sms_body       = str_replace('[[admin_contact]]', env('SUPPORT_CONTATCT'), $sms_body);

        
        $template_id    = $sms_template->template_id;
        try {
             return SendSMSUtility::sendSMS($to, $sms_body);
            
        } catch (\Exception $e) {

        }
    }



    public static function update_password_alert($to = '',$user='')
    {
        $sms_template   = SmsTemplate::where('identifier','update_password_alert')->first();
        $sms_body       = $sms_template->sms_body;
        $sms_body       = str_replace('[[user]]', $user." ,", $sms_body);
        $sms_body       = str_replace('[[site_name]]', env('APP_NAME'), $sms_body);
        $sms_body       = str_replace('[[admin_contact]]', " :".env('SUPPORT_CONTATCT'), $sms_body);

        
        $template_id    = $sms_template->template_id;
        try {
             return SendSMSUtility::sendSMS($to, $sms_body);
            
        } catch (\Exception $e) {

        }
    }



}