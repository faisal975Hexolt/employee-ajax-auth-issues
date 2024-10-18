@php
    use App\User;
    $merchants = User::get_merchant_options();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
    <style>
        textarea {
            width: 100%;
            min-height: 30rem;
            font-family: "Lucida Console", Monaco, monospace;
            line-height: 1.2;
        }

        .card {

            border: thin solid #ccc;

            border-radius: 10px;

            padding: 5px 5px 5px 5px;

            margin: 5px 5px 5px 5px;

        }



        .thinText {

            font-size: 1.125rem;

            line-height: 1.75rem;

        }



        .strongText {

            font-weight: 600;

            letter-spacing: 0.5px;

        }



        .headlineText {

            font-weight: 900;

            letter-spacing: 2.5px;



        }



        .transactiongid {

            color: #3c8dbc;

            cursor: pointer;

        }
    </style>
    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        @if (count($sublinks) > 0)
                            @foreach ($sublinks as $index => $value)
                                @if ($index == 0)
                                    <li class="active"><a data-toggle="tab" class="show-pointer"
                                            data-target="#{{ str_replace(' ', '-', strtolower($value->link_name)) }}">{{ $value->link_name }}</a>
                                    </li>
                                @else
                                    <li><a data-toggle="tab" class="show-pointer"
                                            data-target="#{{ str_replace(' ', '-', strtolower($value->link_name)) }}">{{ $value->link_name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li class="active"><a data-toggle="tab" class="show-pointer"
                                    data-target="#{{ str_replace(' ', '-', strtolower($sublink_name)) }}">{{ $sublink_name }}</a>
                            </li>
                            <li><a data-toggle="tab" class="show-pointer" data-target="#vendor-adjustments">Vendor
                                    Adjustments</a></li>
                            <li><a data-toggle="tab" class="show-pointer"
                                    data-target="#managepay-adjustments">{{ env('APP_NAME') }} Adjustments</a></li>
                        @endif
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        @if (count($sublinks) > 0)
                            @foreach ($sublinks as $index => $value)
                                @if ($index == 0)
                                    <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                        class="tab-pane fade in active">

                                    </div>
                                @else
                                    <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                        class="tab-pane fade">

                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div id="{{ str_replace(' ', '-', strtolower($sublink_name)) }}"
                                class="tab-pane fade in active">
                                <div class="src srct">
                                    <form id="transaction-form">
                                        <input class="form-control" id="trans_date_range" name="trans_date_range"
                                            placeholder="MM/DD/YYYY" type="text" value="">
                                        <input type="hidden" name="trans_from_date" value="">
                                        <input type="hidden" name="trans_to_date" value="">
                                        <input type="hidden" id="transaction-form-perpage" name="perpage" value="10">
                                        <input type="hidden" name="transaction_page" value="transactions">
                                        <input type="hidden" id="transaction-form-ssearch" name="simple_search"
                                            value="">
                                        <input type="hidden" id="transaction-form-search-m" name="searched_merchant_id"
                                            value="">
                                        <i class="fa fa-calendar"></i>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row margin-bottom-lg">
                                            <div class="col-sm-12">
                                                <!-- <a href="{{ route('add-new-settlement') }}" class="btn btn-primary btn-sm pull-right margin-right-md">New Settlement</a>
                                                            <a href="javascript:void(0)" class="btn btn-primary btn-sm pull-right margin-right-md" onclick="bulkSettlement();">Bulk Settlement</a> -->
                                                <div class="col-sm-6">
                                                    <form id="transaction-download-form"
                                                        action="{{ route('download-transactiondata') }}" method="POST"
                                                        role="form">
                                                        <input type="hidden" name="trans_from_date"
                                                            id="input_trans_from_date" class="form-control"
                                                            value="{{ session()->get('fromdate') }}">
                                                        <input type="hidden" name="trans_to_date" id="input_trans_to_date"
                                                            class="form-control" value="{{ session()->get('todate') }}">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="trans_merchant" id="trans_merchant"
                                                            class="form-control" value="0">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-primary btn-sm">Download
                                                            Excel</button>
                                                    </form>
                                                </div>

                                                <div class="col-sm-6">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary btn-sm pull-right margin-right-md "
                                                        id="call-adjustment-modal">Bulk Adjustment</a>
                                                </div>

                                            </div>

                                            <div class="col-sm-12 " style="margin-top:15px;">
                                                <div class="col-6 col-lg-6">
                                                </div>
                                                <div class="col-6 col-lg-6">
                                                    <select name="" class="form-control" id="merchantid"
                                                        onchange="getAllPaymentsByMerchant($(this).val())">


                                                        <option value="all">All Merchants</option>
                                                        @foreach (App\User::get_merchant_lists() as $merchant)
                                                            <option value="{{ $merchant->id }}">
                                                                {{ $merchant->mid . ' : ' . $merchant->merchant_gid }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 " style="margin-top:15px;">
                                                <div class="col-sm-2">
                                                    <select name="page_limit" class="form-control"
                                                        onchange="getAllPayments($(this).val())">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="75">75</option>
                                                        <option value="100">100</option>
                                                        <option value="200">200</option>

                                                    </select>
                                                </div>

                                                <div class="col-sm-4 pull-right margin-right-md">
                                                    <div class="search-box ">

                                                        <input type="search" class="form-control"
                                                            id="emp-transaction-table" placeholder="Search">
                                                        <i class="fa fa-search"></i>

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div id="paginate_alltransaction">

                                        </div>
                                    </div>
                                </div>
                                <!-- Adjustment created modal starts-->
                                <div class="modal" id="adjusttrans-add-response-message-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Vendor Adjustment Response</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Transaction Id</th>
                                                            <th>Adjustment Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="adjustment-response-rows">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Adjustment created modal ends-->

                                <div class="modal" id="adjustment-select-option-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="adjustment-select-form" method="POST" class="form-horizontal"
                                                role="form">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Adjustment</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="adjustment"
                                                                            id="vendor" class="form-control"
                                                                            value="vendor">
                                                                        <span class="cr"><i
                                                                                class="cr-icon fa fa-check"></i></span>
                                                                        Vendor Adjustment
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="adjustment"
                                                                            id="managepay" class="form-control"
                                                                            value="managepay">
                                                                        <span class="cr"><i
                                                                                class="cr-icon fa fa-check"></i></span>
                                                                        S2payment Adjustment
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-6 col-sm-offset-5">
                                                        <button type="submit" class="btn btn-primary btn-sm">Do
                                                            Adjustment</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="vendor-adjustments" class="tab-pane fade in">
                                <div class="src">
                                    <form id="vendor-adjustment-form">
                                        <input class="form-control" id="trans_date_range" name="trans_date_range"
                                            placeholder="MM/DD/YYYY" type="text" value="">
                                        <input type="hidden" name="trans_from_date"
                                            value="{{ session('trans_from_date') }}">
                                        <input type="hidden" name="trans_to_date"
                                            value="{{ session('trans_to_date') }}">
                                        <input type="hidden" name="perpage" value="10">
                                        <input type="hidden" name="transaction_page" value="ryapayadjustment">
                                        <i class="fa fa-calendar"></i>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                                <div class="row margin-bottom-lg">
                                    <div class="col-sm-12">
                                        <a href="javascript:void(0)"
                                            class="btn btn-primary btn-sm pull-right margin-right-md"
                                            onclick="bulkS2paymentAdjustments();">S2payment Adjustment</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="paginate_vendoradjustment">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="managepay-adjustments" class="tab-pane fade in">
                                <div class="src">
                                    <form id="managepay-adjustment">
                                        <input class="form-control" id="trans_date_range" name="trans_date_range"
                                            placeholder="MM/DD/YYYY" type="text" value="">
                                        <input type="hidden" name="trans_from_date"
                                            value="{{ session('trans_from_date') }}">
                                        <input type="hidden" name="trans_to_date"
                                            value="{{ session('trans_to_date') }}">
                                        <input type="hidden" name="perpage" value="10">
                                        <i class="fa fa-calendar"></i>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="paginate_ryapayadjustment">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- Porder created modal starts-->
                    <div id="adjustment-alert-modal" class="modal">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <strong id="adjustment-alert-message"></strong>
                                </div>
                                <div class="modal-footer">
                                    <form>
                                        <input type="submit" class="btn btn-primary btn-sm" value="OK"
                                            onlick="location.refresh();" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Porder created modal ends-->
                    <!-- Porder created modal starts-->
                    <div id="adjustment-alert" class="modal">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <strong id="adjustment-alert-show"></strong>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Porder created modal ends-->



                    <div class="modal" id="managepay-adjustment-add-response-message-modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Vendor Adjustment Response</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Transaction Id</th>
                                                <th>Adjustment Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="managepay-adjustment-response-rows">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <form>
                                        <input type="submit" class="btn btn-primary btn-sm" value="Close"
                                            onlick="location.refresh();" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- reqresmodal -->

    <div class="modal fade" id="viewreqresmodal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLongTitle">Request Response Callback Info</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">


                    <div class="text-center">
                        <h4>Acquirer Name</h4>
                        <h4 id="acquirer_name"></h4>
                    </div>

                    <div class="text-center">
                        <!-- Vendor Callback Section -->
                        <div class="text-center">
                            <div>
                                <h3 class="text-success">Acquirer Callback</h3>
                            </div>
                            <div id="vendorCallbackSection"></div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div>
                            <h3 class="text-success"> Acquirer Request Response</h3>
                        </div>
                        <div>
                            <h3 class="font-weight-bold">Time</h3>
                            <div id="vendorReqTime"></div>

                            <h3 class="font-weight-bold">Message</h3>
                            <div id="vendorMessage"></div>

                            <h3 class="font-weight-bold">Request</h3>
                            <textarea id="vendorReq" rows="5" cols="30" readonly></textarea>

                            <h3 class="font-weight-bold">Response</h3>
                            <textarea id="vendorRes" rows="5" cols="30" readonly></textarea>
                        </div>
                    </div>

                    <div class="text-center">
                        <!-- Merchant Callback Section -->
                        <div class="text-center">
                            <div>
                                <h3 class="text-success">Merchant Callback</h3>
                            </div>
                            <div id="merchantCallbackSection"></div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div>
                            <h3 class="text-success"> Merchant Request Response</h3>
                        </div>
                        <div>
                            <h3 class="font-weight-bold">Time</h3>
                            <div id="merchantReqTime"></div>

                            <h3 class="font-weight-bold">Message</h3>
                            <div id="merchantReqMessage"></div>

                            <h3 class="font-weight-bold">Request</h3>
                            <textarea id="merchantReq" rows="5" cols="30" readonly></textarea>

                            <h3 class="font-weight-bold">Response</h3>
                            <textarea id="merchantRes" rows="5" cols="30" readonly></textarea>



                        </div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(e) {
            //getAdjustmentDetails();

            getMerchantTransactionsByDate();
        });
    </script>

    {{-- viewreqres --}}
    <script>
    $(document).on('click', '.viewreqres', function(e) {
    e.preventDefault();
    var orderid = $(this).attr('orderid');

    $('#viewreqresmodal').modal('show');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        dataType: "json",
        url: "{{ route('fetch_transactions_req_res') }}",
        data: {
            'transaction_id': orderid
        },
        success: function(data) {
            console.log(data);

            // Clear previous data
            $('#vendorCallbackSection').empty();
            $('#vendorReqTime').empty();
            $('#vendorMessage').empty();
            $('#vendorReq').val('');
            $('#vendorRes').val('');
            $('#merchantCallbackSection').empty();
            $('#merchantReqTime').empty();
            $('#merchantReqMessage').empty();
            $('#merchantReq').val('');
            $('#merchantRes').val('');
            $('#acquirer_name').text('');

            $('#acquirer_name').text(data.acquirer);

            // Handle vendor callbacks
            data.vendor_callback.forEach(function(callback) {
                var createdDate = new Date(callback.created_date);
                var formattedDate = createdDate.toLocaleDateString('en-GB') + ' ' + createdDate.toLocaleTimeString('en-GB');
                var callbackData = JSON.stringify(callback.callback, null, 4);

                var vendorCallbackBlock = $('<div>');
                var vendorCallbackTime = $('<div>').text('Time: ' + formattedDate);
                var vendorCallback = $('<textarea>').attr({
                    rows: 5,
                    cols: 30,
                    readonly: true
                }).val(callbackData);

                vendorCallbackBlock.append(vendorCallbackTime);
                vendorCallbackBlock.append(vendorCallback);
                $('#vendorCallbackSection').append(vendorCallbackBlock);
            });

            // Handle vendor request/response
            var createdvendorReqDate = new Date(data.vendor_reqres.created_date);
            var formattedvendorReqDate = createdvendorReqDate.toLocaleDateString('en-GB') + ' ' + createdvendorReqDate.toLocaleTimeString('en-GB');

            $('#vendorReqTime').text('Time: ' + formattedvendorReqDate);
            $('#vendorMessage').text(data.vendor_reqres.message);
            $('#vendorReq').val(JSON.stringify(data.vendor_reqres.request, null, 4));
            $('#vendorRes').val(JSON.stringify(data.vendor_reqres.response, null, 4));

            // Handle merchant callbacks
            data.merchant_callback.forEach(function(callback) {
                var createdDate = new Date(callback.created_date);
                var formattedDate = createdDate.toLocaleDateString('en-GB') + ' ' + createdDate.toLocaleTimeString('en-GB');
                var callbackData = JSON.stringify(callback.callback, null, 4);

                var merchantCallbackBlock = $('<div>');
                var merchantCallbackTime = $('<div>').text('Time: ' + formattedDate);
                var merchantCallback = $('<textarea>').attr({
                    rows: 5,
                    cols: 30,
                    readonly: true
                }).val(callbackData);

                merchantCallbackBlock.append(merchantCallbackTime);
                merchantCallbackBlock.append(merchantCallback);
                $('#merchantCallbackSection').append(merchantCallbackBlock);
            });

            // Handle merchant request/response
            var createdmerchantReqDate = new Date(data.merchant_reqres.Created_date);
            var formattedmerchantReqDate = createdmerchantReqDate.toLocaleDateString('en-GB') + ' ' + createdmerchantReqDate.toLocaleTimeString('en-GB');

            $('#merchantReqTime').text('Time: ' + formattedmerchantReqDate);
            $('#merchantReqMessage').text(data.merchant_reqres.Message);
            $('#merchantReq').val(JSON.stringify(data.merchant_reqres.Request, null, 4));
            $('#merchantRes').val(JSON.stringify(data.merchant_reqres.Response, null, 4));
        }
    });
});

    </script>
@endsection
