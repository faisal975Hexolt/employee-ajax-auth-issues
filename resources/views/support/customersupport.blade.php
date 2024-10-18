@php
    use App\AppOption;
    $stype = AppOption::get_customer_support();
@endphp

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
    <!-- Contact Us Section -->
    <section id="contact" class="section pt-5">
        <!-- Container Starts -->
        <div class="container">

            <!-- End Row -->
            <!-- Start Row -->
            <div class="row">

                <!-- Start Col -->
                <div class="col-lg-6 col-md-12">
                    <div class="text-left">Fill the form with details of as same as <strong>Transaction</strong> details
                    </div>
                    <form id="case-form" method="post" class="card">
                        <div id="show-success-message" class=" text-sm-center"></div>
                        <div id="show-fail-message" class=" text-sm-center"></div>
                        @csrf
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Complaint Type</label>
                                        <select name="case_type" id="case_type" class="form-control">
                                            <option value="">--Select--</option>
                                            @foreach ($stype as $index => $type)
                                                <option value="{{ $type->id }}">{{ $type->option_value }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">
                                            <small class="text-sm-left"
                                                id="case_type_ajax_error">{{ $errors->first('case_type') }}</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        @php $transaction_gid=$paymentShow['transaction_gid']!=''?$paymentShow['transaction_gid']:old('transaction_gid'); @endphp
                                        <input id="transaction_gid" type="text" class="form-control"
                                            name="transaction_gid" value="{{ $transaction_gid }}" placeholder="Payment ID"
                                            {{ $paymentShow['transaction_gid'] != '' ? 'Readonly' : '' }}>
                                        <span class="help-block">
                                            <small class="text-sm-left"
                                                id="transaction_gid_ajax_error">{{ $errors->first('transaction_gid') }}</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        @php $amount=$paymentShow['amount']!=''?$paymentShow['amount']:old('transaction_amount'); @endphp
                                        <input id="transaction_amount" type="text" class="form-control"
                                            name="transaction_amount" value="{{ $amount }}" placeholder="Amount Paid"
                                            {{ $paymentShow['amount'] != '' ? 'Readonly' : '' }}>
                                        <span class="help-block">
                                            <small class="text-sm-left"
                                                id="transaction_amount_ajax_error">{{ $errors->first('transaction_amount') }}</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        @php $name=$paymentShow['name']!=''?$paymentShow['name']:old('customer_name'); @endphp
                                        <input id="customer_name" type="text" class="form-control" name="customer_name"
                                            value="{{ $name }}" placeholder="Name"
                                            {{ $paymentShow['name'] != '' ? 'Readonly' : '' }}>
                                        <span class="help-block">
                                            <small class="text-sm-left"
                                                id="customer_name_ajax_error">{{ $errors->first('customer_name') }}</small>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        @php $email=$paymentShow['email']!=''?$paymentShow['email']:old('customer_email'); @endphp
                                        <input type="text" id="customer_email" type="text" class="form-control"
                                            name="customer_email" value="{{ $email }}" placeholder="Email"
                                            {{ $paymentShow['email'] != '' ? 'Readonly' : '' }}>
                                        <span class="help-block">
                                            <small class="text-sm-left"
                                                id="customer_email_ajax_error">{{ $errors->first('customer_email') }}</small>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        @php $mobile=$paymentShow['mobile']!=''?$paymentShow['mobile']:old('customer_mobile'); @endphp

                                        <input id="customer_mobile" type="text" class="form-control"
                                            name="customer_mobile" value="{{ $mobile }}" placeholder="Mobile"
                                            {{ $paymentShow['mobile'] != '' ? 'Readonly' : '' }}>
                                        <span class="help-block">
                                            <small class="text-sm-left"
                                                id="customer_mobile_ajax_error">{{ $errors->first('customer_mobile') }}</small>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label>Transaction Proof Image</label><br />
                                            <input type="file" name="transaction_proof" id="transaction_proof"
                                                class="fileupload-custom transaction_proof homeImg"
                                                data-privewclss="transaction_proof_preview">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <span class="help-block">
                                                <small class="text-sm-left"
                                                    id="transaction_proof_ajax_error">{{ $errors->first('transaction_proof') }}</small>
                                            </span>

                                            <span style="color: red">Please Upload Image File Only </span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="preview" style="margin-top: 5px;" id="transaction_proof_preview">



                                                <img id="transactionProof" src="" style="width: 110px;">

                                            </div>
                                            <input id="inputtransactionProof"
                                                value="{{ asset('assets/img/No_Image.png') }}" type="hidden">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="customer_reason" class="form-control" id="customer_reason" rows="4"
                                            placeholder="Write Message"></textarea>
                                        <span class="help-block">
                                            <small class="text-sm-left"
                                                id="customer_reason_ajax_error">{{ $errors->first('customer_reason') }}</small>
                                        </span>
                                    </div>
                                </div>


                               

                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="submit-button text-center">
                                <button class="support-btn btn-common btn btn-primary" type="submit">Send
                                    Message</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                    <hr style="border: 0.1px solid rgb(223, 223, 223);">
                </div>
                <!-- End Col -->
                <!-- Start Col -->

                <!-- End Col -->
                <!-- Start Col -->
                <div class="col-lg-5 col-md-12">
                    <div class="contact-img">

                        <div class="side-heading1">
                            <h3>How Can We Help?</h3>
                            <p>Please select a topic below related to your enquiry. If you don't find what u need, fill out
                                our contect form</p>
                        </div>
                        <div class="side-heading2">
                            <div>
                                <h6>Book a demo</h6>
                                <p>Request a demo from one of our conversion specialist</p>
                            </div>
                            <hr style="border: 0.5px solid rgb(121, 121, 121);">
                            <div>
                                <h6>Get Inspired</h6>
                                <p>Request a demo from one of our conversion specialist</p>
                            </div>
                            <hr style="border: 0.5px solid rgb(121, 121, 121);">
                            <div>
                                <h6>Become a Partner</h6>
                                <p>Request a demo from one of our conversion specialist</p>
                            </div>
                        </div>

                    </div>

                    <hr style="border: 0.1px solid rgb(223, 223, 223);">
                    <div class="container">
                        <h4 class="head-top">Contact Information</h4>
                        <div class="cont-top mt-4">
                            <div class="cont-left">
                                <span class="fa fa-phone"></span>
                            </div>
                            <div class="cont-right">
                                <p>{{ env('SUPPORT_NUMBER') }}</p>
                            </div>
                        </div>

                        <div class="cont-top mt-4">
                            <div class="cont-left">
                                <span class="fa fa-envelope "></span>
                            </div>
                            <div class="cont-right">
                                <p>{{ env('SUPPORT_CONTATCT_MAIL') }}</p>
                            </div>
                        </div>

                        <div class="cont-top mt-4">
                            <div class="cont-left">
                                <span class="fa fa-building-o "></span>
                            </div>
                            <div class="cont-right">
                                <p>{{ env('APP_NAME_FULL') }}</p>
                            </div>
                        </div>


                        <div class="cont-top mt-4">
                            <div class="cont-left">
                                <span class="fa fa-map-marker "></span>
                            </div>
                            <div class="cont-right">
                                <p>{{ env('COMPANY_ADDRESS') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Col -->
                <!-- Start Col -->
                <div class="col-lg-1">
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>


        <div class="container">

            <!-- End Row -->
            <!-- Start Row -->
            <div class="row">

                <!-- Start Col -->
                <div class="col-lg-6 col-md-12">


                </div>
                <!-- End Col -->
                <!-- Start Col -->

                <!-- End Col -->
                <!-- Start Col -->
                <div class="col-lg-6 col-md-12">


                </div>

            </div>
            <!-- End Row -->
        </div>



    </section>
    <!-- Contact Us Section End -->
@endsection
