<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ResellerController;


/*Route::get('/', function (){
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/sitemap.xml', function (){
    View::addExtension('xml','php');
    return response(file_get_contents(resource_path('views/sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});

Route::get('/googlea59b5d17aca07eef.html', function (){
    View::addExtension('html','php');
    return View::make('googlea59b5d17aca07eef');
});


$uri = Request::path();


$routes = [
    'about','contact','blog','event','payment-gateway','payment-pages','payment-link','subscription',
    'dev-doc','integration','rpay-mudra','rpay-punji','rpay-tej','rpay-wallet','rpay-epos','rpay-credit-card',
    'rpay-ivr','banking','education','ecommerce','route','invoice','index.html','rpay-doc','disclaimer','privacy'
    ,'term&condition','agreement','covid','saas','upi','customer-stories','partner','customer-stories','adjustment-guide','api'
];

if(in_array($uri,$routes))
{
    Route::get("/".$uri,function () {
        View::addExtension('html','php');
        return View::make('index');
    });
}


Route::get('/pricing', function () {
    View::addExtension('html','php');
    return View::make('index');
});
*/

//daily job route
Route::get('daily_cron_job', 'VerifyController@dailyTransactionReportJob')->name('dailyTransactionReportJob');

Route::get('/reload-captcha', function () {
    return captcha_src('flat');
});


Route::get("/chart", function () {
    return View::make("am_chart.amchart1");
});

/* 
 * Merchant Funcionality Controller Routes 
*/
Auth::routes();
Route::get('/', 'MerchantController@index')->name('dashboard');

Route::get('/apitest', 'MerchantController@apitest')->name('apitest');

Route::get('/view_logs', 'VerifyController@viewlog');

Route::post('/mobile-register', 'Auth\RegisterController@mobile_register');

Route::get('/demo', 'VerifyController@demo_page');

Route::post('/demo/request', 'VerifyController@demo_request')->name("test-demo-request");

Route::post('/verify-login', 'Auth\LoginController@verifyLogin');

Route::get('/resend-mobile-otp', 'Auth\RegisterController@resend_mobileOTP');

Route::post('/verify-mobile', 'VerifyController@verify_mobile_number')->name("mverification");

Route::get('/contact', 'VerifyController@contact_us');

Route::get('/forgotpassword', 'VerifyController@forgotpassword');


Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');

Route::post('forget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');


Route::get('/loginform', 'VerifyController@loginform');

Route::get('/registerform', 'VerifyController@registerform');

Route::post('/contact-us-form', 'VerifyController@managepay_contactus')->name('contact-us');

Route::post('/subscribe-us', 'VerifyController@managepay_subscribe')->name('subscribe-us');

Route::get('/blog', 'VerifyController@blog');

Route::get('/blog/{postid}', 'VerifyController@blog_post')->name('blog-post');

Route::get('/event', 'VerifyController@event');

Route::get('/event/{postid}', 'VerifyController@event_post')->name('event-post');

Route::get('/csr/{postid}', 'VerifyController@csr_post')->name('csr-post');

Route::get('/press-release/{postid}', 'VerifyController@pr_post')->name('pr-post');

Route::get('/gallery', 'VerifyController@gallery')->name('gallery');

Route::get('/career', 'VerifyController@career')->name('career');

Route::get('/integration', 'VerifyController@integration')->name('integration');

Route::get('/career/job/description/{id}', 'VerifyController@get_job_description');

Route::post('/career/job/apply', 'VerifyController@store_applicant');

Route::get('/csr', 'VerifyController@csr')->name('csr');

Route::get('/press-release', 'VerifyController@press_release')->name('press-release');

Route::get('/managepay-qrcode/{id}', 'VerifyController@generate_qrcode');

Route::get('/verify-account/{token}', 'VerifyController@verify_email_account')->name('verify-account');

Route::post('/managepay-webhook', 'VerifyController@get_webhook_detail');

Route::get('/payout-response', 'VerifyController@payout_response');

Route::get("/session-timeout", 'VerifyController@session_timeout')->name("session-timeout");


Route::get('razor_payment', 'RazorpayPaymentController@index');
Route::post('razor_payment', 'RazorpayPaymentController@store')->name('razorpay.payment.store');
Route::any('razor_refund', 'RazorpayPaymentController@razaor_refund')->name('razorpay.payment.razaor_refund');

Route::middleware(['auth'])->group(function () {

    // Route::get('/mobile-verification',function(){

    //     return view("/merchant/mobverify");
    // });

    Route::get('/business-details', function () {

        $states = App\State::all();
        return view("/merchant/business")->with("states", $states);
    });

    Route::post('/resend-message', 'VerifyController@resend_mobile_sms')->name("resend-message");



    Route::get("/account-locked", 'VerifyController@account_locked');

    Route::post("/update-lastlogin", "VerifyController@session_update")->name("session-update");
});

Route::get('/terms-conditions', 'SupportController@terms_condition');

Route::get('/privacy-policies', 'SupportController@privacy_policies');

Route::get('/service-agreement', 'SupportController@merchant_service');

Route::get('/number_spell', 'SupportController@number_spell');



Route::group(['prefix' => 'merchant'], function () {

    Route::get('dashboard', 'MerchantController@index')->name('dashboard');

    Route::post('dashboard', 'MerchantController@index');


    Route::get('testcode', 'MerchantController@Test_code')->name('testcode');

    Route::get('two-factor-auth', 'MerchantController@two_factor_auth')->name('merchant-two-factor-auth');;

    Route::post('two-factor-auth', 'MerchantController@UpdatetwoFactor')->name('merchant.two-factor-auth');


    Route::post('/transactions/download-transaction-ajx', 'MerchantController@download_transaction_ajx')->name('download-transactionlog-ajx');
    Route::get('/transactions/checkJobStatus/{jobId}', 'MerchantController@checkJobStatus')->name('checkJobStatus');
    Route::get('/transactions/deleteCsvFile/{jobId}', 'MerchantController@deleteCsvFile')->name('deleteCsvFile');



    Route::get('verify-2fa', 'External\UserController@verify2fa')->name('verify-2fa');
    Route::post('check-2fa', 'External\UserController@check2fa')->name('check-2fa');

    Route::get('settlement/settlementsummary', 'MerchantController@getSettlementSummary')->name('getSettlementSummary');

    Route::any('settlement/settlementsummarydwnld', 'MerchantController@settlementsummary_dwld')->name('settlementsummaryDwnld');




    Route::get('all-invoices/{perpage}', 'MerchantController@invoice');

    Route::any('/merchant/transactions/download-transaction-log', 'MerchantController@download_transaction')->name('download-transactionlog');

    Route::get('new-invoice', 'MerchantController@show_invoice')->name("show-invoice");

    Route::post('add-business', 'VerifyController@store_merchant_info')->name('business');

    Route::get('payments/{perpage}', 'MerchantController@payment');

    Route::any('fetchpayment', 'MerchantController@fetchpayment');

    Route::get('payment/get/{id}', 'MerchantController@get_payment');

    Route::post('payments', 'MerchantController@payment');

    Route::get('transactions', 'MerchantController@merchant_transaction');

    Route::get('transaction_list', 'MerchantController@merchant_transaction_list');

    Route::any('fetch_transaction_list', 'MerchantController@gettransactionlist')->name('fetch_transaction_list');

    Route::get('invoices', 'MerchantController@merchant_invoice');

    Route::get('paylinks', 'MerchantController@merchant_paylink');

    Route::get('quicklinks/{perpage}', 'MerchantController@get_quicklinks');

    Route::get('refunds/{perpage}', 'MerchantController@refund');

    Route::get('orders/{perpage}', 'MerchantController@order');

    Route::post('orders', 'MerchantController@order');

    Route::get('order/get/{id}', 'MerchantController@get_order');

    Route::post('refunds', 'MerchantController@refund');

    Route::get('disputes/{perpage}', 'MerchantController@dispute');

    Route::post('disputes', 'MerchantController@dispute');

    Route::get('settlements', 'MerchantController@settlement');

    Route::post('settlements', 'MerchantController@settlement');

    Route::any('settlementsbrief', 'MerchantController@settlement_brief');

    Route::get('get-all-items', 'MerchantController@get_all_items');

    Route::get('items/{perpage}', 'MerchantController@item');

    Route::post('items', 'MerchantController@item');

    Route::get('paylinks/get/{perpage}', 'MerchantController@paylink');

    Route::post('paylinks', 'MerchantController@paylink');

    Route::post('paylink/new', 'MerchantController@store_paylink');

    Route::post('quicklink/add', 'MerchantController@store_quicklink');

    Route::post('paylink/bulk/new', 'MerchantController@store_bulk_paylink');

    Route::post('item/new', 'MerchantController@store_item');

    Route::post('item/bulk/new', 'MerchantController@store_bulk_items');

    Route::get('item/edit/{id}', 'MerchantController@edit_item');

    Route::post('item/update', 'MerchantController@item_update');

    Route::post('item/remove', 'MerchantController@destroy_item');

    Route::get('paylink/edit/{id}', 'MerchantController@paylink_edit');

    Route::post('paylink/update', 'MerchantController@paylink_update');

    Route::post('appmode/change', 'MerchantController@change_appmode');

    Route::get('feed-back', 'MerchantController@merchant_feedback');

    Route::get('help-support', 'MerchantController@merchant_helpsupport');

    Route::get('personal-info', 'MerchantController@merchant_info');

    Route::post('personal-info/save', 'MerchantController@store_merchant_info');

    Route::post('business-info/update', 'MerchantController@update_business_info');

    Route::post('business-logo/update', 'MerchantController@update_business_logo');

    Route::post('business-logo/remove', 'MerchantController@remove_business_logo');

    Route::post('company-info/update', 'MerchantController@update_company_info');

    Route::post('business-details-info/save', 'MerchantController@store_business_details_info');
    Route::get('bank-ifsc/reverify', 'MerchantController@reverify_bank_ifsc');
    Route::post('business-aadhaar/verify', 'MerchantController@verify_business_aadhaar');

    Route::get('test/verify', 'MerchantController@testverify');


    Route::post('business-aadhaar/check', 'MerchantController@check_business_aadhaar');
    Route::post('business-aadhaar/reverify', 'MerchantController@reverify_business_aadhaar');
    Route::get('refer-earn', 'MerchantController@merchant_referearn');

    Route::get('checkmail', 'MerchantController@send_mail');

    Route::get('invoice/new', 'MerchantController@create_invoice')->name('new-invoice');

    Route::post('invoice/add', 'MerchantController@store_invoice');

    Route::get('invoice/edit/{id}', 'MerchantController@edit_invoice');

    Route::post('invoice/update', 'MerchantController@update_invoice');

    Route::get('customers/{perpage}', 'MerchantController@customers');

    Route::get('get-all-customers', 'MerchantController@get_all_customers');

    Route::get('get-customer-info/{id}', 'MerchantController@get_customer_details');

    Route::get('get-customer-address/{id}', 'MerchantController@get_customer_address');

    Route::post('customer-address/add', 'MerchantController@store_customer_address');

    Route::post('customer-address/update', 'MerchantController@update_customer_address');

    Route::post('customer-address/delete', 'MerchantController@delete_customer_address');

    Route::get('customer/state/get-gstcode/{id}', 'MerchantController@get_customer_gst_state_code');

    Route::post('get-sub-category', 'MerchantController@get_business_subcategory');

    Route::post('customer/add', 'MerchantController@store_customer');

    Route::get('customer/edit/{id}', 'MerchantController@edit_customer');

    Route::post('customer/update', 'MerchantController@update_customer');

    Route::post('customer/remove', 'MerchantController@delete_customer');

    Route::get('api/add', 'MerchantController@store_merchant_api');

    Route::get('settings', 'MerchantController@merchant_settings');



    Route::get('reonboarding', 'MerchantController@merchant_recorrect')->name('reonboarding');

    Route::post('fetch_reonboarding_doc', 'MerchantController@merchant_recorrect_doc')->name('fetch_reonboarding_doc');

    Route::post('update_onboarding', 'MerchantController@merchant_update_onboarding')->name('update_onboarding');

    Route::any('/esignresponse', 'MerchantController@store_esign_response')->name('esignresponse');

    Route::get('initite_esign_agreement', 'MerchantController@merchantInititeEsignAgreement')->name('initite_esign_agreement');

    Route::get('resolution-center', 'MerchantController@resolution_center');

    Route::get('api/get-api', 'MerchantController@get_merchant_api');

    Route::get('api/details/{id}', 'MerchantController@get_api_details');

    Route::get('api/edit/{id}', 'MerchantController@update_merchant_api');

    Route::get('documents/upload/{id}', 'MerchantController@show_document_form');

    Route::post('document-submission', 'MerchantController@verify_documents');

    Route::get('document-submission/remove/{file}/{id}', 'MerchantController@remove_document');

    Route::get('document-submission/success', 'MerchantController@update_activate_docs');

    Route::get('load-activate-forms/{id}', 'MerchantController@activate_forms');

    Route::get('change-app-mode/{id}', 'MerchantController@change_appmode');

    Route::get('disable-popup', 'MerchantController@disable_popup');

    Route::post('reminder/enable', 'MerchantController@enable_reminders');

    Route::get('reminder/get', 'MerchantController@get_merchant_reminder');

    Route::post('reminder/add', 'MerchantController@store_merchant_reminder');

    Route::post('webhook/add', 'MerchantController@store_merchant_webhook');

    Route::get('webhook/get', 'MerchantController@get_webhook_details');

    Route::post('support/add', 'MerchantController@store_merchant_support');

    Route::get('support/get/{perpage}', 'MerchantController@get_merchant_support');

    Route::post('feedback/add', 'MerchantController@store_merchant_feedback');

    Route::get('feedback/get/{perpage}', 'MerchantController@get_merchant_feedback');

    Route::get('product/get/{perpage}', 'MerchantController@get_merchant_product');

    Route::post('product/add', 'MerchantController@store_merchant_product');

    Route::get('product/edit/{id}', 'MerchantController@edit_merchant_product');

    Route::post('product/update', 'MerchantController@update_merchant_product');

    Route::post('product/delete', 'MerchantController@delete_merchant_product');

    Route::get('customer-case/get/{perpage}', 'MerchantController@customer_case');

    Route::get('case-status/merchant/{id}', 'MerchantController@case_details');

    Route::post('comment/add', 'MerchantController@merchant_comment');

    Route::get('notifications', 'MerchantController@get_notifications');

    Route::get('messages', 'MerchantController@get_messages');

    Route::get('merchant-notifications/{perpage}', 'MerchantController@show_notification_table');

    Route::get('merchant-messages/{perpage}', 'MerchantController@show_message_table');

    Route::get('notification/update/{id}', 'MerchantController@update_notification');

    Route::get('tools', 'MerchantController@utilities');

    Route::get('coupon/new', 'MerchantController@coupon');

    Route::get('coupon/edit', 'MerchantController@coupon');

    Route::post('coupon/add', 'MerchantController@store_coupon');

    Route::get('coupons/get/{perpage}', 'MerchantController@get_all_coupon');

    Route::get('coupons/edit/{id}', 'MerchantController@edit_coupon');

    Route::get('new-coupon-id', 'MerchantController@new_coupon_id');

    Route::get('coupon/options', 'MerchantController@get_types_subtypes');

    Route::get('employee', 'MerchantController@employees')->name('merchant-employee');
    Route::get('employee-types', 'MerchantController@employeeTypes')->name('merchant-employee-types');

    Route::get('employee/get/{id}', 'MerchantController@get_employees');

    Route::get('employee/type/{id}', 'MerchantController@get_employee_permissions');

    Route::post('employee/permissions', 'MerchantController@store_type_permissions')->name('store-type-permissions');;

    Route::get('employee/new', 'MerchantController@create_employee')->name('create-employee');

    Route::post('employee/add', 'MerchantController@store_employee')->name('store-employee');

    Route::get('employee/edit/{id}', 'MerchantController@edit_employee')->name('edit-employee');

    Route::post('employee/update', 'MerchantController@update_employee');

    Route::post('employee/reset-password', 'MerchantController@reset_employee_password');

    Route::get('employee/unlock-account/{id}', 'MerchantController@unlock_employee');

    Route::post('employee/account-status', 'MerchantController@update_employee_status');

    Route::get('logactivities/get/{id}', 'MerchantController@get_merchant_logactivities');

    Route::get('my-account', 'MerchantController@my_account');

    Route::get('my-account/{id}', 'MerchantController@my_account_tab');

    Route::get('employee-login-activity', 'MerchantController@employee_login_activity')->name('employee-login-activity');

    Route::get('view-all-notifications', 'NotiMessController@view_all_notifications');

    Route::get('merchant/view-all-messages', 'NotiMessController@view_all_messages');

    Route::post('change-password', 'MerchantController@change_password')->name('merchant-change-password');

    Route::post('update-mydetails', 'MerchantController@update_mydetails')->name('update-mydetails');

    Route::get('resend-change-email', 'MerchantController@resend_changeemail');

    Route::get('resend-change-mobile', 'MerchantController@resend_changemobile');

    Route::get('pagination/{submod}-{perpage}', 'MerchantController@merchant_pagination');

    Route::get('search/{submod}/{searchtext}', 'MerchantController@merchant_search');

    Route::get('gstinvoicereport', 'MerchantController@gstinvoicereport');
    Route::get('gstinvoiceId', 'MerchantController@gstinvoiceId');

    Route::post('gstinvoicereport', 'MerchantController@gstinvoicereport');
    Route::post('gstinvoicereportdetails', 'MerchantController@gstinvoicereportdetails');

    Route::get('/gstdetailExcel/{date}', 'MerchantController@gstdetailExcel')->name('gstdetailExcel');

    Route::get('transactionreport', 'MerchantController@transactionreport');

    Route::get('merchanttransactionreportlog', 'MerchantController@getMerchantReportLog')->name('getMerchantReportLog');

    Route::get('merchantpayouttransactionreportlog', 'MerchantController@getMerchantPayoutReportLog')->name('getMerchantPayoutReportLog');

    Route::post('transactionreport', 'MerchantController@transactionReportData');

    Route::get('downloadreport', 'MerchantController@transactionReportDownload')->name('transactionReportDownload');
    Route::get('reportlog', 'MerchantController@transactionReportLog');

    Route::get('payouttransactionReportDownload', 'MerchantController@payouttransactionReportDownload')->name('payouttransactionReportDownload');

    Route::post('createdownloadreport', 'MerchantController@ReportDownloadlink')->name('ReportDownloadlink');

    Route::post('getreportMerchantparameter', 'MerchantController@getreportMerchantparameter');

    Route::get('paymentreport', 'MerchantController@paymentreport');

    Route::get('salesreport', 'MerchantController@salesreport');

    Route::get('datatable_export', 'MerchantController@datatableExport');

    Route::get('miscellaneous', 'MerchantController@miscellaneous');

    //payout
    Route::get('payout_overview', 'MerchantController@payoutdashboard');
    Route::post('payout_overview', 'MerchantController@payoutdashboard');

    //payoutcontacts
    Route::get('contacts', 'MerchantController@contacts');
    Route::post('add_single_contact', 'MerchantController@addsinglecontact');
    Route::post('add_bulk_contact', 'MerchantController@storebulkcontacts');
    Route::post('delete_contacts', 'MerchantController@deleteContacts');
    Route::get('edit_contacts', 'MerchantController@editContacts');
    Route::post('update_contacts', 'MerchantController@updateContacts');
    Route::get('check_contacts', 'MerchantController@checkContacts');


    Route::get('beneficiaries', 'MerchantController@beneficiaries');

    Route::get('newbeneficiaries', 'MerchantController@newbeneficiaries');
    Route::post('add_single_beneficiary', 'MerchantController@addsinglebeneficiary');
    Route::post('delete_beneficiaries', 'MerchantController@deleteBeneficiaries');
    Route::get('edit_beneficiaries', 'MerchantController@editBeneficiaries');
    Route::post('update_beneficiaries', 'MerchantController@updateBeneficiaries');
    Route::get('make_beneficiaries_group', 'MerchantController@makeBeneficiariesGroup');
    Route::post('post_make_beneficiaries_group', 'MerchantController@postmakeBeneficiariesGroup');

    Route::post('validate_upi', 'MerchantController@validateUpiId');
    Route::post('validate_account_number', 'MerchantController@validateAccountNumber');
    Route::post('add_bulk_beneficiaries', 'MerchantController@storebulkbeneficiaries');
    Route::post('edit_validate_account_number', 'MerchantController@editvalidateAccountNumber');
    Route::post('edit_validate_upi', 'MerchantController@editvalidateUpiId');

    //beneficiary group
    Route::get('beneficiary_groups', 'MerchantController@beneficiaryGroups');
    Route::get('beneficiary_groups/showmembers/{id}', 'MerchantController@showMembers');
    Route::get('beneficiary_groups/removemember/{id}', 'MerchantController@removeMember');

    Route::get('payout', 'MerchantController@payout');

    Route::post('payout', 'MerchantController@payoutTransferMoney');

    Route::any('payoutecollecttransaction', 'MerchantController@payouteCollectTransaction')->name('payoutecollecttransaction');
    Route::any('payoutfundstransfer', 'MerchantController@payoutFundsTransfer')->name('payoutfundstransfer');
    Route::any('payoutledger', 'MerchantController@payoutLedger')->name('merchant.payoutledger');

    Route::any('payout/payoutTransactionDwnld', 'MerchantController@payoutTransaction_dwnld')->name('payoutTransactionDwnld');



    Route::get('payout_setting', 'MerchantController@payoutsetting');
    Route::get('generate_payout_apikeys', 'MerchantController@payoutApiKey');
    Route::post('save_ip_whitelist', 'MerchantController@payoutIpWhitelist')->name('save_ip_whitelist');

    Route::get('get_api_keys', 'MerchantController@getapikeys');
    Route::get('delete_api_key/{id}', 'MerchantController@deleteApiKey');
    Route::get('delete_ip_address/{id}', 'MerchantController@deleteIpAdress')->name('delete_ip_address');

    //payout account
    Route::get('payout_account', 'MerchantController@payoutaccount');

    //payout reportc
    Route::get('payout_reports', 'MerchantController@payoutreport')->name('payout_reports');

    //endpayout


    //fund transfer
    Route::get('fund_transfer', 'MerchantController@fundTransfer');
    Route::get('add_fund', 'MerchantController@addFund');
    //endfund transfer
    Route::post('add_singlerefund', 'MerchantController@addsinglerefund');

    Route::get('transactionInfo', 'MerchantController@transactionInfo')->name('transactionInfo');
    Route::get('transactionRefundInit', 'MerchantController@transactionRefundInitiate')->name('transactionRefundInit');

    Route::post('/refund/new', 'MerchantController@store_refund_support')->name("refund_support");


    Route::get('payout_transaction_info', 'MerchantController@payoutTransactionInfo')->name('payoutTransactionInfo');

    //savepayoutmodule activation request
    Route::post('save_merchant_request', 'MerchantController@merchantRequest')->name('save_merchant_request');
});





Route::get('/merchantemp/search/{submod}/{searchtext}', 'MerchantEmpController@merchant_search');


Route::get('/download/{file}', function ($file = '') {
    return response()->download(storage_path('app/public/download/' . $file));
});

Route::get('/download/integration/{file}', function ($file = '') {

    if (Storage::disk('integration')->exists($file)) {
        return response()->download(storage_path('app/public/integration/' . $file));
    } else {
        return redirect()->back();
    }
});


Route::get('/download/blog/{file}', function ($file = '') {
    return response()->download(storage_path('app/public/blog/images/' . $file));
});

Route::get('/download/merchant-document/{file}', function ($file = '') {

    $merchant_gid = Auth::user()->merchant_gid;

    return response()->download(storage_path('app/public/merchant/documents/' . $merchant_gid . "/" . $file));
})->name('download-merchant-document');

Route::get('/download/merchant-logo/{file}', function ($file = '') {
    if (file_exists(public_path('/storage/merchantlogos/' . $file))) {
        return response()->download(public_path('/storage/merchantlogos/' . $file));
    }
});

/* 
 * Merchant Support controllers Routes
*/

Route::any('/customers', 'SupportController@customers_payments')->name('customers');

Route::post('/customers', 'SupportController@customers_payments_verify')->name('customers_verify');

Route::post('/customervalidate', 'SupportController@customers_validate_otp')->name('customervalidate');

Route::any('/customers_transactions', 'SupportController@customers_transactions')->name('customers_transactions');



Route::get('/support/{tid?}', 'SupportController@index')->name('support');



Route::get('/support/case-status/customer/{id}', 'SupportController@case_details');

Route::any('/support/new', 'SupportController@store_support')->name("new-support");

Route::post('/support/customer/comment/add', 'SupportController@customer_comment');

Route::get('/support/case/comment/get/{id}', 'SupportController@get_comment');

/* 
 * KYC controllers Routes
*/

Route::get('/kycdemo', 'KycDetailsController@index')->name('kycdemo');




/* 
 * Merchant Payment & Invoice Dynamic Controller Routes
*/

Route::get('/t/p/s-p/{id}', 'DynamicLinkController@test_smartpay');

Route::get('/t/i/s-p/{id}', 'DynamicLinkController@test_invsmartpay');

Route::post('/smart-pay/test-request-payment', 'DynamicLinkController@test_request_payment')->name("test-request-payment");

Route::post('/test/pay/smart-pay/response', 'DynamicLinkController@test_smartpay_response')->name("test-paylink-response");

Route::post('/test/inv/smart-pay/response', 'DynamicLinkController@test_invsmartpay_response')->name("test-invoice-response");

Route::get('/p/s-p/{id}', 'DynamicLinkController@live_smartpay');

Route::get('/i/s-p/{id}', 'DynamicLinkController@live_invsmartpay');

Route::post('/pay/smart-pay/response', 'DynamicLinkController@live_smartpay_response')->name("live-paylink-response");

Route::post('/inv/smart-pay/response', 'DynamicLinkController@live_invsmartpay_response')->name("live-invoice-response");

Route::post('/smart-pay/live-request-payment', 'DynamicLinkController@live_request_payment')->name("live-request-payment");

Route::get('/test-screen/email', function () {
    return view('maillayouts.documentcorrection');
});

/*
 * Merchant Payment Pages   
 */

Route::get('/payment-pages/{id}/view', 'MerchantController@payment_page')->name('create-payment-page');
Route::post('/payment-pages/store/page-detail', 'MerchantController@store_pagedetail')->name('store-page-details');
Route::post('/payment-pages/store/page-input-detail', 'MerchantController@store_page_inputdetail')->name('store-page-inputdetail');
Route::get('/payment-pages/get-all-pages/{id}', 'MerchantController@get_all_page_details');
Route::get('/payment-pages/edit/{id}', 'MerchantController@edit_page_details')->name('edit-payment-page');
Route::post('/payment-pages/remove', 'MerchantController@change_page_status');

Route::get('/pp/v/{id}', 'DynamicLinkController@live_payment_pagelink')->name('payment-page');
Route::get('/t/pp/v/{id}', 'DynamicLinkController@test_payment_pagelink')->name('test-payment-page');
Route::post('/payment-page/request-payment', 'DynamicLinkController@do_payment')->name('request-payment');
Route::get('/easebuzz/hash', 'DynamicLinkController@encryptdata');
Route::post('/payment-page/response', 'DynamicLinkController@live_payment_page_response')->name('payment-pageresponse');
Route::post('/payment-page/test/response', 'DynamicLinkController@test_payment_page_response')->name('test-payment-pageresponse');



/* 
 * Merchant Employee Funcionality Controller Routes
 * 
 * 
*/
Route::group(['prefix' => 'merchant/employee'], function () {

    Route::get('logout', 'Auth\LoginMerchantEmployee@logout')->name("emplogout");
    Route::get('transactions', 'MerchantEmpController@index');
    Route::get('get-transactions/{id}', 'MerchantEmpController@get_transaction');
    Route::get('paylinks', 'MerchantEmpController@showpaylink');
    Route::get('payment/get/{id}', 'MerchantEmpController@get_payment');
    Route::get('get-paylinks/{id}', 'MerchantEmpController@get_paylink');
    Route::post('paylink/add', 'MerchantEmpController@store_paylink');
    Route::get('paylink/edit/{id}', 'MerchantEmpController@edit_paylink');
    Route::post('paylink/update', 'MerchantEmpController@update_paylink');
    Route::get('get-quick-paylinks/{id}', 'MerchantEmpController@get_quick_paylink');
    Route::post('quicklink/add', 'MerchantEmpController@store_quicklink');
    Route::get('login-activity-log', 'MerchantEmpController@show_merchatemp_logactivity');
    Route::get('merchant-emp-login-log/{id}', 'MerchantEmpController@merchatemp_logactivity');
    Route::get('pagination/{submod}-{perpage}', 'MerchantEmpController@merchant_pagination');
});
/* 
 * Employee Funcionality Controller Routes
 * 
*/

Route::group(['prefix' => 'transaction'], function () {

    Route::get('transactionInfoDetail', 'TransactionDetailsController@transactionInfoDetail')->name('transactionInfoDetail');

    Route::post('paymentquerylogs/{id}', 'TransactionDetailsController@getpaymentquerylogs')->name('paymentquerylogs');

    Route::post('paymentrequestlogs/{id}', 'TransactionDetailsController@getpaymentrequestlogs')->name('paymentrequestlogs');

    Route::post('paymentstatus/{id}', 'TransactionDetailsController@getpaymentstatus')->name('paymentstatus');

    Route::post('s2scallbacklogs/{id}', 'TransactionDetailsController@gets2scallbacklogs')->name('s2scallbacklogs');

    Route::post('sends2sresponse/{id}', 'TransactionDetailsController@sends2sresponse')->name('sends2sresponse');
});


Route::group(['prefix' => 'payoutdetails'], function () {

    Route::get('fundtrasnferInfoDetail', 'PayoutTransactionController@fundtrasnferInfoDetail')->name('fundtrasnferInfoDetail');
});

Route::group(['prefix' => 'manage'], function () {

    Route::get('/', 'EmployeeController@index')->name('managepay-dashboard');
    Route::get('download_transactionold', 'EmployeeController@download_transactionold')->name('download_transactionold');
    // Login Routes...
    Route::get('login', ['as' => 'managepay.login', 'uses' => 'EmployeeAuth\LoginController@showLoginForm']);
    Route::post('login', ['uses' => 'EmployeeAuth\LoginController@login']);
    Route::post('logout', ['as' => 'managepay.logout', 'uses' => 'EmployeeAuth\LoginController@logout']);


    Route::get('navigation', 'EmployeeController@navigation')->name('navigation');;


    Route::get('2fa_auth', 'EmployeeController@two_factor_auth')->name('2fa_auth');;

    Route::post('2fa_auth', 'EmployeeController@UpdatetwoFactor')->name('employee.2fa_auth');

    // Registration Routes...
    Route::get('register', ['as' => 'managepay.register', 'uses' => 'EmployeeAuth\RegisterController@showRegistrationForm']);
    Route::post('register', ['uses' => 'EmployeeAuth\RegisterController@register']);

    // Password Reset Routes...
    Route::get('password/reset', ['as' => 'managepay.password.reset', 'uses' => 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm']);

    Route::post('password/email', ['as' => 'managepay.password.email', 'uses' => 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail']);

    Route::get('password/reset/{token}', ['as' => 'managepay.password.reset.token', 'uses' => 'EmployeeAuth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['uses' => 'EmployeeAuth\ResetPasswordController@reset']);

    Route::get("/session-timeout", 'VerifyController@emp_session_timeout');

    Route::post("/update-lastlogin", "VerifyController@emp_session_update")->name("emp-session-update");

    Route::get('admin-forget-password', ['uses' => 'EmployeeAuth\ForgotPasswordController@admin_forget_password']);





    Route::get('generateid', function () {
        return "paysel-" . Str::random(8);
    });

    Route::post('verify-credentials', 'EmployeeAuth\LoginController@verifyLogin');

    Route::get('load-login-forms', 'EmployeeAuth\LoginController@load_login_forms');

    Route::post('email-verify-otp', 'EmployeeAuth\LoginController@managepay_verify_email_otp')->name('managepay-email-verify');

    Route::post('2fa-verify-otp', 'EmployeeAuth\LoginController@managepay_verify_2fa_otp')->name('managepay-2fa-verify-otp');

    Route::post('mobile-verify-otp', 'EmployeeAuth\LoginController@managepay_verify_mobile_otp')->name('managepay-mobile-verify');

    Route::get('ft-password-change/send-otp-mobile', 'EmployeeAuth\LoginController@load_change_password_form')->name('send-otp-mobile');

    Route::post('ft-password-change/verify-empmobile-otp', 'EmployeeAuth\LoginController@verify_empmobile_OTP')->name('verify-empmobile-otp');

    Route::post('ft-password-change/ftpassword-change', 'EmployeeAuth\LoginController@change_ftemppassword')->name('ftpassword-change');

    Route::get('dashboard', 'EmployeeController@index')->name('managepay-dashboard');

    Route::get('dashboardGraphData', 'EmployeeController@dashboardTransactionGraph')->name('dashboardTransactionGraph');

    Route::get('dashboardGraphDataStatusWise', 'EmployeeController@dashboardPaymentStatusWiseGraph')->name('dashboardPaymentStatusWiseGraph');

    Route::get('dashboard_transactionstats', 'EmployeeController@dashboardTransactionStats')->name('dashboardTransactionStats');

   


    //payout
    Route::get('payout_dashboard', 'EmployeeController@payoutDashboard')->name('payoutDashboard');
    Route::get('payout_dashboard_transactionstats', 'EmployeeController@payoutdashboardTransactionStats')->name('payoutdashboardTransactionStats');
    Route::get('payout_dashboard_graph', 'EmployeeController@payoutDashboardGraph')->name('payoutDashboardGraph');

    Route::get('payout_merchants', 'EmployeeController@payoutMerchants')->name('payoutMerchants');
    Route::get('get_approved_payout_merchants', 'EmployeeController@getApprovedPayoutMerchants')->name('getApprovedPayoutMerchants');
    Route::get('merchant_payout_details/view/{id}', 'EmployeeController@merchantPayoutDetails')->name('merchantPayoutDetails');

    Route::get('price_setting', 'EmployeeController@priceSetting')->name('priceSetting');
    Route::get('price_setting/{id}', 'EmployeeController@priceSettingofUser')->name('priceSettingofUser');
    Route::post('save_price_setting', 'EmployeeController@savePriceSetting')->name('savePriceSetting');
    Route::post('delete_price_setting', 'EmployeeController@deletePriceSetting')->name('deletePriceSetting');
    Route::post('edit_price_setting', 'EmployeeController@editPriceSetting')->name('editPriceSetting');
    Route::get('routing_config', 'EmployeeController@routingConfig')->name('routingConfig');
    Route::post('save_routing_config', 'EmployeeController@saveRoutingConfig')->name('saveRoutingConfig');
    Route::post('delete_routing_config', 'EmployeeController@deleteRoutingConfig')->name('deleteRoutingConfig');
    Route::post('edit_routing_config', 'EmployeeController@editRoutingConfig')->name('editRoutingConfig');

    Route::get('payout_transactions', 'EmployeeController@payoutTransacations')->name('payouttransactions');
    Route::get('payout_reports', 'EmployeeController@payoutReports')->name('payoutReports');
    Route::get('payout_reports_logs', 'EmployeeController@payoutReportsLog')->name('payoutReportsLog');

    Route::post('payout_reports_download', 'EmployeeController@generatedPayoutReportDownload')->name('generatedPayoutReportDownload');

    Route::get('payout_get_transactions', 'EmployeeController@getPayouttransactions')->name('getPayouttransactions');
    Route::get('fetch_payouttransactions_req_res', 'EmployeeController@fetch_payouttransactions_req_res')->name('fetch_payouttransactions_req_res');
    Route::get('payout_transaction_info', 'EmployeeController@payoutTransactionInfo')->name('payoutTransactionInfo');
    Route::get('update_payout_transaction_status', 'EmployeeController@updatePayoutTransactionStatus')->name('updatePayoutTransactionStatus');

    Route::any('payoutEcollecttransaction', 'EmployeeController@ecollecttransactionList')->name('manage.payoutEcollecttransaction');;
    Route::any('payoutFundstransfer', 'EmployeeController@payout_fundstransfer')->name('manage.payoutFundstransfer');;
    Route::any('payoutLedger', 'EmployeeController@payout_ledger')->name('manage.payoutLedger');;
    Route::any('payoutAccounts', 'EmployeeController@payout_accounts')->name('manage.payoutAccounts');;

    Route::any('payout/payoutTransactionDwnld', 'EmployeeController@mpayoutTransaction_dwnld')->name('manage.payoutTransactionDwnld');
    //endpayout

    Route::get('email-otp', 'VerifyController@managepay_email_otp')->name('managepay-email');

    Route::get('ft-password-change', 'VerifyController@firsttime_passwordchange')->name('managepay-ft-password');

    Route::get('mobile-otp', 'VerifyController@managepay_mobile_otp')->name('managepay-mobile');

    Route::post('verify-employee-email', 'EmployeeAuth\ForgotPasswordController@verify_email');

    Route::get('load-email-form', 'EmployeeAuth\ForgotPasswordController@load_email_form');

    Route::post('employee-verify-email-otp', 'EmployeeAuth\ForgotPasswordController@verify_email_otp');



    Route::get('load-mobile-form', 'EmployeeAuth\ForgotPasswordController@load_mobile_form');

    Route::post('employee-verify-mobile-otp', 'EmployeeAuth\ForgotPasswordController@verify_mobile_otp');

    Route::get('admin-reset-password', 'EmployeeAuth\ForgotPasswordController@load_reset_password_form');

    Route::post('reset-admin-password', 'EmployeeAuth\ResetPasswordController@reset_admin_password');

    Route::post('send-again-mobile-otp', 'VerifyController@sendagain_managepay_empOTP')->name('send-again-mobile-otp');

    /**
     * 
     * Accounting Module Routing Starts here
     */

    Route::get('account/payable-management/{id}', 'EmployeeController@account')->name('account-payable');

    Route::get('account/payable-management/supplier-invoice/create', 'EmployeeController@show_supplier_invoice')->name('new-supplier-invoice');

    Route::get('account/receivable-management/{id}', 'EmployeeController@account')->name('account-receivable');

    Route::get('account/fixed-assets-accounting/{id}', 'EmployeeController@account')->name('account-fixed-assets');

    Route::get('account/global-taxation-solution/{id}', 'EmployeeController@account')->name('account-global-tax');

    Route::get('account/global-taxation-solution/tax-settlement/create', 'EmployeeController@show_tax_settlement')->name('create-tax-settlement');

    Route::get('account/global-taxation-solution/tax-settlement/get/{id}', 'EmployeeController@get_tax_settlement')->name('get-tax-settlement');

    Route::post('account/global-taxation-solution/tax-settlement/new', 'EmployeeController@store_tax_settlement')->name('new-tax-settlement');

    Route::get('account/global-taxation-solution/tax-adjustment/create', 'EmployeeController@show_tax_adjustment')->name('create-tax-adjustment');

    Route::get('account/global-taxation-solution/tax-adjustment/get/{id}', 'EmployeeController@get_tax_adjustment')->name('get-tax-adjustment');

    Route::post('account/global-taxation-solution/tax-adjustment/new', 'EmployeeController@store_tax_adjustment')->name('new-tax-adjustment');

    Route::get('account/global-taxation-solution/tax-payment/create', 'EmployeeController@show_tax_payment')->name('create-tax-payment');

    Route::get('account/global-taxation-solution/tax-payment/get/{id}', 'EmployeeController@get_tax_payment')->name('get-tax-payment');

    Route::post('account/global-taxation-solution/tax-payment/new', 'EmployeeController@store_tax_payment')->name('new-tax-payment');

    Route::get('account/account-charts/{id}', 'EmployeeController@account')->name('get-chart');

    Route::get('account/book-keeping/{id}', 'EmployeeController@account')->name('get-book-keeping');


    /**
     * Account Purchase Order CRUD Operations Routes
     */

    Route::get('account/purchase-order/get-supplier/{id}', 'EmployeeController@get_selected_supplier_info')->name('get-supplier');
    Route::get('account/payable-management/purchasae-order/get-all-purchase-order/{id}', 'EmployeeController@get_purchase_order')->name('get-all-purchase-order');
    Route::get('account/payable-management/purchase-order/create', 'EmployeeController@show_purchase_order')->name('create-purchase-order');
    Route::post('account/payable-management/purchase-order/new', 'EmployeeController@store_purchase_order')->name('new-purchase-order');
    Route::post('account/payable-management/purchase-order/update', 'EmployeeController@update_purchase_order')->name('update-purchase-order');
    Route::get('account/payable-management/purchase-order/edit/{id}', 'EmployeeController@edit_purchase_order')->name('edit-purchase-order');

    /**
     * Account Supplier Order CRUD Operations Routes
     */
    Route::get('account/payable-management/suporder-invoice/get-purchase-order-items/{id}', 'EmployeeController@get_purchase_order_items')->name('get-purchase-order-items');
    Route::get('account/payable-management/suporder-invoice/get-all-suporder-invoice/{id}', 'EmployeeController@get_suporder_invoice')->name('get-all-suporder-invoice');
    Route::get('account/payable-management/suporder-invoice/create', 'EmployeeController@show_suporder_invoice')->name('create-suporder-invoice');
    Route::post('account/payable-management/suporder-invoice/new', 'EmployeeController@store_suporder_invoice')->name('new-suporder-invoice');
    Route::post('account/payable-management/suporder-invoice/update', 'EmployeeController@update_suporder_invoice')->name('update-suporder-invoice');
    Route::get('account/payable-management/suporder-invoice/edit/{id}', 'EmployeeController@edit_suporder_invoice')->name('edit-suporder-invoice');

    /**
     * Account Expense Invoice Suppliers CRUD Operations Routes
     */
    Route::get('account/payable-management/supexp-invoice/get-all-supexp-invoice/{id}', 'EmployeeController@get_supexp_invoice')->name('get-all-suppexp-invoice');
    Route::get('account/payable-management/supexp-invoice/create', 'EmployeeController@show_supexp_invoice')->name('create-supexp-invoice');
    Route::post('account/payable-management/supexp-invoice/new', 'EmployeeController@store_supexp_invoice')->name('new-supexp-invoice');
    Route::post('account/payable-management/supexp-invoice/update', 'EmployeeController@update_supexp_invoice')->name('update-supexp-invoice');
    Route::get('account/payable-management/supexp-invoice/edit/{id}', 'EmployeeController@edit_supexp_invoice')->name('edit-supexp-invoice');

    /**
     * Account Suppliers Credit Debit Note CRUD Operations Routes
     */
    Route::get('account/payable-management/debit-note/get-all-supcd-note/{id}', 'EmployeeController@get_supcd_note')->name('get-all-supcd-note');
    Route::get('account/payable-management/debit-note/create', 'EmployeeController@show_debit_note')->name('new-debit-note');
    Route::post('account/payable-management/debit-note/new', 'EmployeeController@store_supcd_note')->name('store-supcd-note');
    Route::get('account/payable-management/debit-note/edit/{id}', 'EmployeeController@edit_supcd_note')->name('edit-supcd-note');
    Route::post('account/payable-management/debit-note/update', 'EmployeeController@update_supcd_note')->name('update-supcd-note');

    /**
     * Account Purchase Order CRUD Operations Routes
     */

    Route::get('account/receivable-management/sales-order/get-customer/{id}', 'EmployeeController@get_selected_customer_info')->name('get-customer-info');
    Route::get('account/receivable-management/sales-order/get-all-sales-order/{id}', 'EmployeeController@get_sales_order')->name('get-all-sales-order');
    Route::get('account/receivable-management/sales-order/create', 'EmployeeController@show_sales_order')->name('create-sales-order');
    Route::post('account/receivable-management/sales-order/new', 'EmployeeController@store_sales_order')->name('new-sales-order');
    Route::post('account/receivable-management/sales-order/update', 'EmployeeController@update_sales_order')->name('update-sales-order');
    Route::get('account/receivable-management/sales-order/edit/{id}', 'EmployeeController@edit_sales_order')->name('edit-sales-order');

    /**
     * Account Customer Order Invoice CRUD Operations Routes
     */
    Route::get('account/receivable-management/custorder-invoice/get-sales-order-items/{id}', 'EmployeeController@get_sales_order_items')->name('get-sales-order-items');
    Route::get('account/receivable-management/custorder-invoice/get-all-custorder-invoice/{id}', 'EmployeeController@get_custorder_invoice')->name('get-all-custorder-invoice');
    Route::get('account/receivable-management/custorder-invoice/create', 'EmployeeController@show_custorder_invoice')->name('create-custorder-invoice');
    Route::post('account/receivable-management/custorder-invoice/new', 'EmployeeController@store_custorder_invoice')->name('new-custorder-invoice');
    Route::post('account/receivable-management/custorder-invoice/update', 'EmployeeController@update_custorder_invoice')->name('update-custorder-invoice');
    Route::get('account/receivable-management/custorder-invoice/edit/{id}', 'EmployeeController@edit_custorder_invoice')->name('edit-custorder-invoice');

    /**
     * Account Customer Credit Debit Note CRUD Operations Routes
     */
    Route::get('account/receivable-management/debit-note/get-all-custcd-note/{id}', 'EmployeeController@get_custcd_note')->name('get-all-custcd-note');
    Route::get('account/receivable-management/debit-note/create', 'EmployeeController@show_custcd_note')->name('new-custcd-note');
    Route::post('account/receivable-management/debit-note/new', 'EmployeeController@store_custcd_note')->name('store-custcd-note');
    Route::get('account/receivable-management/debit-note/edit/{id}', 'EmployeeController@edit_custcd_note')->name('edit-custcd-note');
    Route::post('account/receivable-management/debit-note/update', 'EmployeeController@update_custcd_note')->name('update-custcd-note');


    /**
     * Account Invoice Items CRUD Operations Routes 
     */
    Route::get('account/fixed-asset/get-all-assets/{id}', 'EmployeeController@get_all_assets')->name('get-all-assets');

    Route::post('account/fixed-asset/new', 'EmployeeController@store_asset')->name('add-new-asset');

    Route::get('account/fixed-asset/edit/{id}', 'EmployeeController@edit_asset')->name('edit-asset');

    Route::post('account/fixed-asset/update', 'EmployeeController@update_asset')->name('update-asset');

    Route::get('account/fixed-asset/get-all-capital-assets/{id}', 'EmployeeController@get_all_capital_assets')->name('get-all-capital-assets');

    Route::get('account/fixed-asset/get-all-depreciate-assets/{id}', 'EmployeeController@get_all_depreciate_assets')->name('get-all-depreciate-assets');

    Route::get('account/fixed-asset/get-all-sale-assets/{id}', 'EmployeeController@get_all_sale_assets')->name('get-all-sale-assets');

    Route::post('account/fixed-asset/capital/update', 'EmployeeController@update_capital_asset')->name('update-capital-asset');

    Route::post('account/fixed-asset/depreciate/update', 'EmployeeController@update_depreciate_asset')->name('update-depreciate-asset');

    Route::post('account/fixed-asset/sale/update', 'EmployeeController@update_sale_asset')->name('update-sale-asset');

    Route::get('account/vouchers/get-all-vouchers/{id}', 'EmployeeController@get_all_vouchers')->name('get-all-vouchers');

    Route::post('account/voucher/new', 'EmployeeController@store_voucher')->name('add-new-voucher');

    Route::get('account/voucher/edit/{id}', 'EmployeeController@edit_voucher')->name('edit-voucher');

    Route::post('account/voucher/update', 'EmployeeController@update_voucher')->name('update-voucher');

    Route::get('account/invoice/{id}', 'EmployeeController@account')->name('invoice');

    /**
     * Account Invoice Invoices CRUD Operations Routes
     */
    Route::get('account/invoice/invoices/get-all-invoices/{id}', 'EmployeeController@get_all_invoices')->name('get-all-invoices');

    Route::get('account/invoice/invoices/get-all-items-options', 'EmployeeController@get_all_item_options')->name('get-all-item-options');

    Route::get('account/invoice/invoice/get-customer-info/{id}', 'EmployeeController@get_customer_details')->name('get-customer-details');

    Route::get('account/invoice/invoices/get-all-customer-options', 'EmployeeController@get_all_customer_options')->name('get-all-customer-options');

    Route::post("account/invoice/invoice/customer-address/add", 'EmployeeController@store_customer_address')->name('add-new-customer-address');

    Route::post("account/invoice/invoice/customer-address/update", 'EmployeeController@update_customer_address')->name('update-customer-address');

    Route::get("account/invoice/invoices/show", 'EmployeeController@show_invoice')->name('show-new-invoice');

    Route::post('account/invoice/invoices/new', 'EmployeeController@store_invoice')->name('add-new-invoice');

    Route::get('account/invoice/invoices/edit/{id}', 'EmployeeController@edit_invoice')->name('edit-invoice');

    Route::post('account/invoice/invoices/update', 'EmployeeController@update_invoice')->name('update-invoice');

    Route::post('account/invoice/invoices/destroy', 'EmployeeController@destroy_invoice')->name('destroy-invoice');

    /**
     * Account Invoice Items CRUD Operations Routes
     */
    Route::get('account/invoice/items/get-all-items/{id}', 'EmployeeController@get_all_items')->name('get-all-items');

    Route::post('account/invoice/item/new', 'EmployeeController@store_item')->name('add-new-item');

    Route::get('account/invoice/item/edit/{id}', 'EmployeeController@edit_item')->name('edit-item');

    Route::post('account/invoice/item/update', 'EmployeeController@update_item')->name('update-item');

    Route::post('account/invoice/item/destroy', 'EmployeeController@destroy_item')->name('destroy-item');

    Route::get('account/invoice/item/get-item-options', 'EmployeeController@get_item_options')->name('get-item-options');

    /**
     * Account Invoice Customers CRUD Operations Routes
     */
    Route::get('account/invoice/customers/get-all-customers/{id}', 'EmployeeController@get_all_customers')->name('get-all-customers');

    Route::post('account/invoice/customer/new', 'EmployeeController@store_customer')->name('add-new-customer');

    Route::get('account/invoice/customer/edit/{id}', 'EmployeeController@edit_customer')->name('edit-customer');

    Route::post('account/invoice/customer/update', 'EmployeeController@update_customer')->name('update-customer');

    Route::post('account/invoice/customer/destroy', 'EmployeeController@destroy_customer')->name('destroy-customer');

    /**
     * Account Invoice Suppliers CRUD Operations Routes
     */
    Route::get('account/invoice/suppliers/get-all-suppliers/{id}', 'EmployeeController@get_all_suppliers')->name('get-all-suppliers');

    Route::post('account/invoice/supplier/new', 'EmployeeController@store_supplier')->name('add-new-supplier');

    Route::get('account/invoice/supplier/edit/{id}', 'EmployeeController@edit_supplier')->name('edit-supplier');

    Route::post('account/invoice/supplier/update', 'EmployeeController@update_supplier')->name('update-supplier');

    Route::post('account/invoice/supplier/destroy', 'EmployeeController@destroy_supplier')->name('destroy-supplier');


    Route::get('get-chart-options', 'EmployeeController@get_chart_options');

    Route::get('edit-chart-record/{id}', 'EmployeeController@edit_chart_record');

    Route::get('account/charts-account/get-chart/{id}', 'EmployeeController@get_allchart_details')->name('get-all-chart');

    Route::post('account/charts-account/add', 'EmployeeController@store_accountchart')->name('store-chart');

    Route::get('finance/payable-management/{id}', 'EmployeeController@finance')->name('finance-payable');
    Route::get('finance/receivable-management/{id}', 'EmployeeController@finance')->name('finance-receivable');

    /**
     * 
     * Finance Payable Management Supplier Pay Batch Entry routing starts here
     */
    Route::get('finance/payable-management/supplier-paybatch/get/{id}', 'EmployeeController@get_supp_paybatch');
    Route::get('finance/payable-management/supplier-paybatch/create', 'EmployeeController@show_supp_paybatch')->name('supp-paybatch-show');
    Route::post('finance/payable-management/supplier-paybatch/add', 'EmployeeController@store_supp_paybatch')->name('supp-paybatch-add');
    Route::get('finance/payable-management/supplier-paybatch/edit/{id}', 'EmployeeController@edit_supp_paybatch')->name('supp-paybatch-edit');
    Route::post('finance/payable-management/supplier-paybatch/update', 'EmployeeController@update_supp_paybatch')->name('supp-paybatch-update');

    /**
     * 
     * Finance Sundry Payment Entry routing starts here
     */
    Route::get('finance/payable-management/sundry-payment/get/invoice-no/{id}', 'EmployeeController@get_invoice_no');
    Route::get('finance/payable-management/sundry-payment/get/{id}', 'EmployeeController@get_sundry_payment');
    Route::get('finance/payable-management/sundry-payment/create', 'EmployeeController@show_sundry_payment')->name('sundry-payment-show');
    Route::post('finance/payable-management/sundry-payment/add', 'EmployeeController@store_sundry_payment')->name('sundry-payment-add');
    Route::get('finance/payable-management/sundry-payment/edit/{id}', 'EmployeeController@edit_sundry_payment')->name('sundry-payment-edit');
    Route::post('finance/payable-management/sundry-payment/update', 'EmployeeController@update_sundry_payment')->name('sundry-payment-update');
    /**
     * 
     * Finance Payable management Bank starts here
     */
    Route::get('finance/payable-management/bank/get/{id}', 'EmployeeController@get_banks_info');
    Route::post('finance/payable-management/bank/add', 'EmployeeController@store_bank_info')->name('bank-add');
    Route::get('finance/payable-management/bank/edit/{id}', 'EmployeeController@edit_bank_info')->name('bank-edit');
    Route::post('finance/payable-management/bank/update', 'EmployeeController@update_bank_info')->name('bank-update');

    /**
     * 
     * Finance Contra Entry routing starts here
     */
    Route::get('finance/payable-management/contra-entry/get/{id}', 'EmployeeController@get_contra_entry');
    Route::get('finance/payable-management/contra-entry/create', 'EmployeeController@show_contra_entry')->name('contra-entry-show');
    Route::post('finance/payable-management/contra-entry/add', 'EmployeeController@store_contra_entry')->name('contra-entry-add');
    Route::get('finance/payable-management/contra-entry/edit/{id}', 'EmployeeController@edit_contra_entry')->name('contra-entry-edit');
    Route::post('finance/payable-management/contra-entry/update', 'EmployeeController@update_contra_entry')->name('contra-entry-update');

    /**
     * 
     * Finance Receivable management Customer Direct Entry starts here
     */
    Route::get('finance/receivable-management/cust-dreceipt-entry/get/invoice-no/{id}', 'EmployeeController@get_saleinvoice_no');
    Route::get('finance/receivable-management/cust-dreceipt-entry/get/{id}', 'EmployeeController@get_cust_dreceipt_entry');
    Route::get('finance/receivable-management/cust-dreceipt-entry/create', 'EmployeeController@show_cust_dreceipt_entry')->name('cust-dreceipt-entry-show');
    Route::post('finance/receivable-management/cust-dreceipt-entry/add', 'EmployeeController@store_cust_dreceipt_entry')->name('cust-dreceipt-entry-add');
    Route::get('finance/receivable-management/cust-dreceipt-entry/edit/{id}', 'EmployeeController@edit_cust_dreceipt_entry')->name('cust-dreceipt-entry-edit');
    Route::post('finance/receivable-management/cust-dreceipt-entry/update', 'EmployeeController@update_cust_dreceipt_entry')->name('cust-dreceipt-entry-update');
    /**
     * 
     * Finance Receivable management Sundry receipt Entry starts here
     */
    Route::get('finance/receivable-management/sundry-receipt/get/{id}', 'EmployeeController@get_sundry_receipt');
    Route::get('finance/receivable-management/sundry-receipt/create', 'EmployeeController@show_sundry_receipt')->name('sundry-receipt-show');
    Route::post('finance/receivable-management/sundry-receipt/add', 'EmployeeController@store_sundry_receipt')->name('sundry-receipt-add');
    Route::get('finance/receivable-management/sundry-receipt/edit/{id}', 'EmployeeController@edit_sundry_receipt')->name('sundry-receipt-edit');
    Route::post('finance/receivable-management/sundry-receipt/update', 'EmployeeController@update_sundry_receipt')->name('sundry-receipt-update');

    /**
     * 
     * Settlement Transaction Module routing starts here 
     */

    Route::any("settlement/get-all-transactions", 'EmployeeController@get_transactions_bydate');

    Route::get('settlement/transactions/{id}', 'EmployeeController@adjustment')->name('settlement-transactions');

    Route::get('settlement/add/new', 'EmployeeController@store_adjustment_view')->name('add-new-settlement');

    Route::post('settlement/generate', 'EmployeeController@generate_adjustment')->name('generate-adjustment');

    Route::post('settlement/add', 'EmployeeController@store_adjustment')->name('add-settlement');

    Route::get('settlement/get', 'EmployeeController@get_adjustment_detail');

    Route::post('settlement/proceed-adjustment', 'EmployeeController@proceed_adjustment');

    Route::get('settlement/get-merchants-transactions/{id}', 'EmployeeController@get_merchant_transactions');

    Route::post('settlement/transactions-details', 'EmployeeController@get_transactions_details');

    Route::post('settlement/get-vendor-adjustments', 'EmployeeController@get_vendor_adjustments');

    Route::post('settlement/manage-adjustment', 'EmployeeController@managepay_adjustment');

    Route::post('settlement/get-managepay-adjustments', 'EmployeeController@get_managepay_adjustments');

    Route::post('settlement/download-transaction-data', 'EmployeeController@download_transaction')->name('download-transactiondata');

    Route::post('sales/merchant-download-transaction-data', 'EmployeeController@merchantDownloadTransaction')->name('m-download-transactiondata');

    /**
     * Settlement ChargeBack Dispute Resolution starts here
     */

    Route::get('settlement/cdr/{id}', 'EmployeeController@adjustment')->name('cdr-home');
    Route::get('settlement/chargeback-dispute-refund/get/{id}', 'EmployeeController@get_cdr_info');
    Route::get('settlement/chargeback-dispute-refund/create', 'EmployeeController@show_cdr_info')->name('cdr-show');
    Route::post('settlement/chargeback-dispute-refund/add', 'EmployeeController@store_cdr_info')->name('cdr-add');
    Route::get('settlement/chargeback-dispute-refund/edit/{id}', 'EmployeeController@edit_cdr_info')->name('cdr-edit');
    Route::post('settlement/chargeback-dispute-refund/update', 'EmployeeController@update_cdr_info')->name('cdr-update');

    Route::get('settlement/reports/{id}', 'EmployeeController@adjustment');

    Route::get('settlement/settings/{id}', 'EmployeeController@adjustment');

    Route::get('settlement/brief/{id}', 'EmployeeController@settlementSummary');
    Route::get('settlement/getsummary', 'EmployeeController@getSettlementbrief')->name('getSettlementbrief');


    Route::get('settlement/direct/{id}', 'EmployeeController@DirectSettlement');
    Route::get('settlement/getdirectSettlement', 'EmployeeController@getdirectSettlement')->name('getdirectSettlement');

    Route::get('settlement/account/{id}', 'EmployeeController@AccountSettlement');
    Route::get('settlement/getaccountSettlement', 'EmployeeController@getaccountSettlement')->name('getaccountSettlement');
    Route::post('settlement/get_merchant_settelment_view', 'EmployeeController@get_merchant_settelment_view')->name('get_merchant_settelment_view');

    Route::post('settlement/add_direct_settlement', 'EmployeeController@addDirectSettelment')->name('addDirectSettelment');
    Route::post('settlement/add_account_settlement', 'EmployeeController@addAccountSettelment')->name('addAccountSettelment');


    Route::get('transactions/refunds/{id}', 'EmployeeController@transactionRefunds')->name('transaction-refunds');
    Route::get('refund/getrefunds', 'EmployeeController@getTransactionRefunds')->name('fetch-transaction-refunds');
    Route::any('settlement/transactionRefunddwnld', 'EmployeeController@refund_excel_dwld')->name('transactionRefunddwnld');


    //merchant settlement update
    Route::post('settlement/get_settlement_info', 'EmployeeController@get_settlement_info')->name('get_settlement_info');
    Route::post('settlement/update_settlement_utr', 'EmployeeController@updateSettlementUtr')->name('updateSettlementUtr');
    Route::any('settlement/briefdwnld', 'EmployeeController@settlement_excel_dwld')->name('briefdwnld');


    Route::get('technical/l2-tickets/{id}', 'EmployeeController@technical')->name('technical-payable');

    Route::get('createfaketransactions', 'EmployeeController@createFakeTransactions')->name('createFakeTransactions');

    Route::any('technical/transactions', 'EmployeeController@transactions')->name('transactions');
    Route::get('technical/fetch_transaction_req_res', 'EmployeeController@fetch_transactions_req_res')->name('fetch_transactions_req_res');
    Route::get('technical/searchtransactions', 'EmployeeController@gettransactions')->name('gettransactions');

    Route::get('technical/findvendortransactionstatus', 'EmployeeController@findvendortransactionstatus')->name('findvendortransactionstatus');
    Route::get('technical/updatetransactionstatus', 'EmployeeController@updateTransactionStatus')->name('updateTransactionStatus');

    Route::get('technical/transactionInfo', 'EmployeeController@transactionInfo')->name('transactionInfo');

    Route::get('transactionInfoDetail', 'EmployeeController@transactionInfoDetail')->name('transactionInfoDetail1');

    Route::get('technical/merchant_services', 'EmployeeController@merchantServices')->name('merchantTransactionPermission');
    Route::post('technical/add_merchant_services', 'EmployeeController@addMerchantServices')->name('addMerchantServices');
    Route::post('technical/edit_merchant_services', 'EmployeeController@editMerchantServices')->name('editMerchantServices');

    Route::get('technical/merchant_request_listing', 'EmployeeController@merchantRequestListings')->name('merchantRequestListings');
    Route::post('technical/merchant_request_status_update', 'EmployeeController@merchantRequestStatusUpdate')->name('merchantRequestStatusUpdate');

    Route::post('technical/save_vendor_keys', 'EmployeeController@saveVendorkeys')->name('saveVendorkeys');

    Route::post('technical/delete_vendor_keys', 'EmployeeController@deleteVendorKeys')->name('deleteVendorKeys');

    Route::get('technical/merchantList', 'EmployeeController@merchantListWhenSavingVendor')->name('merchantListWhenSavingVendor');

    Route::get('technical/work-status/{id}', 'EmployeeController@technical')->name('technical-payable');

    Route::get('technical/gst-status/{id}', 'EmployeeController@technical')->name('technical-payable');

    Route::get('networking/network-status/{id}', 'EmployeeController@network')->name('networking-payable');

    /**
     * Technical Menu Routes starts here
     */
    Route::get('technical/get-merchant-charges/{perpage}', 'EmployeeController@get_merchant_charges');
    Route::get('technical/get-apporved-merchants/{perpage}', 'EmployeeController@get_approved_merchants');
    Route::get('technical/get-apporved-merchant-list', 'EmployeeController@get_approved_merchants_list')->name('get_approved_merchants_list');

    Route::get('technical/get-gststatus-merchant-list', 'EmployeeController@get_merchants_gst_status_list')->name('get-gststatus-merchant-list');

    Route::get('technical/get-admin-merchant-report-log', 'EmployeeController@getAdminMerchantReportLog')->name('getAdminMerchantReportLog');
    Route::get('technical/get-admin-daily-report-log', 'EmployeeController@getAdminDailyReportLog')->name('getAdminDailyReportLog');


    Route::post('technical/generatedownloadreport', 'EmployeeController@empReportDownloadlink')->name('generatedownloadreport');

    Route::get('technical/downloadgeneratedreport', 'EmployeeController@generatedReportDownload')->name('generatedReportDownload');

    Route::post('technical/getreportparameter', 'EmployeeController@getreportparameter')->name('getreportparameter');

    Route::get('technical/merchant_list_for_accountant', 'EmployeeController@merchantsListForAccountants')->name('merchantsListForAccountants');
    Route::get('technical/add_merchant_accountant', 'EmployeeController@addMerchantAccountant')->name('formmerchantaccountant');
    Route::post('technical/save_merchant_accountant', 'EmployeeController@saveMerchantAccountant')->name('addmerchantaccountant');
    Route::post('technical/edit_merchant_accountant', 'EmployeeController@editMerchantAccountant')->name('editmerchantaccountant');
    Route::get('technical/merchant_accountants', 'EmployeeController@merchantAccountants')->name('listmerchantaccountant');

    Route::get('technical/make-merchant-live/{id}', 'EmployeeController@make_approved_merchant_live');

    Route::get('technical/call-merchant-gst-status', 'EmployeeController@get_comp_gst_status')->name('get_comp_gst_status');
    Route::get('technical/change-merchant-status/{id}/{status}', 'EmployeeController@change_approved_merchant_status');

    Route::get('technical/initiate_unblock_merchant', 'EmployeeController@initiate_unblock_merchant')->name('initiate_unblock_merchant');
    Route::get('technical/get-merchant-charge/{recordid}', 'EmployeeController@get_merchant_charge');
    Route::get('technical/get-merchant-business-type/{merchantid}', 'EmployeeController@get_merchant_bussinesstype');


    Route::get('technical/merchant_list_for_add_charges', 'EmployeeController@get_merchant_list_for_charge_detail');
    Route::post('technical/merchant-charge/add', 'EmployeeController@addupdate_merchant_charge');
    Route::post('technical/change-merchant-password', 'EmployeeController@changeMerchantPassword');

    Route::get('technical/get-adjustment-charges/{perpage}', 'EmployeeController@get_adjustment_charges');
    Route::post('technical/adjustment-charge/add-update', 'EmployeeController@addupdate_adjustment_charge');
    Route::get('technical/get-adjustment-charge/{perpage}', 'EmployeeController@get_adjustment_charge');

    Route::get('technical/get-merchant-list_routing', 'EmployeeController@get_merchant_list_for_routing')->name('get_merchant_list_for_routing');
    Route::get('technical/get-merchant-routes/{id}', 'EmployeeController@get_merchant_routes');
    Route::get('technical/get-merchant_accountants', 'EmployeeController@getMerchantAccountants')->name("getMerchantAccountant");
    Route::post('technical/add-merchant-route', 'EmployeeController@store_merchant_route');
    Route::get('technical/get-merchant-route/{id}', 'EmployeeController@get_merchant_route');

    Route::get('technical/get_merchant_list_for_usage', 'EmployeeController@get_merchant_list_for_usage');
    Route::get('technical/get-merchant-usages/{id}', 'EmployeeController@get_merchant_usages');
    Route::post('technical/add-merchant-usage', 'EmployeeController@store_merchant_usage')->name('store_merchant_usage');
    Route::get('technical/get-merchant-usage/{id}', 'EmployeeController@get_merchant_usage');

    Route::get('master_setting/I2-master/{id}', 'EmployeeController@masters')->name('masters-settings');
    Route::get('cron_setting/I2-master/{id}', 'EmployeeController@cronSetting')->name('cron-setting');
    Route::get('technical/merchant_blocked/{id}', 'EmployeeController@BlockMerchants')->name('block-merchants');

    Route::get('technical/merchant_blocked_list', 'EmployeeController@merchantBlockedList')->name('merchantBlockedList');

    Route::get('technical/cashfree-getroutes/{perpage}', 'EmployeeController@get_cashfree_route');
    Route::post('technical/cashfree-add-route', 'EmployeeController@add_cashfree_route');
    Route::get('technical/cashfree-edit-route/{id}', 'EmployeeController@edit_cashfree_route')->name('cashfree-route');
    Route::post('technical/cashfree-update-route', 'EmployeeController@update_cashfree_route');

    /**
     * 
     * Support Menu routing starts here
     */

    Route::get('support/client-desk/{id}', 'EmployeeController@support')->name('support-payable');
    Route::post('support/call-list/merchant-support/add', 'EmployeeController@store_merchant_support')->name('add-merchant-support');
    Route::get('support/merchant-status/{id}', 'EmployeeController@support')->name('support-payable');
    Route::get('support/call-list/{id}', 'EmployeeController@support')->name('support-payable');
    Route::get('support/merchant/support-list', 'EmployeeController@get_merchant_support')->name('merchant-support');
    Route::get('support/merchant/status', 'EmployeeController@get_merchant_status')->name('merchant-status');
    Route::post('support/call-list/support/new', 'EmployeeController@store_callsupport')->name('call-support');
    Route::get('support/call-list/support/get', 'EmployeeController@get_callsupport')->name('get-callsupport');
    Route::get('support/merchant/locked-accounts/get', 'EmployeeController@get_merchant_locked_accounts');
    Route::get('support/merchant/unlock-account/{merchantid}', 'EmployeeController@merchant_unlock');

    /**
     * 
     * Master Menu routing starts here
     */
    Route::any('getBusinessCategoryList', 'MasterController@getBusinessCategoryList')->name('getBusinessCategoryList');
    Route::any('getBusinessSubCategoryList', 'MasterController@getBusinessSubCategoryList')->name('getBusinessSubCategoryList');
    Route::any('getBusinessTypeList', 'MasterController@getBusinessTypeList')->name('getBusinessTypeList');
    Route::any('getAccountantList', 'MasterController@getAccountantList')->name('getAccountantList');
    Route::any('getIpwhitelist', 'MasterController@getIpWhitelisted')->name('getIpWhitelist');
    Route::any('getPayoutgIpwhitelist', 'MasterController@getPayoutIpWhitelisted')->name('getPayoutIpWhitelisted');
    Route::any('getSettelmentCronSettingList', 'MasterController@getSettelmentCronSettingList')->name('getSettelmentCronSettingList');
    Route::any('getGstCronSettingList', 'MasterController@getGstCronSettingList')->name('getGstCronSettingList');

    Route::any('getVendorList', 'MasterController@vendorList')->name('vendorList');
    Route::get('change_vendor_recon_status', 'MasterController@changeVendorAcquirerStatus')->name('changeVendorReconStatus');
    Route::get('change_vendor_service_status', 'MasterController@changeVendorServiceStatus')->name('changeVendorServiceStatus');
    Route::post('register_payin_vendor', 'MasterController@registerVendor')->name('register_vendor');

    Route::any('getPayoutVendorList', 'MasterController@payoutvendorList')->name('payoutvendorList');
    Route::get('change_payout_vendor_recon_status', 'MasterController@payoutchangeVendorAcquirerStatus')->name('changePayoutVendorReconStatus');
    Route::get('change_payout_vendor_service_status', 'MasterController@payoutchangeVendorServiceStatus')->name('changePayoutVendorServiceStatus');
    Route::post('register_vendor', 'MasterController@registerPayoutVendor')->name('registerPayoutVendor');

    Route::post('fetchBusinessType', 'MasterController@fetchBusinessType')->name('fetchBusinessType');
    Route::post('updateBusinessType', 'MasterController@updateBusinessType')->name('updateBusinessType');

    Route::post('fetchBusinessCategory', 'MasterController@fetchBusinessCategory')->name('fetchBusinessCategory');
    Route::post('updateBusinessCategory', 'MasterController@updateBusinessCategory')->name('updateBusinessCategory');


    Route::post('fetchBusinessSubCategory', 'MasterController@fetchBusinessSubCategory')->name('fetchBusinessSubCategory');
    Route::post('updateBusinessSubCategory', 'MasterController@updateBusinessSubCategory')->name('updateBusinessSubCategory');


    Route::post('fetchSettelmentCronSetting', 'MasterController@fetchSettelmentCronSetting')->name('fetchSettelmentCronSetting');
    Route::post('updateSettelmentCronSetting', 'MasterController@updateSettelmentCronSetting')->name('updateSettelmentCronSetting');
    Route::post('fetchGstCronSetting', 'MasterController@fetchGstCronSetting')->name('fetchGstCronSetting');
    Route::post('updateGstCronSetting', 'MasterController@updateGstCronSetting')->name('updateGstCronSetting');


    /**
     * 
     * Marketing Menu routing starts here
     */

    Route::get('marketing/offline-marketing/{id}', 'EmployeeController@marketing')->name('marketing-online');
    Route::get('marketing/online-marketing/{id}', 'EmployeeController@marketing')->name('marketing-offline');

    Route::post('marketing/add-post', 'EmployeeController@store_post');
    Route::get('marketing/get-all-posts', 'EmployeeController@get_all_post');
    Route::get('marketing/edit-post/{id}', 'EmployeeController@edit_post');
    Route::post('marketing/update-post', 'EmployeeController@update_post');
    Route::post('marketing/remove-post', 'EmployeeController@remove_post');
    Route::get('marketing/remove-post-image/{imagename}', 'EmployeeController@remove_post_image');

    Route::get('merketing/contact/get/{id}', 'EmployeeController@get_contact_lead');

    Route::get('merketing/subscribe/get/{id}', 'EmployeeController@get_subscribe_list');
    Route::get('merketing/gallery/get/{id}', 'EmployeeController@get_gallery_image');
    Route::post('merketing/gallery/add', 'EmployeeController@store_image');
    Route::get('merketing/gallery/edit/{id}', 'EmployeeController@edit_image');
    Route::get('marketing/remove-gallery-image/{imagename}', 'EmployeeController@remove_gallery_image');
    Route::post('marketing/gallery/update', 'EmployeeController@update_image');

    Route::post('marketing/event/add-post', 'EmployeeController@store_event_post');
    Route::get('marketing/event/get-all-posts', 'EmployeeController@get_all_event_post');
    Route::get('marketing/event/edit-post/{id}', 'EmployeeController@edit_event_post');
    Route::post('marketing/event/update-post', 'EmployeeController@update_event_post');
    Route::post('marketing/event/remove-post', 'EmployeeController@remove_event_post');
    Route::get('marketing/event/remove-post-image/{imagename}', 'EmployeeController@remove_event_post_image');

    Route::post('marketing/csr/add-post', 'EmployeeController@store_csr_post');
    Route::get('marketing/csr/get-all-posts', 'EmployeeController@get_all_csr_post');
    Route::get('marketing/csr/edit-post/{id}', 'EmployeeController@edit_csr_post');
    Route::post('marketing/csr/update-post', 'EmployeeController@update_csr_post');
    Route::post('marketing/csr/remove-post', 'EmployeeController@remove_csr_post');
    Route::get('marketing/csr/remove-post-image/{imagename}', 'EmployeeController@remove_csr_post_image');

    Route::post('marketing/pr/add-post', 'EmployeeController@store_pr_post');
    Route::get('marketing/pr/get-all-posts', 'EmployeeController@get_all_pr_post');
    Route::get('marketing/pr/edit-post/{id}', 'EmployeeController@edit_pr_post');
    Route::post('marketing/pr/update-post', 'EmployeeController@update_pr_post');
    Route::post('marketing/pr/remove-post', 'EmployeeController@remove_pr_post');
    Route::get('marketing/pr/remove-post-image/{imagename}', 'EmployeeController@remove_pr_post_image');

    /**
     * 
     * Sales Menu Routing starts here
     * 
     */

    Route::get('sales/lead-status/{id}', 'EmployeeController@sales')->name('sales-payable');
    Route::post('sales/salesheet/new', 'EmployeeController@store_sale')->name('store-salessheet');
    Route::post('sales/dailysheet/new', 'EmployeeController@store_daily')->name('store-salessheet');
    Route::get('sales/leadsalesheet/get', 'EmployeeController@get_lead_sales')->name('get-leadsale');
    Route::get('sales/dailysalesheet/get', 'EmployeeController@get_daily_sales')->name('get-dailysale');
    Route::get('sales/salesheet/get', 'EmployeeController@get_sales')->name('get-salesheet');
    Route::get('sales/leadsalesheet/edit/{id}', 'EmployeeController@edit_leadsale')->name('edit-leadsale');
    Route::get('sales/dailysalesheet/edit/{id}', 'EmployeeController@edit_dailysale')->name('edit-dailysale');
    Route::get('sales/salesheet/edit/{id}', 'EmployeeController@edit_sales')->name('edit-salessheet');
    Route::post('sales/field-lead-salesheet/get', 'EmployeeController@get_field_lead_sales')->name('get-field-lead-salessheet');
    Route::get('sales/field-daily-salesheet/get', 'EmployeeController@get_field_daily_sales')->name('get-field-daily-salessheet');
    Route::get('sales/field-salesheet/get', 'EmployeeController@get_field_sales')->name('get-fieldsalessheet');

    Route::get('sales/merchant-transactions/{id}', 'EmployeeController@sales')->name('sales-payable');
    Route::post('sales/fieldsalesheet/new', 'EmployeeController@store_fieldsale')->name('store-fieldsalessheet');

    Route::get('sales/field-lead-salesheet/edit/{id}', 'EmployeeController@edit_fieldsales')->name('edit-field-leadsalessheet');
    Route::get('sales/field-daily-salesheet/edit/{id}', 'EmployeeController@edit_fieldsales')->name('edit-field-dailysalessheet');
    Route::get('sales/fieldsalesheet/edit/{id}', 'EmployeeController@edit_fieldsales')->name('edit-fieldsalessheet');

    Route::get('sales/merchant-commercials/{id}', 'EmployeeController@sales')->name('sales-payable');

    Route::get('sales/product-modes/{id}', 'EmployeeController@sales')->name('sales-payable');
    Route::get('sales/merchant-commercials/show/{id}', 'EmployeeController@show_merchant_charges');
    Route::get('sales/transaction-breakup/{merchantid}', 'EmployeeController@get_transaction_breakup');
    Route::get('sales/get/campaiagn/{perpage}', 'EmployeeController@get_campaigns');
    Route::post('sales/campaiagn', 'EmployeeController@campaign');

    //merchant details
    Route::get('merchant-details/view/{id}', 'EmployeeController@show_merchant_details')->name('merchant-details-view');
    Route::post('merchant/get_merchant_info', 'EmployeeController@get_merchant_info')->name('get_merchant_info');

    Route::post('merchant/update_merchant_info', 'EmployeeController@updateMerchantInfo')->name('updateMerchantInfo');


    Route::get('merchant/webhook/{id}', 'EmployeeController@get_merchant_webhook');
    Route::any('merchant/vendorconfig/{id}/{vendor}', 'EmployeeController@get_merchant_vendorconfig')->name('merchant-vendorconfig');

    Route::post('merchant/vendorconfigshow/{id}/{vendor}', 'EmployeeController@show_merchant_vendorconfig')->name('show-merchant-vendorconfig');
    Route::get('merchant/vendorconfigshow/{id}/{vendor}', 'EmployeeController@show_merchant_vendorconfig')->name('show-merchant-vendorconfig');

    Route::post('merchant/reset_merchant_password', 'EmployeeController@reset_merchant_password')->name('reset-merchant-password');





    Route::post('vendor/edit_vendor_keys', 'VendorController@editVendorkeys')->name('editVendorkeys');
    Route::post('vendor/add_vendor_keys', 'VendorController@addVendorkeys')->name('addVendorkeys');

    Route::post('papi/get-api', 'VendorController@get_merchant_api')->name('getMerchantApi');;

    Route::post('papi/details/{id}', 'VendorController@get_api_details')->name('getApiDetails');;

    Route::post('papi/edit/{id}', 'VendorController@update_merchant_api')->name('updateMerchantApi');

    Route::post('papi/add', 'VendorController@store_merchant_api');

    Route::post('poutapi/add_update', 'VendorController@add_newapi_payoutadmin')->name('getPayoutRegenerateapimodal');;
    Route::post('poutapi/get-api', 'VendorController@get_newapi_payoutadmin')->name('getpayoutapimodal');
    Route::get('poutapi/get-api-table', 'EmployeeController@get_payout_api_keys')->name('getpayoutapitable');

    Route::post('merchant/getwebhook', 'EmployeeController@show_merchant_webhook')->name('getMerchantWebhook');

    Route::post('merchant/updatewebhook', 'EmployeeController@store_merchant_webhook')->name('storeMerchantWebhook');
    Route::post('merchant/add_ip', 'MasterController@storeIpWhitelisted')->name('storeIpWhitelisted');
    Route::post('merchant/add_payout_ip', 'MasterController@storePayoutIpWhitelisted')->name('storePayoutIpWhitelisted');

    Route::get('show_merchant_payout_webhook/', 'EmployeeController@show_merchant_payout_webhook')->name('show_merchant_payout_webhook');
    Route::post('add_merchant_payout_webhook/', 'EmployeeController@add_merchant_payout_webhook')->name('add_merchant_payout_webhook');

    Route::get('show_merchant_payout_usage', 'EmployeeController@show_merchant_usage_limit')->name('show_merchant_usage_limit');

    Route::post('edit_merchant_payout_usage', 'EmployeeController@edit_merchant_usage_limit')->name('edit_merchant_usage_limit');
    Route::post('add_merchant_payout_usage', 'EmployeeController@add_merchant_usage_limit')->name('add_merchant_usage_limit');


    Route::post('add_merchant_payout_vendor_mid_keys', 'EmployeeController@add_merchant_payout_vendor_mid_keys')->name('add_merchant_payout_vendor_mid_keys');
    Route::post('delete_merchant_payout_vendor_mid_keys', 'EmployeeController@delete_merchant_payout_vendor_mid_keys')->name('delete_merchant_payout_vendor_mid_keys');

    Route::get('payout_transactions_new', function () {
        return view('employee.payout.payouttransactionsnew');
    });
    /**
     * 
     * Risk Complaince Menu Routing starts here
     * 
     */
    Route::get('risk-complaince/merchant-document/{id}', 'EmployeeController@risk_complaince')->name('merchant-document');
    Route::post('add_merchant/', 'EmployeeController@addmerchant')->name('add_merchant');
    Route::post('validateMerchantMail/', 'EmployeeController@validateMerchantMail')->name('validate_merchant_mail');
    Route::get('get_business_subcategories/', 'EmployeeController@getSubCategory')->name('getSubCategorys');
    Route::post('register_merchant/', 'EmployeeController@registermerchant')->name('register_merchant');
    Route::post('register_accountant/', 'EmployeeController@registerAccountant')->name('register_accountant');
    Route::post('admin-document-submission/', 'EmployeeController@verify_documents')->name('verify_documents');
    Route::get('uploddeddocumentsList/{bid}/{mid}', 'EmployeeController@show_document_form')->name('show_document_form');

    Route::post('agreement-document-submission/', 'EmployeeController@upload_agreement')->name('upload_agreement');
    Route::post('uploddedagreement', 'EmployeeController@show_agreement_document')->name('show_agreement_document');
    Route::get('document-agreement/remove/{file}/{id}/{mid}', 'EmployeeController@document_agreement_remove')->name('document_agreement_remove');

    Route::get('risk-complaince/merchant-document/verify/get-merchant-doc-detail/{perpage}', 'EmployeeController@get_merchant_docs')->name('get-all-merchant-doc-detail');
    Route::get('risk-complaince/merchant-document/verify/create/{id}', 'EmployeeController@show_merchant_docs_status')->name('new-merchant-doc');
    Route::get('risk-complaince/merchant-document/view/{id}', 'EmployeeController@show_merchant_docs')->name('show_merchant_docs');
    Route::post('risk-complaince/merchant-document/verify/new', 'EmployeeController@store_merchant_docs_status')->name('store-merchant-doc-status');
    Route::post('risk-complaince/merchant-document/verify/update', 'EmployeeController@update_merchant_docs_status')->name('update-merchant-doc-status');
    Route::post('risk-complaince/merchant-details/verify/update', 'EmployeeController@update_merchant_details_status')->name('update-merchant-details-status');
    Route::post('risk-complaince/merchant-document/send-report', 'EmployeeController@merchant_docs_report')->name('merchant-doc-report');
    Route::get('risk-complaince/merchant/details/{id}', 'EmployeeController@merchant_detail')->name('merchant-detail');

    Route::get('reseller_manage/', 'EmployeeController@resellerManage')->name('resellerManage');
    Route::get('reseller_list/', 'EmployeeController@resellerList')->name('resellerList');
    Route::post('add_reseller/', 'EmployeeController@addReseller')->name('addReseller');
    Route::get('get_merchants_without_resellers/', 'EmployeeController@getMerchantsWithoutResellers')->name('getMerchantsWithoutResellers');
    Route::post('assign_merchant_to_reseller/', 'EmployeeController@assignMerchantToReseller')->name('assignMerchant');
    Route::get('get_merchant_by_reseller_id/', 'EmployeeController@getMerchantsByResellerId')->name('getMerchantsByResellerId');
    Route::get('unlink_merchant/', 'EmployeeController@unlinkMerchant')->name('unlinkMerchant');
    Route::get('reseller_details/{id}', 'EmployeeController@resellerDetails')->name('resellerDetails');

    Route::post('set_reseller_details', 'EmployeeController@setResellerDetails')->name('setResellerDetails');
    Route::get('change_reseller_status', 'EmployeeController@changeResellerStatus')->name('changeResellerStatus');

    Route::get('reseller_documents/{id}', 'EmployeeController@resellerDocuments')->name('resellerDocuments');
    Route::post('store_reseller_documents', 'EmployeeController@storeResellerDocuments')->name('storeResellerDocuments');

    Route::get('/download/reseller-document/{resellerId}/{file}', function ($resellerId, $file) {

        $path = DB::table('reseller_documents')->where('reseller_id', $resellerId)->first()->{$file};

        return response()->download(storage_path('app/public/' . $path));
    })->name('download-reseller-document');

    Route::get('business_categories_list', 'EmployeeController@businessCategoriesList')->name('businessCategoriesList');
    Route::get('business_subcategory_by_category', 'EmployeeController@businessSubCategoryListByCategory')->name('businessSubCategoryListByCategory');






    Route::post('risk-complaince/merchant/document/upload', 'EmployeeController@merchant_document_upload');
    Route::post('risk-complaince/merchant/document/remove', 'EmployeeController@merchant_document_remove');

    Route::get('risk-complaince/merchant/extra-documents/get/{perpapage}', 'EmployeeController@get_merchant_extdocuments');
    Route::get('risk-complaince/merchant/extra-document/get/{id}', 'EmployeeController@get_merchant_extdocument')->name('extra-document');
    Route::post('risk-complaince/merchant/extra-document/upload', 'EmployeeController@merchant_extdocument_upload');
    Route::get('risk-complaince/merchant/extra-document/download/{file}', function ($file) {
        if (file_exists(storage_path('app/public/merchant/extradocuments/' . $file))) {
            return response()->download(storage_path('app/public/merchant/extradocuments/' . $file));
        } else {
            return redirect()->back();
        }
    })->name('download-extra-doc');

    Route::get('risk-complaince/background-verification/verify/get-merchant-business-details/{id}', 'EmployeeController@get_merchant_business_detail')->name('get-all-merchant-bussdetails');
    Route::get('risk-complaince/background-verification/{id}', 'EmployeeController@risk_complaince')->name('background-check');
    Route::post('risk-complaince/background-verification/verify/get-sub-category', 'EmployeeController@get_business_subcategory');
    Route::get('risk-complaince/background-verification/verify/get-verified-merchants/{perpage}', 'EmployeeController@get_verified_merchant')->name('get-all-verified-merchant');
    Route::get('risk-complaince/background-verification/verify/create', 'EmployeeController@show_merchant_verify')->name('new-verify-merchant');
    Route::post('risk-complaince/background-verification/verify/new', 'EmployeeController@store_merchant_verify')->name('store-verify-merchant');
    Route::get('risk-complaince/background-verification/verify/edit/{id}', 'EmployeeController@edit_merchant_verify')->name('edit-verify-merchant');
    Route::post('risk-complaince/background-verification/verify/update', 'EmployeeController@update_merchant_verify')->name('update-verify-merchant');

    Route::get('risk-complaince/grievence-cell/{id}', 'EmployeeController@risk_complaince')->name('risk-complaince-payable');
    Route::get('risk-complaince/grievence-cell/get/all-cases/{perpage}', 'EmployeeController@get_all_cust_cases')->name('get-all-cases');
    Route::get('risk-complaince/grievence-cell/get/cases-details/{id}', 'EmployeeController@get_case_details')->name('get-case-details');
    Route::post('risk-complaince/grievence-cell/comment/add', 'EmployeeController@customer_comment')->name('add-case-comment');
    Route::post('risk-complaince/grievence-cell/case/update', 'EmployeeController@update_customer_case')->name('case-update');
    Route::get('risk-complaince/banned-products/{id}', 'EmployeeController@risk_complaince')->name('risk-complaince-payable');

    /**
     * 
     * Legal Menu Routing starts here
     * 
     */

    Route::get('legal/customer-case/{id}', 'EmployeeController@legal')->name('legal-payable');
    Route::get('legal/customer-case/get/{id}', 'EmployeeController@get_legal_cases')->name('legal-cases');
    Route::get('legal/customer-case/case/create', 'EmployeeController@show_legal_case')->name('show-legal-case');
    Route::post('legal/customer-case/case/add', 'EmployeeController@store_legal_case')->name('store-legal-case');
    Route::get('legal/customer-case/case/edit', 'EmployeeController@edit_legal_case')->name('edit-legal-case');
    Route::post('legal/customer-case/case/update', 'EmployeeController@update_legal_case')->name('update-legal-case');

    Route::get('legal/capital/{id}', 'EmployeeController@legal')->name('legal-payable');
    Route::get('legal/express-case/{id}', 'EmployeeController@legal')->name('legal-payable');
    Route::get('legal/pos-case/{id}', 'EmployeeController@legal')->name('legal-payable');
    Route::get('legal/wallet-gullak-sanddok/{id}', 'EmployeeController@legal')->name('legal-payable');
    Route::get('legal/credit-card-case/{id}', 'EmployeeController@legal')->name('legal-payable');
    Route::get('legal/ivr-pay-case/{id}', 'EmployeeController@legal')->name('legal-payable');

    /**
     * 
     * HRM Menu Route Code Starts here
     */

    Route::get('hrm/employee-details/{id}', 'EmployeeController@hrm')->name('hrm-payable');
    Route::get('hrm/nda/{id}', 'EmployeeController@hrm')->name('hrm-payable');
    Route::get('hrm/bvf/{id}', 'EmployeeController@hrm')->name('hrm-payable');
    Route::get('hrm/employee-attendance/{id}', 'EmployeeController@hrm')->name('hrm-payable');
    Route::get('hrm/payroll/{id}', 'EmployeeController@hrm')->name('hrm-payable');
    Route::get('hrm/performance-appraisal/{id}', 'EmployeeController@hrm')->name('hrm-payable');
    Route::get('hrm/confidentiality-agreement/{id}', 'EmployeeController@hrm')->name('hrm-payable');
    Route::get('hrm/career/{id}', 'EmployeeController@hrm')->name('hrm-career');

    Route::get('hrm/get-employees', 'EmployeeController@get_all_employees')->name('get.employees');
    Route::get('hrm/employee-accesses/{id}', 'EmployeeController@employeeAccess')->name('employeeAccess');
    Route::post('hrm/edit-employee-accesses/', 'EmployeeController@editemployeeAccess')->name('editemployeeAccess');
    Route::get('hrm/employee-details/edit/{id}', 'EmployeeController@edit_employee')->name('edit.employee');
    Route::post('hrm/get-employees/update', 'EmployeeController@update_employee');
    Route::post('hrm/get-employees/add', 'EmployeeController@store_employee');
    Route::post('hrm/get-employees/delete', 'EmployeeController@delete_employee');

    Route::post('hrm/bvf/add-personal-profile', 'EmployeeController@store_personal');
    Route::post('hrm/bvf/add-contact-details', 'EmployeeController@store_contact_details');
    Route::post('hrm/bvf/add-reference-details', 'EmployeeController@store_reference_details');

    Route::get('hrm/nda/get-nda/{id}', 'EmployeeController@get_employee_nda_doc')->name('nda-file');
    Route::post('hrm/nda/upload-file', 'EmployeeController@upload_nda_form');
    Route::get('hrm/conagree/get-conagree/{id}', 'EmployeeController@get_employee_ca_doc')->name('ca-file');
    Route::post('hrm/ca/upload-file', 'EmployeeController@upload_ca_form');

    Route::get('hrm/payroll/payslip/form', 'EmployeeController@emp_payslip')->name('payslip');
    Route::get('hrm/payroll/payslip/get-form/{id}', 'EmployeeController@emp_payslip_from')->name('payslip-from');
    Route::post('hrm/payroll/payslip/add', 'EmployeeController@store_payslip')->name('add-payslip');
    Route::get('hrm/payroll/payslip/edit/{id}', 'EmployeeController@edit_payslip')->name('edit-payslip');
    Route::get('hrm/payroll/payslip/get', 'EmployeeController@get_payslip')->name('get-payslip');

    Route::get('hrm/career/job/get/{id}', 'EmployeeController@get_job');
    Route::post('hrm/career/job/add', 'EmployeeController@store_job');
    Route::get('hrm/career/job/edit/{id}', 'EmployeeController@edit_job');
    Route::post('hrm/career/job/update', 'EmployeeController@update_job');
    Route::post('hrm/career/job/change-status', 'EmployeeController@update_job_status');

    Route::get('hrm/career/applicant/get/{id}', 'EmployeeController@get_applicants');
    Route::post('hrm/career/applicant/update', 'EmployeeController@update_applicant_status');

    Route::get('/download/applicant/resume/{file}', function ($file = '') {
        return response()->download(public_path('storage/applicants/' . $file));
    });

    /**
     * 
     * Merchanr Menu Route Code Starts here
     */

    Route::get('merchant/transactions/{id}', 'EmployeeController@admin_merchant');
    Route::get('merchant/transaction/methods/{id}', 'EmployeeController@admin_merchant');
    Route::get('merchant/details/{id}', 'EmployeeController@admin_merchant');
    Route::get('merchant/routes/{id}', 'EmployeeController@admin_merchant');
    Route::get('merchant/cases/{id}', 'EmployeeController@admin_merchant');
    Route::get('merchant/adjustments/{id}', 'EmployeeController@admin_merchant');

    Route::post('merchant/no-of-transactions', 'EmployeeController@no_of_transactions');
    Route::post('merchant/transaction-amount', 'EmployeeController@transaction_amount');

    Route::post('merchant/transaction-download', 'EmployeeController@transactionSumDownload')->name('transactionSumDownload');

    Route::get('merchant/get-all-merchants/{perpage}', 'EmployeeController@get_all_merchants');

    Route::get('merchant/get-all-merchants-details', 'EmployeeController@get_all_merchant_details')->name('merchant-details');
    Route::get('merchant/get-all-merchant-cases', 'EmployeeController@get_all_cases');
    Route::get('merchant/get-all-adjustments', 'EmployeeController@get_all_adjustments');

    Route::get('merchant/no-of-paylinks', 'EmployeeController@no_of_paylinks');
    Route::get('merchant/no-of-invoices', 'EmployeeController@no_of_invoices');

    /**
     * 
     * My Account Menu Route Code Starts here
     */

    Route::get('my-account', 'EmployeeController@my_account')->name("my-account");

    Route::post('my-account/personal-details/update', 'EmployeeController@update_mydetails')->name("my-details-update");

    Route::get('add_recon', 'EmployeeController@add_recon')->name("add_recon");
    Route::post('import_recon', 'EmployeeController@import_recon')->name("import_recon");

    Route::get('show_recon/{id}', 'EmployeeController@show_recon_by_file')->name("show_recon_by_file");

    Route::get('show_recon', 'EmployeeController@show_recon')->name("show_recon");
    Route::get('recon_data/{id}', 'EmployeeController@recon_tabledata')->name("recon_tabledata");
    Route::get('recon_files_data', 'EmployeeController@recon_files_data')->name("recon_files_data");


    Route::get('export_recon_excel', 'EmployeeController@exportReconExcel')->name("exportReconExcel");

    Route::get('export_recon_csv', 'EmployeeController@ReconExportCsv')->name("exportReconCsv");


    Route::get('general_setting', 'EmployeeController@get_general_settings')->name("general-setting");

    Route::post('general_setting', 'EmployeeController@update_general_settings')->name("general-setting");

    Route::post('update_logo', 'EmployeeController@update_logo')->name("update-logo");
    Route::post('update_favicon', 'EmployeeController@update_favicon')->name("update-favicon");


    Route::post('my-account/request-password-change', 'EmployeeController@request_password_change')->name("my-password-change");

    Route::post('my-account/verify-email-OTP', 'EmployeeController@verify_emailOTP')->name("verify-emailOTP");

    Route::post('my-account/verify-mobile-OTP', 'EmployeeController@verify_mobileOTP')->name("verify-mobileOTP");

    Route::post('my-account/change-password', 'EmployeeController@change_password')->name("change-password");

    Route::get('merchant/get-login-activities', 'EmployeeController@login_activities');

    Route::get('sms_management', 'EmployeeController@get_sms_management')->name("sms-management");

    Route::post('sms_management', 'EmployeeController@store_sms_management')->name("store-sms-management");

    // SMS Management
    // Sms Api Setting
    Route::post('/sms-management/store', [EmployeeController::class, 'sms_management_store'])->name('sms-api.store');
    Route::get('/sms-management/{id}', [EmployeeController::class, 'sms_management_edit'])->name('sms-api.edit');
    Route::put('/sms-management', [EmployeeController::class, 'sms_management_update'])->name('sms-api.update');
    Route::delete('/sms-management/delete/{id}', [EmployeeController::class, 'sms_management_delete']);
    Route::post('/update-status', [EmployeeController::class, 'updateStatus']);


    // Sms Template
    Route::post('/sms-template/store', [EmployeeController::class, 'sms_template_store'])->name('sms-temp.store');
    Route::get('/sms-template/{id}', [EmployeeController::class, 'sms_template_edit'])->name('sms-temp.edit');
    Route::put('/sms-template', [EmployeeController::class, 'sms_template_update'])->name('sms-temp.update');
    Route::delete('/sms-template/delete/{id}', [EmployeeController::class, 'sms_template_destroy']);
    Route::post('/update-status-temp', [EmployeeController::class, 'updateStatusTemp'])->name('update.temp');
    /**
     * 
     * My Account Menu Route Code Starts here
     */
    Route::get('work-status', 'EmployeeController@show_workstatus')->name("show-status");

    Route::get('work-status/get/{id}', 'EmployeeController@get_workstatus')->name("get-work-status");

    Route::post('work-status/add', 'EmployeeController@store_workstatus')->name("store-work-status");

    Route::get('work-status/edit/{id}', 'EmployeeController@edit_workstatus')->name("edit-work-status");

    Route::post('work-status/update', 'EmployeeController@update_workstatus')->name("update-work-status");

    //S2payments Angular Related Routings

    Route::post('contact-us', 'VerifyController@managepay_contactus');

    Route::get('pagination/{submod}-{perpage}', 'EmployeeController@employee_pagination');

    Route::get('emp/search/{submod}/{searchtext}', 'EmployeeController@employee_search');
});

Route::get('/document-verify/download/merchant-document/{email}/{file}', function ($merchant_email, $file) {
    if (file_exists(storage_path('app/public/merchant/documents/' . $merchant_email . "/" . $file))) {
        return response()->download(storage_path('app/public/merchant/documents/' . $merchant_email . "/" . $file));
    } else {
        return redirect()->back();
    }
});

Route::get('/document-agreement/download/merchant-document/{email}/{file}', function ($merchant_email, $file) {
    if (file_exists(storage_path('app/public/onboarding/agreement/' . $merchant_email . "/" . $file))) {
        return response()->download(storage_path('app/public/onboarding/agreement/' . $merchant_email . "/" . $file));
    } else {
        return redirect()->back();
    }
})->name('admin-download-agreement');

//testing
Route::get('/test', 'MerchantController@graph_success_rate');


Route::group(['prefix' => 'invoice'], function () {
    Route::get('/demo', 'InvoiceController@demo')->name('demo');
    Route::get('/recipt/{id}', 'InvoiceController@recipt')->name('recipt');
});


Route::group(['prefix' => 'kyc'], function () {
    Route::any('/esigndoc/{request_id}', 'KycDetailsController@esigndocument')->name('esigndoc');


    Route::any('/readpdf', 'KycDetailsController@readpdf')->name('readpdf');
});

Route::prefix('reseller')->group(function () {
    Route::get('login', [ResellerController::class, 'showLoginForm'])->name('reseller.login');
    Route::post('login', [ResellerController::class, 'login']);
    Route::post('logout', [ResellerController::class, 'logout'])->name('reseller.logout');

    Route::get('register', [ResellerController::class, 'showRegistrationForm'])->name('reseller.registration');
    Route::post('register', [ResellerController::class, 'mobile_register']);
    Route::post('doRegister', [ResellerController::class, 'register']);

    Route::get('password/reset', [ResellerController::class, 'showLinkRequestForm'])->name('reseller.password.request');
    Route::post('password/email', [ResellerController::class, 'sendResetLinkEmail'])->name('reseller.password.email');
    Route::get('password/reset/{token}', [ResellerController::class, 'showResetForm'])->name('reseller.password.reset');
    Route::post('password/reset', [ResellerController::class, 'reset']);

    // Reseller Dashboard (Authenticated Routes)
    Route::middleware('auth:reseller')->group(function () {
        Route::get('dashboard', [ResellerController::class, 'index'])->name('reseller.dashboard');
        Route::get('dashboardTransactionStats', [ResellerController::class, 'dashboardTransactionStats'])->name('reseller.dashboardTransactionStats');
        Route::get('dashboardTransactionGraph', [ResellerController::class, 'dashboardTransactionGraph'])->name('reseller.dashboardTransactionGraph');
        Route::get('myAccount', [ResellerController::class, 'myProfile'])->name('reseller.account');
        Route::get('myAccount/{id}', [ResellerController::class, 'myProfileTab']);

        Route::get('feedback', [ResellerController::class, 'reseller_feedback']);
        Route::post('feedback/add', [ResellerController::class, 'store_reseller_feedback']);
        Route::get('feedback/get/{perpage}', [ResellerController::class, 'get_reseller_feedback']);

        Route::get('helpSupport', [ResellerController::class, 'reseller_helpsupport']);

        Route::post('update-mydetails', [ResellerController::class, 'update_mydetails'])->name('reseller.update-mydetails');
        Route::post('change-password', [ResellerController::class, 'change_password'])->name('reseller-change-password');

        //Payin
        Route::get('payin/transaction', [ResellerController::class, 'reseller_payin_transaction'])->name('reseller.payin.transaction');
        Route::get('payments/{perpage}', [ResellerController::class, 'payment']);
        Route::get('payin/transaction_list', [ResellerController::class, 'reseller_payin_transaction_list'])->name('reseller.payin.transaction_list');
        Route::get('payin/transaction_report', [ResellerController::class, 'reseller_payin_transaction_report'])->name('reseller.payin.transaction_report');
        Route::any('fetch_transaction_list', [ResellerController::class, 'gettransactionlist'])->name('reseller.fetch_transaction_list');
        Route::any('fetchpayment', [ResellerController::class, 'fetchpayment']);
        Route::post('payin/transaction_report', [ResellerController::class, 'transactionReportData']);

        Route::get('payin/transactions_count', [ResellerController::class, 'reseller_transaction_count_view'])->name('reseller.payin.reseller_transaction_count_view');
        Route::get('payin/get_transactions_count', [ResellerController::class, 'gettransactioncount'])->name('reseller.payin.gettransactioncount');

        Route::get('payin/transactions_count_summary', [ResellerController::class, 'reseller_transaction_count_summary_view'])->name('reseller.payin.reseller_transaction_count_summary_view');
        Route::get('payin/get_transactions_count_summary', [ResellerController::class, 'gettransactioncountSummary'])->name('reseller.payin.gettransactioncountSummary');
        Route::get('payin/get_transactions_counts', [ResellerController::class, 'gettransactioncounts'])->name('reseller.payin.gettransactioncounts');

        Route::get('downloadreport', [ResellerController::class, 'transactionReportDownload'])->name('reseller.downloadreport');
        Route::get('reportlog', [ResellerController::class, 'transactionReportLog']);
        Route::post('getreportResellerparameter', [ResellerController::class, 'getreportResellerparameter'])->name('getreportResellerparameter');

        Route::post('createdownloadreport', [ResellerController::class, 'ReportDownloadlink'])->name('reseller.ReportDownloadlink');

        Route::get('refunds/{perpage}', [ResellerController::class, 'refund']);
        Route::post('refunds', [ResellerController::class, 'refund']);

        Route::get('orders/{perpage}', [ResellerController::class, 'order']);
        Route::post('orders', [ResellerController::class, 'order']);

        Route::get('disputes/{perpage}', [ResellerController::class, 'dispute']);

        Route::post('disputes', [ResellerController::class, 'dispute']);

        Route::get('payin/pagination/{submod}-{perpage}', [ResellerController::class, 'reseller_pagination']);

        Route::any('settlement/summary', [ResellerController::class, 'settlement_summary']);
        Route::get('settlement/settlementsummary', [ResellerController::class, 'getSettlementSummary'])->name('reseller.getSettlementSummary');

        Route::any('settlement/settlementsummarydwnld', [ResellerController::class, 'settlementsummary_dwld'])->name('reseller.settlementsummaryDwnld');

        Route::get('notifications', [ResellerController::class, 'get_notifications']);

        Route::get('messages', [ResellerController::class, 'get_messages']);

        Route::get('reseller-notifications/{perpage}', [ResellerController::class, 'show_notification_table']);

        Route::get('reseller-messages/{perpage}', [ResellerController::class, 'show_message_table']);

        Route::get('notification/update/{id}', [ResellerController::class, 'update_notification']);

        Route::post('support/add', [ResellerController::class, 'store_reseller_support']);
        Route::get('support/get/{perpage}', [ResellerController::class, 'get_reseller_support']);

        Route::get('gstinvoicereport', [ResellerController::class, 'gstinvoicereport']);
        Route::get('gstinvoiceId', [ResellerController::class, 'gstinvoiceId']);

        Route::post('gstinvoicereport', [ResellerController::class, 'gstinvoicereport']);
        Route::post('gstinvoicereportdetails', [ResellerController::class, 'gstinvoicereportdetails']);
        Route::get('/gstdetailExcel/{date}', [ResellerController::class, 'gstdetailExcel'])->name('gstdetailExcelReseller');

        Route::get('transactionInfo', [ResellerController::class, 'transactionInfo'])->name('transactionInfo');
        Route::get('fetch_reseller_report_log', [ResellerController::class, 'getResellerMerchantReportLog'])->name('getResellerMerchantReportLog');

        //payout
        Route::get('payout/dashboard', [ResellerController::class, 'payoutDashboard'])->name('reseller.payout.dashboard');
        Route::get('payout/payoutdashboardTransactionStats', [ResellerController::class, 'payoutdashboardTransactionStats'])->name('reseller.payout.payoutdashboardTransactionStats');
        Route::get('payout/payoutDashboardGraph', [ResellerController::class, 'payoutDashboardGraph'])->name('reseller.payout.payoutDashboardGraph');

        Route::get('payout/transactions', [ResellerController::class, 'payoutTransactions']);
        Route::get('payout/get_payout_transactions', [ResellerController::class, 'getPayouttransactions'])->name('reseller.payout.getPayouttransactions');
        Route::get('payout/payoutTransactionInfo', [ResellerController::class, 'payoutTransactionInfo'])->name('reseller.payout.payoutTransactionInfo');

        Route::get('payout/payout_report', [ResellerController::class, 'payoutReport']);
        Route::get('payout/get_payout_report_log', [ResellerController::class, 'getPayoutReportLog'])->name('reseller.payout.getPayoutReportLog');

        Route::get('payout/payout_transaction_report_download', [ResellerController::class, 'payouttransactionReportDownload'])->name('reseller.payout.payouttransactionReportDownload');
    });
});
