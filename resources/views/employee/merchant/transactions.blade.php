@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                            <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">No Of Transactions</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#transaction-volume">Total Transactions Amount</a></li> 
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                        
                        </div>
                        @else
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                        
                        </div>
                        @endif
                    @endforeach
                    @else
                        <div class="src srct">
                            <form id="transaction-form" class="mer_trans_date_range_form">
                                <input class="form-control" id="mer_trans_date_range" name="mer_trans_date_range" placeholder="MM/DD/YYYY" type="text" value="">
                                <input type="hidden" name="trans_from_date" value="{{session('trans_from_date')}}">
                                <input type="hidden" name="trans_to_date" value="{{session('trans_to_date')}}">
                                <input type="hidden" name="transaction_page" value="count">
                                <input type="hidden" name="mode" value="">
                                <i class="fa fa-calendar"></i>
                                {{csrf_field()}} 
                            </form>
                        </div>

                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">

                            <div class="row">
                                <div class="col-sm-12">
                                      <div class="row margin-bottom-lg "> 
                                             <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <form id="no-merchant-transaction-download-form" action="{{route('transactionSumDownload')}}" method="POST" role="form">
                                                    <input type="hidden" name="mode" value="no_of_tran">
                                                    <button type="submit" class="btn btn-primary btn-sm">Download Excel</button>
                                                    </form>
                                                </div>
                                           </div>
                                        </div>
                                    <div id="paginate_nooftransaction">

                                    </div>
                                </div>
                            </div>                          
                        </div>
                        <div id="transaction-volume" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row margin-bottom-lg "> 
                                             <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <form id="total-merchant-transaction-download-form" action="{{route('transactionSumDownload')}}" method="POST" role="form">
                                                     <input type="hidden" name="mode" value="total_of_tran">
                                                    <button type="submit" class="btn btn-primary btn-sm">Download Excel</button>
                                                    </form>
                                                </div>
                                           </div>
                                        </div>
                                    <div id="paginate_transactionamount">

                                    </div>
                                </div>
                            </div>                       
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded',function(e){
        e.preventDefault();
        loadMerchantNoOfTransaction();
    });
</script>
@endsection
