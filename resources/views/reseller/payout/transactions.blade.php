@extends('layouts.resellercontent')
@section('resellercontent')
    <style>
        .transactiongid {

            color: #3c8dbc;

            cursor: pointer;

        }

        .table-container {
            overflow-x: auto;
            /* Enables horizontal scrolling */
            width: 100%;
            /* Adjust the width as needed */

            /* Ensure the container has horizontal scrolling */
            scrollbar-width: thick;
            /* Adjust scrollbar width (only supported in Firefox) */
            scrollbar-color: #888 #f0f0f0;
            /* Adjust scrollbar color (only supported in Firefox) */

            /* For Chrome, Safari, and Edge */
            &::-webkit-scrollbar {
                width: 12px;
                /* Adjust width */
                height: 12px;
                /* Adjust height */
            }

            &::-webkit-scrollbar-thumb {
                background-color: #888;
                /* Color of the thumb */
                border-radius: 6px;
                /* Rounded corners */
            }
        }

        table {
            width: 100%;
            /* Ensure the table takes up full width of the container */
            border-collapse: collapse;
            /* Optional: makes table borders look better */
        }

        th,
        td {
            padding: 8px;
            /* Optional: Adds some padding to table cells */
            border: 1px solid #ddd;
            /* Optional: Adds border to table cells */
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

        .box {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .box-header {
            border-bottom: 1px solid #ddd;
            margin-bottom: 5px;
        }

        .box-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .row {
            margin-bottom: 5px;
        }

        .col-sm-6 {
            padding: 5px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .item {
            font-size: 14px;
            line-height: 1.5;
        }

        .item-label {
            font-weight: bold;
        }

        .item-value {
            font-weight: normal;
        }

        .card-body {
            padding: 15px;
        }
    </style>






    <div class="row" style="margin-top: 5%; margin-left: 5%; margin-right: 5%;">

        <div class="col-6 col-lg-6">
            <select name="" class="form-control" id="merchantid">
                <option value="all">All</option>
                @foreach ($merchantList as $merchant)
                    <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-6">
            <input type="text" name="datetimes" id="datetimes"
                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
        </div>
    </div>





    <div style="margin-top:30px; margin-bottom:100px; " class="table-container">
        <table class="table table-striped table-bordered text-nowrap " id="vendor-table" style="width: 100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Initiation Time</th>
                    <th>Transaction Time</th>
                    <th>Transaction Id</th>
                    <th>Merchant Order Id</th>
                    <th>Utr</th>
                    <th>Merchant Id</th>
                    <th>Merchant Name</th>
                    <th>Beneficiary Name</th>
                    <th>Beneficiary Email</th>
                    <th>Beneficiary Phone</th>
                    <th>Beneficiary Acc</th>
                    <th>Beneficiary Ifsc</th>
                    <th>Amount</th>
                    <th>Status</th>
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



                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">TRANSACTION DETAILS</h3>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 item item-label">Transaction Initiation Time:</div>
                            <div class="col-sm-6 item item-value" id="trantime"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 item item-label">Transaction ID:</div>
                            <div class="col-sm-6 item item-value" id="tranid"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 item item-label">Transaction Status:</div>
                            <div class="col-sm-6 item item-value" id="transtatus"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 item item-label">Payment Time:</div>
                            <div class="col-sm-6 item item-value" id="paymenttime"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 item item-label">UTR:</div>
                            <div class="col-sm-6 item item-value" id="utr"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 item item-label">Payment Mode:</div>
                            <div class="col-sm-6 item item-value" id="paymentmode"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 item item-label">Amount Paid By Customer:</div>
                            <div class="col-sm-6 item item-value" id="amountpaid"></div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">MERCHANT DETAILS</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 item item-label">Merchant Name:</div>
                                <div class="col-sm-6 item item-value" id="merchantname"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 item item-label">Merchant ID:</div>
                                <div class="col-sm-6 item item-value" id="merchantgid"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 item item-label">Merchant Order ID:</div>
                                <div class="col-sm-6 item item-value" id="merchantorderid"></div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">BENEFICIARY DETAILS</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 item item-label">Name:</div>
                                <div class="col-sm-6 item item-value" id="benname"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 item item-label">Email:</div>
                                <div class="col-sm-6 item item-value" id="benemail"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 item item-label">Phone:</div>
                                <div class="col-sm-6 item item-value" id="benphone"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 item item-label">IFSC Code:</div>
                                <div class="col-sm-6 item item-value" id="benifsc"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 item item-label">Bank Account No:</div>
                                <div class="col-sm-6 item item-value" id="benacc"></div>
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



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>



    <script>
        $(document).ready(function() {
            var table; // Declare the table variable
            var start = moment().subtract(60, 'days').startOf('day'); // Start at the beginning of the day
            var end = moment().endOf('day'); // End at the end of the day

            function initializeDataTable(startDate, endDate) {
                return $('#vendor-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
                    "ajax": {
                        "url": "{{ route('reseller.payout.getPayouttransactions') }}",
                        "type": "GET",
                        "data": function(d) {
                            d.merchant_id = $('#merchantid').val();
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
                            "data": "created_at",
                            "render": function(data, type, row) {
                                return moment(data).format('DD-MM-YYYY hh:mm:ss A');
                            }
                        },
                        {
                            "data": "payout_transaction_date",
                            "render": function(data, type, row) {
                                return moment(data).format('DD-MM-YYYY hh:mm:ss A');
                            }
                        },
                        {
                            "data": "orderId",
                            "createdCell": function(td, cellData, rowData, row, col) {
                                $(td).addClass('transactiongid');
                            }
                        },
                        {
                            "data": "merchant_orderId"
                        },
                        {
                            "data": "utr"
                        },
                        {
                            "data": "merchant_gid"
                        },
                        {
                            "data": "name"
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
                            "data": "ben_ifsc"
                        },
                        {
                            "data": "amount"
                        },
                        {
                            "data": "status"
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

            function cb(start, end) {
                $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY hh:mm:ss A') + ' - ' + end.format(
                    'MMMM D, YYYY hh:mm:ss A'));
                var search = $('#search').val();
                reloadDataTable(start.format('YYYY-MM-DD HH:mm:ss'), end.format('YYYY-MM-DD HH:mm:ss'));
                console.log(search, start.format('YYYY-MM-DD HH:mm:ss'), end.format('YYYY-MM-DD HH:mm:ss'));
            }

            $(function() {
                $('input[name="datetimes"]').daterangepicker({
                    timePicker: true, // Enable time picker
                    timePickerSeconds: true, // Enable seconds in time picker
                    timePicker24Hour: true, // Use 24-hour format (can be disabled if you prefer AM/PM)
                    startDate: start,
                    endDate: end,
                    locale: {
                        format: 'DD/MM/YYYY HH:mm:ss' // Date and time format with seconds
                    },
                    ranges: {
                        'Today': [moment().startOf('day'), moment().endOf('day')],
                        'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment()
                            .subtract(1, 'days').endOf('day')
                        ],
                        'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf(
                            'day')],
                        'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment()
                            .endOf('day')
                        ],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment()
                            .subtract(1, 'month').endOf('month')
                        ],
                        'This Year': [moment().startOf('year'), moment().endOf('year')]
                    }
                }, cb);

                cb(start, end); // Initial call to set up the DataTable with the default date range and time
            });

            // Reload DataTable when merchant ID changes
            $('#merchantid').on('change', function() {
                console.log('Merchant ID changed');
                reloadDataTable(start.format('YYYY-MM-DD HH:mm:ss'), end.format('YYYY-MM-DD HH:mm:ss'));
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

                url: "{{ url('/') }}/reseller/payout/payoutTransactionInfo",

                data: {

                    'transferId': transactionId,



                },

                success: function(data) {

                    console.log(data);



                    $('#merchantname').html(data.data.merchant_info.name);
                    $('#merchantgid').html(data.data.merchant_info.merchant_gid);
                    $('#merchantorderid').html(data.data.transaction_info.merchant_orderId);

                    $('#trantime').html(data.data.transaction_info.created_at);
                    $('#tranid').html(data.data.transaction_info.orderId);
                    $('#transtatus').html(data.data.transaction_info.status);
                    $('#paymenttime').html(data.data.transaction_info.payout_transaction_date);
                    $('#utr').html(data.data.transaction_info.utr);
                    $('#paymentmode').html(data.data.transaction_info.transfer_type);
                    $('#amountpaid').html(data.data.transaction_info.amount);


                    $('#benid').html(data.data.transaction_info.ben_id);

                    $('#benname').html(data.data.transaction_info.ben_name);

                    $('#benemail').html(data.data.transaction_info.ben_email);

                    $('#benphone').html(data.data.transaction_info.ben_phone);

                    $('#benifsc').html(data.data.transaction_info.ben_ifsc);

                    $('#benacc').html(data.data.transaction_info.ben_bank_acc);







                }

            })

        })
    </script>
@endsection
