<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', env('APP_NAME')) }}</title>

    @php
        $logoPath = DB::table('logo')->first();
    @endphp

    <!-- Favicons -->
    <link href="{{ asset('images/' . $logoPath->fav_icon_path) }}" rel="icon">
    <link href="{{ asset('images/' . $logoPath->fav_icon_path) }}" rel="apple-touch-icon">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/employee-custom-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/employe-custom-style-2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables_new.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables-a.min.css') }}">



</head>

<body>
    <div id="divLoading"></div>
    <div class="loader"></div>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <!-- <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'S2pay') }}
                </a> -->
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li class="current-time"><a href="javascript:"><strong>
                                <div id="nav-clock"></div>
                            </strong></a></li>
                    <li class="ip-address"><a href="javascript:"><strong><span style='color:#00a8e9'>Login Ip:</span>
                                {{ Request::ip() }}</strong></a></li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (!auth()->guard('employee')->check())
                        <li><a href="{{ route('managepay.login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false" aria-haspopup="true" v-pre>
                                {{ Auth::guard('employee')->user()->first_name . ' ' . Auth::guard('employee')->user()->last_name }}
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('managepay.logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('managepay.logout') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2" id="employee-nav">
                    <div class="col-sm-12">
                        @include('layouts.employeesidenav')
                    </div>
                </div>
                <div class="col-sm-10" id="employee-content">
                    <div class="row">
                        <div class="col-sm-12">
                            @yield('employeecontent')
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        @include('employee.modals')

                        @include('layouts.employeefooter')
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <input type="hidden" id="base_url" value="<?php echo url('/'); ?>"?>
    <script>
        base_phpurl = document.getElementById("base_url").value;
    </script>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.serializejson.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables-new.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <script type="text/javascript" src="{{ asset('js/employeeapp.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/employeeapp_merchant.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/employeeapp_merchant.js') }}"></script>


    <script type="text/javascript" src="{{ asset('js/employeeapp_search.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/view_transaction_details.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>  -->
    <script type="text/javascript" src="{{ asset('js/dataTables-a.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/employee_download.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/view_payout_transactions.js') }}"></script>

    <script type="text/javascript">
        function swalnot(mode, txt) {
            if (mode == 'error') {
                Swal.fire(txt,
                    '',
                    'error'
                );
            } else {
                Swal.fire(txt,
                    '',
                    'success'
                );

            }
        }
    </script>
</body>

</html>
{{-- @extends('layouts.employeeapp') --}}
