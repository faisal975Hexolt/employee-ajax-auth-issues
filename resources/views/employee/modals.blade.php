<div class="modal" id="merchant-detail-view-modal">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Quick View Merchant Details</h4>
            </div>
            <div class="modal-body">
                <form id="regForm" action="">
                    <!-- One "tab" for each step in the form: -->
                    <div class="tab text-center text-md">
                        <h4>Personal Details:</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Name:</label></div>
                                <div class="col-sm-6 text-left" id="name"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Email:</label></div>
                                <div class="col-sm-6 text-left" id="email"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Mobile No:</label></div>
                                <div class="col-sm-6 text-left" id="mobile_no"></div>
                            </div>
                        </div>
                    </div>

                    <div class="tab text-center">
                        <h4>Company Info:</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Montly Expenditure:</label></div>
                                <div class="col-sm-6 text-left" id="expenditure"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Company Name:</label></div>
                                <div class="col-sm-6 text-left" id="business_name"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Company Address:</label></div>
                                <div class="col-sm-6 text-left" id="address"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Pincode:</label></div>
                                <div class="col-sm-6 text-left" id="pincode"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">City:</label></div>
                                <div class="col-sm-6 text-left" id="city"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">State:</label></div>
                                <div class="col-sm-6 text-left" id="state_name"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Country:</label></div>
                                <div class="col-sm-6 text-left" id="country"></div>
                            </div>
                        </div>
                    </div>

                    <div class="tab text-center">
                        <h4>Business Info:</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Business Type:</label></div>
                                <div class="col-sm-6 text-left" id="type_name"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Business Category:</label></div>
                                <div class="col-sm-6 text-left" id="category_name"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Business Sub Category:</label>
                                </div>
                                <div class="col-sm-6 text-left" id="sub_category_name"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">WebApp/Url:</label></div>
                                <div class="col-sm-6 text-left" id="website"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Bank Name:</label></div>
                                <div class="col-sm-6 text-left" id="bank_name"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Bank Acc No:</label></div>
                                <div class="col-sm-6 text-left" id="bank_acc_no"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Bank IFSC Code:</label></div>
                                <div class="col-sm-6 text-left" id="bank_ifsc_code"></div>
                            </div>
                        </div>
                    </div>

                    <div class="tab text-center">
                        <h4>Business Cards Info:</h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Company PAN No:</label></div>
                                <div class="col-sm-6 text-left" id="comp_pan_number"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Company GST:</label></div>
                                <div class="col-sm-6 text-left" id="comp_gst"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Authorized Signatory PAN
                                        No:</label></div>
                                <div class="col-sm-6 text-left" id="mer_pan_number"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Authorized Signatory Aadhar
                                        No:</label></div>
                                <div class="col-sm-6 text-left" id="mer_aadhar_number"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-5 text-right"><label for="">Authorized Signatory
                                        Name:</label></div>
                                <div class="col-sm-6 text-left" id="mer_name"></div>
                            </div>
                        </div>
                    </div>

                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" class="btn btn-success btn-sm" id="prevBtn"
                                onclick="nextPrev(-1)">Previous</button>
                            <button type="button" class="btn btn-primary btn-sm" id="nextBtn"
                                onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>





<!-- Transactiond Details Modal 1 -->
<div id="detail-transaction-model" class="modal" role="dialog" style="z-index: 11000;">
    <div class="modal-dialog " role="document" style="width:700px;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="">Transaction Details</h4>
            </div>
            <div class="modal-body">
                <div class="model-content" id="modal-dynamic-body">
                    <div id="paylink-add-form">

                        <div class="tab-content1">
                            <div id="transaction_details_view">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Transactiond Details Modal 1 -->



<div class="modal" id="vendor-config-edit-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Vendor Api Keys</h4>
            </div>
            <div id="vendor-config-add-succsess-response" class="text-center text-success"></div>
            <div id="vendor-config-add-fail-response" class="text-center text-danger"></div>
            <form class="form-horizontal admin_vendor_keys_form" action="{{ route('editVendorkeys') }}"
                method="post" id="update_vendor_keys_form" enctype="multipart/form-data">

                <div class="modal-body" id="vendor-config-edit-modal-body">

                </div>
                {{ csrf_field() }}

                <input type="hidden" name="id" value="">
                <div class="modal-footer">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="vendor-config-add-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Vendor Api Keys</h4>
            </div>
            <div id="vendor-config-add-succsess-response" class="text-center text-success"></div>
            <div id="vendor-config-add-fail-response" class="text-center text-danger"></div>
            <form class="form-horizontal admin_vendor_keys_form" action="{{ route('addVendorkeys') }}" method="post"
                id="add_vendor_keys_form" enctype="multipart/form-data">

                <div class="modal-body" id="vendor-config-add-modal-body">

                </div>
                {{ csrf_field() }}

                <input type="hidden" name="id" value="">
                <div class="modal-footer">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal" id="admin-merchant-edit-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title editModalTitle">Edit Merchant</h4>
            </div>
            <div id="merchant-edit-add-succsess-response" class="text-center text-success"></div>
            <div id="merchant-edit-fail-response" class="text-center text-danger"></div>
            <form class="form-horizontal" action="{{ route('updateMerchantInfo') }}" method="post"
                id="update_merchant_details_form" enctype="multipart/form-data">

                <div class="modal-body" id="admin-merchant-edit-modal-body">

                </div>
                {{ csrf_field() }}

                <input type="hidden" name="id" value="">
                <div class="modal-footer">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal" id="admin-merchant-document-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title documentModalTitle">Edit Merchant</h4>
            </div>
            <div id="merchant-document-add-succsess-response" class="text-center text-success"></div>
            <div id="merchant-document-fail-response" class="text-center text-danger"></div>
            <form class="form-horizontal" action="{{ route('updateMerchantInfo') }}" method="post"
                id="update_merchant_details_document_form" enctype="multipart/form-data">

                <div class="modal-body" id="admin-merchant-document-modal-body">

                </div>
                {{ csrf_field() }}

                <input type="hidden" name="id" value="">
                <div class="modal-footer">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<div id="update-api-modal-admin" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Generated Api</h4>
            </div>
            <form class="form-horizontal" id="update-api-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="apikeyid" class="control-label col-sm-2"> API Key:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="api_key" id="api_key" value=""
                                readonly>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="apikeyid" class="control-label col-sm-2">Salt Key:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="api_secret" id="api_secret"
                                value="" readonly>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>





<div id="admin-webhook-modal" class="modal admin-webhook-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Webhooks Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title admin-webhook-modal-title">Webhook</h4>
            </div>
            <div id="ajax-webhook-response" class="text-center"></div>
            <form class="form-horizontal" id="admin-webhook-form" action="{{ route('storeMerchantWebhook') }}">
                <div class="admin-webhook-modal-body modal-body">


                </div>

                <div class="modal-footer">
                    <div class="row">

                        <div class="form-group">

                            <div class="col-sm-6 text-center">
                                <button type="button" class="btn btn-primary  " data-dismiss="modal">Cancel</button>
                            </div>

                            <div class="col-sm-6 text-center">
                                <button type="submit" class="btn btn-success ">Submit</button>

                            </div>
                        </div>



                    </div>
                </div>

            </form>
        </div>

    </div>
</div>




<div class="modal" id="admin-settlemnt-edit-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="admin-settlemnt-edit-modal-title">Edit Merchant</h4>
            </div>
            <div id="settlemnt-edit-add-succsess-response" class="text-center text-success"></div>
            <div id="settlemnt-edit-fail-response" class="text-center text-danger"></div>
            <form class="form-horizontal" action="{{ route('updateSettlementUtr') }}" method="post"
                id="update_settlemnt_details_form" enctype="multipart/form-data">

                <div class="modal-body" id="admin-settlemnt-edit-modal-body">

                    <div id="show-success-message" class="text-sm-center"></div>

                    <div id="show-fail-message" class="text-sm-center"></div>

                </div>
                {{ csrf_field() }}

                <input type="hidden" name="id" value="">
                <div class="modal-footer">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
