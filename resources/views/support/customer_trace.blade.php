@php
    use App\AppOption;
    $stype = AppOption::get_customer_support();
@endphp

@extends('layouts.managepaycontent')
@section('managepaycontent')
    <style>
        form {
            width: 560px;
        }
    </style>
    <section id="contact" class="section pt-5">
        <!-- Container Starts -->
        <div class="container">
            <main class="login-form">
                <div class="cotainer">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Track Payments<h5 class="forgot-form-heading">Check The Status of
                                        Payments You have made in last 6 months. View using user phone number</h5><a
                                        href="{{ '/' }}" class="back-link">Back</a>
                                </div>
                                <div class="card-body">



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

                                    <form action="{{ route('customers_verify') }}" method="POST">
                                        <div id="show-success-message" class="text-sm-center"></div>
                                        <div id="show-fail-message" class="text-sm-center"></div>

                                        @csrf

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="email_address"
                                                        class="col-md-4 col-form-label text-md-right">Phone Number</label>
                                                    <div class="col-md-8">
                                                        <input type="text" id="transaction_contact" class="form-control"
                                                            name="transaction_contact" required autofocus
                                                            placeholder="10 digit Phone number" maxlength="10"
                                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                        @if ($errors->has('transaction_contact'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('transaction_contact') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12 ">
                                                <div class="submit-button text-center">
                                                    <button class="support-btn btn-common btn btn-primary"
                                                        type="submit">Check Status</button>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>


                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>
@endsection
