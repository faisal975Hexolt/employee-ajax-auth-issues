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
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li>
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                    @switch($index)
                    @case("0")
                    <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                        <div class="row">
                            <form id="live-merchant-download-form" action="{{route('briefdwnld')}}" method="POST" role="form">
                                @csrf
                                
                                <button style="margin-bottom: 10px" type="submit" class="btn btn-primary btn-sm pull-right">Download Excel</button>
                            </form>
                        </div>
                        <div class="row">
                            <form id="live-merchant-form" >
                                @csrf
                                <div class="row" style="margin-top:15px;">
                                    <div class="col-sm-12 mb-5">
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                
                                                
                                                <input type="text" name="searchfor" id="search" class="searchfor form-control "  placeholder="Search Anything here">
                                                
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-secondary"><i class="glyphicon glyphicon-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text"  class="searchFilter" name="datetimes" id="datetimes"
                                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                                            <input type="hidden" name="trans_from_date" value="">
                                            <input type="hidden" name="trans_to_date" value="">
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-top:15px;">
                                    <div class="col-sm-12 mb-5">
                                        <div class="col-sm-6">
                                            
                                            
                                            <select id="listmerchant" name="merchant_filter" class="form-control searchFilter" >
                                                <option value="">All Merchants</option>
                                                @foreach (App\User::get_merchant_lists() as $merchant )
                                                <option value="{{$merchant->id}}">{{$merchant->mid." : ".$merchant->merchant_gid}}</option>
                                                @endforeach
                                            </select>
                                            
                                            
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            
                                            
                                            <select id="liststatus" name="status_filter" class="form-control searchFilter" >
                                                <option value="">All</option>
                                                @foreach (get_merchant_block_status() as $status )
                                                <option value="{{$status}}">{{ucwords($status)}}</option>
                                                @endforeach
                                            </select>
                                            
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                
                            </form>
                        </div>
                        
                        <div class="col-sm-12">
                            <div style="margin-top:30px; margin-bottom:100px; ">
                                <table class="table table-striped table-bordered text-nowrap " id="merchant-livelist-table" style="width: 100%;">
                                    <thead>
                                         <tr>


                <th>#</th>
                <th>Merchant Id</th>
                <th >Name</th>
                <th >Company Name</th>
                <th>Company Type</th>
                <th>Merchant Mode</th>
                <th>Change App Mode</th>
                
                <th>Created On</th>
                <th>Account Status</th>
                <th>Merchant Status</th>
                <th>OnBoarding Status</th>
                <th>Action</th>
            </tr>

                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                @break
                
                @default
                @break
                @endswitch
                @endforeach
                @else
                <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<script src="{{ asset('js/jquery-3.5.1.min.js') }}" crossorigin="anonymous"></script>

<script type="module" src="{{ asset('js/ionicons.esm.js') }}"></script>
<script>

   



    $(function() {

        var start = moment().subtract(1, 'years');

        var end = moment();

         $("#live-merchant-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
         $("#live-merchant-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));


         $('#live-merchant-form input[name="datetimes"]').daterangepicker({
       

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
                 'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],

                'This Year': [moment().startOf('year'), moment().endOf('year')],

            }

        }, function(start, end, label) {
                         

            $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

          $("#live-merchant-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#live-merchant-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));


        });




    var table = $('#merchant-livelist-table').DataTable({
    processing: true,
    language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '},
    serverSide: true,
    ajax: {
        url: "{{ route('get_approved_merchants_list') }}",
        data: function(d) {
            d.search = $('input[type="search"]').val(),
            d.form=getJsonObject($("#live-merchant-form").serializeArray())

        }
        
    },
    drawCallback: function(settings) {
       // $(".loader").hide();
  },
    order: [[1, 'asc']],
    lengthMenu: [
            [10, 25, 50,100,200,-1],
            [10, 25, 50,100,200,'All'],
        ],
    scrollX: true,
    sScrollXInner: "100%",
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'action_gid',
            name: 'action_gid',
             orderable: false
        },
         {
            data: 'mer_name',
            name: 'mer_name'
        },
        {
            data: 'business_name',
            name: 'business_name'
        },
       

        {
            data: 'type_name',
            name: 'type_name'
        },
         {
            data: 'app_mode',
            name: 'app_mode'
        },
        {
            data: 'change_app_mode',
            name: 'change_app_mode',
             orderable: false
        },
        {
            data: 'created_date',
            name: 'created_date'
             
        },
        {
            data: 'action_account_status',
            name: 'merchant_status',
             orderable: false
        },
         {
            data: 'action_account_status',
            name: 'merchant_status',
             orderable: false
        },
         {
            data: 'action_account_status',
            name: 'merchant_status',
             orderable: false
        },
       
        
        {
            data: 'action_btn',
            name: 'action_btn',
            orderable: false,
            searchable: false
        },
    ]
});


       $('#search').on('input', function() {
            var search = $(this).val();
            if(search.length<4){
                    return true;
            }
            table.draw();
        });


       $(document).on('change', '.searchFilter', function(event){
        var target = $( event.target );
        var search = $(this).val();
        
        if(search.length<4){
                    return true;
            }
         var elementType = $(this).prop('nodeName');
        
         
         table.draw();
       });


     });

        </script>
@endsection