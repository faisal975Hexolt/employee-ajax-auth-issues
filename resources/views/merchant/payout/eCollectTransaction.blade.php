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
                <h3 class="margH">Ecollect Transactions </h3>
         
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
                        @php ($trans = ['merchant/payoutecollecttransaction' => '<a data-toggle="tab"
                            class="show-cursor" data-target="#settlements" onclick="changeTab(this);">List of Ecollect
                            Transactions</a>'])
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
                            <form id="ecollect-transaction-download-form"
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
                                            <form id="ecollect-transaction-form">
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
                                                                    class="fa fa-calendar ecollect-transaction-form-summary"></i></span>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <select id="liststatus" name="status_filter"
                                                                class="form-control ">
                                                                <option value="">All</option>
                                                                @foreach (get_ecollect_status() as $status )
                                                                <option value="{{$status}}">{{ucwords($status)}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <input type="hidden" name="fordownload" value="ecollectDownld"/>

                                            </form>
                                        </div>

                                    
                            <div>
                                <div class="col-sm-12">
                                    <div class="display-block">
                                        <div class="table-responsive1">
                                            <table class="display responsive table table-striped table-bordered text-nowrap"
                                                id="ecollect_transactions_table" style="width:100%">
                                                <thead>

                                                    <tr>

                                                        <th>#</th>
                                                        <th>Initiated At</th>
                                                        <th>Transfer Unique Number</th>
                                                        <th>Beneficiary Account Number</th>
                                                        <th>Beneficiary IFSC Code</th>
                                                        <th>Beneficiary Name</th>
                                                        <th>Transfer Type</th>
                                                        <th>Transfer Amount</th>
                                                        <th>Transaction Status</th>
                                                        <th>Error Message</th>
                                                        <th>Received at</th>

                                                        <!-- <th>Action</th> -->
                                                    </tr>

                                                </thead>


                                                <tbody id="ecollecttransactionstable">

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


    $(".ecollect-transaction-form-summary").click(function(e) {
        e.preventDefault();
        $("input[name='datetimes']").focus();
    })

    var start = moment().subtract(2, 'days');

    var end = moment();

    $("#ecollect-transaction-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD HH:mm:ss'));
    $("#ecollect-transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));


    $('#ecollect-transaction-form input[name="datetimes"]').daterangepicker({
        dateLimit: {
                    days: 61
                },
        minDate: moment().subtract(365, 'days'),
        maxDate: moment(),
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
                .subtract(1, 'month').endOf('month').endOf('day')],
            'Last 2 Month': [moment().subtract(2, 'month').startOf('day').startOf('month'), moment()
                .subtract(1, 'month').endOf('month').endOf('day')]
        },

    }, function(start, end, label) {


        $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
            'MMMM D, YYYY'));

        $("#ecollect-transaction-form input[name='trans_from_date']").val(start.format(
            'YYYY-MM-DD HH:mm:ss'));
        $("#ecollect-transaction-form input[name='trans_to_date']").val(end.format(
            'YYYY-MM-DD HH:mm:ss'));


    });


    var table = $('#ecollect_transactions_table').DataTable({
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
            url: "{{ route('payoutecollecttransaction') }}",
            data: function(d) {
                // $(".loader_custom").show();
                d.search = $('input[type="search"]').val(),
                    d.form = getJsonObject($("#ecollect-transaction-form").serializeArray())

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
                data: 'ecollect_transaction_date',
                name: 'ecollect_transaction_date'
            },

            {
                data: 'transfer_id',
                name: 'transfer_id'
            },
             {
                data: 'merchnat_ben_bank_acc',
                name: 'merchnat_ben_bank_acc'
            },
             {
                data: 'merchnat_ben_ifsc',
                name: 'merchnat_ben_ifsc'
            },
             {
                data: 'merchnat_ben_name',
                name: 'merchnat_ben_name'
            },
            {
                data: 'transfer_mode',
                name: 'transfer_mode',
                orderable: false
            },
            {
                data: 'received_total_amount',
                name: 'received_total_amount',
                orderable: false
            },
            {
                data: 'transaction_status',
                name: 'transaction_status'
            },
            {
                data: 'reponse_error_message',
                name: 'reponse_error_message'
            },
           
            {
                data: 'ecollect_received_date',
                name: 'ecollect_received_date',
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

    var url = $('form#ecollect-transaction-download-form').attr('action');
    // swalnot("error","hekko");
    $("#ecollect-transaction-form").attr('action', url)
    $("#ecollect-transaction-form").attr('method', 'POST')
    $('form#ecollect-transaction-form').submit();
});


$(document).on('submit', '#ecollect-transaction-download-form', function(event) {
    event.preventDefault();
    var url = $(this).attr('action');

    // swalnot("error","hekko");
    $("#ecollect-transaction-form").attr('action', url)
    $("#ecollect-transaction-form").attr('method', 'POST')
    $('form#ecollect-transaction-form').submit();

});
</script>