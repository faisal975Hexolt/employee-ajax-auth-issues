@php
    use App\Classes\ValidationMessage;
@endphp

@extends('layouts.managepayapp')

@section('content')

    <head>
        <meta charset="utf-8">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('new/css/normalize.css') }}" />
        <link rel="stylesheet" href="{{ asset('new/css/sumoselect.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('new/css/slick.css') }}" />
        <link rel="stylesheet" href="{{ asset('new/css/slick-theme.css') }}" />
        <link rel="stylesheet" href="{{ asset('new/css/main.css') }}" />


        <style>
            .flex-container {
                display: flex;
                flex-wrap: nowrap;

            }

            .flex-container>div {

                margin: 10px;
                text-align: center;
            }
        </style>

    </head>

    <body>
        @php
            $logoPath = DB::table('logo')->first();
        @endphp

        <div class="login-wrap">
            <div class="left-col-auth linear-gradient">
                <div class="auth-page-container">
                    <a href="#" class="pay-flash-logo-white">
                        <img src="{{ asset('images/' . $logoPath->path) }}" width="300" alt="image">
                    </a>
                    <div class="auth-page-slider">
                        <div class="js-slider">
                            <div><img src="{{ asset('new/img/slider-image-1.png') }}" alt=""></div>
                            <div><img src="{{ asset('new/img/slider-image-1.png') }}" alt=""></div>
                        </div>
                    </div>
                    <div class="auth-content">
                        <h2>Scale-up your Business</h2>
                        <p>with India's Leading "Digital Collections Platform" </p>
                    </div>
                </div>
            </div>

            <div class="auth-form-container">
                <a href="#" class="pay-flash-logo-auth">
                    <img src="{{ asset('images/' . $logoPath->path) }}" width="250" alt="image">
                </a>
                <h2 class="auth-heading">Sign In</h2>
                <p class="auth-sub-heading">Welcome! We are happy to have you...</p>
                @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
                @if (Session::has('register-message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('register-message') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <form method="POST" id="merchant-login" autocomplete="on">
                    {{ csrf_field() }}
                    <div class="auth-form-group name-control">
                        <input type="text" id="email" name="email" class="auth-form-control"
                            placeholder="Email/Username" id="">
                    </div>
                    <div class="auth-form-group password-control">
                        <input type="password" id="password" name="password" class="auth-form-control"
                            placeholder="Password" id="">
                    </div>
                    <div class="auth-form-group captcha-control">
                        <input name="captcha" id="captcha" type="text" class="auth-form-control" placeholder="Captcha"
                            id="">
                    </div>
                    <div class="auth-form-group">
                        <div class="flex-container captcha-input">
                            <div class="">
                                <img id="display-captcha" src="{{ captcha_src('flat') }}" class="img-responsive float-left"
                                    alt="Captcha-Image" width="250px" height="50px">
                            </div>
                            <div class="">
                                <span class="captcha-css" onclick="reloadCaptcha();">
                                    <i class="pt-3 fas fa-sync fa-lg"></i>
                                </span>
                            </div>
                        </div>
                        <p class="loginError" style="color:red;">
                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                            @endif
                        </p>

                        <p class="text-sm-left font-weight-light" style="color:red;">
                            <span class="help-block">
                                <strong id="captcha_ajax_error" class="error_span"></strong>
                            </span>
                        </p>

                        <p class="text-sm-left font-weight-light" style="color:red;">
                            <span class="help-block">
                                <strong id="merchant-login-error" class="error_span"></strong>
                            </span>
                        </p>
                    </div>

                    <p id="ajax-success-response" class="text-center"></p>
                    <div class="auth-buttons-group">
                        <input type="submit" class="purple-btn m-r-20" value="Login">
                        <!-- <button type="button" class="purple-btn m-r-20">Login</button> -->
                    </div>
                    <p class="forgot-pass-link"><a href="{{ route('forget.password.get') }}">Forgot Password?</a></p>
                    <p class="sign-up-txt">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                </form>
            </div>

        </div>


        <?php
        Session::forget('register-message');
        ?>
    @endsection
