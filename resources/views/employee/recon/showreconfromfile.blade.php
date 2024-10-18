@extends('layouts.employeecontent')
@section('employeecontent')

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- CSS -->
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css"> --}}

        <!-- JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    </head>
    <style>
        .table-container {
            width: 100%;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
            white-space: nowrap;
        }

        #tableScrollRange {
            width: 80%;
            margin: 10px auto;
        }


        #users-table {
            border-collapse: collapse;
            width: max-content;
            /* Ensure table doesn't shrink to fit container */
        }

        #users-table th,
        #users-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #tableScrollRange {
            display: block;
            width: 20%;
            /* Adjust width to make the slider smaller */
            margin: 10px auto;
            /* Center the slider with margin */
            height: px;
            /* Make the range line smaller */
            -webkit-appearance: none;
            /* Remove default styling */
            appearance: none;
            /* Remove default styling */
            background: #ddd;
            /* Track background color */
            outline: none;
            /* Remove outline */
        }

        #tableScrollRange::-webkit-slider-thumb {
            -webkit-appearance: none;
            /* Remove default styling */
            appearance: none;
            /* Remove default styling */
            width: 24px;
            /* Increase square size */
            height: 24px;
            /* Increase square size */
            background: #5d1c84;
            /* Thumb color */
            cursor: pointer;
            /* Cursor on hover */
        }

        #tableScrollRange::-moz-range-thumb {
            width: 24px;
            /* Increase square size */
            height: 24px;
            /* Increase square size */
            background: #4CAF50;
            /* Thumb color */
            cursor: pointer;
            /* Cursor on hover */
        }

        #tableScrollRange::-ms-thumb {
            width: 24px;
            /* Increase square size */
            height: 24px;
            /* Increase square size */
            background: #4CAF50;
            /* Thumb color */
            cursor: pointer;
            /* Cursor on hover */
        }

        #tableScrollRange::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            /* Make the range line smaller */
            cursor: pointer;
            background: #ddd;
        }

        #tableScrollRange::-moz-range-track {
            width: 100%;
            height: 4px;
            /* Make the range line smaller */
            cursor: pointer;
            background: #ddd;
        }

        #tableScrollRange::-ms-track {
            width: 100%;
            height: 4px;
            /* Make the range line smaller */
            cursor: pointer;
            background: #ddd;
            border-color: transparent;
            color: transparent;
        }
    </style>

    <!-- Set the id value in a hidden input -->
    <input type="hidden" id="recon_id" value="{{ $fileId }}">

    <input type="hidden" id="recon_trans_date" value="{{ $fileData->transaction_date }}">

    <div class="container">


        <div class="row justify-content-center mb-3">
            <div class="col-md-2">
                <select id="filterSelect" class="form-control">
                    <option value="">Search Filter</option>
                    <option value="ref_id">Ref Id</option>
                    <option value="txn_id">Txn Id</option>
                    <!-- Add more options if needed -->
                </select>
            </div>

            <div class="col-md-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>

            <div class="col-md-2">
                <button id="filterButton" class="btn btn-primary filterButton">Search</button>
            </div>
            <div class="col-md-3">
                <select id="remarkSelect" class="form-control">
                    <option value="">All</option>

                    <option value="Status Mismatch">Status Mismatch</option>
                    <option value="Amount Mismatch">Amount Mismatch</option>
                    <option value="Date Mismatch">Date Mismatch</option>
                    <option value="Not Found in PG">Not Found in PG</option>
                    <option value="Not Found in Acquirer">Not Found in Acquirer</option>
                    <!-- Add more options if needed -->
                </select>
            </div>
            <div class="col-md-2">
                <button id="filterButton" class="btn btn-primary filterButton">Filter</button>
            </div>


        </div>

        <div class="row justify-content-center " style="margin-top: 20px;">

            <div class="col-md-2">
                <button id="exportButton" class="btn btn-success">Export to Excel</button>
            </div>

            <div class="col-md-2">
                <button id="exportButtonCsv" class="btn btn-success">Export to Csv</button>
            </div>

        </div>


        <div style="justify-content: flex-end;">
            <input type="range" id="tableScrollRange" min="0" max="100" value="0">
        </div>

        <div class="row justify-content-center " style="margin-top: 15px">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header"> </div>
                    <div class="card-body">

                        <div class="table-container">

                            <div class="table-wrapper">
                                <table id="users-table" class="table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <td>id</td>
                                            <td>Merchant Name</td>
                                            <td>Acquirer</td>
                                            <td>Remark</td>
                                            <td>Txn Date</td>
                                            <td>Acquirer Txn Date</td>
                                            <td>Customer Name</td>
                                            <td>Vpa</td>
                                            <td>Mob Number</td>
                                            <td>Amount</td>
                                            <td>Acq Amount</td>
                                            <td>TXN ID</td>
                                            <td>Acquirer TXN ID</td>
                                            <td>Status</td>
                                            <td>Acquirer Status</td>
                                            <td>UTR</td>
                                            <td>Acquirer UTR</td>
                                            <td>REF ID</td>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded dynamically via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            var id = $('#recon_id').val();

            console.log('id', id)
            var url = "{{ route('recon_tabledata', ':id') }}";
            url = url.replace(':id', id);

            var table = $('#users-table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false, // Disable search functionality
                "pageLength": 100, // Show 100 records by default
                ajax: url,
                "columns": [{
                        "data": null,
                        "render": function(data, type, full, meta) {
                            // Return row index + 1 as the ID
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "merchant_name"
                    },
                    {
                        "data": "bank_name"
                    },
                    {
                        "data": "reason"
                    },
                    {
                        "data": "txn_time",
                        "render": function(data, type, full, meta) {
                            // Format created_at timestamp as "19 May, 2024 03:34:31 PM"
                            return data ? new Date(data).toLocaleString('en-US', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: true
                            }) : '';
                        }
                    },
                    {
                        "data": "acquirer_txn_time",
                        "render": function(data, type, full, meta) {
                            // Format created_at timestamp as "19 May, 2024 03:34:31 PM"
                            return data ? new Date(data).toLocaleString('en-US', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: true
                            }) : '';
                        }
                    },
                    {
                        "data": "payer_name"
                    },
                    {
                        "data": "vpa"
                    },
                    {
                        "data": "mobile_number"
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "acquirer_amount"
                    },
                    {
                        "data": "txn_id"
                    },
                    {
                        "data": "acquirer_txn_id"
                    },
                    {
                        "data": "txn_status"
                    },
                    {
                        "data": "acquirer_txn_status"
                    },
                    {
                        "data": "rrn"
                    },
                    {
                        "data": "acquirer_rrn"
                    },
                    {
                        "data": "ref_id"
                    },
                ]
            });


            function synchronizeRangeSlider() {
                const rangeSlider = document.getElementById('tableScrollRange');
                const tableWrapper = document.querySelector('.table-wrapper');
                const table = document.getElementById('users-table');

                rangeSlider.addEventListener('input', function() {
                    tableWrapper.scrollLeft = (table.scrollWidth - tableWrapper.clientWidth) * (rangeSlider
                        .value / 100);
                });

                tableWrapper.addEventListener('scroll', function() {
                    const scrollPercentage = (tableWrapper.scrollLeft / (table.scrollWidth - tableWrapper
                        .clientWidth)) * 100;
                    rangeSlider.value = scrollPercentage;
                });


            }


            table.on('draw.dt', function() {
                synchronizeRangeSlider();
            });



            $('.filterButton').on('click', function() {
                var id = $('#recon_id').val();
                var url = "{{ route('recon_tabledata', ':id') }}";
                url = url.replace(':id', id);
                var searchValue = $('#searchInput').val();
                var filterColumn = $('#filterSelect').val();
                var remarkSelect = $('#remarkSelect').val();


                // Add search value and filter column to the URL
                var filterUrl = url + '?value=' + searchValue + '&filter=' + filterColumn + '&remark=' +
                    remarkSelect;

                console.log(filterUrl)

                // Reload table data with new URL
                table.ajax.url(filterUrl).load();
            });



            $('#exportButton').on('click', function() {
                var id = $('#recon_id').val();
                var url = "{{ route('exportReconExcel') }}";

                var searchValue = $('#searchInput').val();
                var filterColumn = $('#filterSelect').val();
                var remarkSelect = $('#remarkSelect').val();

                // Construct the URL with filter parameters
                var exportUrl = url + '?file=' + id + '&value=' + searchValue + '&filter=' + filterColumn +
                    '&remark=' +
                    remarkSelect;

                console.log(exportUrl)

                // Call AJAX to export data to Excel
                $.ajax({
                    url: exportUrl,
                    type: 'GET',
                    success: function(response) {
                        var blob = new Blob([response], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        // Create a link element to initiate download
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'exported_data.xlsx'; // Specify filename
                        link.click();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                    }
                });
            });

            // Range slider and table synchronization


        });
    </script>

    <script>
        $('#exportButtonCsv').on('click', function() {
            var id = $('#recon_id').val();
            var transDate = $('#recon_trans_date').val();
            var url = "{{ route('exportReconCsv') }}";

            var searchValue = $('#searchInput').val();
            var filterColumn = $('#filterSelect').val();
            var remarkSelect = $('#remarkSelect').val();

            // Construct the URL with filter parameters
            var exportUrl = url + '?file=' + id + '&value=' + searchValue + '&filter=' + filterColumn +
                '&remark=' +
                remarkSelect;

            console.log(exportUrl)

            // Call AJAX to export data to Excel
            $.ajax({
                url: exportUrl,
                type: 'GET',
                success: function(response) {
                    var blob = new Blob([response], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = `recon_${transDate}.csv`;
                    link.click();
                },
                error: function(xhr, status, error) {
                    // Handle error
                }
            });
        });
    </script>
@endsection
