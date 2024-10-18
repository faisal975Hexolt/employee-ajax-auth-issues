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
        <h3>List of Payout Ledgers</h3>

        <form id="manage-ledger-transaction-download-form" action="{{ route('manage.payoutTransactionDwnld') }}" method="POST"
            role="form">
            @csrf

            <button style="margin-bottom: 10px" type="submit" class="btn btn-primary btn-sm pull-right">Download
                Excel</button>
        </form>
    </div>

    <div class="row">

        <form id="payout-ledger-form">
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
                            @foreach (get_settlement_status() as $status)
                                <option value="{{ $status }}">{{ ucwords($status) }}</option>
                            @endforeach
                        </select>


                    </div>
                </div>

            </div>

            <input type="hidden" name="fordownload" value="ledgerDownld" />



        </form>


    </div>





    <div style="margin-top:30px; margin-bottom:100px; ">

        <table class="table table-striped table-bordered text-nowrap" id="payout_ledger_table">



            <thead>

                <tr>

                    <th>#</th>
                    <th>Transaction Date Time</th>
                    <th>Merchant Name</th>
                    <th>Ledger Id</th>

                    <th>Debit</th>
                    <th>Credit</th>
                    <th>TDR Charged</th>
                    <th>GST Charged</th>
                    <th>Transfer Type</th>
                    <th>Description</th>
                    <th>Balance</th>
                    <th>Reference Number</th>
                    <th>Merchant Reference Number</th>


                </tr>

            </thead>

            <tbody>
            </tbody>

        </table>

    </div>








    <!-- updatestatusmodal -->

    <div class="modal fade" id="updatestatusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">

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

            var start = moment().subtract(10, 'days');

            var end = moment();

            $("#payout-ledger-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD HH:mm:ss'));
            $("#payout-ledger-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));


            $('#payout-ledger-form input[name="datetimes"]').daterangepicker({


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

                $("#payout-ledger-form input[name='trans_from_date']").val(start.format(
                    'YYYY-MM-DD HH:mm:ss'));
                $("#payout-ledger-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));


            });






            var table = $('#payout_ledger_table').DataTable({
                processing: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '
                },
                serverSide: true,
                ajax: {
                    url: "{{ route('manage.payoutLedger') }}",
                    data: function(d) {
                        d.search = $('input[type="search"]').val(),
                            d.form = getJsonObject($("#payout-ledger-form").serializeArray())

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
                        name: 'DT_RowIndex',
                        orderable: false
                    },
                    {
                        data: 'created',
                        name: 'created'
                    },
                    {
                        data: 'business_name',
                        name: 'business_name'
                    },

                    {
                        data: 'ledger_id',
                        name: 'ledger_id'
                    },
                    {
                        data: 'debit',
                        name: 'debit'
                    },

                    {
                        data: 'credit',
                        name: 'credit'
                    },
                    {
                        data: 't_tdr',
                        name: 't_tdr'
                    },
                    {
                        data: 't_gst',
                        name: 't_gst'
                    },

                    {
                        data: 'transfer_mode',
                        name: 'transfer_mode'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },

                    {
                        data: 'current_balance',
                        name: 'current_balance',
                    },
                    {
                        data: 'refreance_no',
                        name: 'refreance_no',
                        orderable: false
                    },
                    {
                        data: 'merchant_refreance_no',
                        name: 'merchant_refreance_no',
                        orderable: false
                    }

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
