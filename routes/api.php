<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('add_beneficiary', 'MerchantApiController@addBeneficiary');

Route::get('get_beneficiary_list', 'MerchantApiController@listBeneficiary');

Route::get('payout_transfer', 'MerchantApiController@payoutTransferMoney');

Route::get('s2payout_transfer', 'MerchantApiController@s2payoutTransferMoney');

Route::get('s2payout_directransfer', 'MerchantApiController@s2payoutDirectTransferMoney');


//s2pay
Route::get('s2pay_balance', 'MerchantApiController@s2payBalance');
Route::get('s2pay_payout_status', 'MerchantApiController@s2payPayoutStatusCheck');



Route::get('payout_status', 'MerchantApiController@retrievePayoutStatus');

Route::get('transaction_status', 'MerchantApiController@transactionStatus');

Route::get('get_report', 'MerchantApiController@exportReport');


Route::get('signatureTest', 'MerchantApiController@getSignature');

Route::get('getIpAddress', 'MerchantApiController@getIpAddress');

Route::any('add_item', 'MerchantApiController@addgItem');
Route::post('add_customer', 'MerchantApiController@addCustomer');
Route::post('add_product', 'MerchantApiController@addProduct');
Route::post('add_paylink', 'MerchantApiController@addPaylink');
Route::post('add_quicklink', 'MerchantApiController@addQuicklink');


Route::any('pythruResponse', 'MerchantApiController@pythruResponse');




Route::any('transactionSettelment', 'CronApiController@transactionSettelment');



Route::any('cronSettlement', 'CronApiController@createSettlementCron');


Route::get('payment_settlement_brief', 'CronApiController@paymentSettlementBrief');

 Route::group(['prefix' => 'kyc'], function () {
      Route::any('esignwebhook', 'CronApiController@storeEsignwebhook');
  });