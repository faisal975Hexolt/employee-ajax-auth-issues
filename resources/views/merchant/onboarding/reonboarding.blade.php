@extends('layouts.merchantcontent')
@section('merchantcontent')

    @php
        use App\MerchantBusiness;
        use App\BusinessType;
        use App\BusinessCategory;
        use App\State;
        use App\BusinessSubCategory;
        use App\MerchantDocument;
        use App\AppOption;
        
        $business_type = new BusinessType();
        $btype = $business_type->get_business_type();
        $business_category = new BusinessCategory();
        $business_subcategory = new BusinessSubCategory();
        $merchant_business = new MerchantBusiness();
        
        $business = $merchant_business->get_merchant_business_details()[0];
        $bscategory = [];
        if ($business->business_category_id) {
            $bscategory = $business_subcategory->get_business_subcategory(['id' => $business->business_category_id]);
        }
        
        $statelists = State::state_list();
        $bcategory = $business_category->get_business_category();
        $business_expenditure = AppOption::get_business_expenditure();
        
    @endphp
    <style>
        .downbut {
            background: #3097d1;
            box-sizing: border-box;
            border-radius: 25px;
        }

        fieldset {
            border: revert;
            padding: 16px;
            margin-top: 16px;
        }

        .margTop {
            margin-top: -1.5%;

        }

        .lineht {
            line-height: 1.9;
        }

        .colr {
            color: #f6e084;

        }

        .padtop {
            padding-top: 4px;
        }
    </style>

    <section id="about-1" class="about-1">
        <div class="container-1">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                    <div class="content-1 pt-4 pt-lg-0">
                        <h3 class="margH">Verfication Process Corrections </h3>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!--Module Banner-->
    <div class="row">
        <div class="col-sm-12 padding-left-30">
            <div class="panel panel-default">
                <div class="panel-heading">

                </div>
                <div class="panel-body panelH">
                    <div class="tab-content">

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
                        <div id="business-info" class="tab-pane fade in active">
                            <form class="form-horizontal" id="merchant-info-form" action="{{ route('update_onboarding') }}"
                                method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="panel panel-primary lineht margTop">
                                            <div class="panel-heading">
                                                <div class="panel-title text-left">
                                                    Text Field Corrections
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        @if (count($merchant_updated_details))
                                                            @foreach ($merchant_updated_details as $row)
                                                                <div class="form-group">
                                                                    <label class="control-label col-sm-4"
                                                                        for="{{ $row->field_name }}">{{ $row->field_label }}:<span
                                                                            class="mandatory">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        @if ($row->field_name == 'expenditure')
                                                                            <select name="{{ $row->field_name }}"
                                                                                id="{{ $row->field_name }}"
                                                                                class="col-sm-12 form-control">
                                                                                <option value="">--Select--</option>
                                                                                @foreach ($business_expenditure as $expenditure)
                                                                                    <option value="{{ $expenditure->id }}"
                                                                                        {{ $row->value == $expenditure->id ? 'selected' : '' }}>
                                                                                        {{ $expenditure->option_value }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div id="{{ $row->error }}"></div>
                                                                        @elseif ($row->field_name == 'state_name')
                                                                            <select name="{{ $row->field_name }}"
                                                                                id="{{ $row->field_name }}"
                                                                                class="col-sm-12 form-control">
                                                                                <option value="">--Select--</option>
                                                                                @foreach ($statelists as $state)
                                                                                    <option value="{{ $state->id }}"
                                                                                        {{ $row->value == $state->id ? 'selected' : '' }}>
                                                                                        {{ $state->state_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div id="{{ $row->error }}"></div>
                                                                        @elseif ($row->field_name == 'type_name')
                                                                            <select name="{{ $row->field_name }}"
                                                                                id="{{ $row->field_name }}"
                                                                                class="col-sm-12 form-control">
                                                                                <option value="">--Select--</option>
                                                                                @foreach ($btype as $type)
                                                                                    <option value="{{ $type->id }}"
                                                                                        {{ $row->value == $type->id ? 'selected' : '' }}>
                                                                                        {{ $type->type_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div id="{{ $row->error }}"></div>
                                                                        @elseif ($row->field_name == 'category_name')
                                                                            <select name="{{ $row->field_name }}"
                                                                                id="{{ $row->field_name }}"
                                                                                class="col-sm-12 form-control"
                                                                                onchange="getonboardsubcategory(this)">
                                                                                <option value="">--Select--</option>
                                                                                @foreach ($bcategory as $bcategory)
                                                                                    <option value="{{ $bcategory->id }}"
                                                                                        {{ $row->value == $bcategory->id ? 'selected' : '' }}>
                                                                                        {{ $bcategory->category_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div id="{{ $row->error }}"></div>
                                                                        @elseif ($row->field_name == 'sub_category_name')
                                                                            <select name="{{ $row->field_name }}"
                                                                                id="{{ $row->field_name }}"
                                                                                class="col-sm-12 form-control" disabled>
                                                                                <option value="">--Select--</option>
                                                                                @foreach ($bscategory as $subcategory)
                                                                                    <option value="{{ $subcategory->id }}"
                                                                                        {{ $row->value == $subcategory->id ? 'selected' : '' }}>
                                                                                        {{ $subcategory->sub_category_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div id="{{ $row->error }}"></div>
                                                                        @else
                                                                            <input type="text" class="form-control"
                                                                                id="{{ $row->field_name }}"
                                                                                name="{{ $row->field_name }}"
                                                                                value="{{ $row->value }}"
                                                                                placeholder="{{ $row->field_name }}"
                                                                                onkeyup="ValidateRecorrect('{{ $row->field_name }}','{{ $row->error }}');">
                                                                            <div id="{{ $row->error }}"></div>
                                                                        @endif
                                                                    </div>

                                                                    @if ($row->field_name == 'mer_aadhar_number')
                                                                        <div class="col-sm-2">
                                                                            <button type="button" class="btn btn-success"
                                                                                id="on_send_aadhar_otp">
                                                                                Send OTP
                                                                            </button>
                                                                        </div>
                                                                    @endif

                                                                    @if ($row->field_name == 'mer_aadhar_number')
                                                                        <div class="form-group hide"
                                                                            id="mer_aadhar_verify_error_view">
                                                                            <label class="control-label col-sm-4"
                                                                                for="pan-number"></label>
                                                                            <div class="col-sm-8">
                                                                                <div id="mer_aadhar_verify_error"></div>
                                                                            </div>
                                                                        </div>
                                                                    @endif


                                                                    @if ($row->field_name == 'mer_aadhar_number')
                                                                        <div class="form-group  hide" id="otp_aadhar_view">
                                                                            <label class="control-label col-sm-4"
                                                                                for="pan-number">OTP for Aadhaar:<span
                                                                                    class="mandatory">*</span></label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text"
                                                                                    class="form-control not-mandatory"
                                                                                    id="otp_aadhar_number"
                                                                                    name="otp_aadhar_number" value=""
                                                                                    placeholder="6 Digit OTP for Aadhaar."
                                                                                    maxlength="6"
                                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                                    onkeyup="validateOtpAadharCard('otp_aadhar_number','otp_aadhar_number_error')">
                                                                                <div id="otp_aadhar_number_error"></div>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <button type="button"
                                                                                    class="btn btn-success"
                                                                                    id="on_verify_aadhar_otp">
                                                                                    Verify OTP
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group hide"
                                                                            id="mer_aadhar_check_error_view">
                                                                            <label class="control-label col-sm-4"
                                                                                for="pan-number"></label>
                                                                            <div class="col-sm-8">
                                                                                <div id="mer_aadhar_check_error"></div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif


                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                                <div id="view_doc_details"></div>

                                <div id="ajax1-activate-account-success" class="text-center"></div>
                                <div id="ajax1-activate-account-failed" class="text-center text-danger"></div>
                                <div id="ajax1-activate-account-uploaded" class="text-center text-success"></div>
                                <div id="ajax1-business-info-response-message" class="text-center text-success"></div>

                                <input type="hidden" id="onboardmerchantId" name="onboardmerchantId"
                                    value="{{ $formdata['merchant_id'] }}">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success bg-olive"
                                            id="merchant-info-form-submit" title="">
                                            Submit Data
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
