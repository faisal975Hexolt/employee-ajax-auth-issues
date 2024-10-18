@php

    $vendor_banks = App\RyapayVendorBank::get_vendorbank();

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


    <div class="col-sm-12">
        <h3>Transactions</h3>

        
    </div>

    <div class="row">

        <form id="show-tecnical-transaction-form">
            @csrf
            <div class="row" style="margin-top:15px;">
                <div class="col-sm-12 mb-5">
                    <div class="col-sm-4">
                        <input type="text" class="searchFilter" name="datetimes" id="datetimes"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                        <input type="hidden" name="trans_from_date" value="">
                        <input type="hidden" name="trans_to_date" value="">
                    </div>
                    <div class="col-sm-4">
                        <select id="listmerchant" name="merchant_filter" class="form-control searchFilter">
                            <option value="">All Merchants</option>
                            @foreach (get_merchnat_list() as $merchant)
                                <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <select id="liststatus" name="status_filter" class="form-control searchFilter">
                            <option value="">All</option>
                            @foreach (get_transaction_status() as $status)
                                <option value="{{ $status }}">{{ ucwords($status) }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <div class="row" style="margin-top:15px;">
                <div class="col-sm-12 mb-5">
                    <div class="col-sm-4 mb-5">
                        <div>
                            <select name="parameter" id="" class="form-control">
                                <option value="acquirer_transaction_id">Acquirer ID</option>
                                <option value="transaction_gid">Transaction ID</option>
                                <option value="vendor_transaction_id">Merchant Order ID</option>
                                <option value="bank_ref_no">UTR NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-5">
                        <div>
                            <input class="form-control" type="text" name="value">
                        </div>
                    </div>
                    <div class="col-sm-4 mb-5">
                        <div>
                            <button class="btn btn-primary btn-sm ">Submit</button>
                        </div>
                    </div>
                </div>
            </div>


        </form>


    </div>





    <div style="margin-top:30px; margin-bottom:100px; ">

        <table class="table table-striped table-bordered " id="technical_transactions">



            <thead>

                <tr>

                    <th>#</th>
                    <th>Transaction Initiation Time</th>
                    <th>Merchant Id</th>
                    <th>Merchant Name</th>
                    <th>Transaction Gid</th>
                    <th>Merchant Order Id</th>
                    <th>Mode</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Amount</th>
                    <th>UTR</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>
            </tbody>

        </table>

    </div>





    <!-- infomodal -->

    <div class="modal fade" id="infomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLongTitle">Transaction Info</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">



                    <table class="table table-striped" style="width:100%">



                        <tr>

                            <th>Status</th>

                            <td class="text-info" id="status"></td>

                        </tr>

                    </table>





                    <div id="infotable" style="display:none;">

                        <table class="table table-striped" style="width:100%">



                            <tr>

                                <th>Amount</th>

                                <td id="amount"></td>

                            </tr>

                            <tr>

                                <th>Date</th>

                                <td id="date"></td>

                            </tr>

                            <tr>

                                <th>Message</th>

                                <td id="message"></td>

                            </tr>

                            <tr>

                                <th>Order Id</th>

                                <td id="orderid"></td>

                            </tr>

                            <tr>

                                <th>Transaction Status</th>

                                <td id="txstatus"></td>

                            </tr>





                        </table>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

    <!-- infomodalends -->

    <!-- reqresmodal -->

    <div class="modal fade" id="viewreqresmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">

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
                        <div>
                            <h3 class="text-success"> Vendor Callback</h3>
                        </div>
                        <div id="vendorCallback"></div>
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
                        <div>
                            <h3 class="text-success"> Merchant Callback</h3>
                        </div>
                        <div id="merchantCallback"></div>
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

    <!-- reqresmodalends -->



    <!-- updatestatusmodal -->

    <div class="modal fade" id="updatestatusmodal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLongTitle">Update Transaction Info</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">



                    <table class="table table-striped" style="width:100%">



                        <tr>

                            <th>Current Status</th>

                            <td class="text-info" id="updatedstatus"></td>

                        </tr>



                        <tr>

                            <th>Transaction Id </th>

                            <td class="text-info" id="transferid"></td>

                        </tr>



                        <tr>

                            <th>Reference Id</th>

                            <td class="text-info" id="referenceid"></td>

                        </tr>

                    </table>





                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

    <!-- updatestatusmodalends -->



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            mytable();
        });

        $(document).on('click', '.transactiongid', function() {

            console.log('%ctransactions.blade.php line:345 transaction gid clicked', 'color: #007acc;',
                'transaction gid clicked');

            var transactionId = (this).innerHTML;

            console.log(transactionId);

            admintransactionDetailsView(transactionId);
            return true;

        })
    </script>



    <script>
        $(document).on('click', '.callinfo', function() {

            console.log('%ctransactions.blade.php line:67 object', 'color: #007acc;', 'cdsaf');

            var merchant = $(this).attr('merchant');

            var mode = $(this).attr('mode');

            var orderid = $(this).attr('orderid');

            console.log('%ctransactions.blade.php line:67 object', 'color: #007acc;', orderid, mode, merchant);

            $('#infomodal').modal('show');



            $.ajax({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                type: "GET",

                dataType: "json",

                url: "{{ url('/') }}/manage/technical/findvendortransactionstatus",

                data: {

                    'transactionmode': mode,

                    'merchantid': merchant,

                    'transactionid': orderid

                },

                success: function(data) {

                    console.log(data);



                    if (data.Found == false) {

                        console.log('%ctransactions.blade.php line:110 ', 'color: #007acc;',
                            'data not foound');

                        $("#status").html('Not Found');

                        $("#infotable").hide();

                    } else {

                        console.log('%ctransactions.blade.php line:110 ', 'color: #007acc;', 'foound');

                        $("#status").html('Found');





                        $("#infotable").show();

                        $("#amount").html(data.data.amount);

                        $("#date").html(data.data.date);

                        $("#message").html(data.data.msg);

                        $("#orderid").html(data.data.order_id);

                        $("#txstatus").html(data.data.status);



                    }





                }

            })

        });
    </script>


    {{-- viewreqres --}}
    <script>
        $(document).on('click', '.viewreqres', function() {
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
                    // Clear previous data
                    $('#acquirer_name').text('');
                    $('#vendorCallbackTime').empty();
                    $('#vendorCallback').empty();
                    $('#vendorReqTime').text('');
                    $('#vendorMessage').val('');
                    $('#vendorReq').empty();
                    $('#vendorRes').empty();
                    $('#merchantCallbackTime').empty();
                    $('#merchantCallback').empty();
                    $('#merchantReqTime').text('');
                    $('#merchantReqMessage').val('');
                    $('#merchantReq').empty();
                    $('#merchantRes').empty();

                    $('#acquirer_name').text(data.acquirer);

                    // Handle multiple vendor callbacks
                    data.vendor_callback.forEach(callback => {
                        var createdDate = new Date(callback.created_date);
                        var formattedDate = createdDate.toLocaleDateString('en-GB') + ' ' +
                            createdDate.toLocaleTimeString('en-GB');
                        var callbackData = JSON.stringify(callback.callback, null, 4);



                        $('#vendorCallback').append(
                            '<div>' +
                            '<h3 class="font-weight-bold">Time</h3>' +
                            '<div>' + formattedDate + '</div>' +
                            '<h3 class="font-weight-bold">Callback</h3>' +
                            '<textarea rows="5" cols="30" readonly>' + callbackData +
                            '</textarea>' +
                            '</div>'
                        );
                    });
                    // Handle vendor request/response
                    var createdvendorReqDate = new Date(data.vendor_reqres.created_date);
                    var formattedvendorReqDate = createdvendorReqDate.toLocaleDateString('en-GB') +
                        ' ' + createdvendorReqDate.toLocaleTimeString('en-GB');

                    $('#vendorReqTime').text('Time: ' + formattedvendorReqDate);
                    $('#vendorMessage').val(data.vendor_reqres.message);
                    $('#vendorReq').text(JSON.stringify(data.vendor_reqres.request, null, 4));
                    $('#vendorRes').val(JSON.stringify(data.vendor_reqres.response, null, 4));

                    // Handle multiple merchant callbacks
                    data.merchant_callback.forEach(callback => {
                        var createdDate = new Date(callback.created_date);
                        var formattedDate = createdDate.toLocaleDateString('en-GB') + ' ' +
                            createdDate.toLocaleTimeString('en-GB');



                        $('#merchantCallback').append(
                            '<div>' +
                            '<h3 class="font-weight-bold">Time</h3>' +
                            '<div>' + formattedDate + '</div>' +
                            '<h3 class="font-weight-bold">Response</h3>' +
                            '<div>' +
                            '<span><strong>Response Code:</strong> ' + callback
                            .responsecode +
                            '</span> | ' +
                            '<span><strong>Response Message:</strong> ' + callback.message +
                            '</span>' +
                            '</div>' +
                            '<h3 class="font-weight-bold">Callback</h3>' +
                            '<textarea rows="5" cols="30" readonly>' + callback.callback +
                            '</textarea>' +
                            '</div>'
                        );
                    });

                    // Handle merchant request/response
                    var createdmerchantReqDate = new Date(data.merchant_reqres.Created_date);
                    var formattedmerchantReqDate = createdmerchantReqDate.toLocaleDateString('en-GB') +
                        ' ' + createdmerchantReqDate.toLocaleTimeString('en-GB');

                    $('#merchantReqTime').text('Time: ' + formattedmerchantReqDate);
                    $('#merchantReqMessage').val(data.merchant_reqres.Message);
                    $('#merchantReq').text(data.merchant_reqres.Request);
                    $('#merchantRes').text(data.merchant_reqres.Response);
                }
            });
        });
    </script>



    <script>
        $(document).on('click', '.updatestatus', function() {



            var orderid = $(this).attr('orderid');



            $('#updatestatusmodal').modal('show');



            $.ajax({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                type: "GET",

                dataType: "json",

                url: '{{ url('/') }}/manage/technical/updatetransactionstatus',

                data: {

                    'orderId': orderid

                },

                success: function(data) {







                    $("#updatedstatus").html(data.txStatus);

                    $("#transferid").html(orderid);

                    $("#referenceid").html(data.referenceId);



                }

            })

        });
    </script>





    <script>
        $(function() {

            var momentTimeFormat = 'DD/MM/YYYY HH:mm:ss';
            var startDate = moment().subtract(0, 'days').startOf('day');
            var endDate = moment().subtract(0, 'days').endOf('day');

            $("#show-tecnical-transaction-form input[name='trans_from_date']").val(startDate.format(
                'YYYY-MM-DD HH:mm:ss'));
            $("#show-tecnical-transaction-form input[name='trans_to_date']").val(endDate.format(
                'YYYY-MM-DD HH:mm:ss'));


            $('#show-tecnical-transaction-form input[name="datetimes"]').daterangepicker({
                dateLimit: {
                    days: 61
                },
                opens: 'right',
                "linkedCalendars": true,
                // maxDate: moment(),
                timePicker: true,
                timePicker24Hour: false,
                timePickerSeconds: true,

                startDate: startDate,
                endDate: endDate,
                locale: {
                    format: momentTimeFormat
                },
                minDate: moment().subtract(365, 'days'),
                maxDate: moment(),
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days')
                        .endOf('day')
                    ],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf(
                        'day')],
                    'Last Month': [moment().subtract(1, 'month').startOf('day').startOf('month'), moment()
                        .subtract(1, 'month').endOf('month').endOf('day')
                    ],
                    // 'This Year': [moment().startOf('year'), moment().endOf('year').endOf('day')],
                    'Last 2 Month': [moment().subtract(2, 'month').startOf('day').startOf('month'), moment()
                        .subtract(1, 'month').endOf('month').endOf('day')
                    ],

                },
            }, function(start, end, label) {


                $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY HH:mm:ss') + ' - ' + end
                    .format('MMMM D, YYYY HH:mm:ss'));

                $("#show-tecnical-transaction-form input[name='trans_from_date']").val(start.format(
                    'YYYY-MM-DD HH:mm:ss'));
                $("#show-tecnical-transaction-form input[name='trans_to_date']").val(end.format(
                    'YYYY-MM-DD HH:mm:ss'));
            });






            $(document).ready(function() {
                // Variable to store the mode
                var currentMode = 'filter';

                var table = $('#technical_transactions').DataTable({
                    processing: true,
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '
                    },
                    serverSide: true,
                    ajax: {
                        url: "{{ route('gettransactions') }}",
                        data: function(d) {
                            // Include the mode in the data sent to the server
                            d.form = getJsonObject($("#show-tecnical-transaction-form")
                                .serializeArray());
                            d.mode = currentMode;
                        }
                    },
                    drawCallback: function(settings) {
                        // $(".loader").hide();
                    },
                    order: [
                        [1, 'desc']
                    ],
                    lengthMenu: [
                        [10, 25, 50, 100, 200, -1],
                        [10, 25, 50, 100, 200, 'All'],
                    ],
                    scrollX: true,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'created_date1',
                            name: 'created_date'
                        },
                        {
                            data: 'merchant_gid',
                            name: 'merchant_gid'
                        },
                        {
                            data: 'merchant_username',
                            name: 'merchant_username'
                        },
                        {
                            data: 'transaction_gid_btn',
                            name: 'transaction_gid',
                            orderable: false
                        },
                        {
                            data: 'orderId',
                            name: 'order_gid',
                            orderable: false
                        },
                        {
                            data: 'transaction_mode',
                            name: 'transaction_mode',
                            orderable: false
                        },
                        {
                            data: 'transaction_username',
                            name: 'transaction_username',
                            orderable: false
                        },
                        {
                            data: 'transaction_email',
                            name: 'transaction_email',
                            orderable: false
                        },
                        {
                            data: 'transaction_contact',
                            name: 'transaction_contact',
                            orderable: false
                        },
                        {
                            data: 'transaction_amount',
                            name: 'transaction_amount',
                            orderable: false
                        },
                        {
                            data: 'bank_ref_no',
                            name: 'bank_ref_no',
                            orderable: false
                        },
                        {
                            data: 'transaction_status',
                            name: 'transaction_status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $('#show-tecnical-transaction-form').on('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission
                    currentMode = 'submit'; // Set mode to 'submit'
                    table.ajax.reload();
                });

                // Update DataTable when filter fields change
                $('.searchFilter').on('change', function() {
                    currentMode = 'filter'; // Set mode to 'filter'
                    table.ajax.reload();
                });
            });




        });
    </script>
@endsection
