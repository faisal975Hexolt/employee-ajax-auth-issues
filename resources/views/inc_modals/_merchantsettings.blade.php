<div class="modal fade bussiness-type-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close btclose_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="btmodalTitle">Add</h4>
            </div>
            <div class="modal-body">
                <form id="btype_form" method="post" action="{{ route('register_merchant') }}"
                    enctype="multipart/form-data" vemail="{{ route('validate_merchant_mail') }}"
                    vmobile="{{ route('validate_merchant_mail') }}">
                    {{ csrf_field() }}
                    <div class="">
                        <div class="row" style="margin-left:10px;margin-right:10px;">
                            <input type="hidden" id="modalcounter" value="0">
                            <div class="col-12" id="personaldetails">
                                <div class="">
                                    <!-- <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4> -->
                                    <div class="form-group form-fit">
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Business Type
                                                Name:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="type_name" id="btype_type_name"
                                                    class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Business Type
                                                Status:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="status" id="btype_status"
                                                    class="form-control">
                                                    <option value="">--select business Type--</option>
                                                    @foreach (type_status() as $status)
                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <input type="hidden" name="mode" value="basic">




                                    </div>
                                </div>
                            </div>



                            <!-- //upload files -->
                            <div class="col-12" id="uploadfiles">
                                <div class="">
                                    <input type="hidden" name="row_id" />
                                    <input type="hidden" name="operation" />
                                    <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                        <button class="btn btn-primary registerMer" id="btmodalBtn" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- enduplad files -->
                            <div id="showerror" class="text-danger text-center my-3"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bussiness-subcat-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close bscclose_btn" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="bscmodalTitle">Add</h4>
            </div>
            <div class="modal-body">
                <form id="bscat_form" method="post" action="{{ route('register_merchant') }}"
                    enctype="multipart/form-data" vemail="{{ route('validate_merchant_mail') }}"
                    vmobile="{{ route('validate_merchant_mail') }}">
                    {{ csrf_field() }}
                    <div class="">
                        <div class="row" style="margin-left:10px;margin-right:10px;">
                            <input type="hidden" id="modalcounter" value="0">
                            <div class="col-12" id="personaldetails">
                                <div class="">
                                    <!-- <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4> -->
                                    <div class="form-group form-fit">
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Business SubCategory
                                                Name:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" required="required" name="sub_category_name"
                                                    id="bsc_sub_category_name" class="form-control" value="">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Business
                                                Category:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="category_id" id="bsc_category_id"
                                                    class="form-control">
                                                    <option value="">--select Business Category--</option>
                                                    @foreach (getbusinessCategory() as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Business SubCategory
                                                Status:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="status" id="bsc_status"
                                                    class="form-control">
                                                    <option value="">--select status--</option>
                                                    @foreach (type_status() as $status)
                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <input type="hidden" name="mode" value="basic">




                                    </div>
                                </div>
                            </div>



                            <!-- //upload files -->
                            <div class="col-12" id="uploadfiles">
                                <div class="">
                                    <input type="hidden" name="row_id" />
                                    <input type="hidden" name="operation" />
                                    <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                        <button class="btn btn-primary registerMer" id="bscmodalBtn" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- enduplad files -->
                            <div id="showerror" class="text-danger text-center my-3"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade bussiness-cat-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close bcclose_btn" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="bcmodalTitle">Add</h4>
            </div>
            <div class="modal-body">
                <form id="bcat_form" method="post" action="{{ route('register_merchant') }}"
                    enctype="multipart/form-data" vemail="{{ route('validate_merchant_mail') }}"
                    vmobile="{{ route('validate_merchant_mail') }}">
                    {{ csrf_field() }}
                    <div class="">
                        <div class="row" style="margin-left:10px;margin-right:10px;">
                            <input type="hidden" id="modalcounter" value="0">
                            <div class="col-12" id="personaldetails">
                                <div class="">
                                    <!-- <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4> -->
                                    <div class="form-group form-fit">
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Business Category
                                                Name:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" required="required" name="category_name"
                                                    id="bc_category_name" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Business Category
                                                Status:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="status" id="bc_status"
                                                    class="form-control">
                                                    <option value="">--select status--</option>
                                                    @foreach (type_status() as $status)
                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <input type="hidden" name="mode" value="basic">




                                    </div>
                                </div>
                            </div>



                            <!-- //upload files -->
                            <div class="col-12" id="uploadfiles">
                                <div class="">
                                    <input type="hidden" name="row_id" />
                                    <input type="hidden" name="operation" />
                                    <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                        <button class="btn btn-primary registerMer" id="bcmodalBtn" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- enduplad files -->
                            <div id="showerror" class="text-danger text-center my-3"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade accountant-add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close btclose_btn" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="btmodalTitle">Add</h4>
            </div>
            <div class="modal-body">
                <form id="accountant_form" method="post" action="{{ route('register_accountant') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="">
                        <div class="row" style="margin-left:10px;margin-right:10px;">
                            <input type="hidden" id="modalcounter" value="0">
                            <div class="col-12" id="personaldetails">
                                <div class="">
                                    <!-- <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4> -->
                                    <div class="form-group form-fit">
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Accountant Name:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" required id="name"
                                                    class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Phone:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="mobile" required id="mobile"
                                                    class="form-control" value="">

                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Email:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="email" name="email" required id="email"
                                                    class="form-control" value="">

                                            </div>
                                        </div>
                                        <input type="hidden" name="mode" value="basic">


                                        <div class="col-12" id="uploadfiles">
                                            <div class="">
                                                <input type="hidden" name="row_id" />
                                                <input type="hidden" name="operation" />
                                                <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                                    <button class="btn btn-primary registerAccountant"
                                                        id="accountantmodalBtn" type="submit">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <!-- //upload files -->

                            <!-- enduplad files -->
                            <div id="showerror" class="text-danger text-center my-3"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade vendor-add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close btclose_btn" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="vendormodalTitle">Add Vendor</h4>
            </div>
            <div class="modal-body">
                <form id="vendor_form" 
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="">
                        <div class="row" style="margin-left:10px;margin-right:10px;">
                            <input type="hidden" id="modalcounter" value="0">
                            <div class="col-12" id="personaldetails">
                                <div class="">
                                    <!-- <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4> -->
                                    <div class="form-group form-fit">
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Vendor Name:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" required id="name"
                                                    class="form-control" value="">
                                            </div>
                                        </div>


                                        <input type="hidden" name="mode" value="basic">


                                        <div class="col-12" id="uploadfiles">
                                            <div class="">
                                                <input type="hidden" name="row_id" />
                                                <input type="hidden" name="operation" />
                                                <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                                    <button class="btn btn-primary registerVendor" id="vendormodalBtn"
                                                        type="submit">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <!-- //upload files -->

                            <!-- enduplad files -->
                            <div id="showerror" class="text-danger text-center my-3"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade cron-setting-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close CSclose_btn" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="CSmodalTitle">Add</h4>
            </div>
            <div class="modal-body">
                <form id="csettings_form" method="post" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="">
                        <div class="row" style="margin-left:10px;margin-right:10px;">
                            <input type="hidden" id="modalcounter" value="0">
                            <div class="col-12" id="personaldetails">
                                <div class="">
                                    <!-- <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4> -->
                                    <div class="form-group form-fit">
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Cron Fire At:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" required="required" name="cron_time"
                                                    id="cs_cron_time" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Transaction Start
                                                From:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" required="required" name="transaction_form"
                                                    id="cs_transaction_from" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Transaction Start
                                                Day:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="transaction_form_day"
                                                    id="cs_transaction_form_day" class="form-control">
                                                    <option value="">--select status--</option>
                                                    @foreach (settelmentCronDays() as $status)
                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Transaction End
                                                At:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" required="required" name="transaction_to"
                                                    id="cs_transaction_to" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Transaction End
                                                Day:<span class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="transaction_to_day"
                                                    id="cs_transaction_to_day" class="form-control">
                                                    <option value="">--select status--</option>
                                                    @foreach (settelmentCronDays() as $status)
                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label"> Status:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="status" id="cs_status"
                                                    class="form-control">
                                                    <option value="">--select status--</option>
                                                    @foreach (type_status() as $status)
                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <input type="hidden" name="mode" value="basic">




                                    </div>
                                </div>
                            </div>



                            <!-- //upload files -->
                            <div class="col-12" id="uploadfiles">
                                <div class="">
                                    <input type="hidden" name="row_id" />
                                    <input type="hidden" name="operation" />
                                    <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                        <button class="btn btn-primary registerMer" id="bcmodalBtn" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- enduplad files -->
                            <div id="showerror" class="text-danger text-center my-3"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade gst-cron-setting-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close GCSclose_btn" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="GCSmodalTitle">Add</h4>
            </div>
            <div class="modal-body">
                <form id="gcsettings_form" method="post" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="">
                        <div class="row" style="margin-left:10px;margin-right:10px;">
                            <input type="hidden" id="modalcounter" value="0">
                            <div class="col-12" id="personaldetails">
                                <div class="">
                                    <!-- <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4> -->
                                    <div class="form-group form-fit">

                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Day Of Month:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="gst_cron_day" id="gst_cron_day"
                                                    class="form-control">
                                                    <option value="">--select status--</option>
                                                    @foreach (gstCronDays() as $status)
                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>


                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label">Cron Fire Time:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" required="required" name="gst_cron_time"
                                                    id="gst_cron_time" class="form-control">
                                            </div>
                                        </div>




                                        <div class="form-group col-sm-12">
                                            <label for="input" class="col-sm-4 control-label"> Status:<span
                                                    class="mandatory">*</span></label>
                                            <div class="col-sm-8">
                                                <select required="required" name="status" id="gcs_status"
                                                    class="form-control">
                                                    <option value="">--select status--</option>
                                                    @foreach (type_status() as $status)
                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <input type="hidden" name="mode" value="basic">




                                    </div>
                                </div>
                            </div>



                            <!-- //upload files -->
                            <div class="col-12" id="uploadfiles">
                                <div class="">
                                    <input type="hidden" name="row_id" />
                                    <input type="hidden" name="operation" />
                                    <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                        <button class="btn btn-primary registerMer" id="bcmodalBtn" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- enduplad files -->
                            <div id="showerror" class="text-danger text-center my-3"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
