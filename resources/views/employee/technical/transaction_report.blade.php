@extends('layouts.employeecontent')
@section('employeecontent')
    <div class="row">

        @php

        @endphp
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
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
                        @endif
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        @if (count($sublinks) > 0)
                            @foreach ($sublinks as $index => $value)
                                @switch($index)
                                    @case('0')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                            class="tab-pane fade in active">

                                            <div class="row">
                                                <form id="merchant-transaction-report-form">
                                                    @csrf
                                                    <div class="row" style="margin-top:15px;">
                                                        <div class="col-sm-12 mb-5">

                                                            <div class="col-sm-6">
                                                                <label for="">Range</label>
                                                                <input type="text" name="datetimes" id="datetimes"
                                                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                                                                <input type="hidden" name="trans_from_date" value="">
                                                                <input type="hidden" name="trans_to_date" value="">
                                                            </div>

                                                            <div class="col-sm-6">

                                                                <label for="">Report</label>
                                                                <select id="listreport" name="table_name" class="form-control ">
                                                                    <option value="">--select report--</option>
                                                                    @foreach (\App\Classes\Helpers::transaction_report_types() as $type)
                                                                        <option value="{{ $type }}">{{ ucwords($type) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>


                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="report_parameter">

                                                    </div>


                                                    <div class="row" style="margin-top:15px;">
                                                        <div class="col-sm-12 mb-5">

                                                            <div class="col-sm-12">
                                                                <label for="">Merchant</label>
                                                                <select id="listmerchant" name="merchant_filter"
                                                                    class="form-control ">
                                                                    <option value="">All Merchants</option>
                                                                    @foreach (App\User::get_merchant_lists() as $merchant)
                                                                        <option value="{{ $merchant->id }}">
                                                                            {{ $merchant->mid . ' : ' . $merchant->merchant_gid }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>




                                                        </div>

                                                    </div>

                                                    <div class="row " style="margin-top:15px;">
                                                        <div class="col-sm-12 mb-5">
                                                            <div class="col-sm-12 text-center">

                                                                <button type="submit"
                                                                    class="btn btn-primary active  submitButton"><i
                                                                        class="fa fa-download"></i> Download</button>
                                                            </div>




                                                        </div>

                                                    </div>


                                                </form>
                                            </div>
                                            <hr>
                                            <div class="col-sm-12">
                                                <div style="margin-top:30px; margin-bottom:100px; ">
                                                    <table class="table table-striped table-bordered text-nowrap "
                                                        id="merchant-tranreport-table" style="width: 100%;">
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

                                        </div>
                                    @break

                                    @case('1')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                            class="tab-pane fade in ">

                                            <table id="adminDailyReportLogTable" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Date</th>
                                                        <th>Report Type</th>
                                                        <th>Download Link</th>
                                                        <th>Created Date</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        </div>

                                        @default
                                        @break
                                    @endswitch
                                @endforeach
                            @else
                                <div id="{{ str_replace(' ', '-', strtolower($sublink_name)) }}"
                                    class="tab-pane fade in active">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.5.1.min.js') }}" crossorigin="anonymous"></script>

        <script type="module" src="{{ asset('js/ionicons.esm.js') }}"></script>
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





                var table = $('#merchant-tranreport-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getAdminMerchantReportLog') }}",
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
                            url: '{{ route('generatedownloadreport') }}',
                            data: $('#merchant-transaction-report-form').serializeArray(),
                            async: false,
                            success: function(data) {
                                // var url = "{{ route('generatedReportDownload') }}" + "?" + $.param(
                                //     data.res);



                                $.ajax({
                                    type: "GET",
                                    url: '{{ route('generatedReportDownload') }}',
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
                            url: '{{ route('getreportparameter') }}',
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


        {{-- daily report code --}}
        <script>
            $(document).ready(function() {
                $('#adminDailyReportLogTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url: "{{ route('getAdminDailyReportLog') }}",
                        type: 'GET'
                    },
                    columns: [{
                            data: null,
                            name: 'increment',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'report_type',
                            name: 'report_type'
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
                            data: 'created_date',
                            name: 'created_date'
                        }
                    ]
                });
            });
        </script>
    @endsection
