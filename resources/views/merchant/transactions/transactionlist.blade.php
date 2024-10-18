@extends('layouts.merchantcontent')
@section('merchantcontent')
    <!--Module Banner-->
    <section id="about-1" class="about-1 ">
        <div class="container-1">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                    <div class="content-1 pt-4 pt-lg-0">
                        <h3 class="margH">Transactions Summary </h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        <?php
                        $trans = [
                            'merchant/settlements' => '<a data-toggle="tab" class="show-cursor"
                                                                                                                                                                                                                data-target="#settlements" onclick="changeTab(this);">Transactions List</a>',
                        ];
                        
                        ?>
                        @foreach ($trans as $index => $value)
                            <li class="{{ Request::path() == $index ? 'active' : '' }} active">{!! $value !!}</li>
                        @endforeach
                    </ul>
                    <form action="" id="transaction-tabs-form" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="panel-body panelH">
                    <div class="tab-content">
                        <div id="settlements" class="tab-pane fade in active">

                            <div class="row">
                                <div class="col-sm-12">
                                    <form id="summary-brief-transaction-form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row" style="margin-top:15px;">
                                                    <div class="col-sm-12 mb-5">
                                                        <div class="col-sm-3 ">
                                                            <input class="form-control searchfor" id="search"
                                                                name="searchfor" type="text" value=""
                                                                placeholder="Search anything here">
                                                            <span class="src">
                                                                <i class="fa fa-search "></i></span>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input class="form-control searchFilter" id="datetimes"
                                                                name="datetimes" placeholder="MM/DD/YYYY" type="text"
                                                                value="" readonly>
                                                            <input type="hidden" name="trans_from_date" value="">
                                                            <input type="hidden" name="trans_to_date" value="">
                                                            <span class="src">
                                                                <i
                                                                    class="fa fa-calendar summary-brief-transaction-form-summary"></i></span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <select id="liststatus" name="status_filter"
                                                                class="form-control ">
                                                                <option value="">All</option>
                                                                @foreach (get_transaction_status() as $status)
                                                                    <option value="{{ $status }}">
                                                                        {{ ucwords($status) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>



                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top:15px;">
                                                    <div class="col-sm-12 mb-5">
                                                        <div class="col-sm-4 mb-5">
                                                            <div>
                                                                <select name="parameter" id=""
                                                                    class="form-control">
                                                                    <option value="transaction_gid">Transaction ID
                                                                    </option>
                                                                    <option value="vendor_transaction_id">Merchant
                                                                        Order ID</option>
                                                                    <option value="bank_ref_no">UTR NO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 mb-5">
                                                            <div>
                                                                <input class="form-control" type="text" name="value">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 mb-5">
                                                            <div>
                                                                <button class="btn btn-primary btn-sm"
                                                                    id="filterSubmit">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block">
                                        <div class="table-responsive1">
                                            <table class="display responsive table table-striped table-bordered text-nowrap"
                                                id="summary_transactions_breif" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Sno</th>
                                                        <th>Initiation Time</th>
                                                        <th>Transaction ID</th>
                                                        <th>Merchant Order ID</th>
                                                        <th>Amount</th>
                                                        <th>Transaction Time</th>
                                                        <th>Payer Name</th>
                                                        <th>Email</th>
                                                        <th>Contact</th>
                                                        <th>Status</th>
                                                        <th>Mode</th>
                                                        <th>TDR %</th>
                                                        <th>TDR</th>
                                                        <th>GST %</th>
                                                        <th>GST</th>
                                                        <th>Net TDR</th>
                                                        <th>Net Settlement</th>
                                                        <th>UTR No</th>
                                                        <th>Customer IP</th>

                                                        <th>Settlement</th>
                                                        <th>Settlement Id</th>
                                                        <th>Refund</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody id="settlementsummarytable">
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
    </div>

    <div id="detail-transaction-model" class="modal" role="dialog">
        <div class="modal-dialog " role="document" style="width:700px">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="">Transaction Details</h4>
                </div>
                <div class="modal-body">
                    <div class="model-content" id="modal-dynamic-body">
                        <div id="paylink-add-form">


                            <div id="transaction_details_view" class="row">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(function() {
        $("#liststatus").val("success");
        $(".summary-brief-transaction-form-summary").click(function(e) {
            e.preventDefault();
            $("input[name='datetimes']").focus();
        })
        var start = moment().subtract(1, 'days');
        var end = moment();
        $("#summary-brief-transaction-form input[name='trans_from_date']").val(start.format(
            'YYYY-MM-DD HH:mm:ss'));
        $("#summary-brief-transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD HH:mm:ss'));
        $('#summary-brief-transaction-form input[name="datetimes"]').daterangepicker({
            dateLimit: {
                days: 61
            },
            minDate: moment().subtract(365, 'days'),
            maxDate: moment(),
            startDate: start,
            endDate: end,
            locale: {
                format: 'DD/MM/YYYY HH:mm:ss'
            },
            timePicker: true,
            timePicker24Hour: false,
            timePickerSeconds: true,
            ranges: {
                'Today': [moment().startOf('day'), moment().endOf('day')],
                'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days')
                    .endOf('day')
                ],
                'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf(
                    'day')],
                'Last Month': [moment().subtract(1, 'month').startOf('day').startOf('month'), moment()
                    .subtract(1, 'month').endOf('month').endOf('day')
                ],
                'Last 2 Month': [moment().subtract(2, 'month').startOf('day').startOf('month'), moment()
                    .subtract(1, 'month').endOf('month').endOf('day')
                ]
            },
        }, function(start, end, label) {
            $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                'MMMM D, YYYY'));
            $("#summary-brief-transaction-form input[name='trans_from_date']").val(start.format(
                'YYYY-MM-DD HH:mm:ss'));
            $("#summary-brief-transaction-form input[name='trans_to_date']").val(end.format(
                'YYYY-MM-DD HH:mm:ss'));
        });
        var table = $('#summary_transactions_breif').DataTable({
    fnInitComplete: function() {
        // Disable TBODY scroll bars, Enable TFOOT scroll bars
        $('.dataTables_scrollFoot').css('overflow', 'auto');
    },
    processing: true,
    language: {
        processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><span class="">Processing...</span> '
    },
    serverSide: true,
    ajax: {
        url: "{{ route('fetch_transaction_list') }}",
        data: function(d) {
            // Get form data as an array
            var formDataArray = $("#summary-brief-transaction-form").serializeArray();

            // Convert formDataArray to a key-value object
            var formData = {};
            $.each(formDataArray, function() {
                formData[this.name] = this.value;
            });

            // Add search input value to request data
            d.search = $('input[type="search"]').val();

            console.log(formData , formData['value'],'afasdfaf')   ;

            // Check if form['value'] is empty and set the 'mode' key accordingly
            if (!formData['value'] || formData['value'] === '') {
                d.mode = 'date';
            } else {
                d.mode = 'submit';
            }

            // Pass the form data along with the request
            d.form = formData;

            console.log(d.form);  // For debugging purposes
        }
    },
    drawCallback: function(settings) {
        // Hide loader (if needed)
        // $(".loader_custom").hide();
    },
    order: [
        [1, 'desc']
    ],
    lengthMenu: [
        [10, 25, 50, 100, 200, -1],
        [10, 25, 50, 100, 200, 'All']
    ],
    scrollX: true,
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
        { data: 'created_date', name: 'created_date', render: function(data) {
                return moment(data, 'MMM DD, YYYY hh:mm:ss A').format('MM-DD-YYYY hh:mm:ss A');
            }
        },
        { data: 'transaction_gid', name: 'transaction_gid', orderable: false },
        { data: 'vendor_transaction_id', name: 'vendor_transaction_id', orderable: false },
        { data: 'transaction_amount', name: 'transaction_amount', orderable: false },
        { data: 'payment_datetime', name: 'payment_datetime', orderable: false, render: function(data) {
                return moment(data).format('MM-DD-YYYY hh:mm:ss A');
            }
        },
        { data: 'uname', name: 'uname', orderable: false },
        { data: 'uemail', name: 'uemail', orderable: false },
        { data: 'ucontact', name: 'ucontact', orderable: false },
        { data: 'transaction_status', name: 'transaction_status', orderable: false },
        { data: 'transaction_mode', name: 'transaction_mode', orderable: false },
        { data: 'transaction_adjustment_charged_per', name: 'transaction_adjustment_charged_per' },
        { data: 'transaction_adjustment_charged_amount', name: 'transaction_adjustment_charged_amount' },
        { data: 'transaction_gst_value', name: 'transaction_gst_value' },
        { data: 'transaction_gst_charged_amount', name: 'transaction_gst_charged_amount' },
        { data: 'transaction_total_charged_amount', name: 'transaction_total_charged_amount' },
        { data: 'transaction_total_adjustment', name: 'transaction_total_adjustment' },
        { data: 'bank_ref_no', name: 'bank_ref_no' },
        { data: 'merchant_ip', name: 'merchant_ip' },
        { data: 'fsettlement_status', name: 'fsettlement_status' },
        { data: 'settlement_brief_gid', name: 'settlement_brief_gid' },
        { data: 'frefund_status', name: 'frefund_status' }
    ]
});

        $('#search').on('input', function() {
            var search = $(this).val();
            if (search.length < 4) {
                return true;
            }
            table.draw();
        });

        $('#filterSubmit').on('click', function() {
            // Your code here
            event.preventDefault(); 
            event.stopPropagation(); 
            console.log('Filter Submit button clicked');
            table.draw();
            // Add any additional code you want to run when the button is clicked
        });



        $(document).on('change', '.searchFilter', function(event) {
            var target = $(event.target);
            var search = $(this).val();
            if (search.length < 4) {
                return true;
            }
            var elementType = $(this).prop('nodeName');
            table.draw();
        });
        $(document).on('change', '#liststatus', function(event) {
            var target = $(event.target);
            var search = $(this).val();
            var elementType = $(this).prop('nodeName');
            table.draw();
        });
    });
    $(document).on('click', '.dwd-brief', function(event) {
        event.preventDefault();
        var url = $('form#summary-brief-transaction-download-form').attr('action');
        // swalnot("error","hekko");
        $("#summary-brief-transaction-form").attr('action', url)
        $("#summary-brief-transaction-form").attr('method', 'POST')
        $('form#summary-brief-transaction-form').submit();
    });
    $(document).on('submit', '#summary-brief-transaction-download-form', function(event) {
        event.preventDefault();
        var url = $(this).attr('action');
        // swalnot("error","hekko");
        $("#summary-brief-transaction-form").attr('action', url)
        $("#summary-brief-transaction-form").attr('method', 'POST')
        $('form#summary-brief-transaction-form').submit();
    });
</script>
