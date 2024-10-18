<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash; 
use App\Http\Controllers\Auth\LoginMerchantEmployee;
use App\User;
use App\MerchantEmployee;
use Auth;
use Session;
class UserController extends Controller
{

     protected $redirectTo = '/merchant/dashboard';

public function verify2fa()

    {

        return view('layouts.security.verify-two-factor');
    }



    public function check2fa(Request $request)

    {

        // print_r($request->all());die();

        $message = "INVALID CODE";

      
      
         if (isset($request->otp) && $request->otp && Session::has('userId') && Session::get('username')  && Session::get('user_password')) {

            $userId = Session::get('userId');


            $user = User::where('id', $userId)->first();
           
            if ($user) {

                $ga = new \App\Packages\Authenticator\Authenticator();

                $backup_pass = false;

                $otp = $request->otp;

                $checkResult = $ga->verify($user->tf_auth_secret, $otp);

                if ($user->tf_auth_codes) {

                    $backup_pass = false;

                    $backup_codes = explode(',', $user->tf_auth_codes);

                    if (in_array($otp, $backup_codes)) {

                        $backup_pass = true;

                        $key = array_search($otp, $backup_codes);

                        unset($backup_codes[$key]);

                        $user->tfa_codes = implode(',', $backup_codes);
                    }
                }

                if ($checkResult || $backup_pass == true) {

                    $credentials = array("email" => Session::get('username'), "password" => Session::get('user_password'));

                    Auth::attempt($credentials);

    

                    Session::forget('userId');

                    Session::forget('username');

                    Session::forget('user_credentials');
                    Session::forget('user_password');
                    

                     return redirect('merchant/dashboard');
                }
            }
        }

        return redirect('merchant/verify-2fa')->with('message', $message);
    }



    public function getRealIpAddr()
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {

            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // return $ip;

        $ips = explode(',', $ip);

        return $ips[0];
    }



    public function get_random_num($length = 0)
    {

        $characters = str_shuffle('0123456789');

        $string = '';

        for ($p = 0; $p < $length; $p++) {

            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }





}