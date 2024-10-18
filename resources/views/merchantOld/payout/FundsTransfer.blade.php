@extends('layouts.merchantcontent')
@section('merchantcontent')
<!--Module Banner-->
<div id="buton-1">

</div>

<!--Module Banner-->

    <section id="about-1" class="about-1">
    <div class="container-1">
        <div class="row">
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
                <h3 class="margH">Payout Fund Transfer </h3>
         
            </div>
        </div>
       
        </div>

    </div>
</section> 

    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <ul class="nav nav-tabs" id="transaction-tabs">
                        @php ($trans = ['merchant/payoutfundstransfer' => '<a data-toggle="tab" class="show-cursor"
                            data-target="#settlements" onclick="changeTab(this);">List of Funds Transfer</a>'])
                        @foreach($trans as $index=>$value)
                        <li class="{{ Request::path() == $index ?'active' : ''}}">{!! $value !!}</li>
                        @endforeach
                    </ul>
                    <form action="" id="transaction-tabs-form" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="panel-body panelH">
                    <div class="tab-content">
                        <div id="settlements" class="tab-pane fade in active">
                            <form id="fund-transfer-transaction-download-form"
                                action="{{route('payoutTransactionDwnld')}}" method="POST" role="form">
                                @csrf
                                <div class="tab-button">
                                    <!-- <button  type="submit" class="btn btn-primary btn-sm pull-right">Download Excel</button> -->

                                    <a type="submit" href="#" class="btn btn-primary btn-md dwd-brief">Download
                                        </a>
                                </div>
                            </form>
                            <div class="row">
                                   <div class="col-sm-12">
                                        <form id="fundtransfer-transaction-form">
                                          @csrf

                                            <div class="row Topmarg">
                                                <div class="col-sm-12 mb-5">
                                                  <div class="col-sm-4">
                                                        <input class="form-control searchfor" id="search"
                                                            name="searchfor" type="text" value=""
                                                            placeholder="Search Anything here">
                                                        <span class="src">
                                                            <i class="fa fa-search "></i></span>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <input class="form-control searchFilter" id="datetimes"
                                                            name="datetimes" placeholder="MM/DD/YYYY" type="text"
                                                            value="">
                                                        <input type="hidden" name="trans_from_date" value="">
                                                        <input type="hidden" name="trans_to_date" value="">

                                                        <span class="src">
                                                            <i
                                                                class="fa fa-calendar fundtransfer-transaction-form-summary"></i></span>
                                                    </div>

                                                    <div class="col-sm-4">
                                                         <select id="liststatus" name="status_filter"
                                                            class="form-control ">
                                                            <option value="">All</option>
                                                            @foreach (get_transaction_status() as $status )
                                                            <option value="{{$status}}">{{ucwords($status)}}
                                                            </option>
                                                            @endforeach
                                                        </select>


                                                    </div>
                                                </div>
                                            </div>
                                              <input type="hidden" name="fordownload" value="fundtransferDownld"/>
                                        </form>
                                    </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block">
                                        <div class="table-responsive1">
                                            <table class="display responsive table table-striped table-bordered text-nowrap"
                                                id="fund_transfer_table" style="width:100%">
                                                <thead>

                                                    <tr>

                                                        <th>#</th>
                                                        <th>Payout Date & Time</th>
                                                        <th>Transaction ID</th>
                                                        <th>Merchant Ref Number</th>
                                                         <th>Status</th>
                                                          <th>Transfer Type</th>
                                                        <th>Amount Transferred</th>
                                                        <th>TDR Charged</th>
                                                        <th>GST Charged</th>
                                                        <th>Amount Debited</th>
                                                        
                                                        <th>Bank Ref Number</th>
                                                        <th>Virtual Payee Address</th>
                                                        <th>Account Name</th>
                                                        <th>Account Number</th>
                                                        <th>IFSC Code</th>
                                                       
                                                        <th>Error</th>
                                                        
                                                        

                                                        <!-- <th>Action</th> -->
                                                    </tr>

                                                </thead>


                                                <tbody id="fundtransfertable">

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

@endsection
 <div id="fund-detail-transaction-model" class="modal" role="dialog" style="z-index: 11000;">
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
                                            <div id="fund-transaction_details_view" >
                                                
                                            </div>
                                           
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>


<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>


<script>
$(function() {


    $(".fundtransfer-transaction-form-summary").click(function(e) {
        e.preventDefault();
        $("input[name='datetimes']").focus();
    })

    var start = moment().subtract(10, 'days');

    var end = moment();

    $("#fundtransfer-transaction-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD HH:mm:ss'));
    $("#fundtransfer-transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));


    $('#fundtransfer-transaction-form input[name="datetimes"]').daterangepicker({
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

        $("#fundtransfer-transaction-form input[name='trans_from_date']").val(start.format(
            'YYYY-MM-DD HH:mm:ss'));
        $("#fundtransfer-transaction-form input[name='trans_to_date']").val(end.format(
            'YYYY-MM-DD HH:mm:ss'));


    });


    var table = $('#fund_transfer_table').DataTable({
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
            url: "{{ route('payoutfundstransfer') }}",
            data: function(d) {
                // $(".loader_custom").show();
                d.search = $('input[type="search"]').val(),
                    d.form = getJsonObject($("#fundtransfer-transaction-form").serializeArray())

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
                data: 'payout_transaction_date',
                name: 'payout_transaction_date'
            },

              {
                data: 'transaction_gid_btn',
                name: 'transfer_id'
            },
            {
                data: 'reference_id',
                name: 'reference_id'
            },

            {
                data: 'status',
                name: 'status',
                orderable: false
            },
            {
                data: 'transfer_mode',
                name: 'transfer_mode',

            },


            {
                data: 'payout_amount',
                name: 'payout_amount',
                orderable: false
            },
             {
                data: 'payout_tdr_charged_amount',
                name: 'payout_tdr_charged_amount',
                orderable: false
            },
             {
                data: 'payout_gst_charged_amount',
                name: 'payout_gst_charged_amount',
                orderable: false
            },
             {
                data: 'payout_total_debited',
                name: 'payout_total_debited',
                orderable: false
            },
            {
                data: 'utr',
                name: 'utr',
                orderable: false
            },
            {
                data: 'ben_upi',
                name: 'ben_upi',
            },
            {
                data: 'ben_name',
                name: 'ben_name',
            },
            {
                data: 'ben_bank_acc',
                name: 'ben_bank_acc',
            },
            {
                data: 'ben_ifsc',
                name: 'ben_ifsc',
            },
            

            {
                data: 'reponse_error_message',
                name: 'reponse_error_message',
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

    var url = $('form#fund-transfer-transaction-download-form').attr('action');
    // swalnot("error","hekko");
    $("#fundtransfer-transaction-form").attr('action', url)
    $("#fundtransfer-transaction-form").attr('method', 'POST')
    $('form#fundtransfer-transaction-form').submit();
});


$(document).on('submit', '#fund-transfer-transaction-download-form', function(event) {
    event.preventDefault();
    var url = $(this).attr('action');

    // swalnot("error","hekko");
    $("#fundtransfer-transaction-form").attr('action', url)
    $("#fundtransfer-transaction-form").attr('method', 'POST')
    $('form#fundtransfer-transaction-form').submit();

});
</script>