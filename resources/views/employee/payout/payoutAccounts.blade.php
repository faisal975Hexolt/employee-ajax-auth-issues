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
        <h3>Payout Accounts </h3>

        <form id="paccounts-download-form" action="{{ route('manage.payoutTransactionDwnld') }}" method="POST" role="form">
            @csrf

            <button style="margin-bottom: 10px" type="submit" class="btn btn-primary btn-sm pull-right">Download
                Excel</button>
        </form>
    </div>

    <div class="row">

        <form id="manage-PayoutAccounts-form">
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

                        <select id="listmerchant" name="merchant_filter" class="form-control searchFilterlist">
                            <option value="">All Merchants</option>
                            @foreach (App\User::get_merchant_lists() as $merchant)
                                <option value="{{ $merchant->id }}">{{ $merchant->mid . ' : ' . $merchant->merchant_gid }}
                                </option>
                            @endforeach
                        </select>



                    </div>

                    <div class="col-sm-6">


                        <select id="liststatus" name="status_filter" class="form-control searchFilter">
                            <option value="">All</option>
                            @foreach (payout_status() as $status)
                                <option value="{{ $status }}">{{ ucwords($status) }}</option>
                            @endforeach
                        </select>


                    </div>
                </div>

            </div>
            <input type="hidden" name="fordownload" value="payoutAccountDownld" />




        </form>


    </div>





    <div style="margin-top:30px; margin-bottom:100px; ">

        <table class="table table-striped table-bordered text-nowrap" id="payout_Account_table">



            <thead>

                <tr>

                    <th>#</th>
                    <th>Merchant ID</th>
                    <th>Company Name</th>

                    <th>Balance</th>
                    <th>Payout Status</th>



                </tr>

            </thead>

            <tbody>
            </tbody>

        </table>

    </div>








    <div id="payout-account-transaction-model" class="modal" role="dialog" style="z-index: 11000;">
        <div class="modal-dialog modal-lg" role="document" style="width:1400px">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="">Payout FundTransfer Details</h4>
                </div>
                <div class="modal-body">
                    <div class="model-content" id="modal-dynamic-body">
                        <div id="paylink-add-form">

                            <div class="tab-content1">
                                <div id="fund-transaction_details_view">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
        $(function() {

            var start = moment().subtract(1, 'years');

            var end = moment();

            $("#manage-PayoutAccounts-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD HH:mm:ss'));
            $("#manage-PayoutAccounts-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));


            $('#manage-PayoutAccounts-form input[name="datetimes"]').daterangepicker({
                startDate: start,
                endDate: end,
                locale: {

                    format: 'DD/MM/YYYY HH:mm:ss'

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
                    'This Year': [moment().startOf('year'), moment().endOf('year').endOf('day')],
                },

            }, function(start, end, label) {


                $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));

                $("#manage-PayoutAccounts-form input[name='trans_from_date']").val(start.format(
                    'YYYY-MM-DD HH:mm:ss'));
                $("#manage-PayoutAccounts-form input[name='trans_to_date']").val(end.format(
                    'YYYY-MM-DD HH:mm:ss'));


            });






            var table = $('#payout_Account_table').DataTable({
                processing: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '
                },
                serverSide: true,
                ajax: {
                    url: "{{ route('manage.payoutAccounts') }}",
                    data: function(d) {
                        d.search = $('input[type="search"]').val(),
                            d.form = getJsonObject($("#manage-PayoutAccounts-form").serializeArray())

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

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false
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
                        data: 'balance',
                        name: 'balance'
                    },

                    {
                        data: 'payout_status',
                        name: 'payout_status',
                        orderable: false
                    },




                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // },
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

            $(document).on('change', '.searchFilterlist', function(event) {
                var target = $(event.target);
                var search = $(this).val();

                var elementType = $(this).prop('nodeName');
                table.draw();
            });




        });
    </script>
@endsection
