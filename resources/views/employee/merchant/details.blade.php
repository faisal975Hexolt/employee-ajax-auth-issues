@extends('layouts.employeecontent')
@section('employeecontent')
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
                                    data-target="#merchant-details">Merchant Details</a></li>
                        @endif
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        @if (count($sublinks) > 0)
                            @foreach ($sublinks as $index => $value)
                                @if ($index == 0)
                                    <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                        class="tab-pane fade in active">

                                    </div>
                                @else
                                    <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}"
                                        class="tab-pane fade">

                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div id="merchant-details" class="tab-pane fade in active">

                                <div class="col-sm-12">

                                    <button type="button" style=" margin-bottom:5px;" class="btn btn-primary"
                                        onclick="registerMerchantModal()">Add Merchant</button>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">


                                        <div class="card-body">
                                            <input type="text" name="m_name" class="form-control searchEmail"
                                                placeholder="Search for Name/email Only...">
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table table-bordered merchant_details_data_table text-nowrap"
                                                    id="merchant_details_data_table ">
                                                    <thead>
                                                        <tr>
                                                            <th>Sno</th>
                                                            <th>Merchant Id</th>
                                                            <th>Merchant Name</th>
                                                            <th>Email</th>
                                                            <th>Mobile</th>
                                                            <th>Created Date</th>
                                                            <th>Last Login</th>
                                                            <th>OnBoarding Status</th>
                                                            <th>Account Status</th>
                                                            <th>Status</th>
                                                            <th width="100px">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('inc_modals.merchantregister')
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script>
        var formatDate = function(data) {
            var date = new Date(data);
            var day = ("0" + date.getDate()).slice(-2);
            var month = ("0" + (date.getMonth() + 1)).slice(-2);
            var year = date.getFullYear();
            var hours = date.getHours();
            var minutes = ("0" + date.getMinutes()).slice(-2);
            var seconds = ("0" + date.getSeconds()).slice(-2);
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            var strTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
            return day + "-" + month + "-" + year + " " + strTime;
        };


        document.addEventListener("DOMContentLoaded", function(e) {
            e.preventDefault();
            // loadMerchantDetails();
            $(function() {


                var table = $('.merchant_details_data_table').DataTable({
                    processing: true,
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '
                    },
                    serverSide: true,
                    ajax: {
                        url: "{{ route('merchant-details') }}",
                        data: function(d) {
                            d.email = $('.searchEmail').val(),
                                d.search = $('input[type="search"]').val()
                        }

                    },
                    order: [
                        [5, 'desc']
                    ],
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100],
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'merchant_gid_link',
                            name: 'merchant_gid_link'
                        },
                        {
                            data: 'show_name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'mobile_no',
                            name: 'mobile_no',
                            orderable: false
                        },
                        {
                            data: 'created_date',
                            name: 'created_date',
                            render: function(data, type, row) {
                                return formatDate(data);
                            }
                        },
                        {
                            data: 'last_seen_at',
                            name: 'last_seen_at',
                            render: function(data, type, row) {
                                return formatDate(data);
                            },
                            orderable: false,
                        },
                        {
                            data: 'onboarding_status',
                            name: 'onboarding_status',
                            orderable: false
                        },
                        {
                            data: 'account_status',
                            name: 'account_status',
                            orderable: false
                        },
                        {
                            data: 'merchant_status',
                            name: 'merchant_status',
                            orderable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $(".searchEmail").keyup(function() {
                    table.draw();
                });

            });

        })
    </script>

    <script type="text/javascript"></script>
@endsection
