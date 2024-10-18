<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash; 
use App\Http\Controllers\Auth\LoginMerchantEmployee;
use App\User;
use App\MerchantEmployee;
use App\BlockMerchant;
use Auth;
use Mail; 
use App\Mail\SendMail;
use Session;
use App\Utility\SmsUtility;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/merchant/dashboard';

    protected $redirect2wTo = '/merchant/verify-2fa';

    private $login_attempts_count = 3;

    private $todaydate = "";

    private $datetime="";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->datetime = date('Y-m-d H:i:s');
         //echo get_auth_user_id();die();
        $this->middleware('guest')->except('logout');
    }

     /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {

         // $wallet = new \App\PayoutWallet();
         // $wallet->merchant_id=2;
         // $wallet->balance=0;
                  
         // $wallet->save();
       

        // $OTP = mt_rand(99999,1000000);
        // $name="Aditya";
        // $message = "Dear ".$name.", ".$OTP." is the OTP for verifying your mobile with S2 Pay. Warm Regards, S2 Pay";

        // $sms_response=SmsUtility::phone_number_verification("8668246493", $OTP);
         
        // dd($sms_response);                 
                    Session::forget('userId');

                    Session::forget('username');

                    Session::forget('user_credentials');
                    Session::forget('user_password');


        return view('auth.login')->with("loadcss","login");
    }

    public function verifyLogin(Request $request)
    {   

        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha'=> 'required|captcha',
        ];

        $messages = [
            "email.required"=>"Username field is required",
            "password.required"=>"Password field is required",
            'captcha.captcha'=>'Invalid captcha code.Pleaese try again.'
        ];

        $validator = Validator::make($request->all(), $rules,$messages);


        if($validator->fails())
        {
            echo json_encode(["status"=>FALSE,"errors"=>$validator->errors()]);

        }else{

            $credentials = $request->except('_token');
            $merchant = User::where('email',$request['email'])->first();
            $meremployee = MerchantEmployee::where('employee_email',$request['email'])->first();


            if(isset($merchant))
            {
                $validCredentials = Hash::check($request['password'],$merchant->getAuthPassword());
                if ($validCredentials) {

                    if($merchant->is_account_locked == 'Y')
                    {
                        $message = "Your account got lock temporary due to multiple login attempts <br>contact our customer support to unlock";
                        echo json_encode(['status'=>FALSE,'message'=>$message]);

                    }else if($merchant->merchant_status == 'inactive'){
                        $message = "Your account has deactivated for some reasons<br>contact our customer support to activate your account";
                        echo json_encode(['status'=>FALSE,'message'=>$message]);
                    }else{
                        User::where('id',$merchant->id)->update(['failed_attempts'=>0]);


                         if($merchant->tf_auth == 1 && $merchant->tf_auth_secret!='') {

                                 session(["userId"=>$merchant->id]);
                                 session(["username"=>$request->email]);
                                 session(["user_credentials"=>$credentials]);
                                 session(["user_password"=>$request->password]);
                                
                              
                                $this->guard()->logout();
                               // return redirect('/verify-2fa');
                                echo json_encode(['status'=>TRUE,'redirect'=>$this->redirect2wTo]);
                            }else{

                                     User::where('id',$merchant->id)->update(['failed_attempts'=>0]);
                                     $this->attemptLogin($request);
                                     echo json_encode(['status'=>TRUE,'redirect'=>$this->redirectTo]);
                             }
                         }

                }else{

                    if($merchant->failed_attempts < $this->login_attempts_count)
                    {
                        User::where('id',$merchant->id)->update(['failed_attempts'=>$merchant->failed_attempts+1]);
                        switch ($merchant->failed_attempts) {
                            case '0':
                                $message = "Only ".($merchant->failed_attempts+1)."/3 Passwords Attempts left";
                                break;
                            case '1':
                                $message = "Only ".($merchant->failed_attempts+1)."/3 Passwords Attempts left";
                                break;
                            case '2':
                                $message = "Account will get lock temporary, If you fail this time";
                                break;
                        }
                        echo json_encode(['status'=>FALSE,'message'=>'You entered wrong credentials <br>'.$message]);
                    }else{

                       $lock = new BlockMerchant;
                       $lock->blocked_at = $this->datetime;
                       $lock->created_merchant = $merchant->id;
                       $lock->save();
                       $merchantinfo = new \App\User();
                       $basicinfo = $merchantinfo->get_merchant_details_by_mail($request->email);
                       $basicinfo=$basicinfo[0];

                       $data = array(
                            "from" => env("MAIL_USERNAME", ""),
                            "subject" => "Merchant Account Locked:",
                            "view" => "maillayouts.merchant_account_locked",
                            "htmldata" => array(
                             "name" => $basicinfo->name,
                            "token"=> ''
                        ),
                      );
                       Mail::to($basicinfo->email)->send(new SendMail($data));

                        User::where('id',$merchant->id)->update(['is_account_locked'=>'Y']);
                        $message = "Your account got lock temporarily,contact our customer support to unlock";
                        echo json_encode(['status'=>FALSE,'message'=>$message]); 
                    
                    }
                }
            }else{
                if($meremployee){
                    
                    $validCredentials = Hash::check($request['password'],$meremployee->getAuthPassword());
                    
                    if ($validCredentials) {


                        if($meremployee->is_account_locked == 'Y')
                        {
                            $message = "Your account got lock temporary due to multiple login attempts <br>contact merchant to unlock";
                            echo json_encode(['status'=>FALSE,'message'=>$message]);

                        }else if($meremployee->employee_status == 'inactive'){

                            $message = "Your account has been deactivated <br>contact merchant to activate";
                            echo json_encode(['status'=>FALSE,'message'=>$message]);

                        }else{

                            $loginmerchantemp = new LoginMerchantEmployee();
                            $login_status = $loginmerchantemp->verifyLogin($credentials,$request);
                            echo json_encode(['status'=>$login_status["status"],'redirect'=>$login_status["redirect"]]);
                        }
                        
    
                    }else{
    
                        if($meremployee->failed_attempts < $this->login_attempts_count)
                        {
                            MerchantEmployee::where('id',$meremployee->id)->update(['failed_attempts'=>$meremployee->failed_attempts+1]);
                            switch ($meremployee->failed_attempts) {
                                case '0':
                                    $message = "Only ".($meremployee->failed_attempts+1)."/3 Passwords Attempts left";
                                    break;
                                case '1':
                                    $message = "Only ".($meremployee->failed_attempts+1)."/3 Passwords Attempts left";
                                    break;
                                case '2':
                                    $message = "Account will get lock temporary, If you fail this time";
                                    break;
                            }
                            echo json_encode(['status'=>FALSE,'message'=>'You entered wrong credentials <br>'.$message]);
                        }else{
    
                            MerchantEmployee::where('id',$meremployee->id)->update(['is_account_locked'=>'Y']);
                            $message = "Your account got lock temporarily,contact your merchant to unlock";
                            echo json_encode(['status'=>FALSE,'message'=>$message]); 
                        
                        }
                    }

                }else{
                    echo json_encode(['status'=>FALSE,'message'=>'You entered wrong credentials']);
                }
                
            }
            
            
        }
    
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

}
