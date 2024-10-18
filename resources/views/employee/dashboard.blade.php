@extends('layouts.employeecontent')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .card {
        background-color: #fff;
        border-radius: 10px;
        border: #f78ca0 1px solid;
        padding: 10px 5px 10px 5px;
    }
</style>
@section('employeecontent')
    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#dashboard}}">Dashboard</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="dashboard" class="tab-pane fade in active">
                            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration"
                                role="alert">
                                <div class="inner">
                                    <div class="app-card-body">
                                        <h3 class="mb-3">Welcome,
                                            {{ Auth::guard('employee')->user()->first_name . ' ' . Auth::guard('employee')->user()->last_name }}
                                        </h3>
                                        <!--<div class="row gx-5 gy-3">
                                                                <div class="col-12 col-lg-9">
                                                                    <div>Portal is a free Bootstrap 5 admin dashboard template. The design is simple, clean and modular so it's a great base for building any modern web app.</div>
                                                                </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row g-4 mb-4">
                            <div class="col-6 col-lg-6">
                                <input type="text" name="datetimes" id="datetimes"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                            </div>

                            <div class="col-6 col-lg-6">
                                <select name="" class="form-control" id="merchantid">
                                    <option value="all">All</option>
                                    @foreach (get_merchnat_list() as $merchant)
                                        <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">

                            <div class="col-6 col-lg-3">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(120deg, #0073b7 0%, #637e8e 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total
                                            GTV </h4>
                                        <div class="stats-figure" id="gtv" style="color:white;font-weight:900;">
                                            ₹{{ $dashboard->gtv }} </div>

                                    </div>

                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>

                            <div class="col-6 col-lg-3">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(-20deg, #fc6076 0%, #ff9a44 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">
                                            Successful Transactions</h4>
                                        <div class="stats-figure" id="successfulTransaction"
                                            style="color:white;font-weight:900;">{{ $dashboard->successful_transaction }}
                                        </div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>

                            <div class="col-6 col-lg-3 ">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Amount
                                            Refunded</h4>
                                        <div class="stats-figure" id="refund" style="color:white;font-weight:900;">₹0.00
                                        </div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 ">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: radial-gradient(circle 248px at center, #16d9e3 0%, #30c7ec 47%, #46aef7 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">
                                            ChargeBack Amount</h4>
                                        <div class="stats-figure" id="chargeback" style="color:white;font-weight:900;">₹0.00
                                        </div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>




                        </div>
                        <!-- //new tabs -->
                        <div class="row mt-2 mb-2">


                            <div class="col-6 col-lg-3 hide_content">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total
                                            Transactions</h4>
                                        <div class="stats-figure" id="totalTransaction"
                                            style="color:white;font-weight:900;">{{ $dashboard->total_transaction }}</div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>



                            <div class="col-6 col-lg-3 hide_content">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total
                                            Failed Transactions</h4>
                                        <div class="stats-figure" id="failedTransaction"
                                            style="color:white;font-weight:900;">{{ $dashboard->failed_transaction }}</div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>

                            <div class="col-6 col-lg-3 hide_content">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total
                                            Users </h4>
                                        <div class="stats-figure" style="color:white;font-weight:900;">
                                            {{ $dashboard->total_merchant }} </div>

                                    </div>

                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 hide_content">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total
                                            Live Users</h4>
                                        <div class="stats-figure" style="color:white;font-weight:900;">
                                            {{ $dashboard->live_merchant }}</div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>








                            <div class="col-6 col-lg-3 hide_content">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: radial-gradient(circle 248px at center, #16d9e3 0%, #30c7ec 47%, #46aef7 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total
                                            Active Users</h4>
                                        <div class="stats-figure" style="color:white;font-weight:900;">
                                            {{ $dashboard->active_merchant }}</div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>


                        </div>

                        <div class="row g-4 mb-4 " style="margin-top: 10px;">

                            <div class="col-12 col-lg-12">
                                <div class="card ">
                                    <div class="card-body" id="transactionGraph" style="height:450px; ">

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row g-4 mb-4" style="margin-top: 10px;">

                            <div class="col-md-6">
                                <div class="card ">
                                    <div class="card-header">
                                        <h3 class="box-title" id="paymentModeTitle">Payments Mode Distribution</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="card-body">
                                        <div id="payment-mode-graph"></div>
                                        <div class="text-center text-muted" id="payment-mode-graph-empty"> No data for
                                            selected date
                                            range
                                        </div>
                                    </div>
                                </div><!-- /.box -->
                            </div>

                            <div class="col-md-6">
                                <div class="card ">
                                    <div class="card-header">
                                        <h3 class="box-title" id="paymentModeTitle">Status Wise Transactions</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="card-body">
                                        <div id="transaction-status-graph"></div>
                                        <div class="text-center text-muted" id="transaction-status-graph-empty"> No data
                                            for
                                            selected date
                                            range
                                        </div>
                                    </div>
                                </div><!-- /.box -->
                            </div>

                            <div class="col-md-6" style="margin-top: 10px;">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title" id="deviceTitle">Device Distribution </h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="card-body">
                                        <div id="device-graph"></div>
                                        <div class="text-center text-muted" id="device-graph-empty"> No data for selected
                                            date range
                                        </div>
                                    </div>
                                </div><!-- /.box -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>

    <script src="//cdn.amcharts.com/lib/4/core.js"></script>
    <script src="//cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="//cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>




    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(10, 'days').startOf('day');
            var end = moment().endOf('day');

            function cb(start, end) {
                $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY HH:mm:ss') + ' - ' + end.format(
                    'MMMM D, YYYY HH:mm:ss'));

                merchantId = $('#merchantid').val();



                callingapis(start, end, merchantId);
                callinggraphapi(start, end, merchantId);
            }

            $('input[name="datetimes"]').daterangepicker({
                dateLimit: {
                    days: 61
                },
                startDate: start,
                endDate: end,
                locale: {
                    format: 'DD/MM/YYYY HH:mm:ss'
                },
                timePicker: true,
                timePicker24Hour: false,
                timePickerSeconds: true,
                minDate: moment().subtract(365, 'days'),
                maxDate: moment(),
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days')
                        .endOf('day')
                    ],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf(
                        'day')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month').startOf('day'), moment()
                        .subtract(1, 'month').endOf('month').endOf('day')
                    ],
                    'Last 2 Month': [moment().subtract(2, 'month').startOf('month').startOf('day'), moment()
                        .subtract(1, 'month').endOf('month').endOf('day')
                    ]
                }
            }, cb);

            cb(start, end);

            $('#merchantid').on('change', function(event) {
                console.log('working');
                var merchantId = $(this).val();
                var startDate = moment($('#datetimes').data('daterangepicker').startDate);
                var endDate = moment($('#datetimes').data('daterangepicker').endDate);
                console.log(merchantId, startDate, endDate);

                callingapis(startDate, endDate, merchantId);
                callinggraphapi(startDate, endDate, merchantId);
            });

            function callingapis(start, end, merchantid) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    dataType: "json",
                    data: {
                        'start': start.format('YYYY-MM-DD HH:mm:ss'),
                        'end': end.format('YYYY-MM-DD HH:mm:ss'),
                        'merchantId': merchantid

                    },
                    url: '{{ url('/') }}/manage/dashboard_transactionstats',
                    success: function(data) {

                        console.log('%cdashboard.blade.php line:183 object', 'color: #007acc;', data);

                        $('#totalTransaction').html(data.transactionStats.total_transaction);
                        $('#successfulTransaction').html(data.transactionStats.successful_transaction);
                        $('#failedTransaction').html(data.transactionStats.failed_transaction);
                        $('#gtv').html('₹' + data.transactionStats.gtv);
                        $('#refund').html('₹' + data.transactionStats.refund);
                        $('#chargeback').html();

                    }
                });
            }

            


            function callinggraphapi(start, end, merchantid) {
                //graph
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    dataType: "json",
                    data: {
                        'start': start.format('YYYY-MM-DD HH:mm:ss'),
                        'end': end.format('YYYY-MM-DD HH:mm:ss'),
                        'merchantId': merchantid

                    },
                    url: '{{ url('/') }}/manage/dashboardGraphData',
                    success: function(data) {
                        console.log(data);

                        //graph 1 transaction start
                        var currency_symbol = "₹";
                        var currency_code = "INR";

                        function indianNumberFormat(number, type, currency_code) {
                            if (type == "currency") {
                                return parseFloat(number).toLocaleString("en-IN", {
                                    style: type,
                                    currency: currency_code,
                                    currencyDisplay: "symbol",
                                });
                            } else {
                                return parseInt(number).toLocaleString("en-IN", {
                                    style: type,
                                });
                            }
                        }

                        function drawDoughnutGraph(chart, x_axes_label, y_axes_label, label_format,
                            currency_symbol) {

                            chart.radius = am4core.percent(50);
                            chart.innerRadius = am4core.percent(30);

                            // Add and configure Series
                            var pieSeries = chart.series.push(new am4charts.PieSeries());
                            pieSeries.dataFields.value = y_axes_label;
                            pieSeries.dataFields.category = x_axes_label;
                            pieSeries.slices.template.stroke = am4core.color("#fff");
                            pieSeries.slices.template.strokeWidth = 2;
                            pieSeries.slices.template.strokeOpacity = 1;

                            // This creates initial animation
                            pieSeries.hiddenState.properties.opacity = 1;
                            pieSeries.hiddenState.properties.endAngle = -90;
                            pieSeries.hiddenState.properties.startAngle = -90;
                            pieSeries.slices.template.interactionsEnabled = true;

                            var button = chart.chartContainer.createChild(am4core.Button);
                            button.label.text = "Details";
                            button.padding(5, 5, 5, 5);
                            button.width = 100;
                            button.align = "right";
                            button.valign = "bottom";
                            button.marginRight = 15;

                            switch (label_format) {
                                case "amount":
                                    pieSeries.slices.template.tooltipText = "{category}: {amount}";
                                    button.events.on("hit", function(ev) {
                                        window.location.replace(
                                            "rpdaywisebankcodemerchanttransaction/payment-mode-details"
                                        );
                                    });
                                    break;
                                case "count":
                                    pieSeries.slices.template.tooltipText =
                                        "{category}: {tran_count} Transactions";
                                    button.events.on("hit", function(ev) {
                                        window.location.replace(
                                            "rpdaywisemerchantdevicetransaction/device-details"
                                        );
                                    });
                            }
                        }


                        function dashborad_summary_amchartgraph() {

                            // Apply chart themes
                            am4core.useTheme(am4themes_animated);
                            //am4core.useTheme(am4themes_kelly);

                            // Create chart instance
                            var gtv_chart = am4core.create("transactionGraph", am4charts.XYChart);

                            // set scrollbar for x-axes date range
                            gtv_chart.scrollbarX = new am4core.Scrollbar();

                            // setting data for the gtv and tran count chart


                            gtv_chart.data = data.bar_graph;




                            // Legend for the gtv and tran count in the chart
                            gtv_chart.legend = new am4charts.Legend();
                            gtv_chart.legend.useDefaultMarker = true;
                            var marker = gtv_chart.legend.markers.template.children.getIndex(0);
                            marker.cornerRadius(5, 5, 5, 5);
                            marker.strokeWidth = 2;
                            marker.strokeOpacity = 1;

                            // x-axes date format
                            var gtv_dateAxis = gtv_chart.xAxes.push(new am4charts.DateAxis());
                            gtv_dateAxis.dataFields.category = "gtv_date";
                            gtv_dateAxis.dateFormats.setKey("day", "dd-MM-yyyy");

                            // creating value axis and its configuration for gtv

                            var gtv_valueAxis = gtv_chart.yAxes.push(new am4charts.ValueAxis());

                            // gtv_valueAxis.unit = "Rs.";
                            // gtv_valueAxis.unitPosition = "left";
                            gtv_valueAxis.min = 0;
                            gtv_valueAxis.numberFormatter = new am4core.NumberFormatter();
                            gtv_valueAxis.numberFormatter.numberFormat = "#,##,###a";

                            // Set up axis title
                            gtv_valueAxis.title.text = "GTV Amount (" + currency_symbol + ")";

                            // Create gtv series and its configuration
                            var gtv_series = gtv_chart.series.push(new am4charts.ColumnSeries());
                            gtv_series.dataFields.dateX = "gtv_date";
                            gtv_series.dataFields.valueY = "gtv_amount";
                            gtv_series.name = "Gross Transaction Value";

                            // Tooltip for the gtv series
                            gtv_series.tooltipHTML = `GTV Value : {gtv_amount}`;
                            gtv_series.columns.template.strokeWidth = 0;
                            gtv_series.tooltip.pointerOrientation = "vertical";
                            gtv_series.tooltip.numberFormatter.numberFormat = "#,##,###";

                            // The gtv bar chart radius
                            gtv_series.columns.template.column.cornerRadiusTopLeft = 10;
                            gtv_series.columns.template.column.cornerRadiusTopRight = 10;
                            gtv_series.columns.template.column.fillOpacity = 0.8;

                            gtv_series.yAxis = gtv_valueAxis;

                            // creating value axis and its configuration for transaction count
                            var tran_valueAxis = gtv_chart.yAxes.push(new am4charts.ValueAxis());

                            // setting min value for tran count axes
                            tran_valueAxis.min = 0;
                            // tran_valueAxis.strictMinMax=true;

                            // setting number format for transaction count axes
                            tran_valueAxis.numberFormatter = new am4core.NumberFormatter();
                            tran_valueAxis.numberFormatter.numberFormat = "#,###";

                            // Set up axis title for transaction count value axis
                            tran_valueAxis.title.text = "Count";

                            // Showing value count y-axes on the right side of the chart
                            tran_valueAxis.renderer.opposite = true;

                            // Create series and its configuration for transaction count
                            var tran_count_series = gtv_chart.series.push(new am4charts.LineSeries());
                            tran_count_series.dataFields.dateX = "gtv_date";
                            tran_count_series.dataFields.valueY = "tran_count";
                            tran_count_series.name = "Transaction Count";

                            // setting colour for line graph
                            tran_count_series.propertyFields.stroke = "line_colour";
                            tran_count_series.propertyFields.fill = "line_colour";

                            // Tooltip for the transaction count series
                            tran_count_series.tooltipText = "Transaction Count : {tran_count}";
                            tran_count_series.strokeWidth = 2;
                            tran_count_series.propertyFields.strokeDasharray = "dashLength";
                            tran_count_series.yAxis = tran_valueAxis;

                            // circular bullet
                            var circleBullet = tran_count_series.bullets.push(
                                new am4charts.CircleBullet()
                            );
                            circleBullet.circle.radius = 7;
                            circleBullet.circle.stroke = am4core.color("#fff");
                            circleBullet.circle.strokeWidth = 3;

                            // rectangular bullet on hover on tran count series
                            var durationBullet = tran_count_series.bullets.push(new am4charts.Bullet());
                            var durationRectangle = durationBullet.createChild(am4core.Rectangle);
                            durationBullet.horizontalCenter = "middle";
                            durationBullet.verticalCenter = "middle";
                            durationBullet.width = 7;
                            durationBullet.height = 7;
                            durationRectangle.width = 7;
                            durationRectangle.height = 7;

                            var durationState = durationBullet.states.create("hover");
                            durationState.properties.scale = 1.2;

                            // remove cornaer radiuses of bar chart on hover
                            var hoverState = gtv_series.columns.template.column.states.create("hover");
                            hoverState.properties.cornerRadiusTopLeft = 0;
                            hoverState.properties.cornerRadiusTopRight = 0;
                            hoverState.properties.fillOpacity = 1;

                            // setting random colour for bar chart
                            gtv_series.columns.template.adapter.add("fill", function(fill, target) {
                                return gtv_chart.colors.getIndex(target.dataItem.index);
                            });

                            // Cursor
                            gtv_chart.cursor = new am4charts.XYCursor();

                            //  gtv_chart.dispose();

                            /* payment mode graph */


                            payment_mode_graph_dom = $("#payment-mode-graph");
                            payment_mode_graph_empty_dom = $("#payment-mode-graph-empty");
                            payment_mode_json_data = [{
                                "amount": "100.52",
                                "payment_mode": "UPI"
                            }];
                            payment_mode_json_data = data.pay_mode;

                            payment_mode_chart = am4core.create("payment-mode-graph", am4charts
                                .PieChart);

                            drawDoughnutGraph(payment_mode_chart, "payment_mode", "amount", "amount",
                                currency_symbol);

                            // show error message in case if no data or if all data for payment mode is zero
                            if (payment_mode_json_data.length == 0) {

                                payment_mode_graph_empty_dom.css("display", "block");
                                payment_mode_graph_dom.css("display", "none");

                            } else {

                                payment_mode_graph_empty_dom.css("display", "none");
                                payment_mode_graph_dom.css("display", "block");

                                payment_mode_data = [];

                                $.each(payment_mode_json_data, function(key, value) {
                                    payment_mode_data.push({
                                        "payment_mode": value.transaction_mode,
                                        "amount": indianNumberFormat(value.total,
                                            'currency', currency_code),
                                    });
                                });

                                payment_mode_chart.data = payment_mode_data;
                                payment_mode_chart.reinit();


                                /* Device mode graph */

                                device_graph_dom = $("#device-graph");
                                device_graph_empty_dom = $("#device-graph-empty");
                                device_json_data = [{
                                    "tran_count": "99",
                                    "device_type": "desktop"
                                }];

                                device_chart = am4core.create("device-graph", am4charts.PieChart);

                                drawDoughnutGraph(device_chart, "device_type", "tran_count", "count",
                                    currency_symbol);

                                if (device_json_data.length == 0) {

                                    device_graph_empty_dom.css("display", "block");
                                    device_graph_dom.css("display", "none");

                                } else {

                                    device_graph_empty_dom.css("display", "none");
                                    device_graph_dom.css("display", "block");

                                    device_data = [];

                                    $.each(device_json_data, function(key, value) {
                                        device_data.push({
                                            "device_type": value.device_type,
                                            "tran_count": indianNumberFormat(value
                                                .tran_count, 'decimal', null)
                                        });
                                    });

                                    device_chart.data = device_data;
                                    device_chart.reinit();

                                }

                            }

                            // Transaction Status Graph
                            transaction_status_graph_dom = $("#transaction-status-graph");
                            transaction_status_graph_empty_dom = $("#transaction-status-graph-empty");

                            transaction_status_json_data = data.status_mode;

                            transaction_status_chart = am4core.create("transaction-status-graph",
                                am4charts.PieChart);

                            drawDoughnutGraph(transaction_status_chart, "transaction_status", "total",
                                "total", currency_symbol);

                            if (transaction_status_json_data.length == 0) {
                                transaction_status_graph_empty_dom.css("display", "block");
                                transaction_status_graph_dom.css("display", "none");
                            } else {
                                transaction_status_graph_empty_dom.css("display", "none");
                                transaction_status_graph_dom.css("display", "block");

                                transaction_status_data = [];
                                $.each(transaction_status_json_data, function(key, value) {
                                    transaction_status_data.push({
                                        "transaction_status": value.transaction_status,
                                        "total": indianNumberFormat(value.total,
                                            'decimal', null),
                                    });
                                });

                                transaction_status_chart.data = transaction_status_data;
                                transaction_status_chart.reinit();
                            }
                        }

                        dashborad_summary_amchartgraph();
                        //graph 1 end


                    }
                });
            }

        });
    </script>

    <script>
        navigator.vibrate(10000);
    </script>
@endsection
