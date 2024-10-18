@extends('layouts.employeecontent')
@section('employeecontent')

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- CSS -->
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css"> --}}

        <!-- JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    </head>
    <style>
        .table-container {
            width: 100%;
            overflow-y: auto;
            /* Enable vertical scrollbar */
        }
    </style>



    <div class="container">
        <div class="row">
            <div class="col-sm-3 mb-4">
                <div class="">
                    <label for="">Select Merchant</label>
                    <select name="merchant_for_merchant_charge" id="merchant_for_assigned_accountants" class="form-control">
                        <option value="all">All
                        </option>
                        @foreach ($selectBoxFilterMerchant as $index => $merchant)
                            <option value="{{ $merchant->id }}">
                                {{ $merchant->merchant_gid . ' : ' . $merchant->business_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3 mb-4" style="margin-top: 30px">
                <button type="button" class="btn btn-primary" id="assignAccountantBtn">Assign Accountant</button>
            </div>
        </div>

        <div class="row justify-content-center " style="margin-top: 15px">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header"> </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table id="users-table" class="table table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <td>id</td>
                                        <td>Merchant Id</td>
                                        <td>Merchant Name</td>
                                        <td>Accountant Name</td>
                                        <td>Action</td>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded dynamically via AJAX -->
                                </tbody>
                            </table>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Accountant Modal -->
    <div class="modal fade accountant-add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btclose_btn" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="btmodalTitle">Assign Accountant</h4>
                </div>
                <div class="modal-body">
                    <form id="accountant_form" method="post" action="{{ route('addmerchantaccountant') }}"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="merchantId" value="basic">
                        <div class="form-group">
                            <label for="merchant">Merchant:</label>
                            <select class="form-control" name="merchant_id" id="merchant_list_accountant">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="accountant">Accountant:</label>
                            <select class="form-control" name="accountant_id">
                                @foreach ($accountants as $accountant)
                                    <option value="{{ $accountant['id'] }}">{{ $accountant['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="assignSubmitAccountantBtn" class="btn btn-primary">Assign
                            Accountant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade accountant-edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close btclose_btn" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="btmodalTitle">Edit</h4>
                </div>
                <div class="modal-body">
                    <form id="edit_accountant_form" method="post" action="{{ route('register_accountant') }}"
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
                                                <label for="input" class="col-sm-4 control-label">Accountant:<span
                                                        class="mandatory">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="accountant_id">
                                                        @foreach ($accountants as $accountant)
                                                            <option value="{{ $accountant['id'] }}">
                                                                {{ $accountant['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden" name="merchantId" value="basic">


                                            <div class="col-12" id="uploadfiles">
                                                <div class="">
                                                    <input type="hidden" name="row_id" />
                                                    <input type="hidden" name="operation" />
                                                    <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                                        <button class="btn btn-primary registerAccountant"
                                                            id="editassignAccountantBtn" type="submit">
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

    <script>
        var table; // Declare table variable globally


        function updateMerchantForAccountants() {
            $.ajax({
                type: "GET",
                url: "{{ route('merchantsListForAccountants') }}",
                dataType: "json",
                success: function(response) {
                    var merchantSelect = $("#merchant_list_accountant");
                    merchantSelect.empty(); // Clear current options
                    merchantSelect.append('<option value="">--Select--</option>'); // Add default option

                    // Add new options from the response
                    $.each(response, function(index, merchant) {
                        merchantSelect.append('<option value="' + merchant.id + '">' + merchant
                            .merchant_gid + '  ' + merchant.business_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Server Response:', xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            updateMerchantForAccountants();
        });

        $(document).ready(function() {
             table = $('#users-table').DataTable({
                "processing": true,
                "serverSide": true,
                searching: false,
                "ajax": {
                    "url": "{{ route('getMerchantAccountant') }}",
                    "data": function(d) {
                        d.merchant_id = $('#merchant_for_assigned_accountants').val();
                    }
                },
                "columns": [{
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            // Calculate and return the incremented id
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "merchant.merchant_gid"
                    },
                    {
                        "data": "merchantbusiness.business_name"
                    },
                    {
                        "data": "accountant.name"
                    },
                    {
                        "data": null, // use null data source for action column
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row) {
                            return `
                            <button id="edit_accountant" class="btn btn-warning btn-sm edit-btn" accountantid="${row.accountant_id}" merchantid="${row.merchant_id}">Edit</button>
                        `;
                        }
                    }
                ]
            });

            $('#merchant_for_assigned_accountants').change(function() {
                table.ajax.reload();
            });
        });

        $(document).on("click", "#edit_accountant", function(event) {
            $(".accountant-edit-modal").modal("show");
            $("#accountant_form")[0].reset();
            $("#accountantmodalBtn").attr("disabled", false);
            $('#btype_form input[name="operation"]').val("Add");
            $("#btmodalTitle").html("Add Accountant");

            var accountantId = $(this).attr("accountantid");
            var merchantId = $(this).attr("merchantid");

            // Set the select element to the correct accountant ID
            $("select[name='accountant_id']").val(accountantId);
            $("input[name='merchantId']").val(merchantId);
        });

        $(document).ready(function() {
            $('#editassignAccountantBtn').click(function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Get the form data
                var formData = $('#edit_accountant_form').serialize();

                // Make the AJAX call
                $.ajax({
                    url: "{{ route('editmerchantaccountant') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Handle the success response here
                        $('.accountant-edit-modal').modal('hide');
                        table.ajax.reload(); // Now table variable is accessible here
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response here
                        console.log(xhr.responseText);
                        $('#showerror').text('An error occurred. Please try again.');
                    }
                });
            });
        });


        $(document).ready(function() {
            // Trigger modal on button click
            $('#assignAccountantBtn').click(function() {
                $(".accountant-add-modal").modal("show");
                // Reset form inputs if needed
                $("#accountant_form")[0].reset();
                // Set modal title
                $("#btmodalTitle").html("Assign Accountant");
            });

            // Handle form submission
            $('#assignSubmitAccountantBtn').click(function(event) {
                event.preventDefault(); // Prevent the form from submitting normally
                // Get the form data
                var formData = $('#accountant_form').serialize();

                // Make the AJAX call
                $.ajax({
                    url: "{{ route('addmerchantaccountant') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Handle the success response here

                        updateMerchantForAccountants();
                        $('.accountant-add-modal').modal('hide');
                        table.ajax.reload(); // Reload the table to reflect changes
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response here
                        $('#showerror').text('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
@endsection
