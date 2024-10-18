@php

$vendor_banks = App\RyapayVendorBank::get_vendorbank();

@endphp

@extends('layouts.employeecontent')

@section('employeecontent')



<style>

    .dataTables_filter {

        display: none;

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



<h3>Transactions</h3>



<div class="row">
<form id="show-tecnical-transaction-form">
    <div class="col-sm-6">

        <input type="text" id="search" class="form-control" placeholder="search ..">

    </div>

    <div class="col-sm-6">

        <input type="text" name="datetimes" id="datetimes" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />

    </div>
</form>

</div>





<div style="margin-top:30px; margin-bottom:100px; ">

    <table class="table table-striped table-bordered text-nowrap" id="transactions">



        <thead>

            <tr>

                <th>#</th>
                 <th>Transaction Initiation Time</th>
                <th>Transaction Gid</th>
                <th>Order Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>
        </tbody>

    </table>

</div>





<!-- infomodal -->

<div class="modal fade" id="infomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLongTitle">Transaction Info</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">



                <table class="table table-striped" style="width:100%">



                    <tr>

                        <th>Status</th>

                        <td class="text-info" id="status"></td>

                    </tr>

                </table>





                <div id="infotable" style="display:none;">

                    <table class="table table-striped" style="width:100%">



                        <tr>

                            <th>Amount</th>

                            <td id="amount"></td>

                        </tr>

                        <tr>

                            <th>Date</th>

                            <td id="date"></td>

                        </tr>

                        <tr>

                            <th>Message</th>

                            <td id="message"></td>

                        </tr>

                        <tr>

                            <th>Order Id</th>

                            <td id="orderid"></td>

                        </tr>

                        <tr>

                            <th>Transaction Status</th>

                            <td id="txstatus"></td>

                        </tr>





                    </table>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>

<!-- infomodalends -->



<!-- updatestatusmodal -->

<div class="modal fade" id="updatestatusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

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



<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>


<script>


    $(document).ready(function () {
            $('#transactions').DataTable({
                    scrollX: true,
            });
    });

    $(document).on('click', '.transactiongid', function() {

        console.log('%ctransactions.blade.php line:345 transaction gid clicked', 'color: #007acc;', 'transaction gid clicked');

         var transactionId = (this).innerHTML;
      
         console.log(transactionId);

        admintransactionDetailsView(transactionId);
        return true;

    })

</script>



<script>

    $(document).on('click', '.callinfo', function() {

        console.log('%ctransactions.blade.php line:67 object', 'color: #007acc;', 'cdsaf');

        var merchant = $(this).attr('merchant');

        var mode = $(this).attr('mode');

        var orderid = $(this).attr('orderid');

        console.log('%ctransactions.blade.php line:67 object', 'color: #007acc;', orderid, mode, merchant);

        $('#infomodal').modal('show');



        $.ajax({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },

            type: "GET",

            dataType: "json",

            url: "{{url('/')}}/manage/technical/findvendortransactionstatus",

            data: {

                'transactionmode': mode,

                'merchantid': merchant,

                'transactionid': orderid

            },

            success: function(data) {

                console.log(data);



                if (data.Found == false) {

                    console.log('%ctransactions.blade.php line:110 ', 'color: #007acc;', 'data not foound');

                    $("#status").html('Not Found');

                    $("#infotable").hide();

                } else {

                    console.log('%ctransactions.blade.php line:110 ', 'color: #007acc;', 'foound');

                    $("#status").html('Found');





                    $("#infotable").show();

                    $("#amount").html(data.data.amount);

                    $("#date").html(data.data.date);

                    $("#message").html(data.data.msg);

                    $("#orderid").html(data.data.order_id);

                    $("#txstatus").html(data.data.status);



                }





            }

        })

    });

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

    $('#search').on('input', function() {

        var search = $(this).val();

        $('#transactions').DataTable().destroy();

        var startDate = moment($('#datetimes').data('daterangepicker').startDate).format('YYYY-MM-DD');

        var endDate = moment($('#datetimes').data('daterangepicker').endDate).format('YYYY-MM-DD');

        console.log(search, startDate, endDate);

        $.ajax({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },

            type: "GET",

            dataType: "json",

            url: '{{url("/")}}/manage/technical/searchtransactions',

            data: {

                'search': search,

                'startdate': startDate,

                'enddate': endDate

            },

            success: function(data) {

               // console.log(data);

                $('#transactions tbody').html(``);

                data.forEach((element, index) => {

                    if (element.transaction_status == 'pending') {

                        $('#transactions tbody').append(`<tr><td>${index+1}</td><td>${element.created_date}</td><td class="transactiongid">${element.transaction_gid}</td><td>${element.order_gid}</td><td>${element.transaction_username}</td><td>${element.transaction_email}</td><td>${element.transaction_contact}</td><td>${element.transaction_amount}</td><td>${element.transaction_status}</td>

                            <td><button class="btn btn-sm btn-warning callinfo"  merchant=${element.created_merchant} orderid=${element.transaction_gid} mode=${element.transaction_mode}><ion-icon name="information-circle-outline"></ion-icon></button> 

                            <button orderid=${element.transaction_gid}  class="updatestatus btn btn-sm btn-success"><ion-icon  name="card-outline"></ion-icon></button></td>


                            </tr>`);

                    } else {

                        $('#transactions tbody').append(`<tr><td>${index+1}</td><td>${element.created_date}</td><td class="transactiongid">${element.transaction_gid}</td><td>${element.order_gid}</td><td>${element.transaction_username}</td><td>${element.transaction_email}</td><td>${element.transaction_contact}</td><td>${element.transaction_amount}</td><td>${element.transaction_status}</td><td><button class="btn btn-sm btn-warning callinfo"  merchant=${element.created_merchant} orderid=${element.transaction_gid} mode=${element.transaction_mode}><ion-icon name="information-circle-outline"></ion-icon></button></td></tr>`);

                    }

                });



                $('#transactions').DataTable({
                            scrollX: true,
                    }).draw();



            }

        })

    })

</script>



<script type="text/javascript">

    $(function() {



        var start = moment().subtract(0, 'days');

        var end = moment();





        function cb(start, end) {

            $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            var search = $('#search').val();

            $('#transactions').DataTable().destroy();

            $.ajax({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                type: "GET",

                dataType: "json",

                url: '{{url("/")}}/manage/technical/searchtransactions',

                data: {

                    'search': search,

                    'startdate': start.format('YYYY-MM-DD'),

                    'enddate': end.format('YYYY-MM-DD')

                },

                success: function(data) {



                  //  console.log('cb function', data);

                    $('#transactions tbody').html(``);

                    data.forEach((element, index) => {

                        if (element.transaction_status == 'pending') {

                            $('#transactions tbody').append(`<tr><td>${index+1}</td><td>${element.created_date}</td><td class="transactiongid">${element.transaction_gid}</td><td>${element.order_gid}</td><td>${element.transaction_username}</td><td>${element.transaction_email}</td><td>${element.transaction_contact}</td><td>${element.transaction_amount}</td><td>${element.transaction_status}</td><td><button class="btn btn-sm btn-warning callinfo" merchant=${element.created_merchant} orderid=${element.transaction_gid} mode=${element.transaction_mode}><ion-icon  name="information-circle-outline"></ion-icon></button> <button orderid=${element.transaction_gid} class="updatestatus btn btn-sm btn-success" ><ion-icon   name="card-outline"></ion-icon></button></td></tr>`);

                        } else {

                            $('#transactions tbody').append(`<tr><td>${index+1}</td><td>${element.created_date}</td><td class="transactiongid">${element.transaction_gid}</td><td>${element.order_gid}</td><td>${element.transaction_username}</td><td>${element.transaction_email}</td><td>${element.transaction_contact}</td><td>${element.transaction_amount}</td><td>${element.transaction_status}</td><td><button class="btn btn-sm btn-warning callinfo" merchant=${element.created_merchant} orderid=${element.transaction_gid} mode=${element.transaction_mode}><ion-icon  name="information-circle-outline"></ion-icon></button></td></tr>`);

                        }



                    });



                    $('#transactions').DataTable({
                                scrollX: true,
                        }).draw();



                }

            })



        }


         $('#show-tecnical-transaction-form input[name="datetimes"]').daterangepicker({
       

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

                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],

                'This Year': [moment().startOf('year'), moment().endOf('year')],

            }

        }, cb);



        cb(start, end);





    });

</script>



















@endsection