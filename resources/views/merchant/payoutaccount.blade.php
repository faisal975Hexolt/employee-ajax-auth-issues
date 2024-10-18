@extends('layouts.merchantcontent')

@section('merchantcontent')
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
                                                                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
                                                                  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                                                                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                                                  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <style>
        .accountscard {

            background-color: white;

            border-radius: 1rem;

            padding: 10px;

        }

        .accountsdetails {

            background-color: white;

            border-radius: 1rem;

            padding: 10px;

            max-width: 250px;

        }

        .margTop {
            margin-top: 5%;

        }

        .lineht {
            line-height: 1.9;
        }

        .colr {
            color: #f6e084;

        }
    </style>



    <section id="about-1" class="about-1">

        <div class="container-1">

            <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">

                <div class="content-1 pt-4 pt-lg-0">

                    <h3 class="">Accounts</h3>

                </div>

            </div>

        </div>

    </section>
    </br>
    </br>

    <div class="container">


        <div class="panel panel-primary  margTop lineht">
            <div class="panel-heading">
                <div class="panel-title text-left">
                    Account Details
                </div>
            </div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header with-border transaction-details-block">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body" style="">
                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Wallet Balance:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>
                                                ₹
                                                {{ $merchantServices->wallet != null ? number_format((float) $merchantServices->wallet->balance, 2, '.', '') : '0.00' }}</b>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Payout Account:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>
                                                {!! payout_status_html($merchantServices->payout, 1) !!}
                                        </div>
                                    </div>
                                </div>




                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="panel panel-primary  margTop lineht">
            <div class="panel-heading">
                <div class="panel-title text-left">
                    Merchant Details
                </div>
            </div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header with-border transaction-details-block">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body" style="">
                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Name:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            @if (count($merchant_businesses))
                                                <b>
                                                    {{ $merchant_businesses[0]->mer_name }}
                                                </b>
                                            @else
                                                <b>
                                                    {{ $merchant->name }}
                                                </b>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body" style="">
                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Business Name:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                            @if (count($merchant_businesses))
                                                <b>
                                                    {{ $merchant_businesses[0]->business_name }}
                                                </b>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body" style="">
                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Email:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>
                                                {{ $merchant->email }}</b></div>
                                    </div>


                                </div>


                                <div class="box-body" style="">
                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px; padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Phone No.:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>
                                                {{ $merchant->mobile_no }}</b></div>
                                    </div>


                                </div>


                                <div class="box-body" style="">
                                    <div class="row" style="margin: 0 1%;">
                                        <div class="col-sm-6 text-right item"
                                            style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                            Status:</div>
                                        <div class="col-sm-6 text-left item"
                                            style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;"><b>
                                                {!! ftype_status($merchant->merchant_status, 1) !!}</b></div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>




        <div class="panel panel-primary lineht">
            <div class="panel-heading">
                <div class="panel-title text-Left">
                    Registered Merchant Businesses Details <i class="colr">( Transactions will be accepted from these
                        accounts only )</i>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="col-md-6">
                            <div class="box box-primary">

                                @foreach ($merchant_businesses as $business)
                                    <div class="box-body" style="">
                                        <div class="row" style="margin: 0 1%;">
                                            <div class="col-sm-6 text-right item"
                                                style="text-align: left; padding-top: 5px; padding-left: 10%;  padding-bottom: 5px; overflow-wrap: break-word;">
                                                Merchant Name:</div>
                                            <div class="col-sm-6 text-left item"
                                                style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                                <b> {{ $business->mer_name ?? '' }}</b>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="box-body" style="">
                                        <div class="row" style="margin: 0 1%;">
                                            <div class="col-sm-6 text-right item"
                                                style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                                Merchant Aadhar No.:</div>
                                            <div class="col-sm-6 text-left item"
                                                style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                                <b> {{ $business->mer_aadhar_number ?? '' }}</b>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="box-body" style="">
                                        <div class="row" style="margin: 0 1%;">
                                            <div class="col-sm-6 text-right item"
                                                style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                                Bank Name:</div>
                                            <div class="col-sm-6 text-left item"
                                                style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                                <b> {{ $business->bank_name ?? '' }}</b>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="box-body" style="">
                                        <div class="row" style="margin: 0 1%;">
                                            <div class="col-sm-6 text-right item"
                                                style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                                Account Number:</div>
                                            <div class="col-sm-6 text-left item"
                                                style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                                <b> {{ $business->bank_acc_no ?? '' }}</b>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="box-body" style="">
                                        <div class="row" style="margin: 0 1%;">
                                            <div class="col-sm-6 text-right item"
                                                style="text-align: left; padding-top: 5px; padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                                Ifsc Code:</div>
                                            <div class="col-sm-6 text-left item"
                                                style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                                <b> {{ $business->bank_ifsc_code ?? '' }}</b>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="box-body" style="">
                                        <div class="row" style="margin: 0 1%;">
                                            <div class="col-sm-6 text-right item"
                                                style="text-align: left; padding-top: 5px;padding-left: 10%; padding-bottom: 5px; overflow-wrap: break-word;">
                                                Pincode:</div>
                                            <div class="col-sm-6 text-left item"
                                                style="padding-top: 5px; padding-bottom: 5px; overflow-wrap: break-word;">
                                                <b> {{ $business->pincode ?? '' }}</b>
                                            </div>
                                        </div>


                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
