@extends('layouts.merchantcontent')

@section('merchantcontent')
    <style>
        .flex-container {

            display: flex;

            flex-wrap: nowrap;



        }



        .flex-container>div {



            width: 400px;

            margin: 10px;

            text-align: left;



        }



        .submitButton {

            margin-top: 2rem;
            float: right;
            margin-right: -6%;

        }

        .margH {
            margin-left: -20px;
            margin-top: 26px;
        }

        .panelW {
            width: 100%;

        }

        .dwnbtn {
            float: right;
            margin-right: 1%;
            margin-top: -11%;
        }
    </style>



    <section id="about-1" class="about-1">
        <div class="container-1">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                    <div class="content-1 pt-4 pt-lg-0">
                        <h3 class="margH">Payout Transaction Report</h3>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- <form method="POST" class="flex-container" action="/merchant/transactionreport"   > -->

    <div class="row panelH">
        <div class="col-sm-12">
            <div class="row" style="margin-top:15px;">
                <div class="col-md-12">
                    <form class="flex-container" id="report_form">
                        {{ csrf_field() }}
                        <div class="col-sm-4">
                            <label for="">Range</label>
                            <input class="form-control transaction_download_report" id="transaction_download_report"
                                readonly name="transaction_download_report" placeholder="MM/DD/YYYY" type="text"
                                value="" />
                            <input type="hidden" class="report_start_date" name="report_start_date" value="">
                            <input type="hidden" class="report_end_date" name="report_end_date" value="">

                            <input type="hidden" name="type" value="transaction_report" />
                            <span class="src">
                                <i class="fa fa-calendar transaction_download_report-cal trareporttopmarg"></i></span>

                        </div>

                        <div class="col-sm-2">

                            <div class="form-group">

                                <label for="">Status</label>
                                <select class="form-control" name="status" id="transaction_status">
                                    <option value="">--select status--</option>
                                    <option value="FAILED">FAILED</option>
                                    <option value="SUCCESS">SUCCESS</option>
                                    <option value="PENDING">PENDING</option>
                                </select>
                            </div>

                        </div>

                        <div class="report_parameter">
                        </div>

                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary dwnbtn"> Download</button>
                </div>
                </form>
            </div>




            <div class="col-sm-12">
                <div style="margin-top:30px; margin-bottom:100px; ">
                    <table class="table table-striped table-bordered text-nowrap " id="merchant-tranreport-table"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Report From </th>
                                <th>Report To</th>
                                <th>Report type</th>
                                <th>Payment Mode</th>
                                <th>Transaction Status</th>
                                <th>Progress</th>
                                <th>Download Link</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

            <script>
                var table;

                $(document).ready(function() {


                    table = $('#merchant-tranreport-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('getMerchantPayoutReportLog') }}",
                        },
                        order: [
                            [1, 'desc']
                        ],
                        lengthMenu: [
                            [10, 25, 50, 100, 200, -1],
                            [10, 25, 50, 100, 200, 'All'],
                        ],
                        scrollX: true,
                        sScrollXInner: "100%",
                        columns: [{
                                data: null, // `data: null` allows you to define custom content
                                name: 'serial_number',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row, meta) {
                                    return meta.row + 1; // Return row index starting from 1
                                }
                            }, {
                                data: 'from',
                                name: 'from',
                                orderable: false
                            },
                            {
                                data: 'to',
                                name: 'to'
                            },
                            {
                                data: 'report_type',
                                name: 'report_type'
                            },
                            {
                                data: 'payment_mode',
                                name: 'payment_mode'
                            },
                            {
                                data: 'transaction_status',
                                name: 'transaction_status'
                            },
                            {
                                data: 'progress',
                                name: 'progress',
                                render: function(data, type, row) {
                                    return data !== null ? data + '%' : '';
                                }
                            },
                            {
                                data: 'download_link',
                                name: 'download_link',
                                render: function(data, type, row) {
                                    if (data !== null) {
                                        return '<a href="' + data + '" target="_blank">Download</a>';
                                    } else {
                                        return ''; // Return an empty string if download_link is null
                                    }
                                }
                            }, {
                                data: 'created_date',
                                name: 'created_date'
                            }
                        ]
                    });

                    table.draw();

                    $(document).on('submit', '#report_form', function(event) {
                        event.preventDefault();

                        $.ajax({
                            type: "GET",
                            url: '{{ route('payouttransactionReportDownload') }}',
                            data: $('#report_form').serializeArray(),
                            async: false,
                            success: function(data) {
                                table.ajax.reload(null,
                                    false
                                );

                                var checkProgress = setInterval(function() {
                                    table.ajax.reload(null,
                                        false
                                    ); // Reload the table data without resetting pagination
                                    var firstRow = table.row(0)
                                        .data(); // Get the data of the first row



                                    if (firstRow && firstRow
                                        .download_link != null) {
                                        clearInterval(checkProgress);
                                    }
                                }, 5000); // Check every 1 second

                            },
                            complete: function() {

                            }
                        })









                    });



                })
            </script>
        @endsection
