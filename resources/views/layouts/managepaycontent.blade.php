@extends('layouts.managepayapp')
@section('content')
    <header class="header ">
        <nav class="navbar navbar-expand-sm  navbar-dark">
            <!-- Brand/logo -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('new/img/S2PAY_Logo_m.png') }}" width="150" height="60px" alt="S2PAY_Logo">
            </a>

            <!-- Links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ env('APP_URL') }}">Home</a>
                </li>

            </ul>
        </nav>
    </header>



    <div class="main-content">
        @yield('managepaycontent')
    </div>
@endsection
