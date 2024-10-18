<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->guard('employee')->user();

        $fullUrl = url()->current();

        // Extract the path from the full URL
        $path = parse_url($fullUrl, PHP_URL_PATH);

        $find = DB::table('navigation')->where('hyperlink', $path)->first();

        if ($find) {
            $combinationArray =  [
                'Account' => 'account',
                'Finance' => 'finance',
                'Settlement' => 'settlement',
                'Technical' => 'technical',
                'Networking' => 'networking',
                'Support' => 'support',
                'Marketing' => 'marketing',
                'Sales' => 'sales',
                'Risk & Compliance' => 'risk_compliance',
                'Legal' => 'legal',
                'HRM' => 'hrm',
                'Merchant' => 'merchant',
                'Chargeback & Dispute' => 'chargeback_dispute',
                'Payout' => 'payout',
                'Reports' => 'reports',
                'Users' => 'users',
                'Settings' => 'settings',
                'Merchant Management' => 'merchant_management',
                'Onboarding Management' => 'onboarding_management',
                'Recon' => 'recon',
            ];

            if (array_key_exists($find->link_name, $combinationArray)) {
                $module = $combinationArray[$find->link_name];
            } else {
                $getParent = DB::table('navigation')->where('id', $find->parent_id)->first();
                $module = $combinationArray[$getParent->link_name];
            }

            $getPermissions = DB::table('nav_permission')->where('employee_id', $user->id)->first();

            $arr = explode('+', $getPermissions->{$module});

            $check = in_array($find->id, $arr);

            if (!$check) {
                return response('You are not authorized', 403);
            }
        }

        return $next($request);
    }
}
