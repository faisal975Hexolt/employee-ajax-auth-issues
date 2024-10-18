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
                                                        id="add_settelment_cron">Add Settelment Cron Settings</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form id="manage-CronSetting-form">
                                                    @csrf
                                                    <div class="row" style="margin-top:15px;">
                                                        <div class="col-sm-12 mb-5">
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" name="searchfor" id="searchCronSetting"
                                                                        class="searchforCronSettingt form-control "
                                                                        placeholder="Search Anything here">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-secondary"><i
                                                                                class="glyphicon glyphicon-search"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">


                                                                <select id="liststatusCronSetting" name="status_filter"
                                                                    class="form-control searchFilterBSubCat">
                                                                    <option value="">All</option>

                                                                    <option value="active">Active</option>
                                                                    <option value="inactive">InActive </option>

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
                                                                id="merchant-CronSetting-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Cron Fire At</th>
                                                                        <th>Transaction Start From</th>
                                                                        <th>Transaction Start Day</th>
                                                                        <th>Transaction End At</th>
                                                                        <th>Transaction End Day</th>

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

                                    @case('1')
                                        <div id="{{ str_replace(' ', '-', strtolower($value->link_name)) }}" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary pull-right btn-sm margin-bottom-lg"
                                                        id="add_gst_cron">Add GST Cron Settings</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <form id="manage-gstCronSetting-form">
                                                    @csrf
                                                    <div class="row" style="margin-top:15px;">
                                                        <div class="col-sm-12 mb-5">
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" name="searchfor" id="searchGstCronSetting"
                                                                        class="searchforGCronSettingt form-control "
                                                                        placeholder="Search Anything here">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-secondary"><i
                                                                                class="glyphicon glyphicon-search"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">


                                                                <select id="liststatusGstCronSetting" name="status_filter"
                                                                    class="form-control searchFilterGstCat">
                                                                    <option value="">All</option>

                                                                    <option value="active">Active</option>
                                                                    <option value="inactive">InActive </option>

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
                                                                id="merchant-GstCronSetting-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Cron Fire On Day of Month</th>
                                                                        <th>Cron Fire At</th>



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
        CronSettingUrl = "{{ route('getSettelmentCronSettingList') }}";
        GstCronSettingUrl = "{{ route('getGstCronSettingList') }}";
    </script>
    @include('inc_modals._merchantsettings')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/emp_cronmaster.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // merchantCharges();
            //$('[data-toggle="merchant-charges-info"]').popover();
        });
    </script>

@endsection
