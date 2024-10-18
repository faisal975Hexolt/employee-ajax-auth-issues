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
    <link href="{{asset('images/'.$logoPath->fav_icon_path)}}" rel="icon">
    <link href="{{asset('images/'.$logoPath->fav_icon_path)}}" rel="apple-touch-icon">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
    <link href="{{ asset('css/employee-app-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/employe-custom-style-2.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

</head>

<body>
    <div id="app">

        @yield('content')
    </div>

    <input type="hidden" id="base_url" value="<?php echo url('/'); ?>"?>
    <script>
        base_phpurl = document.getElementById("base_url").value;
    </script>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.serializejson.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/employeeapp.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/amchart.js') }}"></script>

    <script src="//cdn.amcharts.com/lib/4/core.js"></script>
    <script src="//cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="//cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>

</body>

</html>
