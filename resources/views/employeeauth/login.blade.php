@extends('layouts.employeeapp')

@section('content')
@php
    $logoPath = DB::table('logo')->first(); 
@endphp
<div id="divLoading"></div>
<img class="wave" src="{{asset('assets/img/login-wave.png') }}">
<div class="container">
    <div class="img">
        <img src="{{asset('assets/img/subscription-banner.png') }}">
    </div>
    <div class="login-content">
        <form method="POST" id="employee-login" autocomplete="off">
            <img src="{{asset('images/'.$logoPath->path)}}" alt="logo" width="300" style="height:130px;">
            <h3 class="title">Employee Login</h3>
            <div id="employee-success-message" class="text-success">
                @if(session('success'))
                    {{session('success')}}
                @endif
            </div>
            <div id="employee-login-error"></div>
            <div class="input-div one ">
                <div class="i">
                    <i class="fa fa-user fa-lg"></i>
                </div>
                <div class="div">
                    <input type="text" class="input" name="employee_username" id="employee_username" placeholder="Username" value="{{ old('employee_username') }}" required autofocus autocomplete="off">
                </div>
            </div>
            <div class="input-div pass">
                <div class="i"> 
                    <i class="fa fa-lock fa-lg"></i>
                </div>
                <div class="div">
                    <input type="password" class="input" name="password" id="password" placeholder="Password" required autocomplete="off">
                </div>
                <div class="i show-pointer" onclick="showPasssword('password',this)"> 
                    <i class="fa fa-eye fa-lg"></i>
                </div>
            </div>            
            <input type="submit" class="btn" value="Login"><br>
            {{ csrf_field() }}
        </form>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="employee-login-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="load-login-form">

            </div>
        </div>
    </div>
</div>

@endsection
