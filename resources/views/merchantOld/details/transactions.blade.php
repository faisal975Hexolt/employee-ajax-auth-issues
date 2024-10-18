 <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  -->

<style>
 

#detailsblock .box.box-primary {
    min-height: 273px;
    border-top: ridge;
    padding-top: 15px;
}


.headerColor {
   background-color:#e5eff1 !important;
   color:#333 !important;
   border-color:#fff;
   height:46px;
}

.hcolor {
   background-color:#fafafa  !important;
}

.padbox{
   padding-top: 15px;
}

.padh3{
   padding-top: 12px;
    padding-left: 12px;
}



   </style>


  <div class="modal-body">

   <div class="container-fluid" id="detailsblock">
         <div class="col-md-6">
            <div class="box box-primary borderColor" style="border-top-color:#3c8dbc;">
               <div class="box-header with-border transaction-details-block">
                  <h4 class="box-title">TRANSACTION DETAILS</h4>
               </div>
               <div class="box-body padbox" style="">
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Transaction Initiation Time:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{\Carbon\Carbon::parse($info['transaction_info']['created_date'])->format('M d, Y H:m:s')}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Transaction ID:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><strong class="copy-to-clipboard-text" id="transaction_id">{{$info['transaction_info']['transaction_gid']}}</strong>&nbsp;&nbsp;&nbsp;<span title="Copy" onclick="copyToClipboard('transaction_id')" class="copy_to_clipboard ctc_transaction_id"><i class="fa fa-clipboard copy-to-clipboard-icon" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Copy to clipboard"></i></span></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Transaction Status:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['transaction_status']}}</b></div>
                  </div>
               <!--  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Transaction Response Code:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b></b></div>
                  </div> -->
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Transaction Sequence ID:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><strong class="copy-to-clipboard-text" id="transaction_sequence_id">SPAY-{{$info['transaction_info']['id']}}</strong>&nbsp;&nbsp;&nbsp;<span title="Copy" onclick="copyToClipboard('transaction_sequence_id')" class="copy_to_clipboard ctc_transaction_sequence_id"><i class="fa fa-clipboard copy-to-clipboard-icon" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Copy to clipboard"></i></span></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Pg Payment ID:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['vendor_transaction_id']}}</b></div>
                  </div>
               <!--  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Tran Parq Id:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b></b></div>
                  </div> -->
               
                  <!-- <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Is S2S Response Sent:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>Yes</b></div>
                  </div> -->
               </div>
            </div>
         </div>
          <div class="col-md-6">
             <div class="box box-primary borderColor" style="border-top-color:#3c8dbc;">
            <div class="box-header with-border transaction-details-block">
               <h4 class="box-title">MERCHANT SPECIFIC DETAILS<h4>
            </div>
            <div class="box-body padbox">
               {{-- <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Merchant Name:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['merchant_info']['name']}}</b></div>
               </div>
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Merchant ID:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><strong class="copy-to-clipboard-text" id="merchant_id">{{$info['merchant_info']['merchant_gid']}}</strong>&nbsp;&nbsp;&nbsp;<span title="Copy" onclick="copyToClipboard('merchant_id')" class="copy_to_clipboard ctc_merchant_id"><i class="fa fa-clipboard copy-to-clipboard-icon" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Copy to clipboard"></i></span></div>
               </div>
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Merchant Order ID:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><strong class="copy-to-clipboard-text" id="merchant_order_id">{{$info['transaction_info']['udf1']}}</strong>&nbsp;&nbsp;&nbsp;<span title="Copy" onclick="copyToClipboard('merchant_order_id')" class="copy_to_clipboard ctc_merchant_order_id"><i class="fa fa-clipboard copy-to-clipboard-icon" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Copy to clipboard"></i></span></div>
               </div> --}}
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Merchant Currency:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>INR</b></div>
               </div>
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">UDF 1:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['udf1']}}</b></div>
               </div>
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">UDF 2:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['udf2']}}</b></div>
               </div>
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">UDF 3:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['udf3']}}</b></div>
               </div>
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">UDF 4:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['udf4']}}</b></div>
               </div>
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">UDF 5:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['udf5']}}</b></div>
               </div>
               <div class="row" style="margin: 0 1%;">
                  <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Purpose Of Payment:</div>
                  <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b></b></div>
               </div>
            </div>
         </div>
       </div>
             

     
         <div class="col-md-6">
            <div class="box box-primary" style="border-top-color:#3c8dbc;">
               <div class="box-header with-border transaction-details-block">
                  <h4 class="box-title">PAYMENT DETAILS</h4>
               </div>
               <div class="box-body padbox" style="">
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Payment Mode:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['transaction_mode']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Transaction Type:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['transaction_type']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Payment Channel:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>S2pay</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Amount Requested:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>₹ {{$info['transaction_info']['transaction_amount']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Amount Paid By Customer:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>₹ {{$info['transaction_info']['transaction_amount']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">UPI Id:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{get_transaction_upiId($info['transaction_info'])}}</b></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="box box-primary" style="border-top-color:#3c8dbc;">
               <div class="box-header with-border transaction-details-block">
                  <h4 class="box-title">CUSTOMER DETAILS</h4>
               </div>
               <div class="box-body padbox" style="">
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Customer Name:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['transaction_username']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Customer Phone No:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['transaction_contact']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Customer Email:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['transaction_email']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Customer IP:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['merchant_ip']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Customer Device:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b> {{$info['transaction_info']['merchant_device']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Customer Platform:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['merchant_platform']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Customer Browser:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['merchant_browser']}}</b></div>
                  </div>
                  <div class="row" style="margin: 0 1%;">
                     <div class="col-sm-6 text-right item" style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">Customer Location:</div>
                     <div class="col-sm-6 text-left item" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>{{$info['transaction_info']['merchant_location']}}</b></div>
                  </div>
               </div>
            </div>
         </div>
   
   </div>
               </br>
   <div class="container-fluid " id="logsblock">
      <div class="col-md-12">
      <div class="box box-default" >
       <div class="box-heading headerColor"><h4 class="padh3">ACTIONS LOG</h4></div>
         <div class="panel-body" style="background-color:#fff;" >   
            
            <!-- </div>
            <div class="box-body" style=""> -->
              <div class="table-responsive">
                     <table class="table table-striped" >
                        <thead >
                           <tr>
                              <th class="text-center hcolor">Tran Order ID</th>
                              <th class="text-center hcolor">Tran ID</th>
                              <th class="text-center hcolor">Bank Ref No</th>
                              <th class="text-center hcolor">Action</th>
                              <th class="text-center hcolor">Amount</th>
                              <th class="text-center hcolor">Status</th>
                              <th class="text-center hcolor">Requested Time</th>
                              <th class="text-center hcolor">Completed Time</th>
                             
                           </tr>
                        </thead>
                        <tbody id="logbody">
                           <tr>
                              <td class="text-center">{{$info['transaction_info']['order']['order_gid']}}</td>
                              <td class="text-center">{{$info['transaction_info']['system_reference_number']?? $info['transaction_info']['transaction_gid']}}</td>
                              <td class="text-center">{{$info['transaction_info']['bank_ref_no']}}</td>
                              <td class="text-center">Sale</td>
                              <td class="text-center">₹ {{$info['transaction_info']['transaction_amount']}}</td>
                              <td class="text-center">{{$info['transaction_info']['transaction_status']}}</td>
                              <td class="text-center">{{\Carbon\Carbon::parse($info['transaction_info']['created_date'])->format('M d, Y H:m:s')}}</td>
                              <td class="text-center">{{\Carbon\Carbon::parse($info['transaction_info']['created_date'])->format('M d, Y H:m:s')}}</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      <div class="col-md-12" style="display: none;">
         <div class="box box-primary box-solid">
            <div class="box-header with-border">
               <h3 class="box-title">SETTLEMENT LOG</h3>
            </div>
            <div class="box-body" style="">
               <div class="">
                  <div class="table-responsive" id="settlement-log-datatable" style="display: none;">
                     <table class="table table-striped">
                        <thead style="background-color:#f5f5f5;">
                           <tr>
                              <th class="text-center">Transaction ID</th>
                              <th class="text-center">Transaction Qualifier</th>
                              <th class="text-center">Settlement Qualifier</th>
                              <th class="text-center">Amount Paid by customer</th>
                              <th class="text-center">Settlement Amount</th>
                              <th class="text-center">Bank Settlement Date</th>
                              <th class="text-center">Settlement Bank Reference Number</th>
                              <th class="text-center">Settlement Account Name</th>
                              <th class="text-center">Settlement Account Number</th>
                              <th class="text-center">Settlement IFSC Code</th>
                           </tr>
                        </thead>
                        <tbody id="settlementlogbody"></tbody>
                     </table>
                  </div>
                  <h3 class="text-center font-weight-bold text-md mt-3 mb-3" id="settlement-log-datatable-empty" style="display: block;">
                     There is no settlements for this transaction
                  </h3>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid" id="action-buttons" style="display: none;">
      <div class="col-md-12">
         <div class="box box-primary box-solid">
            <div class="box-header with-border">
               <h3 class="box-title">ACTIONS BUTTONS</h3>
            </div>
            <div class="box-body" style="">
               <div class="nav">
                  <ul class="nav nav-tabs">
                     <li class=""><button type="button" class="btn btn-primary bg-olive" href="#create-chargeback-id" data-toggle="tab" style=" margin:5px; color: white" id="create-chargeback-button-id">Create Chargeback</button></li>
                     <li><button type="button" class="btn btn-primary bg-olive" href="#" data-toggle="tab" style="margin: 5px; color: white; display: none;" id="create-refund-button-id">Create Refund</button></li>
                     <li><button type="button" class="btn btn-primary bg-olive" href="#payment-query-logs" data-toggle="tab" style=" margin:5px; color: white" id="payment-query-logs-id">Payment Queries logs</button></li>
                     <li><button type="button" class="btn btn-primary bg-olive hide" href="#s2s-callback-logs" data-toggle="tab" style=" margin:5px; color: white" id="s2s-callback-logs-id">Browser/S2S Callback Log</button></li>
                     <li><button type="button" class="btn btn-primary bg-olive hide" href="#payment-request-logs" data-toggle="tab" style=" margin:5px; color: white" id="payment-request-logs-id">Payment Request logs</button></li>
                  </ul>
                  <div class="tab-content">
                     <div class="tab-pane fade in" id="create-chargeback-id" style="display: none;">
                        <form method="POST" action="https://mrm.s2pay.in/pgchargebackseditor" accept-charset="UTF-8" class="form-horizontal" id="create-chargback_form">
                           <input name="_token" type="hidden" value="KqAIs5gS3UcHGrkdBX5VGsSNiVCHCLgV1Hoed2WH">
                           <div style="padding-top: 50px" class="form-group has-feedback ">
                              <label for="crbk_request_id" class="control-label col-md-4 required">Chargeback Sl.No :</label>
                              <div class="col-md-6">
                                 <input class="form-control" placeholder="Chargeback Sl.No" name="crbk_request_id" type="text" id="crbk_request_id">
                              </div>
                           </div>
                           <input class="form-control" id="crbk_second_chargeback" name="crbk_second_chargeback" type="hidden" value="n">
                           <div class="form-group has-feedback ">
                              <label for="crbk_chargeback_datetime" class="control-label col-md-4 required">Chargeback Date :</label>
                              <div class="col-md-6">
                                 <input class="form-control single-datepicker" name="crbk_chargeback_datetime" type="text" id="crbk_chargeback_datetime">
                                 <i class="fa fa-calendar form-control-feedback"></i>
                              </div>
                           </div>
                           <div class="form-group has-feedback ">
                              <label for="crbk_chargeback_reason_code" class="control-label col-md-4 required">Chargeback Reason Code :</label>
                              <div class="col-md-6">
                                 <input class="form-control" placeholder="Chargeback Reason Code" name="crbk_chargeback_reason_code" type="text" id="crbk_chargeback_reason_code">
                              </div>
                           </div>
                           <div class="form-group has-feedback ">
                              <label for="crbk_chargeback_description" class="control-label col-md-4 required">Chargeback Description :</label>
                              <div class="col-md-6">
                                 <input class="form-control" placeholder="Chargeback Description" name="crbk_chargeback_description" type="text" id="crbk_chargeback_description">
                              </div>
                           </div>
                           <div class="form-group has-feedback ">
                              <label for="crbk_target_date" class="control-label col-md-4 required">Target Date For Document Submission :</label>
                              <div class="col-md-6">
                                 <input class="form-control single-datepicker" name="crbk_target_date" type="text" id="crbk_target_date">
                                 <i class="fa fa-calendar form-control-feedback"></i>
                              </div>
                           </div>
                           <div class="form-group has-feedback ">
                              <label for="crbk_debit_merchant" class="control-label col-md-4 ">Create Chargeback Settlement Record ?:</label>
                              <div class="col-md-6">
                                 <select class="form-control crbk_debit_merchant" required="" id="crbk_debit_merchant" name="crbk_debit_merchant">
                                    <option value="y">Yes</option>
                                    <option value="n">No</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group has-feedback ">
                              <label for="crbk_source_of_complaint" class="control-label col-md-4 ">Source of Complaint:</label>
                              <div class="col-md-6">
                                 <select class="form-control crbk_source_of_complaint" required="" id="crbk_source_of_complaint" name="crbk_source_of_complaint">
                                    <option value="ACQUIRER">ACQUIRER</option>
                                    <option value="INTERNAL">INTERNAL</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group has-feedback ">
                              <label for="send_mail" class="control-label col-md-4 ">Send Mail</label>
                              <div class="col-md-6">
                                 <select class="form-control send_mail" required="" id="send_mail" name="send_mail">
                                    <option value="y">Yes</option>
                                    <option value="n">No</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group has-feedback ">
                              <label for="crbk_is_dispute" class="control-label col-md-4 ">Chargeback / Dispute :</label>
                              <div class="col-md-6">
                                 <select class="form-control crbk_is_dispute" required="" id="crbk_is_dispute" name="crbk_is_dispute">
                                    <option value="n" selected="selected">Chargeback</option>
                                    <option value="y">Dispute</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group has-feedback ">
                              <label for="crbk_category" class="control-label col-md-4 ">Category :</label>
                              <div class="col-md-6">
                                 <select class="form-control crbk_category" required="" id="crbk_category" name="crbk_category">
                                    <option value="Merchant-Is-Fraud">Merchant-Is-Fraud</option>
                                    <option value="Merchant-Not-Delivered-Service">Merchant-Not-Delivered-Service</option>
                                    <option value="Customer-Unhappy-with-Service-Delivered">Customer-Unhappy-with-Service-Delivered</option>
                                    <option value="Payment-Technical-Issues">Payment-Technical-Issues</option>
                                    <option value="Merchant-Not-Reachable">Merchant-Not-Reachable</option>
                                    <option value="Merchant-Communication-Issues">Merchant-Communication-Issues</option>
                                    <option value="Merchant-seems-Doubtful">Merchant-seems-Doubtful</option>
                                    <option value="Customer-Alert-for-Fraud">Customer-Alert-for-Fraud</option>
                                    <option value="Bank-Alert-for-Fraud">Bank-Alert-for-Fraud</option>
                                    <option value="Police-Alert-for-Fraud">Police-Alert-for-Fraud</option>
                                    <option value="Acquirer-Alert-for-Fraud">Acquirer-Alert-for-Fraud</option>
                                    <option value="Consumer-Misrepresentation">Consumer-Misrepresentation</option>
                                 </select>
                              </div>
                           </div>
                           <input type="hidden" name="crbk_transaction_id" value="TYUPII82241675156">
                           <div class="table-responsive text-center">
                              <button type="submit" class="btn btn-success bg-olive" id="confirm-create-chargeback-button" data-toggle="tooltip" title="" data-original-title="Add">
                              Add
                              </button>
                           </div>
                        </form>
                     </div>
                     <div class="tab-pane fade" id="payment-query-logs">
                        <div id="no_data" style="display: none">
                           <h3>No Data Available</h3>
                        </div>
                        <div class="table-responsive" id="payment-query-logs-div" style="display: none;">
                           <table id="payment-query-logs-table" class="table table-bordered table-striped table-hover "></table>
                        </div>
                        <button type="button" class="btn btn-info bg-olive pull-right" id="get-payment-status-button" data-toggle="tooltip" title="" style="display: none" data-original-title="Get Payment Status">ReRun The Payment Query</button>
                     </div>
                     <div class="tab-pane fade" id="s2s-callback-logs">
                        <div id="no_s2s_data" style="display: none">
                           <h3>No Data Available</h3>
                        </div>
                        <div class="table-responsive" id="s2s-callback-logs-div" style="display: none;">
                           <table id="s2s-callback-logs-table" class="table table-bordered table-striped table-hover "></table>
                        </div>
                        <button type="button" class="btn btn-info pull-right hide" id="send-s2s-response-button" data-toggle="tooltip" title="" data-original-title="Send s2s Response">Send S2S Response</button>
                     </div>
                     <div class="tab-pane fade" id="payment-request-logs">
                        <div id="no_payment_request_data" style="display: none">
                           <h3>No Data Available</h3>
                        </div>
                        <div class="table-responsive" id="payment-request-logs-div" style="display: none;">
                           <table id="payment-request-logs-table" class="table table-bordered table-striped table-hover "></table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>

