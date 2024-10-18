@extends('layouts.employeecontent')

@section('employeecontent')
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
    </style>




    <h3>Payout Reports</h3>


    <form id="merchant-transaction-report-form">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <label for="">Range</label>
                <input type="text" name="datetimes" id="datetimes"
                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                <input type="hidden" name="trans_from_date" value="">
                <input type="hidden" name="trans_to_date" value="">
            </div>

            <div class="col-sm-6">
                <label for="">Reports</label>
                <select name="table_name" id="table_name" class="form-control">
                    <option value="">--Select Report--</option>
                    <option value="transaction">Transaction</option>
                    <option value="ecollect">Ecollect</option>
                    <option value="ledger">ledger</option>
                </select>
            </div>
        </div>

        <div class="row transactionreportoptions" style="margin-top: 1%; display:none;">
            <div class="col-sm-6">

                <label for="">Payment Mode</label>
                <select name="mode" id="" class="form-control">
                    <option value="all">--Select--</option>
                    <option value="IMPS">IMPS</option>
                    <option value="NEFT">NEFT</option>
                </select>

            </div>

            <div class="col-sm-6">
                <label for="">Status</label>
                <select name="status" id="" class="form-control">
                    <option value="all">--Select--</option>
                    <option value="SUCCESS">SUCCESS</option>
                    <option value="PENDING">PENDING</option>
                    <option value="FAILED">FAILED</option>
                </select>
            </div>
        </div>

        <div class="row transactionreportoptions" style="margin-top: 1%">
            <div class="col-sm-6">

                <label for="">Merchant</label>
                <select name="merchant_filter" id="" class="form-control">
                    <option value="all">All Merchants</option>

                    @foreach ($merchants as $merchant)
                        <option value="{{ $merchant->id }}">{{ $merchant->merchant_gid }} {{ $merchant->business_name }}
                        </option>
                    @endforeach

                </select>

            </div>


        </div>

        <div class="row " style="margin-top:15px;">
            <div class="col-sm-12 mb-5">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary active "><i class="fa fa-download"></i>
                        Download
                    </button>
                </div>
            </div>

        </div>
    </form>




    <div style="margin-top:30px; margin-bottom:100px; " class="table-container">
        <table class="table table-striped table-bordered text-nowrap " id="vendor-table" style="width: 100%;">
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




    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>




    <script>
        $(document).ready(function() {
            var table; // Declare the table variable

            function initializeDataTable(startDate, endDate) {
                return $('#vendor-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
                    "ajax": {
                        "url": "{{ route('payoutReportsLog') }}",
                        "type": "GET",
                    },
                    "columns": [{
                            "data": null,
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            "data": "from_date",
                            "render": function(data, type, row) {
                                return moment(data).format('DD-MM-YYYY hh:mm:ss A');
                            }
                        },
                        {
                            "data": "to_date",
                            "render": function(data, type, row) {
                                return moment(data).format('DD-MM-YYYY hh:mm:ss A');
                            }
                        },
                        {
                            "data": "report_type"
                        },
                        {
                            "data": "payment_mode"
                        },
                        {
                            "data": "transaction_status"
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
                        },
                        {
                            "data": "created_date",
                            "render": function(data, type, row) {
                                return moment(data).format('DD-MM-YYYY hh:mm:ss A');
                            }
                        },

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
                    $('input[name="payout_datetime"] span').html(start.format('MMMM D, YYYY') + ' - ' + end
                        .format('MMMM D, YYYY'));
                    var search = $('#search').val();
                    reloadDataTable(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                    console.log(search, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                }

                $('input[name="payout_datetime"]').daterangepicker({
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


            document.getElementById('table_name').addEventListener('change', function() {
                var transactionOptions = document.querySelector('.transactionreportoptions');
                if (this.value === 'transaction') {
                    transactionOptions.style.display =
                        'flex'; // Change to 'block' if flex doesn't suit your design
                } else {
                    transactionOptions.style.display = 'none';
                }
            });

            $(document).on('submit', '#merchant-transaction-report-form', function(event) {
                event.preventDefault();
                var tablename = $("#merchant-transaction-report-form select[name='table_name']").val();
                event.preventDefault();
                if (tablename) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('generatedPayoutReportDownload') }}',
                        data: $('#merchant-transaction-report-form').serializeArray(),
                        async: false,
                        success: function(data) {
                            console.log(data);

                            table.ajax.reload(null, false);

                            var checkProgress = setInterval(function() {
                                table.ajax.reload(null,
                                    false
                                ); // Reload the table data without resetting pagination
                                var firstRow = table.row(0)
                                    .data(); // Get the data of the first row

                                console.table(firstRow, "check first row")


                                if (firstRow && firstRow
                                    .download_link != null) {
                                    console.log('clear interval', firstRow
                                        .download_link)
                                    clearInterval(checkProgress);
                                }
                            }, 5000); // Check every 1 second
                        },
                        complete: function() {

                        }
                    })

                } else {

                    Swal.fire("Error!", "Please Select Report Type", "error");
                }

            });
        });
    </script>

    <script></script>

    <script>
        $(function() {
            var momentTimeFormat = 'DD/MM/YYYY HH:mm:ss';
            var start = moment().subtract(1, 'days').startOf('day');
            var end = moment().subtract(0, 'days').endOf('day');

            $("#merchant-transaction-report-form input[name='trans_from_date']").val(start.format(
                'YYYY-MM-DD HH:mm:ss'));
            $("#merchant-transaction-report-form input[name='trans_to_date']").val(end.format(
                'YYYY-MM-DD HH:mm:ss'));


            $('#merchant-transaction-report-form input[name="datetimes"]').daterangepicker({
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


                $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY HH:mm:ss') + ' - ' + end
                    .format('MMMM D, YYYY HH:mm:ss'));

                $("#merchant-transaction-report-form input[name='trans_from_date']").val(start.format(
                    'YYYY-MM-DD HH:mm:ss'));
                $("#merchant-transaction-report-form input[name='trans_to_date']").val(end.format(
                    'YYYY-MM-DD HH:mm:ss'));

            });
        });
    </script>
@endsection
