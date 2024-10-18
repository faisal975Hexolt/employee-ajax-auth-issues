@php
    use App\Http\Controllers\MerchantController;

    $per_page = MerchantController::page_limit();
@endphp
@extends('layouts.merchantcontent')
@section('merchantcontent')
<!-- 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

<style>
    .transactiongid{
        color:#3c8dbc;
        cursor:pointer;
        text-align: left;
    }
    

    .thinText {
       
        line-height: 2.75rem;
    }

    .strongText {
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .headlineText{
        font-weight: 900;
        letter-spacing: 2.5px;
      
    }
    .transactiongid{
        color:#3c8dbc;
        cursor:pointer;
    }

    .active{
        color: #636b6f !important;
    }

    #ttable {
    border-radius: 10% !important;
    border-left: none;
    border-right: none;
    border-style: none;
    box-shadow: 0 0 29px 0 rgb(230 232 239 / 12%);
}



.nav-tabs > li.active > a {
    color: #333 !important;
    background-color: #d9e8eb !important;
}

.marg{
    margin-left: 20px;
}

.marg1{
    margin-left: 4px;
}
.margH{
    margin-left: -15px;
}

.tblH{
    text-align:left; 
}
.panelH{
    background-color:#ffffff !important;
}



    </style>
<!--Module Banner-->
<!-- <div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
    <button  class="btn btn-danger" id="Hide">Remove</button>
</div>
<section id="about-1" class="about-1">
    <div class="container-1">

        <div class="row">
        
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
            <h3>Transaction </h3>
            <p class="font-italic">Get your all transations detail</p>
            @if(get_merchnant_app_status())

                <p>Transaction, Refund, Order and Disputes Details</p>
             @else
                  <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
            @endif
            </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in">
            <img src="{{ asset('assets/img/trans.png') }}" width="400" height="240" class="img-fluid" id="img-dash" alt="merchant-transaction.png">
        </div>
        </div>

    </div>
</section> -->
<!--Module Banner-->
<div>
<section id="about-1" class="about-1">
    <div class="container-1">
        <div class="row">
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
                <h3 class="margH">Transaction </h3>
         
            </div>
        </div>
       
        </div>

    </div>
</section> 

    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading panelH">
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#payments">Payments</a></li>
                        <li><a data-toggle="tab" class="show-cursor" data-target="#refunds">Refunds</a></li>
                        <li><a data-toggle="tab" class="show-cursor" data-target="#orders">Orders</a></li>
                        <li><a data-toggle="tab" class="show-cursor" data-target="#disputes">Disputes</a></li>
                    </ul>
                    </br>
                    <div>
                        <form id="transaction-download-form" action="{{route('download-transactionlog')}}" method="POST" role="form">
                            
                        <div class="col-sm-4 dateMargin" id="dash_date_range_summary">
                            <input class="form-control marg1" id="transaction_download_range_summary" readonly name="transaction_download_range_summary" placeholder="MM/DD/YYYY" type="text" value="">
                                <input type="hidden" name="trans_from_date" value="">
                                <input type="hidden" name="trans_to_date" value="">
                                <input type="hidden" name="perpage" value="10">
                                <input type="hidden" name="type" value="transaction">
                           
                                
                            <span class="src">
                                <i class="fa fa-calendar dash-fa-calendar-summary"></i></span>
                            </div>   
                        
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-md butMargin"> Download</button>
                            </div>
                            {{csrf_field()}}
                        </form>

                    </div> 

                    <form action="" id="transaction-tabs-form" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="panel-body panelbdy">
                    <div class="tab-content">
                        <div id="payments" class="tab-pane fade in active">
                            <div class="row transrow">
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <select name="page_limit" class="form-control marg" onchange="setTransactionsPage($(this).val())">
                                                @foreach($per_page as $index => $page)
                                                <option value="{{$index}}">{{$page}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- <div class="col-sm-10">
 
                                            <form id="transaction-download-form" action="{{route('download-transactionlog')}}" method="POST" role="form">
                                               <div class="col-sm-8" id="dash_date_range_summary">
                                                 <input class="form-control" id="transaction_download_range_summary" name="transaction_download_range_summary" placeholder="MM/DD/YYYY" type="text" value="">
                                                    <input type="hidden" name="trans_from_date" value="">
                                                    <input type="hidden" name="trans_to_date" value="">
                                                     <input type="hidden" name="perpage" value="10">
                                                     <input type="hidden" name="type" value="transaction">
                                                   <span class="src">
                                                    <i class="fa fa-calendar dash-fa-calendar-summary"></i></span>
                                                 </div>   
                                               
                                                <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-primary btn-sm">Download</button>
                                                </div>
                                                {{csrf_field()}}
                                            </form>

                                        </div> -->
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="transaction-table" placeholder="Search">
                                            <!-- <i class="fa fa-search"></i> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_payment">
                                        
                                    </div>
                                </div>
                                <!-- Transactiond Details Modal -->
                                <div id="transaction-details-modal" class="modal" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Transactiond Details Modal content-->
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Transaction Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" id="edit-transaction-form">
                                                <div class="form-group">
                                                    <label for="transactionid" class="control-label col-sm-4">Transaction Id</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="transaction_gid_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="orderid" class="control-label col-sm-4">Order Id</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="order_gid_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="transactionemail" class="control-label col-sm-4">Transaction Email</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="transaction_email_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="transactioncontact" class="control-label col-sm-4">Transaction Contact</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="transaction_contact_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="transactionamount" class="control-label col-sm-4">Transaction Amount</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="transaction_amount_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="transactionstatus" class="control-label col-sm-4">Transaction Status</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="transaction_status_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="createddate" class="control-label col-sm-4">Created Date</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="created_date_label"></label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        </div>

                                    </div>
                                </div>


                                 <!-- Transactiond Details Modal 1 -->
                        <div id="detail-transaction-model" class="modal" role="dialog">
                            <div class="modal-dialog modal-lg" role="document" style="width:1200px">

                                <!-- Modal content-->
                                <div class="modal-content">
                                <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" id="">Transaction Details</h4>
                                        </div>
                                <div class="modal-body">
                                    <div class="model-content" id="modal-dynamic-body">
                                        <div id="paylink-add-form">
                                       
                                        
                                            <div id="transaction_details_view" class="row" >
                                                
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div id="refund-transaction-model" class="modal" role="dialog">
                            <div class="modal-dialog" role="document" style="width:800">

                                <!-- Modal content-->
                                <div class="modal-content">
                                <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" id="detailTitle">Transaction Details</h4>
                                        </div>
                                <div class="modal-body">
                                    <div class="model-content" id="modal-dynamic-body">
                                        <div id="paylink-add-form">
                                       
                                        <div class="tab-content1">
                                            <div id="transaction_refund_view" >
                                                
                                            </div>
                                           
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transactiond Details Modal code ends-->
                            </div>
                        </div>
                        <div id="refunds" class="tab-pane ">
                            <div class="row transrow">
                                <div class="col-sm-7">
                                    <div class="col-sm-2">
                                        <select name="page_limit" class="form-control marg1" onchange="getAllPayments($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="refund-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_refund">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="orders" class="tab-pane ">
                            <div class="row transrow">
                                 <div class="col-sm-7">
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                             <select name="page_limit" class="form-control marg1" onchange="getAllOrders($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                        </div>
                                        
                                        <div class="col-sm-10">
                                            <form id="order-download-form" action="{{route('download-transactionlog')}}" method="POST" role="form">
                                               <div class="col-sm-8 ">      
                                                 <input class="form-control" id="order_download_range" name="order_download_range" placeholder="MM/DD/YYYY" type="text" value="">
                                                    <input type="hidden" name="order_from_date" value="">
                                                    <input type="hidden" name="order_to_date" value="">
                                                     <input type="hidden" name="perpage" value="10">
                                                       <input type="hidden" name="type" value="order">
                                                    <span class="src">
                                                    <i class="fa fa-calendar order-fa-calendar-summary"></i></span>
                                                 </div>   
<!--                                                
                                                <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-primary btn-sm">Download</button>
                                                </div> -->
                                                {{csrf_field()}}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="search-box">
                                         <form action="">
                                            <input type="search" id="order-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_order">
                                         
                                    </div>
                                </div>
                                <!-- Order Details Modal -->
                                <div id="order-details-modal" class="modal" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Order Details Modal content-->
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Order Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" id="edit-order-form">
                                                <div class="form-group">
                                                    <label for="orderid" class="control-label col-sm-4">Order Id</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="order_gid_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="transactionid" class="control-label col-sm-4">Transaction Id</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="transaction_gid_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="orderreceipt" class="control-label col-sm-4">Order Receipt</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="order_receipt_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="orderattempts" class="control-label col-sm-4">Order Attempts</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="order_attempts_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="orderamount" class="control-label col-sm-4">Order Amount</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="order_amount_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="orderstatus" class="control-label col-sm-4">Order Status</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="order_status_label"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="createddate" class="control-label col-sm-4">Created Date</label>
                                                    <div class="col-sm-5">
                                                        <label for="" class="cotrol-label col-sm-12" id="created_date_label"></label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="disputes" class="tab-pane">
                            
                            <div class="row transrow">
                                <div class="col-sm-7">
                                    <div class="col-sm-2">
                                        <select name="page_limit" class="form-control marg1" onchange="getAllDisputes($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="dispute-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_dispute">
                                        
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


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script>
  const downloadCsvData = (function () {
        const a = document.createElement("a");
        document.body.appendChild(a);
        a.style = "display: none";
        return function (data, fileName) {
            const blob = new Blob([data], {type: "octet/stream"}),
            url = window.URL.createObjectURL(blob);
            a.href = url;
            a.download = fileName;
            a.click();
            window.URL.revokeObjectURL(url);
        };
    }());
 
    
    function deleteCsvFile(jobId){
        $.ajax({
            type: "GET",
            url: base_phpurl+"/merchant/transactions/deleteCsvFile/"+jobId,
            dataType: "json",
            success: function(response) {
                console.log("deleteCsvFile",response);
            }
        });
    }
    function downloadTransactionSett(){
        let downloadTrnsBtn = document.getElementById('downloadTrnsBtn');
        downloadTrnsBtn.textContent = 'Please Wait...';
        $('#downloadTrnsBtn').attr('disabled','disabled');
        var token = $("meta[name='csrf-token']").attr("content");
        var formdata = {};
        $.ajax({
            type: "POST",
            url: "{{ route('download-transactionlog-ajx') }}",
            data: {  _token: token },
            dataType: "json",
            success: function(response) {
                var jobId = response.jobId;
                pollJobStatus(jobId);
            }
        });
    }

    function pollJobStatus(jobId) {
        var jobIdres  = jobId;
        var pollingInterval =   1000;

        var checkStatus = function () {
            $.ajax({
                url: base_phpurl+"/merchant/transactions/checkJobStatus/"+jobIdres,
                method: 'GET',
                success: function (response) {
                    console.log("response",response);
                if (response.completed) {
                    $('#filenamepathid').text(response.filePath);
                    downloadCsvData(response.file, response.filePath);
                    let downloadTrnsBtn1 = document.getElementById('downloadTrnsBtn');
                    downloadTrnsBtn1.textContent = 'Download CSV';
                    $("#downloadTrnsBtn").removeAttr("disabled");
                    setTimeout(deleteCsvFile(response.jobId), 5000);
                } else {
                    setTimeout(function() {
                        pollJobStatus(response.jobId)
                    }, pollingInterval);
                }
            }
            });
        };
        // Start the initial checkStatus
        checkStatus();
    }


    

</script>

 

@endsection