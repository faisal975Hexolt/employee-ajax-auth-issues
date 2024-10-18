@php
    use \App\Http\Controllers\MerchantController;
    $per_page = MerchantController::page_limit();
@endphp
@extends('.layouts.merchantcontent')
@section('merchantcontent')
<!-- ---------Banner---------- -->
<div id="buton-1">
    <!-- <button class="btn btn-primary" id="Show">Show</button>
    <button  class="btn btn-primary" id="Hide">Remove</button> -->
    </div>
<section id="about-1" class="about-1">
    <div class="container-1">
  
      <div class="row">
      
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
          <div class="content-1 pt-4 pt-lg-0">
            <h3>Login Activities</h3>
            <p class="font-italic">
            Get started with accepting payments right away</p>
  
            
          </div>
        </div>
       
      </div>
  
    </div>
</section>

<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#users">Login Activities</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="users" class="tab-pane fade in active">
                       
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <select name="page_limit" class="form-control" onchange="getAllMerchantEmployees($(this).val())">
                                        @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="loginActivity-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_loginActivity">

                                </div>
                            </div>
                        </div>
                     
                      
                      
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getAllMerchantLoginActivity();
    });
</script>
@endsection
