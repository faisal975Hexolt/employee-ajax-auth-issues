@extends('layouts.employeecontent')
@section('employeecontent')
    {{-- <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet"> --}}
    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        <li class="{{ session('page-active') ? '' : 'active' }}"><a data-toggle="tab" class="show-pointer"
                                data-target="#mydetails">Api Setting</a></li>
                        <li class="{{ session('page-active') ? 'active' : '' }}"><a data-toggle="tab" class="show-pointer"
                                data-target="#template-activities">Template
                                Management</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="mydetails" class="tab-pane fade {{ session('page-active') ? '' : 'in active' }}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                        data-toggle="modal" data-target="#exampleModal">
                                        Add Api Setting
                                    </button>
                                </div>
                            </div>
                            <!-- Modal -->
                            @include('employee.sms.models.sms-models')

                            <div class="row">
                                <div class="col-sm-12">
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div>
                                                <div class="alert alert-danger">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-hidden="true">&times;</button>
                                                    <strong>Error!</strong>{{ $error }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if (session('message'))
                                        <div>
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-hidden="true">&times;</button>
                                                <strong>Success!</strong> {{ session('message') }}
                                            </div>
                                        </div>
                                    @endif
                                    <table class="table table-striped table-bordered text-nowrap " id="sms-api-table"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Provider Name</th>
                                                <th>Sms Username</th>
                                                <th>SMS Id</th>
                                                <th>Api Key</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($sms_data as $item)
                                                <tr>
                                                    <td>{{ $i }}</td> <?php $i++; ?>
                                                    <td>{{ $item->provider_name }}</td>
                                                    <td>{{ $item->sms_username }}</td>
                                                    <td>{{ $item->sms_sid }}</td>
                                                    <td>{{ $item->api_key }}</td>
                                                    <td>
                                                        <center> <input type="checkbox" class="status-toggle-api"
                                                                data-id="{{ $item->id }}"
                                                                {{ $item->status ? 'checked' : '' }} data-toggle="toggle"
                                                                data-on="Active" data-off="Inactive"> </center>
                                                    </td>
                                                    <td style="display: flex">
                                                        <div
                                                            style="display:flex; justify-content:center; align-items:center;">
                                                            <button
                                                                class="edit-btn btn btn-sm btn-clean btn-icon btn-outline-primary"
                                                                data-id="{{ $item->id }}"
                                                                data-sms-id="{{ $item->sms_sid }}"
                                                                data-provider_name="{{ $item->provider_name }}"
                                                                data-sms_username="{{ $item->sms_username }}"
                                                                data-api_key="{{ $item->api_key }}"
                                                                data-sms-password="{{ $item->sms_password }}"
                                                                data-otp-username="{{ $item->otp_username }}"
                                                                data-status="{{ $item->status }}" data-toggle="modal"
                                                                data-target="#editModal">
                                                                <i class="fa fa-edit"></i>&nbsp;Edit
                                                            </button>
                                                        </div>
                                                        <button
                                                            class="delete-btn btn btn-sm btn-clean btn-icon btn-outline-danger"
                                                            value="{{ $item->id }}">
                                                            <i class="fa fa-trash"></i>&nbsp;Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="template-activities" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                        data-toggle="modal" data-target="#templateModal">
                                        Add Template Setting
                                    </button>
                                </div>
                            </div>
                            @include('employee.sms.models.template-model')

                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_sms_template">
                                        <table class="table table-striped table-bordered text-nowrap " id="sms-api-table"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Identifier</th>
                                                    <th>Sms Body</th>
                                                    <th>Template Id</th>
                                                    <th>Status</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @php
                                                    use Illuminate\Support\Str;
                                                @endphp

                                                @foreach ($sms_template as $template)
                                                    <tr>
                                                        <td>{{ $i }}</td> <?php $i++; ?>
                                                        <td>{{ $template->identifier }}</td>
                                                        <td>{{ Str::limit($template->sms_body, 50) }}</td>

                                                        <td>{{ $template->template_id }}</td>

                                                        <td>
                                                            <center><input type="checkbox" class="status-toggle-temp"
                                                                    data-id="{{ $template->id }}"
                                                                    {{ $template->status ? 'checked' : '' }}
                                                                    data-toggle="toggle" data-on="Active"
                                                                    data-off="Inactive" data-width="100" data-height="35">
                                                            </center>
                                                        </td>
                                                        <td style="display: flex">
                                                            <div
                                                                style="display:flex; justify-content:center; align-items:center;">

                                                                <button
                                                                    class="template-edit-btn btn btn-sm btn-clean btn-icon btn-outline-primary"
                                                                    value="{{ $template->id }}"
                                                                    data-temp-id="{{ $template->id }}"
                                                                    data-identifier="{{ $template->identifier }}"
                                                                    data-sms_body="{{ $template->sms_body }}"
                                                                    data-template_id="{{ $template->template_id }}"
                                                                    data-temp-status="{{ $template->status }}"
                                                                    data-toggle="modal" data-target="#editTemplateModal">
                                                                    <i class="fa fa-edit"></i>&nbsp;Edit
                                                                </button>
                                                            </div>
                                                            <div
                                                                style="display:flex; justify-content:center; align-items:center;">
                                                                <button
                                                                    class="delete-btn-temp btn btn-sm btn-clean btn-icon btn-outline-secondary"
                                                                    value="{{ $template->id }}"><i
                                                                        class="fa fa-trash"></i>&nbsp;Delete</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
    {{-- <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // Function to initialize Bootstrap Toggle
            function initializeBootstrapToggle() {
                $('.status-toggle-api').bootstrapToggle({
                    // Customize options if needed
                });
            }

            // Function to handle toggle change event
            function handleToggleChange() {
                $('.status-toggle-api').change(function() {
                    var $this = $(this);
                    var id = $this.data('id');
                    var status = $this.prop('checked') ? 1 : 0;

                    // AJAX request to update status on toggle change
                    $.ajax({
                        url: 'update-status',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update the toggle state based on response
                                if (response.status) {
                                    // Turn off all other toggles except the current one
                                    $('.status-toggle-api').each(function() {
                                        if ($(this).data('id') !== id) {
                                            $(this).bootstrapToggle('off');
                                        }
                                    });
                                }
                            } else {
                                // If there's an error, revert the toggle
                                $this.bootstrapToggle(status ? 'off' : 'on');
                                alert('Failed to update status.');
                            }
                        },
                        error: function() {
                            // If AJAX request fails, revert the toggle
                            $this.bootstrapToggle(status ? 'off' : 'on');
                            alert('Error in AJAX request.');
                        }
                    });
                });

                $('.status-toggle-temp').change(function() {
                    var $this = $(this);
                    var id = $this.data('id');
                    var status = $this.prop('checked') ? 1 : 0;

                    // AJAX request to update status on toggle change
                    $.ajax({
                        url: '{{ route('update.temp') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update the toggle state based on response
                                if (response.status) {
                                    if (response.status) {
                                        $this.bootstrapToggle('on');
                                    } else {
                                        $this.bootstrapToggle('off');
                                    }
                                }
                            } else {
                                // If there's an error, revert the toggle
                                $this.bootstrapToggle(status ? 'off' : 'on');
                                alert('Failed to update status.');
                            }
                        },
                        error: function() {
                            // If AJAX request fails, revert the toggle
                            $this.bootstrapToggle(status ? 'off' : 'on');
                            alert('Error in AJAX request.');
                        }
                    });
                });
            }

            // Initialize Bootstrap Toggle and handle toggle change on page load
            initializeBootstrapToggle();
            handleToggleChange();
        });
    </script>
@endsection
