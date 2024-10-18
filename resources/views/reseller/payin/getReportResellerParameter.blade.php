@if ($table_name == 'transaction')

    <div class="col-sm-6">

        <div class="form-group">

            <label for="">Payment Mode</label>

            <select class="form-control" name="mode" id="listmode">

                <option value="">All</option>
                @foreach (\App\Classes\Helpers::payment_report_mode() as $r => $mode)
                    <option {{ request()->input('mode') == $r ? 'selected' : '' }} value="{{ $r }}">
                        {{ ucwords($mode) }}</option>
                @endforeach

            </select>

        </div>

    </div>

    <span>
        <div class="col-sm-6">
            <div class="form-group">

                <label for="">Status</label>

                <select class="form-control" name="status" id="">

                    <option value="">All</option>

                    @foreach (\App\Classes\Helpers::payment_report_status() as $r => $status)
                        <option {{ request()->input('status') == $status ? 'selected' : '' }}
                            value="{{ $status }}">{{ ucwords($status) }}
                        </option>
                    @endforeach



                </select>

            </div>

        </div>
    </span>
@elseif($table_name == 'refund')
    <div class="col-md-6 hide">

        <div class="form-group">

            <label for="">Payment Mode</label>

            <select class="form-control" name="mode" id="listmode">

                <option value="">All</option>
                @foreach (\App\Classes\Helpers::payment_report_mode() as $r => $mode)
                    <option {{ request()->input('mode') == $r ? 'selected' : '' }} value="{{ $r }}">
                        {{ ucwords($mode) }}</option>
                @endforeach

            </select>

        </div>

    </div>


    <div class="col-md-6">
        <div class="form-group">

            <label for="">Status</label>

            <select class="form-control" name="status" id="">

                <option value="">All</option>

                @foreach (\App\Classes\Helpers::refund_report_status() as $r => $status)
                    <option {{ request()->input('status') == $status ? 'selected' : '' }} value="{{ $status }}">
                        {{ frefund_status($status) }}
                    </option>
                @endforeach



            </select>

        </div>

    </div>
@elseif($table_name == 'settlement')
    <div class="col-md-6 hide">

        <div class="form-group">

            <label for="">Payment Mode</label>

            <select class="form-control" name="mode" id="listmode">

                <option value="">All</option>
                @foreach (\App\Classes\Helpers::payment_report_mode() as $r => $mode)
                    <option {{ request()->input('mode') == $r ? 'selected' : '' }} value="{{ $r }}">
                        {{ ucwords($mode) }}</option>
                @endforeach

            </select>

        </div>

    </div>


    <div class="col-md-6">
        <div class="form-group">

            <label for="">Status</label>

            <select class="form-control" name="status" id="">

                <option value="">All</option>

                @foreach (\App\Classes\Helpers::settlement_report_status() as $r => $status)
                    <option {{ request()->input('status') == $status ? 'selected' : '' }} value="{{ $status }}">
                        {{ fsettlement_status($status) }}
                    </option>
                @endforeach



            </select>

        </div>

    </div>




@endif
