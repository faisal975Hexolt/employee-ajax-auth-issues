@extends('layouts.employeecontent')

@section('employeecontent')
    @php
        $merchant_id = request()->route('id');
    @endphp
    <div class="row">

        <div class="col-sm-12 padding-20">

            <div class="panel panel-default">

                <div class="col-sm-12">

                    <a onclick="history.back()" href="#" class="btn btn-primary btn-sm pull-right">Go
                        Back</a>

                    <input type="hidden" name="merchantId" value=" {{ request()->route('id') }}">

                </div>

                <div class="panel-heading">
                    {{-- <span class="pull-right">On Boarding Status:{{ $user->OnboardingStatus->name }}</span> --}}
                    <br>
                    <ul class="nav nav-tabs" id="transaction-tabs">

                        <li class="active"><a data-toggle="tab" class="show-pointer"
                                data-target="#agreement_process">Agreement
                                Process</a>
                        </li>

                        <li><a data-toggle="tab" class="show-pointer" data-target="#webhook">Webhook</a>
                        </li>

                        <li><a data-toggle="tab" class="show-pointer" data-target="#apikeys">Api Keys</a>
                        </li>

                        <li><a data-toggle="tab" class="show-pointer" data-target="#ip_whitelisting">Ip Whitelisting</a>
                        </li>

                        <li><a data-toggle="tab" class="show-pointer" data-target="#usage">Usage</a>
                        </li>


                        <li><a data-toggle="tab" class="show-pointer" data-target="#vendor_config">Vendor Configuration</a>
                        </li>


                    </ul>


                </div>

                <div class="panel-body">
                    <div class="tab-content">
                        <div id="agreement_process" class="tab-pane fade in active">
                            <div class="row">
                                Aggreement Process


                            </div>

                            <div class="row padding-10">


                            </div>

                        </div>


                        <div id="webhook" class="tab-pane fade in ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                        id="add_webhook">Add
                                        /Update Webhook </a>
                                </div>
                            </div>
                            <table id="webhook_table" class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <th>#</th>
                                    <th>Webhook</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            <div class="row padding-10">


                            </div>

                        </div>


                        <div id="apikeys" class="tab-pane fade in ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="tab-button">
                                        <div class="btn
                                        btn-primary pull-right btn-sm margin-bottom-lg generatenewapibutton regenerateApiadmin"
                                            mid="{{ $merchant_id }}">Generate</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table id="payout_api_keys" class="table table-bordered" style="width: 100%;">
                                    <thead>
                                        <th>Api Key</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                        <th>View</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="ip_whitelisting" class="tab-pane fade in ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                        id="add_ip">Add
                                        /Update Ip </a>
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

                        <div id="usage" class="tab-pane fade in ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button
                                        class="btn btn-primary pull-right btn-sm margin-bottom-lg addUsageModal">Add</button>
                                </div>

                                <table id="usage_table" class="table table-bordered" style="width: 100%;">
                                    <thead>
                                        <th>Minimum Ticket Size</th>
                                        <th>Maximum Ticket Size</th>
                                        <th>Daily Ticket Size</th>
                                        <th>Created At</th>
                                        <th>Created At</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>




                        </div>

                        <div id="vendor_config" class="tab-pane fade in ">

                            @include('employee.payout.vendorconfig')
                        </div>


                    </div>


                </div>
            </div>

        </div>


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
                        <form id="ip_form" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="merchantId" value="<?= $merchant_id ?>">
                            <div class="form-group">
                                <label for="merchant">IP:</label>
                                <input type="text" class="text" name="ip">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade webhook-add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close btclose_btn" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="btmodalTitle">Add /Update Webhook</h4>
                    </div>
                    <div class="modal-body">
                        <form id="webhook_form" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="merchantId" value="<?= $merchant_id ?>">
                            <div class="form-group">
                                <label for="merchant">Webhook:</label>
                                <input type="text" class="text" name="webhook">
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="">
                                        <label for="merchant">Active:</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="">
                                        <input type="checkbox" value="1" name="is_active">
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- api-modal --}}
        <div id="update-api-modal-admin" class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Generated Payout Api</h4>
                    </div>
                    <form class="form-horizontal" id="update-api-form">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="apikeyid" class="control-label col-sm-2"> API Key:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="api_key" id="api_key"
                                        value="" readonly>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="apikeyid" class="control-label col-sm-2">Salt Key:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="salt" id="salt"
                                        value="" readonly>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- editusagemodal --}}
        <div class="modal " id="merchant-usage-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            onclick="closeModal()">×</button>
                        <h4 class="modal-title usageTitle">Update Merchant Payout Usage Setting</h4>
                    </div>
                    <div id="merchant-usage-add-succsess-response" class="text-center text-success"></div>
                    <div id="merchant-usage-add-fail-response" class="text-center text-danger"></div>
                    <form class="form-horizontal" id="merchant-payout-usage-form">
                        <div class="modal-body" id="usgaeModalBoday">

                            <div class="form-group form-fit">
                                <label for="minimum_ticket_size" class="col-sm-3 control-label">Minimum Ticket Size:<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="minimum_ticket_size" id="minimum_ticket_size"
                                        class="form-control" value="" placeholder="Minimum Ticket Size">
                                    <div id="minimum_ticket_size_error" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group form-fit">
                                <label for="maximum_ticket_size" class="col-sm-3 control-label">Maximum Ticket Size:<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="maximum_ticket_size" id="maximum_ticket_size"
                                        class="form-control" value="" placeholder="Maximum Ticket Size">
                                    <div id="maximum_ticket_size_error" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group form-fit">
                                <label for="daily_total_limit" class="col-sm-3 control-label">Daily Total Limit:<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="daily_total_limit" id="daily_total_limit"
                                        class="form-control" value="" placeholder="Daily Total Limit">
                                    <div id="daily_total_limit_error" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="usageid" id="usageid" value="">
                        <input type="hidden" name="mid" id="mid" value="">
                        <div class="modal-footer">
                            <div class="">
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- addusagemodal --}}
        <div class="modal " id="add-merchant-usage-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            onclick="closeModal()">×</button>
                        <h4 class="modal-title usageTitle">Add Merchant Payout Usage Setting</h4>
                    </div>
                    <div id="merchant-usage-add-succsess-response" class="text-center text-success"></div>
                    <div id="merchant-usage-add-fail-response" class="text-center text-danger"></div>
                    <form class="form-horizontal" id="add-merchant-payout-usage-form">
                        {{ csrf_field() }}
                        <div class="modal-body" id="usgaeModalBoday">
                            <div class="form-group form-fit">
                                <label for="minimum_ticket_size" class="col-sm-3 control-label">Minimum Ticket Size:<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="minimum_ticket_size" id="minimum_ticket_size"
                                        class="form-control" value="" placeholder="Minimum Ticket Size">
                                    <div id="minimum_ticket_size_error" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group form-fit">
                                <label for="maximum_ticket_size" class="col-sm-3 control-label">Maximum Ticket Size:<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="maximum_ticket_size" id="maximum_ticket_size"
                                        class="form-control" value="" placeholder="Maximum Ticket Size">
                                    <div id="maximum_ticket_size_error" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="form-group form-fit">
                                <label for="daily_total_limit" class="col-sm-3 control-label">Daily Total Limit:<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="daily_total_limit" id="daily_total_limit"
                                        class="form-control" value="" placeholder="Daily Total Limit">
                                    <div id="daily_total_limit_error" class="text-danger"></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="mid" id="mid" value="{{ $merchant_id }}">

                        <div class="modal-footer">
                            <div class="">
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
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
    $(document).ready(function() {
        var ipWhitelistTable = $('#ip_whitelist').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "{{ route('getPayoutIpWhitelisted') }}",
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
                url: "{{ route('storePayoutIpWhitelisted') }}",
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

        //webhook

        var webhookTable = $('#webhook_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "{{ route('show_merchant_payout_webhook') }}",
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
                    "data": "webhook_url"
                },
                {
                    "data": "is_active",
                    "render": function(data, type, row) {
                        return row.is_active ? 'Active' : "In Active";
                        l
                    }
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




        $(document).on("click", "#add_webhook", function(event) {
            $(".webhook-add-modal").modal("show");
        });

        $('#webhook_form').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('add_merchant_payout_webhook') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $(".webhook-add-modal").modal("hide");
                        webhookTable.ajax
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



        //apikeys
        var apiTable = $('#payout_api_keys').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "{{ route('getpayoutapitable') }}",
                "type": "GET",
                "data": function(d) {
                    d.mid = <?= $merchant_id ?>;
                }
            },
            "columns": [{
                    "data": "api_key"
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
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button class="btn btn-primary btn-sm regenerateApiadmin" rowid="' +
                            row.id + '" mid="' + row.created_merchant + '">Regenerate</button>';
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button class="btn btn-primary btn-sm viewpayinApiadmin" rowid="' +
                            row.id + '" mid="' + row.created_merchant + '">View</button>';
                    }
                }


            ],
            "drawCallback": function(settings) {
                var api = this.api();
                var data = api.rows().data();
                if (data.length > 0) {
                    $('.generatenewapibutton').hide();
                } else {
                    $('.generatenewapibutton').show();
                }
            }
        });


        //get Api Details javascript functionality code starts here
        $(document).on('click', '.viewpayinApiadmin', function(e) {
            if (api_id != "") {
                var mid = $(this).attr('mid');
                var api_id = $(this).attr('rowid');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('getpayoutapimodal') }}",
                    type: "POST",
                    data: {
                        mid: mid,
                        api_id: api_id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.length > 0) {
                            $.each(response[response.length - 1], function(key, value) {
                                $("#update-api-modal-admin input[name=" + key + "]")
                                    .val(value);
                            });
                        }
                    },
                    complete: function() {
                        $("#update-api-modal-admin").modal({
                            show: true,
                            backdrop: 'static',
                            keyboard: false
                        });
                    }
                })
            }
        });
        //get Api Details javascript functionality code ends here



        //Edit Api javascript functionality code starts here
        $(document).on('click', '.regenerateApiadmin', function(e) {
            var mid = $(this).attr('mid');
            var api_id = $(this).attr('rowid');

            if (api_id != "") {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('getPayoutRegenerateapimodal') }}",
                    type: "POST",
                    data: {
                        mid: mid,
                        api_id: api_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.length > 0) {

                            $.each(response[response.length - 1], function(key, value) {
                                $("#update-api-modal-admin input[name=" + key + "]")
                                    .val(value);
                            });
                        }
                    },
                    complete: function() {
                        apiTable.ajax
                            .reload();
                        $("#update-api-modal-admin").modal({
                            show: true,
                            backdrop: 'static',
                            keyboard: false
                        });
                    }
                })
            }
        });
        //Edit Api javascript functionality code ends here



        //usage
        var usageTable = $('#usage_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "{{ route('show_merchant_usage_limit') }}",
                "type": "GET",
                "data": function(d) {
                    d.mid = <?= $merchant_id ?>;
                }
            },
            "columns": [{
                    "data": "minimum_ticket_size"
                },
                {
                    "data": "maximum_ticket_size"
                },
                {
                    "data": "daily_total_limit"
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
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button class="btn btn-primary btn-sm editUsageModal" ' +
                            'rowid="' + row.id + '" ' +
                            'mid="' + row.created_merchant + '" ' +
                            'minimum_ticket_size="' + row.minimum_ticket_size + '" ' +
                            'maximum_ticket_size="' + row.maximum_ticket_size + '" ' +
                            'daily_total_limit="' + row.daily_total_limit + '">Edit</button>';
                    }
                }


            ],
            "drawCallback": function(settings) {
                var api = this.api();
                var data = api.rows().data();
                if (data.length > 0) {
                    $('.addUsageModal').hide();
                } else {
                    $('.addUsageModal').show();
                }
            }
        });

        //edit usage stasrt
        $(document).on("click", ".editUsageModal", function(event) {

            // Get the attributes from the clicked button
            var rowid = $(this).attr('rowid');
            var mid = $(this).attr('mid');
            var minimum_ticket_size = $(this).attr('minimum_ticket_size');
            var maximum_ticket_size = $(this).attr('maximum_ticket_size');
            var daily_total_limit = $(this).attr('daily_total_limit');

            console.log(rowid, mid, minimum_ticket_size, daily_total_limit, maximum_ticket_size);


            $('#daily_total_limit').val(daily_total_limit);
            $('#maximum_ticket_size').val(maximum_ticket_size);
            $('#minimum_ticket_size').val(minimum_ticket_size);
            $('#usageid').val(rowid);
            $('#mid').val(mid);


            $("#merchant-usage-modal").modal("show");
        });

        //add usage start 
        $(document).on("click", ".addUsageModal", function(event) {
            $("#add-merchant-usage-modal").modal("show");
        });

        $('#add-merchant-payout-usage-form').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var $submitButton = $(this).find('input[type="submit"]');
            $submitButton.prop('disabled', true); // Disable the button


            $.ajax({
                url: '{{ route('add_merchant_usage_limit') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                    } else {

                    }
                    usageTable.ajax.reload();
                    $("#add-merchant-usage-modal").modal("hide");
                    $submitButton.prop('disabled', false); // Enable the button
                },
                error: function() {
                    $submitButton.prop('disabled',
                        false); // Enable the button in case of error
                }
            });
        });
    });
</script>
