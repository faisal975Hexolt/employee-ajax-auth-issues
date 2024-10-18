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
                        <h3 class="margH">Transaction Report</h3>
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

                                <label for="">Report Type</label>

                                <select class="form-control" name="table_name" id="listreport">

                                    <option value="">--select report--</option>
                                    @foreach (\App\Classes\Helpers::transaction_report_types() as $type)
                                        <option {{ request()->input('table_name') == $type ? 'selected' : '' }}
                                            value="{{ $type }}">{{ ucwords($type) }}</option>
                                    @endforeach
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
            <!-- </div>
                                                </div> -->



            @if (isset($transaction))
                <div class="card">

                    <div class="card-body">

                        <table id="example" class="table table-striped table-bordered table-sm border ">

                            <thead>

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Order Id</th>

                                    <th scope="col">Transaction Response</th>

                                    <th scope="col">Transaction Type</th>

                                    <th scope="col">Merchant</th>

                                    <th scope="col">Username</th>

                                    <th scope="col">Email</th>

                                    <th scope="col">Contact</th>

                                    <th scope="col">Amount</th>

                                    <th scope="col">Status</th>

                                    <th scope="col">Mode</th>

                                    <th scope="col">Description</th>

                                    <th scope="col">Transaction Date</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($transaction as $index => $payment)
                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $payment->order_id }}</td>

                                        <td>{{ $payment->transaction_response }}</td>

                                        <td>{{ $payment->transaction_type }}</td>

                                        <td>{{ $payment->name }}</td>

                                        <td>{{ $payment->transaction_username }}</td>

                                        <td>{{ $payment->transaction_email }}</td>

                                        <td>{{ $payment->transaction_contact }}</td>

                                        <td>{{ $payment->transaction_amount }}</td>

                                        <td>{{ $payment->transaction_status }}</td>

                                        <td>{{ $payment->transaction_mode }}</td>

                                        <td>{{ $payment->transaction_description }}</td>

                                        @if ($payment->transaction_date != null)
                                            <td>{{ \Carbon\Carbon::parse($payment->transaction_date)->format('j F, Y') }}
                                            </td>
                                        @else
                                            <td></td>
                                        @endif







                                    </tr>
                                @endforeach







                            </tbody>



                        </table>

                    </div>

                </div>
            @endif





            <!-- settlement table -->

            @if (isset($settlement))
                <div class="card">

                    <div class="card-body">

                        <table id="example" class="table table-striped table-bordered table-sm border ">

                            <thead>

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Gid</th>

                                    <th scope="col">Current Balance</th>

                                    <th scope="col">Settlement Amount</th>

                                    <th scope="col">Settlement Fee</th>

                                    <th scope="col">Settlement Tax</th>

                                    <th scope="col">Settlement Status</th>

                                    <th scope="col">Settlement Date</th>

                                    <th scope="col">Date</th>

                                    <th scope="col">Merchant</th>









                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($settlement as $index => $payment)
                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $payment->settlement_gid }}</td>

                                        <td>{{ $payment->current_balance }}</td>

                                        <td>{{ $payment->settlement_amount }}</td>

                                        <td>{{ $payment->settlement_fee }}</td>

                                        <td>{{ $payment->settlement_tax }}</td>

                                        <td>{{ $payment->settlement_status }}</td>

                                        <td>{{ \Carbon\Carbon::parse($payment->settlement_date)->format('j F, Y') }}</td>

                                        <td>{{ \Carbon\Carbon::parse($payment->created_date)->format('j F, Y') }}</td>

                                        <td>{{ $payment->name }}</td>











                                    </tr>
                                @endforeach







                            </tbody>



                        </table>

                    </div>

                </div>
            @endif



            <!-- refund table -->

            @if (isset($refund))
                <div class="card">

                    <div class="card-body">

                        <table id="example" class="table table-striped table-bordered table-sm border ">

                            <thead>

                                <tr>

                                    <th scope="col">#</th>

                                    <th scope="col">Gid</th>

                                    <th scope="col">Payment Id</th>

                                    <th scope="col">Transaction Mode</th>

                                    <th scope="col">Transaction Status</th>

                                    <th scope="col">Refund Amount</th>

                                    <th scope="col">Refund Notes</th>

                                    <th scope="col">Refund Status </th>

                                    <th scope="col">Date</th>

                                    <th scope="col">Merchant</th>











                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($refund as $index => $payment)
                                    <tr>

                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $payment->refund_gid }}</td>

                                        <td>{{ $payment->payment_id }}</td>

                                        <td>{{ $payment->transaction_mode }}</td>

                                        <td>{{ $payment->transaction_status }}</td>

                                        <td>{{ $payment->refund_amount }}</td>

                                        <td>{{ $payment->refund_notes }}</td>

                                        <td>{{ $payment->refund_status }}</td>

                                        <td>{{ \Carbon\Carbon::parse($payment->created_date)->format('j F, Y') }}</td>

                                        <td>{{ $payment->name }}</td>











                                    </tr>
                                @endforeach







                            </tbody>



                        </table>

                    </div>

                </div>
            @endif







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
                            url: "{{ route('getMerchantReportLog') }}",
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
                        var tablename = $("#report_form select[name='table_name']").val();
                        event.preventDefault();
                        if (tablename) {
                            $.ajax({
                                type: "POST",
                                url: '{{ route('ReportDownloadlink') }}',
                                data: $('#report_form').serializeArray(),
                                async: false,
                                success: function(data) {
                                    $.ajax({
                                        type: "GET",
                                        url: '{{ route('transactionReportDownload') }}',
                                        data: data.res,
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

                                },
                                complete: function() {
                                    setTimeout(() => {
                                        $(".loader").hide();
                                        table.draw();
                                    }, 1500);
                                }
                            })

                        } else {

                            Swal.fire("Error!", "Please Select Report Type", "error");
                        }





                    });



                })
            </script>
        @endsection
