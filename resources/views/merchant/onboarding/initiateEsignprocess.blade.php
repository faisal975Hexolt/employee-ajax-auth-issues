@php
    use \App\Http\Controllers\MerchantController;

    $per_page = MerchantController::page_limit();
@endphp
@extends('layouts.merchantcontent')
@section('merchantcontent')



<style type="text/css">
    .box{background:#fff;
        border-radius:3px;
        border-top:0px solid #d2d6de;
        box-shadow:0 1px 1px rgba(0,0,0,.1);
        margin-bottom:20px;
        position:relative;width:100%}
</style>


        
    <section id="about-1" class="about-1 ">
      <div class="container-1">

        <div class="row">
         
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
            
             <h3 class="MargH3">Welcome to {{env('WEB_NAME')}}  </h3>
                        <span style="display:{{Auth::user()->app_mode?'none':'block'}}">
                <p>Get started with accepting payments after completion of Esign of Agreement</p>

                <p>Hello Merchant .<br> Your Account is inactive.<br>
                 Your Account Will Activated After Completion of Document Approval Process. </p> 
             </span>
         


               @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    @if (Session::has('error'))
                         <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif

             
          
            </div>

           

            
          </div>
       
    <!--Module Banner-->
   
    <input type="hidden" id="kycrequest_id" name="kyc_request_id" value="{{$data['kycrequest_id']}}"?>

</div>

      </div>
    </section>

@endsection




