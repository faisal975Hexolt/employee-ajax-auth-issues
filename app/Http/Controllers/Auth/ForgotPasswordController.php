<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Merchant; 
use App\Mail\SendMail;
use Mail; 
use Hash;
use Illuminate\Support\Str;
use App\Utility\SmsUtility;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        //return back()->with('status', trans($response));
        echo json_encode(['status'=>TRUE,'message' => trans($response)]);
    }


      
    public function showForgetPasswordForm()
      {
         return view('auth.passwords.forgetPassword');
      }




     public function submitForgetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:merchant',
          ],['email.exists'=>'Email Id Not registered with us, Please try with different email)']);
  
          $token = Str::random(64);
  

           $merchantinfo = new \App\User();
           $basicinfo = $merchantinfo->get_merchant_details_by_mail($request->email);
           $basicinfo=$basicinfo[0];

           if($basicinfo->is_account_locked=='Y'){

              return back()->withInput()->with('error', 'Merchant Account is locked , Due to 3 wrong login attempts. Please Conctat Customer Support of '.env('APP_NAME_FULL').".");

           }
           if($basicinfo->merchant_status=='inactive'){
            return back()->withInput()->with('error', 'Merchant Account is Inactive . Please Conctat Customer Support of '.env('APP_NAME_FULL').".");
           }


           DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
           

           $data = array(
                "from" => env("MAIL_USERNAME", ""),
                "subject" => "Merchant Password Change Request:",
                "view" => "maillayouts.merchant_reset_link",
                "htmldata" => array(
                    "name" => $basicinfo->name,
                    "token"=> $token
                ),
            );
           Mail::to($request->email)->send(new SendMail($data));


           $sms_response=SmsUtility::reset_password($basicinfo->mobile_no, $basicinfo->name);
  
  
          return back()->with('message', 'We have e-mailed your password reset link!');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:merchant',
               'password' => ['required','string','min:8','max:20','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            
              'password_confirmation' => 'required'
          ],['password.regex'=>'Password should contain at-least 1 Uppercase,1 Lowercase,1 Numeric & 1 Special character)']);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token,Please Initiate New Password reset link');
          }


           $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->where('created_at','>',Carbon::now()->subMinutes(10))
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Token is expired,Please Initiate New Password reset link');
          }



  
          $user = Merchant::where('email', $request->email)
                      ->update(['password' => bcrypt($request->password),'is_account_locked'=>"N","failed_attempts"=>0]);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();


           $merchantinfo = new \App\User();
           $basicinfo = $merchantinfo->get_merchant_details_by_mail($request->email);
           $basicinfo=$basicinfo[0];


           $lock = \App\BlockMerchant::where('created_merchant', $basicinfo->id)
            ->update(array('blocked_status' => 'completed'));
            


          $data = array(
                "from" => env("MAIL_USERNAME", ""),
                "subject" => "Password Changed Successfully:",
                "view" => "maillayouts.merchant_password_success",
                "htmldata" => array(
                    "name" => $basicinfo->name
                ),
            );
           Mail::to($request->email)->send(new SendMail($data));
           $sms_response=SmsUtility::update_password_alert($basicinfo->mobile_no, $basicinfo->name);

  
          return redirect('/login')->with('message','Your password has been changed , Successfully!');
      }

      

}
