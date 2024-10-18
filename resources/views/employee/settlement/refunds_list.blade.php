@php
    
    $vendor_banks = App\RyapayVendorBank::get_vendorbank();
    
@endphp

@extends('layouts.employeecontent')

@section('employeecontent')
    <style>
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
        <h3>Transactions Refunds</h3>

        <form id="summary-refund-transaction-download-form" action="{{ route('transactionRefunddwnld') }}" method="POST"
            role="form">
            @csrf

            <button style="margin-bottom: 10px" type="submit" class="btn btn-primary btn-sm pull-right">Download
                Excel</button>
        </form>
    </div>

    <div class="row">

        <form id="summary-refund-transaction-form">
            @csrf
            <div class="row" style="margin-top:15px;">
                <div class="col-sm-12 mb-5">

                    <div class="col-sm-6">
                        <div class="input-group">


                            <input type="text" name="searchfor" id="search" class="searchfor form-control "
                                placeholder="Search Anything here">

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-secondary"><i
                                        class="glyphicon glyphicon-search"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <input type="text" class="searchFilter" name="datetimes" id="datetimes"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                        <input type="hidden" name="trans_from_date" value="">
                        <input type="hidden" name="trans_to_date" value="">

                    </div>


                </div>
            </div>

            <div class="row" style="margin-top:15px;">
                <div class="col-sm-12 mb-5">
                    <div class="col-sm-6">


                        <select id="listmerchant" name="merchant_filter" class="form-control searchFilterM">
                            <option value="">All Merchants</option>
                            @foreach (App\User::get_merchant_lists() as $merchant)
                                <option value="{{ $merchant->id }}">{{ $merchant->mid . ' : ' . $merchant->merchant_gid }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="getfor" value="admin" />



                    </div>

                    <div class="col-sm-6">


                        <select id="liststatus" name="status_filter" class="form-control searchFilter">
                            <option value="">All</option>
                            @foreach (\App\Classes\Helpers::refund_report_status() as $r => $status)
                                <option {{ request()->input('status') == $status ? 'selected' : '' }}
                                    value="{{ $status }}">
                                    {{ frefund_status($status) }}
                                </option>
                            @endforeach
                        </select>


                    </div>
                </div>

            </div>





        </form>


    </div>





    <div style="margin-top:30px; margin-bottom:100px; ">

        <table class="table table-striped table-bordered text-nowrap" id="summary_transactions_refund">



            <thead>

                <tr>
                    <th>#</th>
                    <th>Created at</th>
                    <th>Refund Id</th>
                    <th>Merchant Id </th>
                    <th>Merchant Name</th>
                    <th>Payment Id </th>
                    <th>Merchant Order Id </th>
                    <th>Bank Ref No</th>
                    <th>Amount</th>
                    <th>Customer VPA </th>
                    <th>Refund Bank Ref No </th>
                    <th>Refund Status </th>
                    <th>Adjusted Settlment ID </th>
                    <th>Action </th>

                </tr>

            </thead>

            <tbody>
            </tbody>

        </table>

    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>



    <script>
        $(function() {

            var momentTimeFormat = 'DD/MM/YYYY HH:mm:ss';
            var start = moment().subtract(2, 'days').startOf('day');
            var end = moment().subtract(0, 'days').endOf('day');

            $("#summary-refund-transaction-form input[name='trans_from_date']").val(start.format(
                'YYYY-MM-DD HH:mm:ss'));
            $("#summary-refund-transaction-form input[name='trans_to_date']").val(end.format(
            'YYYY-MM-DD HH:mm:ss'));


            $('#summary-refund-transaction-form input[name="datetimes"]').daterangepicker({


                opens: 'left',
                "linkedCalendars": false,
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
                    'This Year': [moment().startOf('year'), moment().endOf('year').endOf('day')]
                },
            }, function(start, end, label) {


                $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY HH:mm:ss') + ' - ' + end
                    .format(
                        'MMMM D, YYYY'));

                $("#summary-refund-transaction-form input[name='trans_from_date']").val(start.format(
                    'YYYY-MM-DD HH:mm:ss'));
                $("#summary-refund-transaction-form input[name='trans_to_date']").val(end.format(
                    'YYYY-MM-DD HH:mm:ss'));


            });






            var table = $('#summary_transactions_refund').DataTable({
                processing: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '
                },
                serverSide: true,
                ajax: {
                    url: "{{ route('fetch-transaction-refunds') }}",
                    data: function(d) {
                        d.search = $('input[type="search"]').val(),
                            d.form = getJsonObject($("#summary-refund-transaction-form")
                            .serializeArray())

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
                        data: 'created_date',
                        name: 'created_date'
                    },

                    {
                        data: 'refund_gid',
                        name: 'refund_gid'
                    },

                    {
                        data: 'merchant_gid',
                        name: 'merchant_gid'
                    },
                    {
                        data: 'business_name',
                        name: 'business_name'
                    },

                    {
                        data: 'transaction_gid',
                        name: 'transaction_gid',
                        orderable: false
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        orderable: false
                    },
                    {
                        data: 'bank_ref_no',
                        name: 'bank_ref_no',
                        orderable: false
                    },
                    {
                        data: 'refund_amount',
                        name: 'refund_amount',
                        orderable: false
                    },
                    {
                        data: 'customer_vpa',
                        name: 'customer_vpa',
                        orderable: false
                    },


                    {
                        data: 'refund_arn',
                        name: 'refund_arn',
                        orderable: false
                    },

                    {
                        data: 'refund_status',
                        name: 'refund_status'
                    },
                    {
                        data: 'settlement_brief_gid',
                        name: 'settlement_brief_gid'
                    },


                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            $('#search').on('input', function() {
                var search = $(this).val();
                if (search.length < 4) {
                    return true;
                }
                table.draw();
            });


            $(document).on('change', '.searchFilter', function(event) {
                var target = $(event.target);
                var search = $(this).val();
                if (search.length < 4) {
                    return true;
                }
                var elementType = $(this).prop('nodeName');


                table.draw();
            });

            $(document).on('change', '.searchFilterM', function(event) {
                var target = $(event.target);
                var search = $(this).val();
                if (search.length == 0) {
                    return true;
                }
                var elementType = $(this).prop('nodeName');


                table.draw();
            });




        });
    </script>
@endsection
