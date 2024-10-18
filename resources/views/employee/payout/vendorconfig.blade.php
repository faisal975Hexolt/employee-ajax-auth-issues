@php
    $merchant_id = request()->route('id');

    $s2paymidkeys = DB::table('s2pay_payout_midkeys')->where('merchant_id', $merchant_id)->get();

@endphp

<div class="row">
    <div class="col-sm-12">
        <h3>Vendor Configuration</h3>
        <!-- Add your vendor configuration content here -->

        <div class="row">
            <div class="col-sm-12">
                <select id="showvendor" class="">
                    <option value="">--Select--</option>
                    @foreach (\DB::table('payout_vendor_bank')->where('acquirer_status', 1)->get() as $index => $vendor)
                        <option value="{{ $vendor->bank_name }}">{{ $vendor->bank_name }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary pull-right btn-sm margin-bottom-lg" id="add-vendor-button">Add Vendor
                    Api Keys</button>
            </div>
        </div>
    </div>
</div>


<div id="s2paytable" class="vendor-table" style="display:none;">
    <div class="table-responsive">
        <table class="table table-striped table-bordered text-nowrap">
            <h4>S2 Pay</h4>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Api Key</th>
                    <th>Salt</th>
                    <th>Created</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($s2paymidkeys as $index => $s2payKeys)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s2payKeys->api_key }}</td>
                        <td>{{ $s2payKeys->salt }}</td>
                        <td>{{ Carbon\Carbon::parse($s2payKeys->created_date)->format('d-M, Y h:i:s A') }}
                        </td>
                        <td><button class="btn btn-danger" id="deleteButton" data-toggle="modal"
                                rowid="{{ $s2payKeys->id }}" vendor="S2PAY">Delete</button></td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div id="shownotice" style="display:none;">
    <h5>Vendor Not Configured . </h3>
</div>


{{-- add vendor config modal --}}
<div class="modal " id="add-vendor-config-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                    onclick="closeModal()">×</button>
                <h4 class="modal-title usageTitle">Add</h4>
            </div>
            <div id="merchant-usage-add-succsess-response" class="text-center text-success"></div>
            <div id="merchant-usage-add-fail-response" class="text-center text-danger"></div>
            <form class="form-horizontal" action="{{ route('add_merchant_payout_vendor_mid_keys') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body" id="usgaeModalBoday">

                    <!-- //s2payform -->
                    <div id="s2payform" style="display:none;">
                        <div class="form-group">
                            <label for="input" class="col-sm-3 control-label">Api Key:</label>
                            <div class="col-sm-8">
                                <input type="text" name="s2pay_api_key" id="s2pay_api_key" class="form-control"
                                    value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input" class="col-sm-3 control-label">Salt:</label>
                            <div class="col-sm-8">
                                <input type="text" name="s2pay_salt" id="s2pay_salt" class="form-control"
                                    value="">
                            </div>
                        </div>
                        <input type="hidden" name="vendor" value="S2PAY">
                    </div>
                    <!-- //s2pay -->
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

<!-- deleteModal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" style="margin-top:150px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Are you
                    sure ?</h4>

            </div>

            <div class="modal-footer">
                <form action="{{ route('delete_merchant_payout_vendor_mid_keys') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $merchant_id }}" name="mid">
                    <input type="hidden" id="getId" name="id">
                    <input type="hidden" id="deletevendor" name="vendor">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- enddeleteModal -->





<script>
    // Wait for the document to be ready
    $(document).ready(function() {
        // Cache selectors for better performance
        var tables = $('.vendor-table'); // Assuming all tables have a common class 'vendor-table'

        // Event listener for dropdown change
        $('#showvendor').on('change', function() {
            var vendorId = $(this).val();

            // Show the table corresponding to the selected vendorId
            switch (vendorId) {

                case 'S2PAY':
                    var tableRows = $('#s2paytable tbody tr').length;
                    $('#s2paytable').show();
                    if (tableRows === 0) {
                        $('#s2payform').show();
                    }
                    $('#shownotice').hide();
                    break;

                default:
                    $('#shownotice').show();
                    $('#s2payform').hide();
                    $('#s2paytable').hide();
            }
        });
    });
</script>

<script>
    $(document).on("click", "#deleteButton", function(event) {

        var rowid = $(this).attr('rowid');
        var vendor = $(this).attr('vendor');

        console.log(rowid, vendor);

        $('#getId').val(rowid);
        $('#deletevendor').val(vendor);
        $("#deleteModal").modal("show");
    });
</script>

<script>
    $(document).on("click", "#add-vendor-button", function(event) {

        $("#add-vendor-config-modal").modal("show");
    });
</script>
