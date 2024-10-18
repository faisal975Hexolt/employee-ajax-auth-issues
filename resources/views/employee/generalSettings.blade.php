@extends('layouts.employeecontent')
@section('employeecontent')

    <style>
        #specificInput {
            display: block !important;
            /* Or you can use another display value */
        }
    </style>
    <div class="row">

        <div class="col-sm-12 padding-20">
            <div class="panel panel-default ">

                <form method="POST" class="" action="{{ route('update-logo') }}" enctype="multipart/form-data">
                    <div class="">
                        <legend>Update Logo and Fav Icon</legend>
                    </div>

                    {{ csrf_field() }}

                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="form-group">
                                <label for="">Select logo</label>
                                <input type="file" class="form-file-input" id="specificInput" name="image" required>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-3 col-sm-offset-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>


                </form>

                <form method="POST" class="" action="{{ route('update-favicon') }}" enctype="multipart/form-data">
                    <div class="">
                        <legend>Update Fav Icon</legend>
                    </div>

                    {{ csrf_field() }}

                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="form-group">
                                <label for="">Select Fav Icon</label>
                                <input type="file" class="form-file-input" id="specificInput" name="image" required>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-3 col-sm-offset-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="{{ session('page-active') ? '' : 'active' }}"><a data-toggle="tab" class="show-pointer"
                            data-target="#mydetails">General Settings</a></li>

                </ul>
            </div>

            <div>




                <div class="panel-body">
                    <div class="tab-content">
                        <div id="mydetails" class="tab-pane fade {{ session('page-active') ? '' : 'in active' }}">
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
                                    <form method="POST" class="form-horizontal" action="{{ route('general-setting') }}">
                                        <div class="form-group col-sm-11 col-sm-offset-1">
                                            <legend>Update Settings</legend>
                                        </div>

                                        @foreach ($feilds as $row => $feild)
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">{{ $feild['name'] }}:
                                                    @if ($feild['is_required'])
                                                        <span class="mandatory">*</span>
                                                    @endif
                                                </label>

                                                <div class="col-sm-9">
                                                    <input type="text" name="{{ $feild['key'] }}"
                                                        id="{{ $feild['key'] }}" class="form-control"
                                                        value="{{ env($feild['key']) }}">
                                                </div>
                                            </div>
                                        @endforeach




                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
