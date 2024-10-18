@extends('layouts.resellercontent')
@section('resellercontent')
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

                                                        <div class="col-sm-3">
                                                            <input class="form-control searchFilter" id="datetimes"
                                                                name="datetimes" placeholder="MM/DD/YYYY" type="text"
                                                                value="" readonly>
                                                            <input type="hidden" name="trans_from_date" value="">
                                                            <input type="hidden" name="trans_to_date" value="">
                                                            <span class="src">
                                                                <i
                                                                    class="fa fa-calendar summary-brief-transaction-form-summary"></i></span>
                                                        </div>


                                                        <div class="col-sm-2">
                                                            <form id="summary-brief-transaction-download-form"
                                                                action="{{ route('settlementsummaryDwnld') }}"
                                                                method="POST" role="form">
                                                                @csrf
                                                                <div class="tab-button">
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-md pull-right">
                                                                        Download</button>


                                                                </div>
                                                            </form>
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
                                                        <th>Merchant Gid</th>
                                                        <th>Business Name</th>
                                                        <th>Merchant Name</th>
                                                        <th>No Of Transaction Successful</th>
                                                        <th>Transaction Amount Successful</th>

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
        <div class="modal-dialog modal-lg" role="document" style="width:800px">

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
<script>
    $(function() {
        $("#liststatus").val("success");
        $(".summary-brief-transaction-form-summary").click(function(e) {
            e.preventDefault();
            $("input[name='datetimes']").focus();
        })
        var start = moment().subtract(2, 'days');
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
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('reseller.payin.gettransactioncount') }}",
                type: 'GET',
                data: function(d) {
                    d.form = getJsonObject($("#summary-brief-transaction-form").serializeArray())
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, // Sno
                {
                    data: 'merchant_id'
                },
                {
                    data: 'business_name'
                },
                {
                    data: 'merchant_name'
                },
                {
                    data: 'total_transactions'
                },
                {
                    data: 'total_amount'
                }
            ],
            order: [
                [1, 'asc']
            ], // Default ordering
            paging: false,
            searching: false,
            info: false,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                text: 'Export to Excel',
                filename: 'table_export',
                exportOptions: {
                    modifier: {
                        search: 'none'
                    }
                }
            }]
        });




        $('#search').on('input', function() {
            var search = $(this).val();
            if (search.length < 4) {
                return true;
            }
            table.draw();
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


    });
</script>
