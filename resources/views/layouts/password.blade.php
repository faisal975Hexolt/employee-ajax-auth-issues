@php
    $logoPath = DB::table('logo')->first();
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', env('APP_NAME')) }}</title>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

        body {
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f5f8fa;
        }

        .navbar-laravel {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
        }

        .navbar-brand,
        .nav-link,
        .my-form,
        .login-form {
            font-family: Raleway, sans-serif;
        }

        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .login-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }
    </style>


    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    @if (isset($loadcss))
        @switch($loadcss)
            @case('gallery')
                <link href="{{ asset('css/gallery-style.css') }}" rel="stylesheet">
            @break

            @case('career')
                <link href="{{ asset('css/career-style.css') }}" rel="stylesheet">
            @break

            @case('csr')
                <link href="{{ asset('css/csr-style.css') }}" rel="stylesheet">
            @break

            @case('press-release')
                <link href="{{ asset('css/press-release-style.css') }}" rel="stylesheet">
            @break

            @case('integration')
                <link href="{{ asset('css/integration.css') }}" rel="stylesheet">
            @break

            @case('event')
                <link href="{{ asset('css/event-style.css') }}" rel="stylesheet">
            @break

            @default
                <link href="{{ asset('css/managepay-styles.css') }}" rel="stylesheet">
        @endswitch
    @endif
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="assets/code/icofont/icofont.min.css" rel="stylesheet">



    <!-- Favicons -->

    <link href="assets/code/boxicons/css/boxicons.min.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- =================Font Awsome=================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('new/css/normalize.css') }}" />

    <link rel="stylesheet" href="{{ asset('new/css/sumoselect.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('new/css/slick.css') }}" />

    <link rel="stylesheet" href="{{ asset('new/css/slick-theme.css') }}" />

    <link rel="stylesheet" href="{{ asset('new/css/main.css') }}" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-177386849-1');
    </script>


    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "S2payments",
        "url": "https://s2payments.in",
        "logo": "https://s2payments.in/wp-content/uploads/2023/04/S2PAY_Logo.png",
        "contactPoint": {
          "@type": "ContactPoint",
          "telephone": "7676752187",
          "contactType": "customer service",
          "contactOption": "TollFree",
          "areaServed": "IN",
          "availableLanguage": "en"
        },
        "sameAs": [
          "https://www.facebook.com/s2pay",
          "https://twitter.com/{{env('APP_NAME')}}_ind",
          "https://www.linkedin.com/company//admin/",
          "https://www.instagram.com/{{env('APP_NAME')}}/"
        ]
      }
      </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
        <div class="container">
            <div class="col-md-4 ">
                <a href="{{ 'login' }}" class="back-link">Back</a>
            </div>
            <div class="col-md-4">
                <ul class="navbar-nav ml-auto">


                    <img src="{{ asset('images/' . $logoPath->path) }}" width="200" alt="yourpg">


                </ul>
                <br>
                <h2> <a class="navbar-brand" href="#">Reset Your Password here</a>

                </h2>
            </div>





            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('login') }}">Home</a>
                    </li>


                </ul>


            </div>
        </div>
    </nav>

    @yield('content')


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/crudapp.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/validatefunction.js') }}"></script>

    <script src="{{ asset('new/js/plugins/enquire.min.js') }}"></script>
    <script src="{{ asset('new/js/plugins/jquery.sumoselect.min.js') }}"></script>
    <script src="{{ asset('new/js/plugins/slick.min.js') }}"></script>
    <script src="{{ asset('new/js/login.js') }}"></script>

    @if (isset($loadscript))
        @switch($loadscript)
            @case('gallery')
                <script type="text/javascript" src="{{ asset('js/gallery.js') }}"></script>
            @break

            @case('career')
                <script type="text/javascript" src="{{ asset('js/career.js') }}"></script>
            @break

            @default
                <script type="text/javascript" src="{{ asset('js/supportapp.js') }}"></script>
        @endswitch
    @endif
    <script>
        $('.dropdown').hover(function() {
            $(this).find('.mega-menu').stop(true, true).delay(200).fadeIn(500);
        }, function() {
            $(this).find('.mega-menu').stop(true, true).delay(200).fadeOut(500);
        });
    </script>

</body>

</html>
