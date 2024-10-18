@php
	use App\AppOption;
	$stype = AppOption::get_customer_support();
@endphp

@extends("layouts.managepayapp")
@section("content")
<header class="header ">
<nav class="navbar navbar-expand-sm  navbar-dark">
  <!-- Brand/logo -->
  <a class="navbar-brand" href="#">
    <img src="{{ asset('new/img/S2PAY_Logo_m.png') }}"  width="150" height="60px" alt="S2PAY_Logo">
  </a>
  
  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="{{env('APP_URL')}}">Home</a>
    </li>
   
  </ul>
</nav>
</header>
<!-- Contact Us Section -->
<section id="contact" class="section pt-5">
	<!-- Container Starts -->
	<div class="container">
	
	  <!-- End Row -->
	  <!-- Start Row -->
	  <div class="row">

	  <div id="zoop-gateway-model">
      <div id="zoop-model-content"></div>
    </div>
		
       
		
	  </div>
	  <!-- End Row -->
	</div>


	
	
       
        
  </section>
  <!-- Contact Us Section End -->
@endsection

