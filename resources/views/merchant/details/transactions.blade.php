<style>
   .rounded-border {
       border: 2px solid black; /* Black border with a thickness of 2px */
       padding: 20px; /* Some padding inside the div */
   }
</style>


<div class="form-container" >
    <form class="form-horizontal" id="view" autocomplete="off">
        <div class="row">
            <div class="modal-body">
                <div class="container-fluid" id="detailsblock">
                    <div class="col-md-12">
                        <div class="box box-primary rounded-border">
                            <div class="box-header with-border transaction-details-block">
                                <h3 class="box-title">TRANSACTION DETAILS</h3>
                            </div>
                            <div class="box-body" style="">
                                @if (!empty($info['transaction_info']->created_date))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Transaction Initiation Time:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ \Carbon\Carbon::parse($info['transaction_info']->created_date)->format('m-d-Y h:i:s A') }}</b>
                                        </div>
                                    </div>
                                @endif

                               

                                @if (!empty($info['transaction_info']->payment_datetime))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Payment Time:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ \Carbon\Carbon::parse( $info['transaction_info']->payment_datetime )->format('m-d-Y h:i:s A') }}  </b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->transaction_gid))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Transaction ID:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <strong class="copy-to-clipboard-text"
                                                id="transaction_id">{{ $info['transaction_info']->transaction_gid }}</strong>&nbsp;&nbsp;&nbsp;<span
                                                title="Copy" onclick="copyToClipboard('transaction_id')"
                                                class="copy_to_clipboard ctc_transaction_id">
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->bank_ref_no))
                                <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                    <div class="col-sm-6 text-right item"
                                        style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        Bank Ref No:</div>
                                    <div class="col-sm-6 text-left item"
                                        style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <strong class="copy-to-clipboard-text"
                                            id="transaction_id">{{ $info['transaction_info']->bank_ref_no }}</strong>&nbsp;&nbsp;&nbsp;<span
                                            title="Copy" onclick="copyToClipboard('transaction_id')"
                                            class="copy_to_clipboard ctc_transaction_id">
                                        </span>
                                    </div>
                                </div>
                            @endif

                                @if (!empty($info['transaction_info']->transaction_status))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Transaction Status:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->transaction_status }}</b>
                                        </div>
                                    </div>
                                @endif

                             

                             
                                @if (!empty($info['transaction_info']->transaction_mode))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Payment Mode:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->transaction_mode}}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->transaction_amount))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Amount Paid By Customer:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->transaction_amount}}</b>
                                        </div>
                                    </div>
                                @endif

                               

                            </div>
                        </div>
                    </div>


                    <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px;">
                        <div class="box box-primary rounded-border">
                            <div class="box-header with-border transaction-details-block">
                                <h3 class="box-title">MERCHANT DETAILS</h3>
                            </div>
                            <div class="box-body" style="">
                                @if (!empty($info['merchant_info']['name']))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Merchant Name:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['merchant_info']['name'] }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['merchant_info']['merchant_gid']))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Merchant ID:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <strong class="copy-to-clipboard-text"
                                                id="merchant_id">{{ $info['merchant_info']['merchant_gid'] }}</strong>&nbsp;&nbsp;&nbsp;<span
                                                title="Copy" onclick="copyToClipboard('merchant_id')"
                                                class="copy_to_clipboard ctc_merchant_id">
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->vendor_transaction_id))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Merchant Order ID:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <strong class="copy-to-clipboard-text"
                                                id="merchant_order_id">{{ $info['transaction_info']->vendor_transaction_id }}</strong>&nbsp;&nbsp;&nbsp;<span
                                                title="Copy" onclick="copyToClipboard('merchant_order_id')"
                                                class="copy_to_clipboard ctc_merchant_order_id"></span>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->udf1))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            UDF 1:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->udf1 }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->udf2))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            UDF 2:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->udf2 }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->udf3))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            UDF 3:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->udf3 }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->udf4))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            UDF 4:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->udf4}}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->udf5))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            UDF 5:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->udf5 }}</b>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="box box-primary rounded-border">
                            <div class="box-header with-border transaction-details-block">
                                <h3 class="box-title">CUSTOMER DETAILS</h3>
                            </div>
                            <div class="box-body" style="">
                                @if (!empty($info['transaction_info']->transaction_username))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer Name:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->transaction_username }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->transaction_email))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer Email:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->transaction_email}}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->transaction_contact))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer Phone No:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->transaction_contact}}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->customer_vpa))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer Vpa:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->customer_vpa }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->merchant_ip) || $info['transaction_info']->merchant_ip === null)
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer IP:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->merchant_ip}}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->merchant_device) && $info['transaction_info']->merchant_device != 'Unknown')
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer Device:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->merchant_device }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (
                                    !empty($info['transaction_info']->merchant_platform) &&
                                        $info['transaction_info']->merchant_platform != 'Unknown')
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer Platform:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->merchant_platform }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->merchant_browser) && $info['transaction_info']->merchant_browser != 'Unknown')
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer Browser:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->merchant_browser }}</b>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($info['transaction_info']->merchant_location))
                                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Customer Location:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b>{{ $info['transaction_info']->merchant_location }}</b>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </form>



</div>
