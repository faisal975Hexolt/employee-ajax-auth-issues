@extends('layouts.merchantcontent')
@section('merchantcontent')

<!--Module Banner-->
<section id="about-1" class="about-1 ">

    <div class="container-1">

        <div class="row">

            <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                <div class="content-1 pt-4 pt-lg-0">

                    <h3 class="margH">Settlement Summary </h3>



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
                        @php ($trans = ['merchant/settlements' => '<a data-toggle="tab" class="show-cursor"
                            data-target="#settlements" onclick="changeTab(this);">Settlement List</a>'])
                        @foreach($trans as $index=>$value)
                        <li class="{{ Request::path() == $index ?'active' : ''}} active">{!! $value !!}</li>
                        @endforeach
                    </ul>
                    <form action="" id="transaction-tabs-form" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="panel-body panelH">
                    <div class="tab-content">
                        <div id="settlements" class="tab-pane fade in active">
                           
                            <div class="row">
                                <div class="col-sm-12">
                                    <form id="summary-brief-transaction-form">


                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">

                                                <div class="row" style="margin-top:15px;">
                                                    <div class="col-sm-12 mb-5">
                                                        <div class="col-sm-3 ">
                                                            <input class="form-control searchfor" id="search"
                                                                name="searchfor" type="text" value=""
                                                                placeholder="Search anything here">
                                                            <span class="src">
                                                                <i class="fa fa-search "></i></span>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <input class="form-control searchFilter" id="datetimes"
                                                                name="datetimes" placeholder="MM/DD/YYYY" type="text"
                                                                value="" readonly>
                                                            <input type="hidden" name="trans_from_date" value="">
                                                            <input type="hidden" name="trans_to_date" value="">

                                                            <span class="src">
                                                                <i
                                                                    class="fa fa-calendar summary-brief-transaction-form-summary"></i></span>
                                                        </div>

                                                        <div class="col-sm-3">
                                                        <select id="liststatus" name="status_filter"
                                                                class="form-control ">
                                                                <option value="">All</option>
                                                                @foreach (get_settlement_status() as $status )
                                                                <option value="{{$status}}">{{ucwords($status)}}
                                                                </option>
                                                                @endforeach
                                                            </select>


                                                        </div>

                                                        <div class="col-sm-2">
                                                            <form id="summary-brief-transaction-download-form"
                                                                action="{{route('settlementsummaryDwnld')}}" method="POST" role="form">
                                                                @csrf
                                                                <div class="tab-button">
                                                                    <button  type="submit" class="btn btn-primary btn-md pull-right"> Download</button> 
                                                                    <!-- <a type="submit" href="#" class="btn btn-primary btn-sm dwd-brief"><i class="fa fa-download"></i> Download
                                                                        Excel</a>  -->
                                                                                                        
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div> 
                                            </div>
                                        </div>                                                  
                                    </form> 
                                </div>
                            </div>
                            </br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block">
                                        <div class="table-responsive1">
                                            <table class="display responsive table table-striped table-bordered "
                                                id="summary_transactions_breif" style="width:100%">
                                                <thead>

                                                    <tr>

                                                        <th>#</th>
                                                        <th>Initiated At</th>
                                                        <th>Settlement Id</th>
                                                        <th>Merchant Id</th>
                                                        <th>Period</th>
                                                        <th>UTR No.</th>
                                                        <th>Amount</th>
                                                        <th>Charges</th>
                                                        <th>Adjustments</th>

                                                        <th>Refunds</th>
                                                        <th>Settling Amount</th>
                                                        <th>Status</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>

                                                </thead>

                                               
                                                <tbody id="settlementsummarytable">

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



<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>


<script>
$(function() {


    $(".summary-brief-transaction-form-summary").click(function(e) {
        e.preventDefault();
        $("input[name='datetimes']").focus();
    })

    var start = moment().subtract(2, 'days');

    var end = moment();

    $("#summary-brief-transaction-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD HH:mm:ss'));
    $("#summary-brief-transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));


    $('#summary-brief-transaction-form input[name="datetimes"]').daterangepicker({
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

        $("#summary-brief-transaction-form input[name='trans_from_date']").val(start.format(
            'YYYY-MM-DD HH:mm:ss'));
        $("#summary-brief-transaction-form input[name='trans_to_date']").val(end.format(
            'YYYY-MM-DD HH:mm:ss'));


    });


    var table = $('#summary_transactions_breif').DataTable({
        fnInitComplete: function(){
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
            url: "{{ route('getSettlementSummary') }}",
            data: function(d) {
                // $(".loader_custom").show();
                d.search = $('input[type="search"]').val(),
                    d.form = getJsonObject($("#summary-brief-transaction-form").serializeArray())

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
                data: 'created_at',
                name: 'created_at'
            },

            {
                data: 'settlement_brief_gid',
                name: 'settlement_brief_gid'
            },
            {
                data: 'merchant_gid',
                name: 'merchant_gid'
            },

            {
                data: 'period',
                name: 'transaction_form',
                orderable: false
            },
            {
                data: 'bank_utr',
                name: 'bank_utr',
                orderable: false
            },
            {
                data: 'transaction_amount',
                name: 'transaction_amount',
                orderable: false
            },
            {
                data: 'transaction_total_charged_amount',
                name: 'transaction_total_charged_amount',
                orderable: false
            },
            {
                data: 'transaction_total_adjustment',
                name: 'transaction_total_adjustment',
                orderable: false
            },


            {
                data: 'transaction_total_refunded',
                name: 'transaction_total_refunded',
                orderable: false
            },
            {
                data: 'transaction_total_settlement',
                name: 'transaction_total_settlement',
                orderable: false
            },
            {
                data: 'settlement_status',
                name: 'settlement_status'
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

    $(document).on('change', '#liststatus', function(event) {
        var target = $(event.target);
        var search = $(this).val();

        var elementType = $(this).prop('nodeName');


        table.draw();
    });



});



$(document).on('click', '.dwd-brief', function(event) {
    event.preventDefault();

    var url = $('form#summary-brief-transaction-download-form').attr('action');
    // swalnot("error","hekko");
    $("#summary-brief-transaction-form").attr('action', url)
    $("#summary-brief-transaction-form").attr('method', 'POST')
    $('form#summary-brief-transaction-form').submit();
});


$(document).on('submit', '#summary-brief-transaction-download-form', function(event) {
    event.preventDefault();
    var url = $(this).attr('action');

    // swalnot("error","hekko");
    $("#summary-brief-transaction-form").attr('action', url)
    $("#summary-brief-transaction-form").attr('method', 'POST')
    $('form#summary-brief-transaction-form').submit();

});
</script>