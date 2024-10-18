@extends('layouts.employeecontent')
@section('employeecontent')

    <head>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    </head>
    <div class="row">
        <div class="col-sm-12 padding-20">


            <a href="{{ route('resellerManage') }}" class="btn btn-secondary"> <button  class="btn btn-primary">Back</button></a>

            <form class="form-horizontal" id="reseller-form" action="{{ route('setResellerDetails') }}" method="POST">
                @csrf <!-- Add CSRF token for security -->
                <div class="modal-body">
                    <input type="hidden" id="reseller_id" name="reseller_id" value="{{ request()->route('id') }}">
                    <div class="form-group">
                        <label for="business_name" class="control-label col-sm-4">Business Name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="business_name" id="business_name"
                                value="{{ $reseller->business_name ?? '' }}">
                            <span class="text-danger" role="alert" id="business_name-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="business_type" class="control-label col-sm-4">Business Type:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="business_type" id="business_type">
                                <option value="">Select Business Type</option>
                                @foreach ($business_type as $type)
                                    <option value="{{ $type->id }}"
                                        @if (empty($reseller->business_type) && empty($type->id))
                                            selected
                                        @elseif (!empty($reseller->business_type) && $reseller->business_type == $type->id)
                                            selected
                                        @endif
                                    >
                                        {{ $type->type_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger" role="alert" id="business_type-error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business_category" class="control-label col-sm-4">Business Category:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="business_category" id="business_category">
                                <option value="">Select Business Category</option>
                                {{-- Business categories will be populated dynamically --}}
                            </select>
                            <span class="text-danger" role="alert" id="business_category-error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business_sub_category" class="control-label col-sm-4">Business Sub Category:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="business_sub_category" id="business_sub_category">
                                <option value="">Select Business Sub Category</option>
                                {{-- Business subcategories will be populated dynamically --}}
                            </select>
                            <span class="text-danger" role="alert" id="business_sub_category-error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gst_no" class="control-label col-sm-4">Gst No:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="gst_no" id="gst_no"
                                value="{{ $reseller->gst_no ?? '' }}">
                            <span class="text-danger" role="alert" id="gst_no-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="website" class="control-label col-sm-4">Website:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="website" id="website"
                                value="{{ $reseller->website ?? '' }}">
                            <span class="text-danger" role="alert" id="website-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_name" class="control-label col-sm-4">Bank Name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="bank_name" id="bank_name"
                                value="{{ $reseller->bank_name ?? '' }}">
                            <span class="text-danger" role="alert" id="bank_name-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_account_number" class="control-label col-sm-4">Bank Account Number:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="bank_account_number"
                                id="bank_account_number" value="{{ $reseller->bank_account_number ?? '' }}">
                            <span class="text-danger" role="alert" id="bank_account_number-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_ifsc_code" class="control-label col-sm-4">Bank IFSC Code:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="bank_ifsc_code" id="bank_ifsc_code"
                                value="{{ $reseller->bank_ifsc_code ?? '' }}">
                            <span class="text-danger" role="alert" id="bank_ifsc_code-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pan_number" class="control-label col-sm-4">PAN Number:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="pan_number" id="pan_number"
                                value="{{ $reseller->pan_number ?? '' }}">
                            <span class="text-danger" role="alert" id="pan_number-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="aadhar_number" class="control-label col-sm-4">Aadhar Number:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="aadhar_number" id="aadhar_number"
                                value="{{ $reseller->aadhar_number ?? '' }}">
                            <span class="text-danger" role="alert" id="aadhar_number-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label col-sm-4">Address:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="address" id="address"
                                value="{{ $reseller->address ?? '' }}">
                            <span class="text-danger" role="alert" id="address-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pin_code" class="control-label col-sm-4">Pin Code:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="pin_code" id="pin_code"
                                value="{{ $reseller->pin_code ?? '' }}">
                            <span class="text-danger" role="alert" id="pin_code-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="control-label col-sm-4">City:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="city" id="city"
                                value="{{ $reseller->city ?? '' }}">
                            <span class="text-danger" role="alert" id="city-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="control-label col-sm-4">State:</label>
                        <div class="col-sm-6">


                            <select class="form-control" name="state" id="state">
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        @if (!is_null($reseller) && $reseller->state == $state->id)
                                            selected
                                        @endif
                                    >
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                            </select>


                            <span class="text-danger" role="alert" id="state-error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>






        </div>
    </div>



    <script>
        $(document).ready(function() {
            // Populate business categories on page load
            populateBusinessCategories();

            // Function to populate business categories
            function populateBusinessCategories() {
                $.ajax({
                    url: "{{ route('businessCategoriesList') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#business_category').empty();
                        $('#business_category').append(
                            '<option value="">Select Business Category</option>');
                        $.each(response.data, function(index, category) {
                            $('#business_category').append('<option value="' + category.id +
                                '">' + category.category_name + '</option>');
                        });

                        // Pre-select business_category if available in $reseller
                        var businessCategory = "{{ $reseller->business_category ?? '' }}";
                        console.log(businessCategory)
                        if (businessCategory !== '') {
                            $('#business_category').val(businessCategory);
                            // Trigger change event to populate subcategories for pre-selected category
                            populateBusinessSubcategories(businessCategory);
                        }
                    }
                });
            }

            // Function to populate business subcategories based on selected category
            function populateBusinessSubcategories(categoryId) {
                $.ajax({
                    url: "{{ route('businessSubCategoryListByCategory') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: categoryId
                    },
                    success: function(response) {
                        $('#business_sub_category').empty();
                        $('#business_sub_category').append(
                            '<option value="">Select Business Sub Category</option>');
                        $.each(response.data, function(index, subcategory) {
                            $('#business_sub_category').append('<option value="' + subcategory
                                .id + '">' + subcategory.sub_category_name + '</option>');
                        });

                        // Pre-select business_sub_category if available in $reseller
                        var businessSubCategory = "{{ $reseller->business_sub_category ?? '' }}";
                        if (businessSubCategory !== '') {
                            $('#business_sub_category').val(businessSubCategory);
                        }
                    }
                });
            }

            // Handle change event for business_category select
            $('#business_category').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    populateBusinessSubcategories(categoryId);
                } else {
                    $('#business_sub_category').empty();
                    $('#business_sub_category').append(
                        '<option value="">Select Business Sub Category</option>');
                }
            });
        });
    </script>
@endsection
