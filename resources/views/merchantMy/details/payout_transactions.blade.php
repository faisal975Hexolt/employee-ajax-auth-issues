<div class="form-container">

                                               

<form class="form-horizontal" id="view" autocomplete="off">

 <div class="row">


    <div class="container-fluid" id="detailsblock1">

    <div class="col-md-6">
   <div class="box box-primary">
      <div class="box-header with-border disbursement-details-block">
         <h3 class="box-title">DISBURSEMENT DETAILS</h3>
      </div>
      <div class="box-body" style="">
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Transaction Date:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{$info['transaction_info']['created_at']}}</b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Transaction ID:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><strong class="copy-to-clipboard-text" id="transaction_id">
                 {{$info['transaction_info']['system_reference_number']?? $info['transaction_info']['transfer_id']}}
             </strong>&nbsp;&nbsp;&nbsp;<span title="Copy" onclick="copyToClipboard('transaction_id')" class="copy_to_clipboard ctc_transaction_id"><i class="fa fa-clipboard copy-to-clipboard-icon" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Copy to clipboard"></i></span></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Transaction Status:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>
                {{$info['transaction_info']['status']}}
            </b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Bank Reference No:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b></b></div>
         </div>
      </div>
   </div>
</div>
<div class="col-md-6">
   <div class="box box-primary">
      <div class="box-header with-border disbursement-details-block">
         <h3 class="box-title">MERCHANT SPECIFIC DETAILS</h3>
      </div>
      <div class="box-body" style="">
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Merchant Name:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>
                {{$info['merchant_info']['name']}}
            </b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Merchant ID:</div>
              <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><strong class="copy-to-clipboard-text" id="merchant_id">{{$info['merchant_info']['merchant_gid']}}</strong>&nbsp;&nbsp;&nbsp;<span title="Copy" onclick="copyToClipboard('merchant_id')" class="copy_to_clipboard ctc_merchant_id"><i class="fa fa-clipboard copy-to-clipboard-icon" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Copy to clipboard"></i></span></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Merchant Order ID:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;">
                <strong class="copy-to-clipboard-text" id="merchant_order_id">
                {{$info['transaction_info']['transfer_id']}}
            </strong>&nbsp;&nbsp;&nbsp;<span title="Copy" onclick="copyToClipboard('merchant_order_id')" class="copy_to_clipboard ctc_merchant_order_id"><i class="fa fa-clipboard copy-to-clipboard-icon" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Copy to clipboard"></i></span></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Merchant Currency:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>INR</b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Merchant IP:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>XX</b></div>
         </div>
      </div>
   </div>
</div>

<div class="col-md-6">
   <div class="box box-primary">
      <div class="box-header with-border disbursement-details-block">
         <h3 class="box-title">PAYMENT DETAILS</h3>
      </div>
      <div class="box-body" style="">
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Payment Mode:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{$info['transaction_info']['transfer_mode']}}</b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Amount Requested:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{$info['transaction_info']['amount']}}</b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Amount Paid By Customer:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{$info['transaction_info']['amount']}}</b></div>
         </div>

         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Vendor:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{ get_vendor_name($info['transaction_info']['vendor'])}}</b></div>
         </div>
      </div>
   </div>
</div>
<div class="col-md-6">
   <div class="box box-primary">
      <div class="box-header with-border disbursement-details-block">
         <h3 class="box-title">BANK ACCOUNT DETAILS</h3>
      </div>
      <div class="box-body" style="">
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Bank Account Name:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{$info['transaction_info']['ben_name']}}</b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Bank Account No:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{$info['transaction_info']['ben_bank_acc']}}</b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Bank IFSC Code:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;">
                <b>{{$info['transaction_info']['ben_ifsc']}}</b>
            </div>
         </div>
      </div>
   </div>
</div>



<div class="col-md-6">
   <div class="box box-primary">
      <div class="box-header with-border disbursement-details-block">
         <h3 class="box-title">ACQUIRER ACCOUNT DETAILS</h3>
      </div>
      <div class="box-body" style="">
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Acquirer:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{$info['transaction_info']['ben_bank_name']}}</b></div>
         </div>
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Account ID:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><strong class="copy-to-clipboard-text" id="account_id">S2PAY</strong>&nbsp;&nbsp;&nbsp;<span title="Copy" onclick="copyToClipboard('account_id')" class="copy_to_clipboard ctc_account_id"><i class="fa fa-clipboard copy-to-clipboard-icon" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Copy to clipboard"></i></span></div>
         </div>
      </div>
   </div>
</div>


<div class="col-md-6">
   <div class="box box-primary">
      <div class="box-header with-border disbursement-details-block">
         <h3 class="box-title">BENEFICIARY DETAILS</h3>
      </div>
      <div class="box-body" style="">
         <div class="row" style="margin: 0 1%;">
            <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px;">Beneficiary ID:</div>
            <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px;"><b>{{$info['transaction_info']['ben_id']}} </b></div>
         </div>
        
      </div>
   </div>
</div>
</div>




<div class="container-fluid" id="action-buttons" style="margin-top:2%;">

                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">ACTIONS BUTTONS</h3>
                            </div>
                            <div class="box-body" style="">
                                <div class="nav">
                                    <ul class="nav nav-tabs">
                            <li><button type="button" href="#s2s-ft-callback-logs" class="btn btn-primary bg-olive" data-toggle="tab" style="margin:5px;color:white;" id="s2s-ft-callback-logs-id">S2S Callback logs</button></li>
                            <li><button type="button" href="#payment-ft-query-logs" class="btn btn-primary bg-olive" data-toggle="tab" style="margin:5px;color:white;" id="payment-ft-query-logs-id">Payment Query logs</button></li>
                            <li><button type="button" href="#payment-ft-request-logs" class="btn btn-primary bg-olive" data-toggle="tab" style="margin:5px;color:white;" id="payment-ft-request-logs-id">Payment Request logs</button></li>
                             </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade" id="s2s-ft-callback-logs">
                                            <div id="no_s2s_data1" style="display: none">
                                                <h3>No Data Available</h3>
                                                        <button type="button" class="btn btn-info pull-right" id="send-s2s-fund-transfer-response-button" data-toggle="tooltip" title="" data-original-title="Send s2s Response">Send S2S Response</button>
                                                </div>
                                            <div class="table-responsive" id="s2s-ft-callback-logs-div" style="display: none;">
                                                <table id="s2s-ft-callback-logs-table" class="table table-bordered table-striped table-hover "></table>
                                                      <button type="button" class="btn btn-info pull-right" id="send-s2s-fund-transfer-response-button1" data-toggle="tooltip" title="" data-original-title="Send s2s Response">Send S2S Response</button>
                                                </div>
                                        </div>
                                        <div class="tab-pane fade" id="payment-ft-query-logs">
                                            <div id="no_data1" style="display: none">
                                                <h3>No Data Available</h3>
                                            </div>
                                            <div class="table-responsive" id="payment-ft-query-logs-div" style="display: none;">
                                                <table id="payment-ft-query-logs-table" class="table table-bordered table-striped table-hover "></table>
                                            </div>
                                            
                                                <button type="button" class="btn btn-info pull-right" id="get-ft-payment-status-button" data-toggle="tooltip" title="" style="display: none" data-original-title="Get Payment Status">ReRun The Payment Query</button>
                                            
                                        </div>
                                        <div class="tab-pane fade" id="payment-ft-request-logs">
                                            <div id="no_data2" style="display: none">
                                                <h3>No Data Available</h3>
                                            </div>
                                            <div class="table-responsive" id="payment-ft-request-logs-div" style="display: none;">
                                                <table id="payment-ft-request-logs-table" class="table table-bordered table-striped table-hover "></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                   

                </div>



              



                                                    

        </div>