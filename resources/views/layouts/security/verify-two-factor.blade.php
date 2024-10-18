@php
    $logoPath = DB::table('logo')->first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <img src="{{ asset('images/' . $logoPath->path) }}" width="300" alt="yourpg">
    <title>{{ config('app.name', env('APP_NAME')) }}</title>
    <link rel="stylesheet" href="{{ asset('template_assets\other\mdb\css\bootstrap.min.css') }}">

</head>
@php
    $logoPath = DB::table('logo')->first();
@endphp

<body class="container"
    style="background:url({{ asset('template_assets/assets/images/big/auth-bg.jpg') }}) no-repeat center center;margin-top:10%">

    <form action="{{ route('check-2fa') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-4 col-sm-0"></div>
            <div class="col-md-4 col-sm-12 text-center">

                <div class="form-group card" style="padding:30px">
                    <img class="mt-2" src="{{ asset('images/' . $logoPath->path) }}"
                        style="width:50%;margin-left:25%">
                    <label for="otp" style="font-weight:500;font-size:12px">Two Factor Authentication</label>

                    <label for="otp" style="font-weight:500;font-size:12px">Kindly check Authenticator app for
                        login 6 digit code</label>

                    <input type="text" class="form-control mb-2 text-center" maxlength="6" name="otp"
                        autocomplete="off" required placeholder="6-digit PIN">
                    <button type="submit" class="btn btn-md btn-info">Verify</button>
                    <div class="progress" style="height:5px">
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                            style="width:100%;background-color:#207b8a"></div>
                    </div>
                    <div style="font-size:12px">
                        Verify to get in Merchant Dashborad
                    </div>

                    <div class="text-danger text-sm" style="font-size:12px">
                        {{ session('message') ? session('message') : '' }}
                    </div>
                </div>

            </div>
            <div class="col-12 text-center">

                <a href="{{ route('logout') }}" class="btn btn-danger btn-md"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i
                        class="fa fa-power-off"></i>
                    Logout
                </a>




            </div>
        </div>
    </form>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</body>
<script src="{{ asset('template_assets\other\mdb\js\jquery.min.js') }}"></script>
<script src="{{ asset('template_assets/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

</html>
