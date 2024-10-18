@extends('layouts.employeecontent')
@section('employeecontent')

    <head>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>



        <!-- CSS -->


        <!-- JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    </head>
    <div class="row">
        <div class="col-sm-12 padding-20">

            <div class="tab-pane fade in ">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                            id="add_reseller">Add Reseller </a>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div style="margin-top:30px; margin-bottom:100px; ">
                            <table class="table table-striped table-bordered text-nowrap " id="vendor-table"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
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
    </div>

    <div id="add_reseller_modal" class="modal " role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Webhooks Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title ">Add Reseller</h4>
                </div>
                <div id="ajax-webhook-response" class="text-center"></div>
                <form class="form-horizontal" id="reseller-form" action="{{ route('addReseller') }}" method="POST">
                    @csrf <!-- Add CSRF token for security -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-4">User Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="username" id="username"
                                    value="{{ old('username') }}">
                                <span class="text-danger" role="alert" id="username-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="control-label col-sm-4">First Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    value="{{ old('first_name') }}">
                                <span class="text-danger" role="alert" id="first_name-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="control-label col-sm-4">Last Name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    value="{{ old('last_name') }}">
                                <span class="text-danger" role="alert" id="last_name-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-sm-4">Email:</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email') }}">
                                <span class="text-danger" role="alert" id="email-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="control-label col-sm-4">Mobile:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="mobile" id="mobile"
                                    value="{{ old('mobile') }}">
                                <span class="text-danger" role="alert" id="mobile-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label col-sm-4">Password:</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password" id="password">
                                <span class="text-danger" role="alert" id="password-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6 text-center">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="alert alert-success text-center" id="successMsg" style="display: none;"></div>

            </div>

        </div>
    </div>

    <div id="assign_merchant_modal" class="modal " role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Webhooks Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title ">Link Merchant</h4>
                </div>
                <div id="ajax-webhook-response" class="text-center"></div>
                <form class="form-horizontal" id="assign-merchant-form" action="{{ route('assignMerchant') }}"
                    method="POST">
                    @csrf <!-- Add CSRF token for security -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-4">Merchants:</label>
                            <div class="col-sm-6">
                                <input type="hidden" id="reseller_id" name="reseller_id">
                                <select multiple="multiple" class="form-control" name="merchant_id">


                                </select>
                                <span class="text-danger" role="alert" id="username-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6 text-center">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-sm-12">
                        <div style="margin-top:30px; margin-bottom:100px; ">

                            <div id="merchants-table-container">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success text-center" id="successMsg" style="display: none;"></div>

            </div>

        </div>
    </div>










    <script>
        var table;

        function resellerTable() {

            table = $('#vendor-table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false, // Disable the search functionality
                "ajax": "{{ route('resellerList') }}",
                "columns": [{
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "username"
                    },
                    {
                        "data": "first_name"
                    },
                    {
                        "data": "last_name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "mobile_no"
                    },
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            console.log(row, data);
                            var statusText = row.status == 1 ? 'Active' : 'Inactive';
                            var buttonClass = row.status == 1 ? 'btn-success' : 'btn-danger';
                            var oppositeStatus = row.status == 1 ? 0 : 1;

                            return `<button class="btn btn-sm ${buttonClass} btn-toggle-status" data-id="${row.id}" data-status="${oppositeStatus}">${statusText}</button>`;
                        }
                    }, {
                        "data": "recon",
                        "render": function(data, type, row) {
                            var allotButton =
                                '<button id="allotMerchant" class="btn btn-sm btn-primary btn-allot" data-id="' +
                                row.id + '">Link Merchant</button>';
                            var detailsUrl = "{{ route('resellerDetails', ['id' => ':id']) }}";
                            detailsUrl = detailsUrl.replace(':id', row.id);
                            var detailsButton = '<a href="' + detailsUrl +
                                '" class="btn btn-sm btn-info">View Details</a>';

                                var docButtonUrl =  "{{ route('resellerDocuments', ['id' => ':id']) }}";
                                docButtonUrl = docButtonUrl.replace(':id', row.id);
                                var docButton = '<a href="' + docButtonUrl +
                                '" class="btn btn-sm btn-dark mx-4">Docs</a>';
                            return allotButton + ' ' + detailsButton + ' ' + docButton;
                        }
                    }
                ]

            });
        }
        $(document).ready(function() {




            resellerTable();

            // Use event delegation to handle button clicks
            $('#vendor-table tbody').on('click', '.btn-allot', function() {
                var row = table.row($(this).parents('tr')).data();
                var id = row.id;
                $("#assign_merchant_modal").modal("show");
                $("#reseller_id").val(id);

                // AJAX request to fetch merchant list
                $.ajax({
                    url: '{{ route('getMerchantsWithoutResellers') }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var $select = $('select[name="merchant_id"]');
                        $select.empty();



                        // Populate the select box with new options
                        $.each(data.data, function(index, item) {
                            $select.append($('<option>', {
                                value: item.id,
                                text: item.merchant_gid + ' -- ' + item.name
                            }));
                        });

                        $select.select2();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching merchants list:', error);
                    }
                });

                // Get form data
                var formData = formData || {};
                formData.reseller_id = id;


                $.ajax({
                    url: '{{ route('getMerchantsByResellerId') }}',
                    method: 'GET',
                    dataType: 'json',
                    data: formData,
                    success: function(data) {
                        console.log(data);
                        generateTable(data.data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching merchants list:', error);
                    }
                });

                function generateTable(data) {
                    if (!Array.isArray(data)) {
                        console.error('Invalid data format');
                        return;
                    }

                    var table =
                        '<table class="table table-striped table-bordered text-nowrap " border="1">';
                    table +=
                        '<thead><tr><th>Merchant GID</th><th>Name</th><th>Email</th><th>Mobile No</th><th>Action</th></tr></thead>';
                    table += '<tbody>';

                    data.forEach(function(merchant) {
                        table += '<tr>';
                        table += '<td>' + merchant.merchant_gid + '</td>';
                        table += '<td>' + merchant.name + '</td>';
                        table += '<td>' + merchant.email + '</td>';
                        table += '<td>' + merchant.mobile_no + '</td>';
                        table += '<td>' +
                            '<button class="btn btn-sm btn-primary btn-unlink" data-id="' + merchant
                            .id +
                            '" id="unlink">X</button>  ' + '</td>';
                        table += '</tr>';
                    });

                    table += '</tbody></table>';

                    $('#merchants-table-container').html(table);

                    $('.btn-unlink').on('click', function() {
                        var merchantGID = $(this).data('id');
                        console.log('Unlink button clicked for Merchant ID:', merchantGID);
                        // Perform your unlink action here

                        $.ajax({
                            url: '{{ route('unlinkMerchant') }}',
                            method: 'GET',
                            data: {
                                merchant_id: merchantGID
                            },
                            success: function(response) {
                                console.log('Merchant unlinked successfully:',
                                    response);

                                $("#assign_merchant_modal").modal("hide");
                                swalnot('Success', 'Successfully Unlinked Merchant');
                                // Optionally refresh the table or perform other actions here
                            },
                            error: function(xhr, status, error) {
                                console.error('Error unlinking merchant:', error);
                            }
                        });


                    });
                }
            });

            //change status
            $('#vendor-table').on('click', '.btn-toggle-status', function() {
                var resellerId = $(this).data('id');
                var newStatus = $(this).data('status');

                // AJAX call to update reseller status
                $.ajax({
                    url: "{{ route('changeResellerStatus') }}",
                    type: "GET",
                    data: {
                        reseller_id: resellerId,
                        status: newStatus
                    },
                    success: function(response) {
                        // Update DataTable or handle success action
                        $('#vendor-table').DataTable().destroy();
                        resellerTable();

                    },
                    error: function(xhr, status, error) {
                        // Handle error if needed
                        console.error(xhr.responseText);
                    }
                });
            });


            // submit add a new reseller . 
            $(document).ready(function() {
                $('#reseller-form').on('submit', function(e) {
                    e.preventDefault();

                    // Clear previous error messages
                    $('.text-danger').text('');

                    // Get form data
                    var formData = $(this).serialize();

                    // Submit form data via AJAX
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                $('#successMsg').show().text(data.message);
                                $("#add_reseller_modal").modal("hide");
                                $('#vendor-table').DataTable().destroy();
                                resellerTable();
                            } else {
                                var errors = data.errors;
                                // Loop through the errors object and display the errors
                                $.each(errors, function(key, value) {
                                    $('#' + key + '-error').text(value[0]);
                                });

                            }
                        },
                        error: function(xhr) {
                            console.log(xhr)

                        }
                    });
                });
            });


            // submit assigning merchant to reseller 
            $(document).ready(function() {
                $('#assign-merchant-form').on('submit', function(e) {
                    e.preventDefault();

                    // Clear previous error messages
                    $('.text-danger').text('');

                    // Get form data
                    var formData = $(this).serialize();

                    // Parse the serialized string into an object
                    var parsedData = {};
                    formData.split('&').forEach(function(keyValue) {
                        var pair = keyValue.split('=');
                        var key = decodeURIComponent(pair[0]);
                        var value = decodeURIComponent(pair[1]);

                        // Check if key already exists in the parsedData object
                        if (parsedData[key]) {
                            // If key already exists and is an array, push the new value
                            if (Array.isArray(parsedData[key])) {
                                parsedData[key].push(value);
                            } else {
                                // If key already exists but is not an array, convert it to an array
                                parsedData[key] = [parsedData[key], value];
                            }
                        } else {
                            // If key does not exist in parsedData, set it as a single value
                            parsedData[key] = value;
                        }
                    });


                    // Submit form data via AJAX
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: parsedData,
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                $("#assign_merchant_modal").modal("hide");

                                console.log(data)
                                swalnot('Success', 'Successfully Assigned');
                            } else {
                                swalnot('Failed', 'Not Assigned, Try Again');
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr)

                        }
                    });
                });
            });
        });

        $(document).on("click", "#add_reseller", function(event) {
            $("#add_reseller_modal").modal("show");
            $("#reseller-form")[0].reset();
        });
    </script>
@endsection
