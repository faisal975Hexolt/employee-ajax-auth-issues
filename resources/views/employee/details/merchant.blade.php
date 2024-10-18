@php
    use App\User;
    $merchants = User::get_tmode_docupload_merchants();

    $merchant_detailsNew = $data['merchant_details'][0];
    $merchant_business_details = empty($data['merchant_business_details']) ? [] : $data['merchant_business_details'][0];
    $merchant_business_documents = empty($data['merchant_business_documents'])
        ? []
        : $data['merchant_business_documents'];

    $show_name = $merchant_detailsNew->name;

@endphp



@extends('layouts.employeecontent')

@section('employeecontent')

    <div class="row">

        <div class="col-sm-12 padding-20">

            <div class="panel panel-default">

                <div class="panel-heading">
                    <span class="pull-right">On Boarding Status:{{ $user->OnboardingStatus->name }}</span>
                    <br>
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        @if (count($sublinks) > 0)
                            @foreach ($sublinks as $index => $value)
                                @if ($index == 0)
                                    <li class="active"><a data-toggle="tab" class="show-pointer"
                                            data-target="#{{ str_replace(' ', '-', strtolower($value['link_name'])) }}">{{ $value['link_name'] }}</a>
                                    </li>
                                @else
                                    <li><a data-toggle="tab" class="show-pointer"
                                            data-target="#{{ str_replace(' ', '-', strtolower($value['link_name'])) }}">{{ $value['link_name'] }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>


                </div>

                <div class="panel-body">
                    <div class="tab-content">


                        @if (count($sublinks) > 0)
                            @foreach ($sublinks as $index => $value)
                                @if ($index == 0)
                                    <div id="{{ str_replace(' ', '-', strtolower($value['link_name'])) }}"
                                        class="tab-pane fade in active">
                                        <div class="row">

                                            <div class="col-sm-12">

                                                <a onclick="history.back()" href="#"
                                                    class="btn btn-primary btn-sm pull-right">Go
                                                    Back</a>

                                            </div>

                                        </div>

                                        <div class="row padding-10">

                                            <div class="col-sm-12">

                                                @if ($module == 'docscreen')
                                                    @if ($form == 'create')
                                                        <div class="col-sm-12">
                                                            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration"
                                                                role="alert">
                                                                <div class="inner">
                                                                    <div class="app-card-body">
                                                                        <h4 class="mb-3">Basic Details of
                                                                            {{ $show_name }}
                                                                            <button
                                                                                class="btn btn-primary edit_merchant_admin"
                                                                                mode="basic"
                                                                                mid="<?= $merchant_id ?>">Edit</button>
                                                                        </h4>



                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <form id="merchant-details-form" method="POST"
                                                                class="form-horizontal">

                                                                <div class="form-group">
                                                                    <label for="input"
                                                                        class="col-sm-3 control-label">Merchant Id:</label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" id="inputmerchant_gid"
                                                                            class="form-control"
                                                                            value="{{ $merchant_detailsNew->merchant_gid }}"
                                                                            disabled>

                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label for="input"
                                                                        class="col-sm-3 control-label">User Name:</label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" id="inputname"
                                                                            class="form-control"
                                                                            value="{{ $merchant_detailsNew->name }}"
                                                                            disabled>

                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label for="input"
                                                                        class="col-sm-3 control-label">Email:</label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" id="inputemail"
                                                                            class="form-control"
                                                                            value="{{ $merchant_detailsNew->email }}"
                                                                            disabled>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="input"
                                                                        class="col-sm-3 control-label">Mobile:</label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" id="inputmobile_no"
                                                                            class="form-control"
                                                                            value="{{ $merchant_detailsNew->mobile_no }}"
                                                                            disabled>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="input"
                                                                        class="col-sm-3 control-label">Expected
                                                                        Volume:</label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" id="inputtransaction_limit"
                                                                            class="form-control"
                                                                            value="{{ $merchant_detailsNew->transaction_limit }}"
                                                                            disabled>

                                                                    </div>
                                                                </div>



                                                            </form>

                                                            <hr>
                                                        </div>



                                                        <div class="col-sm-12">
                                                            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration"
                                                                role="alert">
                                                                <div class="inner">
                                                                    <div class="app-card-body">
                                                                        <h4 class="mb-3">Business Details of
                                                                            {{ $show_name }}
                                                                            <button
                                                                                class="btn btn-primary edit_merchant_admin"
                                                                                mode="business"
                                                                                mid="<?= $merchant_id ?>">{{ !empty($merchant_business_details) ? 'Edit' : 'Add' }}</button>
                                                                        </h4>



                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if (!empty($merchant_business_details))
                                                                <form id="merchant-business-details-form" method="POST"
                                                                    class="form-horizontal">

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Merchant
                                                                            Name:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="input"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->mer_name }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Business
                                                                            Name:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputbusiness_name"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->business_name }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Business
                                                                            Type:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputtype_name"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->type_name }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Business
                                                                            Category:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputcategory_name"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->category_name }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Business Sub
                                                                            Category:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text"
                                                                                id="inputsub_category_name"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->sub_category_name }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Expected Monthly
                                                                            Volume:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputexpenditure"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->expenditure }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Merchant GST
                                                                            Charges:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputexpenditure"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->merchant_gst_chargers }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Website:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputwebsite"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->website }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Bank
                                                                            Name:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputbank_name"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->bank_name }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Bank Account
                                                                            Number:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputbank_acc_no"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->bank_acc_no }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Bank IFSC
                                                                            Code:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputbank_ifsc_code"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->bank_ifsc_code }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Company Pan
                                                                            number:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text"
                                                                                id="inputcomp_pan_number"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->comp_pan_number }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">GST:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputcomp_gst"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->comp_gst }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Pan
                                                                            Number:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputmer_pan_number"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->mer_pan_number }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Aadhar
                                                                            Number:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text"
                                                                                id="inputmer_aadhar_number"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->mer_aadhar_number }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Incorporation
                                                                            Certificate Number:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text"
                                                                                id="inputincorp_cert_number"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->comp_cin }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>






                                                                </form>
                                                            @endif
                                                            <hr>
                                                        </div>






                                                        <div class="col-sm-12">
                                                            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration"
                                                                role="alert">
                                                                <div class="inner">
                                                                    <div class="app-card-body">
                                                                        <h4 class="mb-3">Business Addreess of
                                                                            {{ $show_name }}

                                                                            <button
                                                                                class="btn btn-primary edit_merchant_admin"
                                                                                mode="addreess"
                                                                                mid="<?= $merchant_id ?>">{{ !empty($merchant_business_details) ? 'Edit' : 'Add' }}</button>
                                                                        </h4>


                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @if (!empty($merchant_business_details))
                                                                <form id="merchant-address-form" method="POST"
                                                                    class="form-horizontal">



                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Address:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputaddress"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->address }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Pincode:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputpincode"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->pincode }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">City:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputcity"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->city }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">State:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputstate_name"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->state_name }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="input"
                                                                            class="col-sm-3 control-label">Country:</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="inputcountry"
                                                                                class="form-control"
                                                                                value="{{ $merchant_business_details->country }}"
                                                                                disabled>

                                                                        </div>
                                                                    </div>

                                                                </form>

                                                                <hr>
                                                            @endif
                                                        </div>




                                                        <div class="col-sm-12">
                                                            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration"
                                                                role="alert">
                                                                <div class="inner">
                                                                    <div class="app-card-body">
                                                                        <h4 class="mb-3">KYC Documents of
                                                                            {{ $show_name }}

                                                                            <button
                                                                                class="btn btn-primary edit_merchant_admin_documents"
                                                                                mode="documents"
                                                                                mid="<?= $merchant_id ?>">{{ !empty($merchant_business_documents) ? 'Edit' : 'Add' }}</button>
                                                                        </h4>


                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @if (!empty($merchant_business_documents))
                                                                <form id="document-details-form" method="POST"
                                                                    class="form-horizontal">



                                                                    <table class="table table-bordered table-hover">

                                                                        <thead>

                                                                            <tr>

                                                                                <th>File Name</th>

                                                                                <th>File</th>

                                                                                <th>Action</th>

                                                                            </tr>

                                                                        </thead>


                                                                        <tbody>
                                                                            @include('employee.details.merchant_docs')
                                                                        </tbody>

                                                                    </table>

                                                                </form>

                                                                <hr>
                                                            @endif
                                                        </div>





                                                        <div class="row">

                                                            {{--  <div class="col-sm-12">

                                                <button type="submit" class="btn btn-primary pull-right" onclick="callReportModal();">Submit Report</button>

                                            </div> --}}

                                                        </div>
                                                    @endif
                                                @endif

                                            </div>

                                        </div>

                                    </div>
                                @elseif($value['link_name'] == 'Agreement Process')
                                    <div id="{{ str_replace(' ', '-', strtolower($value['link_name'])) }}"
                                        class="tab-pane fade">
                                        <div class="row ">

                                            <div class="col-sm-12">
                                                <form action="#" method="GET" class="form-horizontal"
                                                    id="agreement-merchant-">
                                                    <div class="form-group">
                                                        <legend class="padding-10">Agreement Process of Merchant</legend>
                                                    </div>
                                                    @if (session('message'))
                                                        <span class="help-block col-sm-offset-2">
                                                            <div class="text-success text-sm-center">
                                                                {{ session('message') }}</div>
                                                        </span>
                                                    @endif




                                                    <div id="view_aggrement_doc_details"></div>





                                                    <input type="hidden" name="merchant_id" value="<?= $merchant_id ?>">
                                                    {{ csrf_field() }}

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($value['link_name'] == 'Merchant Change Password')
                                    <div id="{{ str_replace(' ', '-', strtolower($value['link_name'])) }}"
                                        class="tab-pane fade">



                                        <div class="row ">
                                            <div class="col-sm-12">
                                                <form action="{{ route('reset-merchant-password') }}" method="POST"
                                                    class="form-horizontal" id="reset-merchant-password-change">
                                                    <div class="form-group">
                                                        <legend class="padding-10">Change Password</legend>
                                                    </div>
                                                    @if (session('message'))
                                                        <span class="help-block col-sm-offset-2">
                                                            <div class="text-success text-sm-center">
                                                                {{ session('message') }}</div>
                                                        </span>
                                                    @endif
                                                    <div class="form-group">
                                                        <label for="input"
                                                            class="col-sm-2 control-label">Password:</label>
                                                        <div class="col-sm-3">
                                                            <input type="password" name="password" id="password"
                                                                class="form-control" autocomplete="off">
                                                            @if (!empty($password))
                                                                <span class="help-block password">
                                                                    <strong
                                                                        class="text-danger">{{ $password }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-1 show-cursor"
                                                            onclick="showMyPasssword('password',this)">
                                                            <i class="fa fa-eye fa-lg"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="input" class="col-sm-2 control-label">Confirm
                                                            Password:</label>
                                                        <div class="col-sm-3">
                                                            <input type="password" name="password_confirmation"
                                                                id="password_confirmation" class="form-control"
                                                                autocomplete="off">
                                                            @if (!empty($confirm_password))
                                                                <span class="help-block confirm-password">
                                                                    <strong
                                                                        class="text-danger">{{ $confirm_password }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-1 show-cursor"
                                                            onclick="showMyPasssword('password_confirmation',this)">
                                                            <i class="fa fa-eye fa-lg"></i>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="merchant_id" value="<?= $merchant_id ?>">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <div class="col-sm-10 col-sm-offset-2">
                                                            <button type="submit" class="btn btn-primary">Change
                                                                Password</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($value['link_name'] == 'Merchant WebHook')
                                    <div id="{{ str_replace(' ', '-', strtolower($value['link_name'])) }}"
                                        class="tab-pane fade">

                                        <div id="merchant-webhook-view">

                                        </div>
                                    </div>
                                @elseif($value['link_name'] == 'Merchant Payin Apis')
                                    <div id="{{ str_replace(' ', '-', strtolower($value['link_name'])) }}"
                                        class="tab-pane fade">
                                        <div id="merchant-api-view">

                                        </div>
                                    </div>
                                @elseif($value['link_name'] == 'Merchant Ip Whitelisting')
                                    <div id="{{ str_replace(' ', '-', strtolower($value['link_name'])) }}"
                                        class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                                    id="add_ip">Add /Update Ip </a>
                                            </div>
                                        </div>
                                        <table id="ip_whitelist" class="table table-bordered" style="width: 100%;">
                                            <thead>
                                                <th>#</th>
                                                <th>Ip</th>
                                                <th>Created At</th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                @elseif($value['link_name'] == 'Vendor Configuration')
                                    <div id="{{ str_replace(' ', '-', strtolower($value['link_name'])) }}"
                                        class="tab-pane fade">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <select mid="<?= $merchant_id ?>" id="showvendor"
                                                    class="show_vendor_config">
                                                    <option value="">--Select--</option>
                                                    @foreach (\App\RyapayVendorBank::get_vendorbank() as $index => $vendor)
                                                        <option value="{{ $vendor->bank_name }}">{{ $vendor->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="vendor-config-div"></div>
                                            </div>
                                        </div>
                                    </div>
                    </div>
                    @endif
                    @endforeach
                    @endif

                </div>
            </div>

        </div>


        {{-- add ip --}}
        <div class="modal fade ip-add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close btclose_btn" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="btmodalTitle">Add /Update Ip</h4>
                    </div>
                    <div class="modal-body">
                        <form id="ip_form" method="post" 
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="merchantId" value="<?= $merchant_id ?>">
                            <div class="form-group">
                                <label for="merchant">IP:</label>
                                <input type="text" class="text" name="ip">
                            </div>

                            <button type="submit"  class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- deletevendorModal -->
        <div class="modal fade" id="vendorDeleteModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" style="margin-top:150px" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="vendorexampleModalLongTitle">Are you sure to delete ?</h4>

                    </div>

                    <div class="modal-footer">
                        <form action="{{ url('/') }}/manage/technical/delete_vendor_keys" method="POST"
                            id="admin-vendor-delete-form">
                            {{ csrf_field() }}
                            <input type="hidden" id="getId" name="id">
                            <input type="hidden" id="vendor" name="vendor_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- end deletevendorModal -->


        <div class="modal" id="document-response-modal">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h4 class="modal-title">Document Status</h4>

                    </div>

                    <div class="modal-body">

                        <div id="document-response-message"></div>

                    </div>

                    <div class="modal-footer">

                        <a href="{{ route('merchant-document', 'paysel-7WRwwggm') }}"
                            class="btn btn-primary btn-sm">Ok</a>

                    </div>

                </div>

            </div>

        </div>

        <div class="modal" id="report-modal">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">KYC Correction Report To Merchant</h4>

                    </div>

                    <div class="modal-body">

                        <form id="rnc-report-form" method="POST" class="form-horizontal" role="form">

                            <div class="form-group">

                                <label for="" class="col-sm-3 control-label">Note:</label>

                                <div class="col-sm-9">

                                    <span class="text-danger">Fill the below textarea if you would like to make a note to
                                        merchant via email</span>

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="textarea" class="col-sm-3 control-label">Email Note:</label>

                                <div class="col-sm-9">

                                    <textarea name="email_note" id="textarea" class="form-control" rows="6"></textarea>

                                </div>

                            </div>

                            {{ csrf_field() }}

                            <input type="hidden" id="merchant_id" name="merchant_id" value={{ $merchant_id }}>

                            <div class="form-group">

                                <div class="col-sm-10 col-sm-offset-3">

                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


<script>
    var SubCatUrl = "{{ route('getSubCategorys') }}";
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/emp_merchant_edit.js') }}"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(e) {
        //getAdjustmentDetails();
        fetchWebhookData(<?= $merchant_id ?>);
        getA_MerchantApi(<?= $merchant_id ?>);
        load_agreement_docuement(<?= $merchant_id ?>);
    });




    $(document).ready(function() {
        var ipWhitelistTable = $('#ip_whitelist').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "{{ route('getIpWhitelist') }}",
                "type": "GET",
                "data": function(d) {
                    d.mid = <?= $merchant_id ?>; // Pass the mid parameter to the AJAX request
                }
            },
            "columns": [{
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "ipwhitelist"
                },
                {
                    "data": "created_at",
                    "render": function(data, type, row) {
                        var date = new Date(data);
                        var year = date.getFullYear();
                        var month = ('0' + (date.getMonth() + 1)).slice(-2);
                        var day = ('0' + date.getDate()).slice(-2);
                        var hours = ('0' + date.getHours()).slice(-2);
                        var minutes = ('0' + date.getMinutes()).slice(-2);
                        var seconds = ('0' + date.getSeconds()).slice(-2);
                        return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes +
                            ':' + seconds;
                    }
                }
            ]
        });

        $(document).on("click", "#add_ip", function(event) {
            $(".ip-add-modal").modal("show");
        });

        $('#ip_form').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('storeIpWhitelisted') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $(".ip-add-modal").modal("hide");
                        ipWhitelistTable.ajax
                    .reload(); // Reload the DataTable to show the latest changes
                    } else {
                        alert(response.message || "An error occurred while adding the IP.");
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred while adding the IP.");
                }
            });
        });
    });
</script>
