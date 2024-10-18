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
    <h3>Ecollect Transactions </h3>

    <form id="ecollect-transaction-download-form" action="{{route('manage.payoutTransactionDwnld')}}" method="POST" role="form">
        @csrf

        <button style="margin-bottom: 10px" type="submit" class="btn btn-primary btn-sm pull-right">Download
            Excel</button>
    </form>
</div>

<div class="row">

    <form id="manage-ecollect-transaction-form">
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


                    <select id="listmerchant" name="merchant_filter" class="form-control searchFilter">
                        <option value="">All Merchants</option>
                        @foreach (get_merchnat_list() as $merchant )
                        <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                        @endforeach
                    </select>



                </div>

                <div class="col-sm-6">


                    <select id="liststatus" name="status_filter" class="form-control searchFilter">
                        <option value="">All</option>
                        @foreach (get_ecollect_status() as $status )
                        <option value="{{$status}}">{{ucwords($status)}}</option>
                        @endforeach
                    </select>


                </div>
            </div>

        </div>


           <input type="hidden" name="fordownload" value="ecollectDownld"/>


    </form>


</div>





<div style="margin-top:30px; margin-bottom:100px; ">

    <table class="table table-striped table-bordered text-nowrap " id="payout-Ecollecttransaction-table">



        <thead>

                                 <tr>

                                                        <th>#</th>
                                                        <th>Initiated At</th>
                                                        <th>Merchant Name</th>
                                                        <th>Transfer Unique Number</th>
                                                        <th>Beneficiary Account Number</th>
                                                        <th>Beneficiary IFSC Code</th>
                                                        <th>Beneficiary Name</th>
                                                        <th>Transfer Type</th>
                                                        <th>Transfer Amount</th>
                                                        <th>Transaction Status</th>
                                                        <th>Error Message</th>
                                                        <th>Received at</th>


               

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

        url: '{{url("/")}}/manage/technical/updatetransactionstatus',

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

    var start = moment().subtract(2, 'days');

    var end = moment();

    $("#manage-ecollect-transaction-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
    $("#manage-ecollect-transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));


    $('#manage-ecollect-transaction-form input[name="datetimes"]').daterangepicker({

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

        $("#manage-ecollect-transaction-form input[name='trans_from_date']").val(start.format(
            'YYYY-MM-DD HH:mm:ss'));
        $("#manage-ecollect-transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));


    });






    var table = $('#payout-Ecollecttransaction-table').DataTable({
        processing: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '
        },
        serverSide: true,
        ajax: {
            url: "{{ route('manage.payoutEcollecttransaction') }}",
            data: function(d) {
                d.search = $('input[type="search"]').val(),
                    d.form = getJsonObject($("#manage-ecollect-transaction-form").serializeArray())

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
                data: 'ecollect_transaction_date',
                name: 'ecollect_transaction_date'
            },
             {
                data: 'business_name',
                name: 'business_name'
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




});
</script>



















@endsection