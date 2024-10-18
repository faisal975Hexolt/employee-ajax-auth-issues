@extends('layouts.merchantcontent')
@section('merchantcontent')
<style>

.panelH{
    background-color:#ffffff !important;
}
.margH{
    margin-left: -15px;
}

.nav-tabs > li.active > a {
    color: #333 !important;
    background-color: #d9e8eb !important;
}
    </style>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


  <section id="about-1" class="about-1">
    <div class="container-1">
        <div class="row">
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
                <h3 class="margH">Settlements </h3>
         
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
                        @php ($trans = ['merchant/settlements' => '<a data-toggle="tab" class="show-cursor" data-target="#settlements" onclick="changeTab(this);">Settlements</a>'])
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sno</th>
                                                        <th>Adjustment Id</th>
                                                        <th>Amount</th>
                                                        <th>Fees</th>
                                                        <th>Tax</th>
                                                        <th>Created At</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="settlementtable">
                                                    @if(count($settlements)>0)
                                                    @php($table_count=0)
                                                    @foreach($settlements as $settlement)
                                                    <tr>
                                                        <td>{{++$table_count}}</td>
                                                        <td>{{$settlement->settlement_gid}}</td>
                                                        <td>{{$settlement->settlement_amount}}</td>
                                                        <td>{{$settlement->settlement_fee}}</td>
                                                        <td>{{$settlement->settlement_tax}}</td>
                                                        <td>{{$settlement->created_date}}</td>
                                                        <td>{{$settlement->status}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td class="text-center" colspan=7>No Data found</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <div></div>
                                                </tfoot>
                                            </table>
                                            <div class="col-sm-6">
                                                <h5 class="pagination">Showing {{$settlements->firstItem()}} to {{$settlements->lastItem()}} of {{$settlements->total()}} entries</h5> 
                                            </div>
                                            <div class="col-sm-6">
                                                <span class="pull-right">
                                                    <ul class="pagination">
                                                        <li><a href="{{$settlements->previousPageUrl()}}">Previous</a></li>
                                                        <li><a href="javascript:">{{$settlements->currentPage()}}</a></li>
                                                        <li><a href="{{$settlements->nextPageUrl()}}">Next</a></li>
                                                    </ul>
                                                </span>
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
    </div>
@endsection