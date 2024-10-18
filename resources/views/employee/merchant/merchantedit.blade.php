@if ($mode == 'basic')
    <div id="basic">
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Name:<span class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_name" id="e_name" class="form-control"
                    value="{{ getBladeView($info['data'], 'name') }}">
                <div id="e_name_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Email:<span class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_email" id="e_email" class="form-control"
                    value="{{ getBladeView($info['data'], 'email') }}" disabled>
                <div id="e_name_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Mobile Number:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_mobile_no" id="e_mobile_no" class="form-control"
                    value="{{ getBladeView($info['data'], 'mobile_no') }}">
                <div id="e_name_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Expected Volume:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_transaction_limit" id="e_transaction_limit" class="form-control"
                    value="{{ getBladeView($info['data'], 'transaction_limit') }}">
                <div id="e_name_error" class="text-danger"></div>
            </div>
        </div>
    </div>
@elseif($mode == 'business')
    <div id="business">
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Merchant Name::<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_mer_name" id="e_mer_name" class="form-control"
                    value="{{ getBladeView($info['data'], 'mer_name') }}">
                <div id="e_mer_name_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Business Name:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_business_name" id="e_business_name" class="form-control"
                    value="{{ getBladeView($info['data'], 'business_name') }}">
                <div id="e_business_name_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Business Type:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">

                <select name="e_business_type_id" id="e_business_type_id" class="form-control" required>
                    @foreach (getBusinessType() as $business)
                        <option value="{{ $business->id }}"
                            {{ getBladeView($info['data'], 'business_type_id') == $business->id ? 'selected' : '' }}>
                            {{ $business->type_name }}</option>
                    @endforeach
                </select>

                <div id="e_business_type_id_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Business Category:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">

                <select name="e_business_category_id" id="e_business_category_id" class="form-control" required>
                    @foreach (getbusinessCategory() as $category)
                        <option value="{{ $category->id }}"
                            {{ getBladeView($info['data'], 'business_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}</option>
                    @endforeach
                </select>

                <div id="e_business_category_id_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Business Sub Category:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">


                <select name="e_business_sub_category_id" id="e_business_sub_category_id" class="form-control"
                    required>
                    @foreach (getbusinessSubcategoryByCat(getBladeView($info['data'], 'business_category_id')) as $subcategory)
                        <option value="{{ $subcategory->id }}"
                            {{ getBladeView($info['data'], 'business_sub_category_id') == $subcategory->id ? 'selected' : '' }}>
                            {{ $subcategory->sub_category_name }}</option>
                    @endforeach
                </select>
                <div id="e_business_sub_category_id_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Expected Monthly Volume:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">

                <select name="e_business_expenditure" id="e_business_expenditure" class="form-control" required>
                    @foreach (getmonthlyExpenditure() as $expdt)
                        <option value="{{ $expdt->id }}"
                            {{ getBladeView($info['data'], 'business_expenditure') == $expdt->id ? 'selected' : '' }}>
                            {{ $expdt->option_value }}</option>
                    @endforeach
                </select>

                <div id="e_business_expenditure_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Merchant GST Charges:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_merchant_gst_chargers" id="e_merchant_gst_chargers"
                    class="form-control" value="{{ getBladeView($info['data'], 'merchant_gst_chargers') }}">
                <div id="e_merchant_gst_chargers" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Website:<span class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_webapp_url" id="e_webapp_url" class="form-control"
                    value="{{ getBladeView($info['data'], 'webapp_url') }}">
                <div id="e_webapp_url_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Bank Name:<span class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_bank_name" id="e_bank_name" class="form-control"
                    value="{{ getBladeView($info['data'], 'bank_name') }}">
                <div id="e_bank_name_error" class="text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Bank Account Number:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_bank_acc_no" id="e_bank_acc_no" class="form-control"
                    value="{{ getBladeView($info['data'], 'bank_acc_no') }}">
                <div id="e_bank_acc_no_error" class="text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Bank IFSC Code:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_bank_ifsc_code" id="e_bank_ifsc_code" class="form-control"
                    value="{{ getBladeView($info['data'], 'bank_ifsc_code') }}">
                <div id="e_bank_ifsc_code_error" class="text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Company Pan number:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_comp_pan_number" id="e_comp_pan_number" class="form-control"
                    value="{{ getBladeView($info['data'], 'comp_pan_number') }}">
                <div id="e_comp_pan_number_error" class="text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">GST:<span class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_comp_gst" id="e_comp_gst" class="form-control"
                    value="{{ getBladeView($info['data'], 'comp_gst') }}">
                <div id="e_comp_gst_error" class="text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Pan Number:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_mer_pan_number" id="e_mer_pan_number" class="form-control"
                    value="{{ getBladeView($info['data'], 'mer_pan_number') }}">
                <div id="e_mer_pan_number_error" class="text-danger"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Aadhar Number:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_mer_aadhar_number" id="e_mer_aadhar_number" class="form-control"
                    value="{{ getBladeView($info['data'], 'mer_aadhar_number') }}">
                <div id="e_mer_aadhar_number_error" class="text-danger"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Company Cin:<span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" name="e_comp_cin" id="e_comp_cin" class="form-control"
                    value="{{ getBladeView($info['data'], 'comp_cin') }}">
                <div id="e_comp_cin" class="text-danger"></div>
            </div>
        </div>
    </div>
@elseif($mode == 'addreess')
    <div id="addreess">
        <div class="form-group">
            <label for="input" class="col-sm-4 control-label">Address:<span class="text-danger">*</span></label>
            <div class="col-sm-8">

                <textarea name="e_address" id="e_address" class="form-control">{{ getBladeView($info['data'], 'address') }}</textarea>
                <div id="e_address_error" class="text-danger"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="input" class="col-sm-4 control-label">Pincode:<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" name="e_pincode" id="e_pincode" class="form-control"
                value="{{ getBladeView($info['data'], 'pincode') }}">
            <div id="e_pincode_error" class="text-danger"></div>
        </div>
    </div>


    <div class="form-group">
        <label for="input" class="col-sm-4 control-label">City:<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" name="e_city" id="e_city" class="form-control"
                value="{{ getBladeView($info['data'], 'city') }}">
            <div id="e_city_error" class="text-danger"></div>
        </div>
    </div>

    <div class="form-group">
        <label for="input" class="col-sm-4 control-label">State:<span class="text-danger">*</span></label>
        <div class="col-sm-8">


            <select name="e_state" id="e_state" class="form-control" required>
                @foreach (\App\State::all() as $state)
                    <option value="{{ $state->id }}"
                        {{ getBladeView($info['data'], 'state') == $state->id ? 'selected' : '' }}>{{ $state->state_name }}
                    </option>
                @endforeach
            </select>
            <div id="e_state_error" class="text-danger"></div>
        </div>
    </div>



@endif



<input type="hidden" name="merchant_id" value="{{ $merchant_id }}">

<input type="hidden" name="mode" value="{{ $mode }}">
