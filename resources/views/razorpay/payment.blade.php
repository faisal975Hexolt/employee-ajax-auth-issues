<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel 9 - Razorpay Payment Gateway Integration</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-3 col-md-offset-6">
                        @if($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">?</span>
                            </button>
                            <strong>Error!</strong> {{ $message }}
                        </div>
                        @endif
                        @if($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">?</span>
                            </button>
                            <strong>Success!</strong> {{ $message }}
                        </div>
                        @endif
                        <div class="card card-default">
                            <div class="card-header">
                                Laravel 9- Razorpay Payment Gateway Integration
                            </div>
                            <div class="card-body text-center">
                                <form action="{{ route('razorpay.payment.store') }}" method="POST">
                                    @csrf
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                        data-key="rzp_test_d0Dk9dijytsiNL" data-amount="1000" data-currency="INR"
                                        data-buttontext="Pay 100 INR" data-name="codesolutionstuff.com"
                                        data-description="Rozerpay"
                                        data-image="https://codesolutionstuff.com/wp-content/uploads/2020/10/logo.jpg"
                                        data-prefill.name="name" data-prefill.email="email"
                                        data-theme.color="#F37254"></script>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>