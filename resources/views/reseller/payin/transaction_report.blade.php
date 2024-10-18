@extends('layouts.resellercontent')

@section('resellercontent')


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



    <!--
                            <div id="buton-1">

                                <button class="btn btn-dark" id="Show">Show</button>

                                <button class="btn btn-danger" id="Hide">Remove</button>

                            </div> -->


    <!-- <section id="about-1" class="about-1">

                                <div class="container-1">



                                    <div class="row">



                                        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">

                                            <div class="content-1 pt-4 pt-lg-0">



                                                <h3>Transaction Report</h3>

                                                <p>Get started with accepting payments right away</p>

                                                @if (get_merchnant_app_status())
    <p>Transaction, Refund, Order and Disputes Details</p>
@else
    <p>You are just one step away from activating your account to accept domestic and international
                                                    payments from your customers. We just need a few more details</p>
    @endif

                                                

                                            </div>

                                        </div>

                                        <div class="col-lg-6" data-aos="zoom-in" id="img-dash">

                                            <img src="{{ asset('assets/img/dash-bnr.png') }}" width="450" height="280" class="img-fluid"
                                                alt="dash-bnr.png">

                                        </div>

                                    </div>



                                </div>

                            </section> -->



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
                    <form method="POST" class="flex-container" id="merchant-transaction-report-form">

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

                                <label for="">Merchant</label>

                                <select class="form-control" name="merchant_id" id="merchantList">


                                    <option value="0">All</option>
                                    {{-- <option value="all_merchant">All Merchant</option> --}}
                                    @foreach ($merchantList as $list)
                                        <option value="{{ $list->id }}">{{ ucwords($list->name) }}</option>
                                    @endforeach
                                </select>

                            </div>

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
            <!-- report table -->

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


            <script src="{{ asset('js/jquery-3.5.1.min.js') }}" crossorigin="anonymous"></script>

            <script type="module" src="{{ asset('js/ionicons.esm.js') }}"></script>
            <script>
                $(function() {

                    var momentTimeFormat = 'DD/MM/YYYY HH:mm:ss';
                    var start = moment().subtract(1, 'days').startOf('day');
                    var end = moment().subtract(0, 'days').endOf('day');

                    $("#merchant-transaction-report-form input[name='report_start_date']").val(start.format(
                        'YYYY-MM-DD HH:mm:ss'));
                    $("#merchant-transaction-report-form input[name='report_end_date']").val(end.format(
                        'YYYY-MM-DD HH:mm:ss'));


                    $('#merchant-transaction-report-form input[name="transaction_download_report"]').daterangepicker({
                        dateLimit: {
                            days: 61
                        },
                        minDate: moment().subtract(365, 'days'),
                        maxDate: moment(),
                        opens: 'left',
                        "linkedCalendars": true,
                        startDate: start,
                        endDate: end,
                        locale: {
                            format: momentTimeFormat
                        },
                        timePicker: true,
                        timePicker24Hour: false,
                        timePickerSeconds: true,

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
                            'Last 2 Month': [moment().subtract(2, 'month').startOf('day').startOf('month'), moment()
                                .subtract(1, 'month').endOf('month').endOf('day')
                            ],
                            //'This Year': [moment().startOf('year'), moment().endOf('year').endOf('day')]
                        },
                    }, function(start, end, label) {


                        $('input[name="transaction_download_report"] span').html(start.format(
                                'MMMM D, YYYY HH:mm:ss') + ' - ' + end
                            .format('MMMM D, YYYY HH:mm:ss'));

                        $("#merchant-transaction-report-form input[name='trans_from_date']").val(start.format(
                            'YYYY-MM-DD HH:mm:ss'));
                        $("#merchant-transaction-report-form input[name='trans_to_date']").val(end.format(
                            'YYYY-MM-DD HH:mm:ss'));


                    });





                    var table = $('#merchant-tranreport-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('getResellerMerchantReportLog') }}",
                            data: function(d) {
                                d.search = $('input[type="search"]').val();
                                d.form = getJsonObject($("#merchant-transaction-report-form")
                                    .serializeArray());
                            }
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
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex'
                            },
                            {
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



                    $(document).on('submit', '#merchant-transaction-report-form', function(event) {

                        var tablename = $("#merchant-transaction-report-form select[name='table_name']").val();
                        event.preventDefault();
                        if (tablename) {
                            $.ajax({
                                type: "POST",
                                url: '{{ route('reseller.ReportDownloadlink') }}',
                                data: $('#merchant-transaction-report-form').serializeArray(),
                                async: false,
                                success: function(data) {
                                    // var url = "{{ route('generatedReportDownload') }}" + "?" + $.param(
                                    //     data.res);



                                    $.ajax({
                                        type: "GET",
                                        url: '{{ route('reseller.downloadreport') }}',
                                        data: data.res,
                                        async: false,
                                        success: function(data) {


                                            var checkProgress = setInterval(function() {
                                                table.ajax.reload(null,
                                                    false
                                                ); // Reload the table data without resetting pagination
                                                var firstRow = table.row(0)
                                                    .data(); // Get the data of the first row

                                                console.table(firstRow);

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


                    $(".submitButton").prop("disabled", true);

                    $(document).on('change', '#listreport', function(event) {
                        var tableName = $(this).val();
                        if (tableName) {
                            $(".submitButton").prop("disabled", true);
                            $(".loader").show();
                            $.ajax({
                                type: "POST",
                                url: '{{ route('getreportResellerparameter') }}',
                                data: $('#merchant-transaction-report-form').serializeArray(),
                                dataType: "json",
                                success: function(response) {
                                    $('.report_parameter').html(null);
                                    if (response.status) {
                                        $('.report_parameter').html(response.view);
                                    }


                                },
                                complete: function() {
                                    setTimeout(() => {
                                        $(".loader").hide();
                                        $(".submitButton").prop("disabled", false);
                                    }, 1500);
                                }
                            });
                        }


                    });




                });
            </script>

        @endsection
