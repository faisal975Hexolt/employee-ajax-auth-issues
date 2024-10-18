@php

    $vendor_banks = App\RyapayVendorBank::get_vendorbank();

@endphp

@extends('layouts.employeecontent')

@section('employeecontent')
    <style>
        .transactiongid {

            color: #3c8dbc;

            cursor: pointer;

        }
    </style>
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




    <h3>Transactions</h3>



    <div class="row">

        <div class="col-sm-6">

            <input type="text" id="search" class="form-control" placeholder="search ..">

        </div>

        <div class="col-sm-6">
            <input type="text" name="datetimes" id="datetimes"
                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
        </div>
    </div>





    <div style="margin-top:30px; margin-bottom:100px; ">
        <table class="table table-striped table-bordered text-nowrap " id="vendor-table" style="width: 100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction Id</th>
                    <th>Beneficiary Name</th>
                    <th>Beneficiary Email</th>
                    <th>Beneficiary Phone</th>
                    <th>Beneficiary Acc</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>



    <!-- transaction details Modal -->

    <div class="modal fade" id="transactiondetailsmodal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index:11000;">

        <div class="modal-dialog " role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" fdprocessedid="nhe2cq">×</button>
                    <h4 class="modal-title" id="">View Transaction Details</h4>
                </div>

                <div class="modal-body">



                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-primary">
                                <div class="box-header with-border transaction-details-block">
                                    <h3 class="box-title">TRANSACTION DETAILS</h3>
                                </div>
                                <div class="">
                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Transaction Initiation Time:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="trantime"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Transaction ID:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="tranid"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Transaction Status:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="transtatus"></span></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="box box-primary">
                                <div class="box-header with-border transaction-details-block">
                                    <h3 class="box-title">MERCHANT DETAILS</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Merchant Name:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="mname"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Merchant Email:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="memail"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Merchant Contact:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="mcontact"></span></b>
                                        </div>
                                    </div>


                                </div>

                            </div>

                        </div>

                    </div>





                    <div class="row">

                        <div class="col-sm-12">

                            <div class="box box-primary">

                                <div class="box-header with-border transaction-details-block">
                                    <h3 class="box-title">PAYMENT DETAILS</h3>
                                </div>

                                <div class="card-body">

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Payment Mode:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="paymentmode"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Amount:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="tranamount"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            VENDOR:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="tranvendor"></span></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-12">

                            <div class="box box-primary">

                                <div class="box-header with-border transaction-details-block">

                                    <h3 class="box-title">BENEFICIARY DETAILS</h3>

                                </div>

                                <div class="card-body">

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            ID:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="benid"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            NAME:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="benname"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            EMAIL:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="benemail"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            IFSC CODE:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="benifsc"></span></b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            BANK ACCOUNT NO:
                                        </div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            <b><span id="benacc"></span></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

    <!--  transaction details Modalends -->


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





    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>



    <script>
        $(document).ready(function() {
            var table; // Declare the table variable

            function initializeDataTable(startDate, endDate) {
                return $('#vendor-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
                    "ajax": {
                        "url": "{{ route('getPayouttransactions') }}",
                        "type": "GET",
                        "data": function(d) {
                            d.search = $('#search').val();
                            d.startdate = startDate;
                            d.enddate = endDate;
                        }
                    },
                    "columns": [{
                            "data": null,
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            "data": "orderId",
                            "createdCell": function(td, cellData, rowData, row, col) {
                                $(td).addClass('transactiongid');
                            }
                        },
                        {
                            "data": "ben_name"
                        },
                        {
                            "data": "ben_email"
                        },
                        {
                            "data": "ben_phone"
                        },
                        {
                            "data": "ben_bank_acc"
                        },
                        {
                            "data": "amount"
                        },
                        {
                            "data": "status"
                        },
                        {
                            "data": "created_at"
                        },
                        {
                            "data": null,
                            "render": function(data, type, row, meta) {
                                return '<button class="viewreqres" orderid="' + row.orderId +
                                    '">View</button>';
                            }
                        }
                    ]
                });
            }

            function reloadDataTable(startDate, endDate) {
                if ($.fn.DataTable.isDataTable('#vendor-table')) {
                    $('#vendor-table').DataTable().destroy();
                }
                table = initializeDataTable(startDate, endDate);
            }

            $(function() {
                var start = moment().subtract(60, 'days');
                var end = moment();

                function cb(start, end) {
                    $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end
                        .format('MMMM D, YYYY'));
                    var search = $('#search').val();
                    reloadDataTable(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                    console.log(search, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                }

                $('input[name="datetimes"]').daterangepicker({
                    startDate: start,
                    endDate: end,
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment()
                            .subtract(1, 'month').endOf('month')
                        ],
                        'This Year': [moment().startOf('year'), moment().endOf('year')]
                    }
                }, cb);

                cb(start, end); // Initial call to set up the DataTable with the default date range

                $('#search').on('keyup', function() {
                    if (table) {
                        table.ajax.reload(); // Reload DataTable
                    }
                });
            });
        });
    </script>



    <script>
        $(document).on('click', '.transactiongid', function() {

            console.log('%ctransactions.blade.php line:345 transaction gid clicked', 'color: #007acc;',
                'transaction gid clicked');

            $('#transactiondetailsmodal').modal('show');

            var transactionId = (this).innerHTML;

            console.log(transactionId);



            $.ajax({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                type: "GET",

                dataType: "json",

                url: "{{ url('/') }}/manage/payout_transaction_info",

                data: {

                    'transferId': transactionId,



                },

                success: function(data) {

                    console.log(data);



                    $('#mname').html(data.data.merchant_info.name);

                    $('#memail').html(data.data.merchant_info.email);

                    $('#mcontact').html(data.data.merchant_info.mobile_no);





                    $('#trantime').html(data.data.transaction_info.created_at);

                    $('#tranid').html(data.data.transaction_info.transfer_id);

                    $('#transtatus').html(data.data.transaction_info.status);

                    $('#tranvendor').html(data.data.transaction_info.vendor);



                    $('#paymentmode').html(data.data.transaction_info.transfer_mode);

                    $('#tranamount').html(data.data.transaction_info.amount);





                    $('#benid').html(data.data.transaction_info.ben_id);

                    $('#benname').html(data.data.transaction_info.ben_name);

                    $('#benemail').html(data.data.transaction_info.ben_email);

                    $('#benifsc').html(data.data.transaction_info.ben_ifsc);

                    $('#benacc').html(data.data.transaction_info.ben_bank_acc);







                }

            })

        })
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
                url: "{{ route('fetch_payouttransactions_req_res') }}",
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
                            '<h3 class="font-weight-bold">Callback</h3>' +
                            '<textarea rows="5" cols="30" readonly>' + callback.callback +
                            '</textarea>' +
                            '</div>'
                        );
                    });

                    // Handle merchant request/response
                    var createdmerchantReqDate = new Date(data.merchant_reqres.created_date);
                    var formattedmerchantReqDate = createdmerchantReqDate.toLocaleDateString('en-GB') +
                        ' ' + createdmerchantReqDate.toLocaleTimeString('en-GB');

                    $('#merchantReqTime').text('Time: ' + formattedmerchantReqDate);
                    $('#merchantReqMessage').val(data.merchant_reqres.message);
                    $('#merchantReq').text(data.merchant_reqres.request);
                    $('#merchantRes').text(data.merchant_reqres.response);
                }
            });
        });
    </script>
@endsection
