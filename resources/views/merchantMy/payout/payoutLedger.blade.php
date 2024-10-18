@extends('layouts.merchantcontent')
@section('merchantcontent')
<!--Module Banner-->
<div id="buton-1">

</div>

<!--Module Banner-->
<section id="about-1" class="about-1 ">

    <div class="container-1">

        <div class="row">

            <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                <div class="content-1 pt-4 pt-lg-0">

                    <h3>Payout Ledgers </h3>



                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <ul class="nav nav-tabs" id="transaction-tabs">
                        @php ($trans = ['merchant/payoutledger' => '<a data-toggle="tab" class="show-cursor"
                            data-target="#settlements" onclick="changeTab(this);">List of Payout Ledgers</a>'])
                        @foreach($trans as $index=>$value)
                        <li class="{{ Request::path() == $index ?'active' : ''}}">{!! $value !!}</li>
                        @endforeach
                    </ul>
                    <form action="" id="transaction-tabs-form" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="settlements" class="tab-pane fade in active">
                            <form id="ledger-transaction-download-form"
                                action="{{route('payoutTransactionDwnld')}}" method="POST" role="form">
                                @csrf
                                <div class="tab-button">
                                    <!-- <button  type="submit" class="btn btn-primary btn-sm pull-right">Download Excel</button> -->

                                    <a type="submit" href="#" class="btn btn-primary btn-sm dwd-brief">Download
                                        Excel</a>
                                </div>
                            </form>
                            <div class="row">
                                <form id="ledger-transaction-form">
                                    @csrf





                                    <div class="row">
                                        <div class="col-sm-12">

                                            <div class="row" style="margin-top:15px;">
                                                <div class="col-sm-12 mb-5">



                                                    <div class="col-sm-6 ">
                                                        <input class="form-control searchfor" id="search"
                                                            name="searchfor" type="text" value=""
                                                            placeholder="Search Anything here">


                                                        <span class="src">
                                                            <i class="fa fa-search "></i></span>
                                                    </div>



                                                    <div class="col-sm-6 ">
                                                        <input class="form-control searchFilter" id="datetimes"
                                                            name="datetimes" placeholder="MM/DD/YYYY" type="text"
                                                            value="">
                                                        <input type="hidden" name="trans_from_date" value="">
                                                        <input type="hidden" name="trans_to_date" value="">

                                                        <span class="src">
                                                            <i
                                                                class="fa fa-calendar ledger-transaction-form-summary"></i></span>
                                                    </div>



                                                </div>
                                            </div>

                                           

                                   <input type="hidden" name="fordownload" value="ledgerDownld"/>             



                                </form>


                            </div>

                            <div>
                                <div class="col-sm-12">
                                    <div class="display-block">
                                        <div class="table-responsive1">
                                            <table class="display responsive table table-striped table-bordered text-nowrap"
                                                id="payout_ledger_table" style="width:100%">
                                                <thead>

                                                    <tr>

                                                        <th>#</th>
                                                        <th>Transaction Date Time</th>
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

                                                        <!-- <th>Action</th> -->
                                                    </tr>

                                                </thead>


                                                <tbody id="payoutledgertable">

                                                </tbody>

                                            </table>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>


<script>
$(function() {


    $(".ledger-transaction-form-summary").click(function(e) {
        e.preventDefault();
        $("input[name='datetimes']").focus();
    })

    var start = moment().subtract(2, 'days');

    var end = moment();

    $("#ledger-transaction-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD HH:mm:ss'));
    $("#ledger-transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));


    $('#ledger-transaction-form input[name="datetimes"]').daterangepicker({
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
            ]
        },

    }, function(start, end, label) {


        $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
            'MMMM D, YYYY'));

        $("#ledger-transaction-form input[name='trans_from_date']").val(start.format(
            'YYYY-MM-DD HH:mm:ss'));
        $("#ledger-transaction-form input[name='trans_to_date']").val(end.format(
            'YYYY-MM-DD HH:mm:ss'));


    });


    var table = $('#payout_ledger_table').DataTable({
        fnInitComplete: function() {
            // Disable TBODY scoll bars


            // Enable TFOOT scoll bars
            $('.dataTables_scrollFoot').css('overflow', 'auto');



        },
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '
        },
        serverSide: true,
        ajax: {
            url: "{{ route('merchant.payoutledger') }}",
            data: function(d) {
                // $(".loader_custom").show();
                d.search = $('input[type="search"]').val(),
                    d.form = getJsonObject($("#ledger-transaction-form").serializeArray())

            }

        },
        drawCallback: function(settings) {
            // $(".loader_custom").hide();
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

    $(document).on('change', '#liststatus', function(event) {
        var target = $(event.target);
        var search = $(this).val();

        var elementType = $(this).prop('nodeName');


        table.draw();
    });



});



$(document).on('click', '.dwd-brief', function(event) {
    event.preventDefault();

    var url = $('form#ledger-transaction-download-form').attr('action');
    // swalnot("error","hekko");
    $("#ledger-transaction-form").attr('action', url)
    $("#ledger-transaction-form").attr('method', 'POST')
    $('form#ledger-transaction-form').submit();
});


$(document).on('submit', '#ledger-transaction-download-form', function(event) {
    event.preventDefault();
    var url = $(this).attr('action');

    // swalnot("error","hekko");
    $("#ledger-transaction-form").attr('action', url)
    $("#ledger-transaction-form").attr('method', 'POST')
    $('form#ledger-transaction-form').submit();

});
</script>