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
                            <form id="blocked-merchant-download-form" action="{{route('briefdwnld')}}" method="POST" role="form">
                                @csrf
                                
                                <button style="margin-bottom: 10px" type="submit" class="btn btn-primary btn-sm pull-right">Download Excel</button>
                            </form>
                        </div>
                        <div class="row">
                            <form id="blocked-merchant-form" >
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
                                <table class="table table-striped table-bordered text-nowrap " id="merchant-blockedlist-table" style="width: 100%;">
                                    <thead>
                                         <tr>

                <th>#</th>
                <th>Initiated At</th>
                <th>Merchant Id</th>
                <th>Merchant Name</th>
                <th>Blocked At</th>
                <th>Block Status</th>
                <th>Status</th>
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

        var start = moment().subtract(2, 'days');

        var end = moment();

         $("#blocked-merchant-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
         $("#blocked-merchant-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));


         $('#blocked-merchant-form input[name="datetimes"]').daterangepicker({
       

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

        }, function(start, end, label) {
                         

            $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

          $("#blocked-merchant-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#blocked-merchant-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));


        });




    var tablemerchantBlockedList = $('#merchant-blockedlist-table').DataTable({
    processing: true,
    language: {
            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '},
    serverSide: true,
    ajax: {
        url: "{{ route('merchantBlockedList') }}",
        data: function(d) {
            d.search = $('input[type="search"]').val(),
            d.form=getJsonObject($("#blocked-merchant-form").serializeArray())

        }
        
    },
    drawCallback: function(settings) {
       // $(".loader").hide();
  },
    order: [[1, 'desc']],
    lengthMenu: [
            [10, 25, 50,100,200,-1],
            [10, 25, 50,100,200,'All'],
        ],
    scrollX: true,
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'merchant_gid',
            name: 'merchant_gid'
        },
        {
            data: 'merchant_username',
            name: 'merchant_username'
        },

        {
            data: 'blocked_at',
            name: 'blocked_at'
        },
        {
            data: 'blocked_status',
            name: 'blocked_status',
             orderable: false
        },
        {
            data: 'status',
            name: 'status',
             orderable: false
        },
       
        
        {
            data: 'action',
            name: 'action',
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
            tablemerchantBlockedList.draw();
        });


       $(document).on('change', '.searchFilter', function(event){
        var target = $( event.target );
        var search = $(this).val();
        if(search.length<4){
                    return true;
            }
         var elementType = $(this).prop('nodeName');
        
         
         tablemerchantBlockedList.draw();
       });


     $(document).on('click', '.edit_block_admin', function(){

merchantId=$(this).attr('merchant');
rowid=$(this).attr('rowid');
Swal.fire({
    title: 'Do you want to Unblock Merchant?',
    showDenyButton: true,
    // showCancelButton: true,
    confirmButtonText: 'Yes',
    denyButtonText: 'No',
    width: 500,
    
  }).then((result) => {
    
    if (result.isConfirmed) {
      

        $(".loader").show();
       
         $.ajax({
                type: "GET",
                url: "{{route('initiate_unblock_merchant')}}",
                data:{merchantId:merchantId,rowid:rowid},
                dataType: "json",
                success: function(response) {
                 
                   
                     swalnot(response.type,response.message);
                     tablemerchantBlockedList.draw();    
                },
                complete: function() {
                      $(".loader").hide();
                  }
              });
    } else if (result.isDenied) {
      Swal.fire('Canclled', '', 'info')
    }
  })

});


     });

        </script>
@endsection