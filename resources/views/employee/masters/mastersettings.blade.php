@extends('layouts.employeecontent')
@section('employeecontent')

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- CSS -->
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css"> --}}

        <!-- JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    </head>
    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        @if (count($sublinks) > 0)
                            @foreach ($sublinks as $index => $value)
                                @if ($index == 0)
                                    <li class="active"><a data-toggle="tab" class="show-pointer"
                                            data-target="#{{ str_replace(' ', '-', strtolower($value->link_name)) }}">{{ $value->link_name }}</a>
                                    </li>
                                @else
                                    <li><a data-toggle="tab" class="show-pointer"
                                            data-target="#{{ str_replace(' ', '-', strtolower($value->link_name)) }}">{{ $value->link_name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li class="active"><a data-toggle="tab" class="show-pointer"
                                    data-target="#{{ str_replace(' ', '-', strtolower($sublink_name)) }}">{{ $sublink_name }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        @if (count($sublinks) > 0)
                            @foreach ($sublinks as $index => $value)
                                @switch($index)
                                    @case('0')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                            class="tab-pane fade in active">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                                        id="add_btype">Add Business Type </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form id="manage-BType-form">
                                                    @csrf
                                                    <div class="row" style="margin-top:15px;">
                                                        <div class="col-sm-12 mb-5">
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" name="searchfor" id="searchBType"
                                                                        class="searchforBType form-control "
                                                                        placeholder="Search Anything here">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-secondary"><i
                                                                                class="glyphicon glyphicon-search"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">


                                                                <select id="liststatusBType" name="status_filter"
                                                                    class="form-control searchFilterBType">
                                                                    <option value="">All</option>
                                                                    @foreach (get_business_status() as $status)
                                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>


                                                            </div>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="fordownload" value="BTypeDownld" />
                                                </form>
                                                <div class="col-sm-12">
                                                    <div style="margin-top:30px; margin-bottom:100px; ">
                                                        <table class="table table-striped table-bordered text-nowrap "
                                                            id="merchant-BType-table" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Type Name</th>
                                                                    <th>Status</th>
                                                                    <th>Created On</th>
                                                                    <th>Action</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    @break

                                    @case('1')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                                        id="add_bcat">Add Business Categories </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form id="manage-BCat-form">
                                                    @csrf
                                                    <div class="row" style="margin-top:15px;">
                                                        <div class="col-sm-12 mb-5">
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" name="searchfor" id="searchBCat"
                                                                        class="searchforBCat form-control "
                                                                        placeholder="Search Anything here">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-secondary"><i
                                                                                class="glyphicon glyphicon-search"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">


                                                                <select id="liststatusBCat" name="status_filter"
                                                                    class="form-control searchFilterBCat">
                                                                    <option value="">All</option>
                                                                    @foreach (get_business_status() as $status)
                                                                        <option value="{{ $status }}">{{ ucwords($status) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>


                                                            </div>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="fordownload" value="BCatDownld" />
                                                </form>
                                                <div class="col-sm-12">
                                                    <div style="margin-top:30px; margin-bottom:100px; ">
                                                        <table class="table table-striped table-bordered text-nowrap "
                                                            id="merchant-BCat-table" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Category Name</th>
                                                                    <th>Status</th>
                                                                    <th>Created On</th>
                                                                    <th>Action</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @break

                                    @case('2')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                                        id="add_bsubcat">Add Business SuBCategories</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form id="manage-BSubCat-form">
                                                    @csrf
                                                    <div class="row" style="margin-top:15px;">
                                                        <div class="col-sm-12 mb-5">
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" name="searchfor" id="searchBSubCat"
                                                                        class="searchforBSubCat form-control "
                                                                        placeholder="Search Anything here">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-secondary"><i
                                                                                class="glyphicon glyphicon-search"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">


                                                                <select id="liststatusBSubCat" name="status_filter"
                                                                    class="form-control searchFilterBSubCat">
                                                                    <option value="">All</option>
                                                                    @foreach (get_business_status() as $status)
                                                                        <option value="{{ $status }}">
                                                                            {{ ucwords($status) }}</option>
                                                                    @endforeach
                                                                </select>


                                                            </div>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="fordownload" value="BSubCatDownld" />
                                                </form>
                                                <div class="col-sm-12">
                                                    <div style="margin-top:30px; margin-bottom:100px; ">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered text-nowrap "
                                                                id="merchant-BSubCat-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Sub Category Name</th>
                                                                        <th>Category Name</th>

                                                                        <th>Status</th>
                                                                        <th>Created On</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    @break

                                    @case('4')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                            class="tab-pane fade in ">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                                        id="add_accountant">Add Accountant </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form id="manage-BType-form">
                                                    @csrf
                                                    <input type="hidden" name="fordownload" value="BTypeDownld" />
                                                </form>
                                                <div class="col-sm-12">
                                                    <div style="margin-top:30px; margin-bottom:100px; ">
                                                        <table class="table table-striped table-bordered text-nowrap "
                                                            id="accountant-table" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Name</th>
                                                                    <th>Email</th>
                                                                    <th>Phone</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    @break

                                    @case('5')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                            class="tab-pane fade in ">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                                        id="add_vendor">Add Acquirer </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form id="manage-BType-form">
                                                    @csrf
                                                    <input type="hidden" name="fordownload" value="BTypeDownld" />
                                                </form>
                                                <div class="col-sm-12">
                                                    <div style="margin-top:30px; margin-bottom:100px; ">
                                                        <table class="table table-striped table-bordered text-nowrap "
                                                            id="vendor-table" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Bank Name</th>
                                                                    <th>Acquirer Status</th>
                                                                    <th>Service Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    @break

                                    @case('6')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                            class="tab-pane fade in ">

                                            <div class="row">
                                                <div class="col-sm-12 padding-20">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">

                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="tab-content">

                                                                <div id="payout_settings" class="tab-pane fade in active">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                                                                id="payout_add_vendor">Add Payout Vendor </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">

                                                                        <div class="col-sm-12">
                                                                            <div style="margin-top:30px; margin-bottom:100px; ">
                                                                                <table
                                                                                    class="table table-striped table-bordered text-nowrap "
                                                                                    id="payout-vendor-table" style="width: 100%;">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>#</th>
                                                                                            <th>Bank Name</th>
                                                                                            <th>Acquirer Status</th>
                                                                                            <th>Service Status</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>




                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade payout-vendor-add-modal" tabindex="-1" role="dialog"
                                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog  modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <button type="button" class="close btclose_btn" data-dismiss="modal"
                                                                aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="vendormodalTitle">Add Vendor</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="payout_vendor_form" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <div class="">
                                                                    <div class="row"
                                                                        style="margin-left:10px;margin-right:10px;">
                                                                        <input type="hidden" id="modalcounter" value="0">
                                                                        <div class="col-12" id="personaldetails">
                                                                            <div class="">
                                                                                <!-- <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4> -->
                                                                                <div class="form-group form-fit">
                                                                                    <div class="form-group col-sm-12">
                                                                                        <label for="input"
                                                                                            class="col-sm-4 control-label">Vendor
                                                                                            Name:<span
                                                                                                class="mandatory">*</span></label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text" name="name"
                                                                                                required id="name"
                                                                                                class="form-control"
                                                                                                value="">
                                                                                        </div>
                                                                                    </div>


                                                                                    <input type="hidden" name="mode"
                                                                                        value="basic">


                                                                                    <div class="col-12" id="uploadfiles">
                                                                                        <div class="">
                                                                                            <input type="hidden"
                                                                                                name="row_id" />
                                                                                            <input type="hidden"
                                                                                                name="operation" />
                                                                                            <div class="row text-center "
                                                                                                style="margin:10px 5px 10px 5px;">
                                                                                                <button
                                                                                                    class="btn btn-primary registerVendor"
                                                                                                    id="vendormodalBtn"
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
                                                                        <div id="showerror" class="text-danger text-center my-3">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @break

                                    @default
                                    @break
                                @endswitch
                            @endforeach
                        @else
                            <div id="{{ str_replace(' ', '-', strtolower($sublink_name)) }}"
                                class="tab-pane fade in active">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        BCatUrl = "{{ route('getBusinessCategoryList') }}";
        BSubCatUrl = "{{ route('getBusinessSubCategoryList') }}";
        BTypeUrl = "{{ route('getBusinessTypeList') }}";
    </script>
    @include('inc_modals._merchantsettings')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/emp_master.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // merchantCharges();
            //$('[data-toggle="merchant-charges-info"]').popover();
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#accountant-table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false, // Disable the search functionality
                "ajax": "{{ route('getAccountantList') }}",
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "mobile"
                    },
                ]
            });
        });


        $(document).on("submit", "#accountant_form", function(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to Submit this?")) {
                $("#accountantmodalBtn").attr("disabled", true);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: base_phpurl + "/manage/register_accountant",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    method: "POST",
                    success: function(data) {
                        var result = jQuery.parseJSON(data);

                        console.log(result);
                        if (result.type == "success") {

                            if ($.fn.DataTable.isDataTable('#accountant-table')) {
                                $('#accountant-table').DataTable().destroy();
                            }

                            // Reinitialize the DataTable
                            $('#accountant-table').DataTable({
                                "processing": true,
                                "serverSide": true,
                                "searching": false, // Disable the search functionality
                                "ajax": "{{ route('getAccountantList') }}",
                                "columns": [{
                                        "data": "id"
                                    },
                                    {
                                        "data": "name"
                                    },
                                    {
                                        "data": "email"
                                    },
                                    {
                                        "data": "mobile"
                                    }
                                ]
                            });


                            swalnot(result.type, result.message);
                            $("#accountant_form")[0].reset();
                            $(".accountant-add-modal").modal("hide");
                        } else {
                            var mssg = result.message;

                            if (typeof mssg == "string") {
                                swalnot(result.type, result.message);
                                return true;
                            }
                            $.each(mssg, function(key, value) {
                                var input = "#accountant_form input[name=" + key + "]";
                                $(input + "+span>strong").text(value);
                                $(input).parent().parent().addClass("has-error");

                                //  text += key +"=>";

                                value.forEach(myFunction);

                                text += "<br>";
                            });



                            Swal.fire({
                                title: "Form Error",
                                icon: "error",
                                html: '<span style="color:#F8BB86;font-size:15px"><b>' +
                                    text +
                                    "</b></span>",
                                showCloseButton: true,
                                showCancelButton: true,
                                focusConfirm: false,
                            });
                        }

                        reset();
                        $("#accountantmodalBtn").attr("disabled", false);
                    },
                    error: function() {
                        alert("Fail to insert data into database....!");
                    },
                });
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            var table = initializeDataTable();

            function initializeDataTable() {
                return $('#vendor-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
                    "ajax": "{{ route('vendorList') }}",
                    "columns": [{
                            "data": null,
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            "data": "bank_name"
                        },
                        {
                            "data": "acquirer_status",
                            "render": function(data, type, row) {
                                var btnText = (row.acquirer_status == 1) ? "Active" : "Inactive";
                                var btnClass = (row.acquirer_status == 1) ? "btn-success" :
                                    "btn-danger";
                                return '<button class="btn ' + btnClass +
                                    ' btn-change-status" data-id="' + row.id + '" data-status="' +
                                    row.acquirer_status + '">' + btnText + '</button>';
                            }
                        },
                        {
                            "data": "is_active",
                            "render": function(data, type, row) {
                                var btnText = (row.is_active == 1) ? "Active" : "Inactive";
                                var btnClass = (row.is_active == 1) ? "btn-success" : "btn-danger";
                                return '<button class="btn ' + btnClass +
                                    ' btn-service-change-status" data-id="' + row.id +
                                    '" data-status="' +
                                    row.is_active + '">' + btnText + '</button>';
                            }
                        }
                    ]
                });
            }

            // Use event delegation to handle button clicks
            $('#vendor-table tbody').on('click', '.btn-change-status', function() {
                var row = table.row($(this).parents('tr')).data();
                var id = row.id;
                var currentStatus = $(this).data('status');
                var newStatus = (currentStatus == 1) ? 0 : 1;

                console.log(id, currentStatus);

                $.ajax({
                    url: "{{ route('changeVendorReconStatus') }}",
                    method: 'GET',
                    data: {
                        id: id,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            var statusString = newStatus ? 'Active' : 'Inactive'
                            swalnot('success', `Acquirer Status Changed To ${statusString}`);
                            table.ajax.reload();
                        } else {
                            swalnot('error', response.message);
                            console.error("Error:", response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            });

            $('#vendor-table tbody').on('click', '.btn-service-change-status', function() {
                var row = table.row($(this).parents('tr')).data();
                var id = row.id;
                var currentStatus = $(this).data('status');
                var newStatus = (currentStatus == 1) ? 0 : 1;

                console.log(id, currentStatus);

                $.ajax({
                    url: "{{ route('changeVendorServiceStatus') }}",
                    method: 'GET',
                    data: {
                        id: id,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            var statusString = newStatus ? 'Active' : 'Inactive'
                            swalnot('success', `Service Status Changed To ${statusString}`);
                            table.ajax.reload();
                        } else {
                            console.error("Error:", response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            });

            $(document).on("submit", "#vendor_form", function(event) {
                event.preventDefault();
                if (confirm("Are you sure you want to Submit this?")) {
                    $("#accountantmodalBtn").attr("disabled", true);
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: "{{ route('register_vendor') }}",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        method: "POST",
                        success: function(data) {
                            var result = jQuery.parseJSON(data);
                            console.log(result);
                            if (result.type == "success") {
                                table.destroy(); // Destroy the previous instance
                                table = initializeDataTable(); // Reinitialize the DataTable

                                swalnot(result.type, result.message);
                                $("#vendor_form")[0].reset();
                                $(".vendor-add-modal").modal("hide");
                            } else {
                                var mssg = result.message;
                                var text = "";
                                if (typeof mssg == "string") {
                                    swalnot(result.type, result.message);
                                    return true;
                                }
                                $.each(mssg, function(key, value) {
                                    var input = "#vendor_form input[name=" + key + "]";
                                    $(input + "+span>strong").text(value);
                                    $(input).parent().parent().addClass("has-error");

                                    value.forEach(function(errMsg) {
                                        text += errMsg + "<br>";
                                    });
                                });

                                Swal.fire({
                                    title: "Form Error",
                                    icon: "error",
                                    html: '<span style="color:#F8BB86;font-size:15px"><b>' +
                                        text + "</b></span>",
                                    showCloseButton: true,
                                    showCancelButton: true,
                                    focusConfirm: false,
                                });
                            }

                            reset();
                            $("#vendormodalBtn").attr("disabled", false);
                        },
                        error: function() {
                            alert("Fail to insert data into database....!");
                        },
                    });
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var table = initializeDataTable();

            function initializeDataTable() {
                return $('#payout-vendor-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searching": false, // Disable the search functionality
                    "ajax": "{{ route('payoutvendorList') }}",
                    "columns": [{
                            "data": null,
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            "data": "bank_name"
                        },
                        {
                            "data": "acquirer_status",
                            "render": function(data, type, row) {
                                var btnText = (row.acquirer_status == 1) ? "Active" : "Inactive";
                                var btnClass = (row.acquirer_status == 1) ? "btn-success" :
                                    "btn-danger";
                                return '<button class="btn ' + btnClass +
                                    ' btn-change-status" data-id="' + row.id + '" data-status="' +
                                    row.acquirer_status + '">' + btnText + '</button>';
                            }
                        },
                        {
                            "data": "is_active",
                            "render": function(data, type, row) {
                                var btnText = (row.is_active == 1) ? "Active" : "Inactive";
                                var btnClass = (row.is_active == 1) ? "btn-success" : "btn-danger";
                                return '<button class="btn ' + btnClass +
                                    ' btn-service-change-status" data-id="' + row.id +
                                    '" data-status="' + row.is_active + '">' + btnText +
                                    '</button>';
                            }
                        }
                    ]
                });
            }

            // Use event delegation to handle button clicks
            $('#payout-vendor-table tbody').on('click', '.btn-change-status', function() {
                var row = table.row($(this).parents('tr')).data();
                var id = row.id;
                var currentStatus = $(this).data('status');
                var newStatus = (currentStatus == 1) ? 0 : 1;

                $.ajax({
                    url: "{{ route('changePayoutVendorReconStatus') }}",
                    method: 'GET',
                    data: {
                        id: id,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            var statusString = newStatus ? 'Active' : 'Inactive'
                            swalnot('success', `Acquirer Status Changed To ${statusString}`);
                            table.ajax.reload();
                            table.ajax.reload();
                        } else {
                            console.error("Error:", response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            });

            $('#payout-vendor-table tbody').on('click', '.btn-service-change-status', function() {
                var row = table.row($(this).parents('tr')).data();
                var id = row.id;
                var currentStatus = $(this).data('status');
                var newStatus = (currentStatus == 1) ? 0 : 1;

                console.log(id, currentStatus);

                $.ajax({
                    url: "{{ route('changePayoutVendorServiceStatus') }}",
                    method: 'GET',
                    data: {
                        id: id,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            var statusString = newStatus ? 'Active' : 'Inactive'
                            swalnot('success', `Service Status Changed To ${statusString}`);
                            table.ajax.reload();
                        } else {
                            console.error("Error:", response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            });

            $(document).on("submit", "#payout_vendor_form", function(event) {
                event.preventDefault();
                if (confirm("Are you sure you want to Submit this?")) {
                    $("#accountantmodalBtn").attr("disabled", true);
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: "{{ route('registerPayoutVendor') }}",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        method: "POST",
                        success: function(data) {
                            var result = jQuery.parseJSON(data);
                            console.log(result);
                            if (result.type == "success") {
                                table.destroy(); // Destroy the previous instance
                                table = initializeDataTable(); // Reinitialize the DataTable

                                swalnot(result.type, result.message);
                                $("#payout_vendor_form")[0].reset();
                                $(".payout-vendor-add-modal").modal("hide");
                            } else {
                                var mssg = result.message;
                                var text = "";
                                if (typeof mssg == "string") {
                                    swalnot(result.type, result.message);
                                    return true;
                                }
                                $.each(mssg, function(key, value) {
                                    var input = "#payout_vendor_form input[name=" +
                                        key + "]";
                                    $(input + "+span>strong").text(value);
                                    $(input).parent().parent().addClass("has-error");

                                    value.forEach(function(errMsg) {
                                        text += errMsg + "<br>";
                                    });
                                });

                                Swal.fire({
                                    title: "Form Error",
                                    icon: "error",
                                    html: '<span style="color:#F8BB86;font-size:15px"><b>' +
                                        text + "</b></span>",
                                    showCloseButton: true,
                                    showCancelButton: true,
                                    focusConfirm: false,
                                });
                            }

                            $("#accountantmodalBtn").attr("disabled", false);
                        },
                        error: function() {
                            alert("Fail to insert data into database....!");
                        },
                    });
                }
            });
        });

        $(document).on("click", "#payout_add_vendor", function(event) {
            $(".payout-vendor-add-modal").modal("show");
            $("#payout_vendor_form")[0].reset();
            $("#vendormodalBtn").html("Add Vendor");
            $("#vendormodalBtn").attr("disabled", false);
        });
    </script>

@endsection
