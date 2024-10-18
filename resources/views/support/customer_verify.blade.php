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
                                <div class="card-header">
                                    <h5 class="forgot-form-heading">Verify Phone Number , OTP Sent on :
                                        {{ Session::get('customer_transaction_contact') }}</h5><a href="{{ 'customers' }}"
                                        class="back-link">Back</a>
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

                                    <form action="{{ route('customervalidate') }}" method="POST">
                                        <div id="show-success-message" class="text-sm-center"></div>
                                        <div id="show-fail-message" class="text-sm-center"></div>

                                        @csrf

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label for="email_address"
                                                        class="col-md-4 col-form-label text-md-right">Enter OTP</label>
                                                    <div class="col-md-8">
                                                        <input type="text" id="contact_otp" class="form-control"
                                                            name="contact_otp" required autofocus maxlength="6"
                                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                            placeholder="Please enter 6 Digit OTP">
                                                        @if ($errors->has('contact_otp'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('contact_otp') }}</span>
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
