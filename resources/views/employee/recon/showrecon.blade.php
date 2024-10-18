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
            display: block;
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


    <div class="container">
        <div class="mt-3 mb-3">
            <a href="{{ route('add_recon') }}"> <button class="btn btn-primary">Import Recon</button></a>
        </div>

        <div style="margin-top: 15px">
            <div class="row justify-content-center">
                @isset($disputeCount)
                    <p>Total Disputes: {{ $disputeCount }}</p>
                @endisset

                @isset($notFoundCount)
                    <p>Not Found: {{ $notFoundCount }}</p>
                @endisset

                @isset($totalCount)
                    <p>Total Records Read: {{ $totalCount }}</p>
                @endisset
            </div>
        </div>
        <div class="row justify-content-center " style="margin-top: 15px">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header"> </div>
                    <div class="card-body">
                        <div lass="slider-wrapper d-flex justify-content-end">
                            <input type="range" id="tableScrollRange" min="0" max="100" value="0">
                        </div>
                        <div class="table-container">

                            <div class="table-wrapper">


                                <table id="users-table" class="table table-striped table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Recon Date</th>
                                            <th>Trans Date</th>
                                            <th>Acquirer</th>
                                            <th>File Name</th>
                                            <th>File Type</th>
                                            <th>Status</th>


                                            <th>Not Found - PG </th>
                                            <th>Not Found - Acquirer</th>
                                            <th>Status Mismatch </th>
                                            <th>Amount Mismatch </th>
                                            <th>Date Mismatch </th>

                                            <th>Total Records</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
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
            $('#users-table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": "{{ route('recon_files_data') }}",
                "columns": [{
                        "data": null,
                        "render": function(data, type, full, meta) {
                            // Return row index + 1 as the ID
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "recon_date",
                        "render": function(data, type, full, meta) {
                            // Format date as "19 May, 2024"
                            return data ? new Date(data).toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            }) : '';
                        }
                    },
                    {
                        "data": "transaction_date",
                        "render": function(data, type, full, meta) {
                            // Format date as "19 May, 2024"
                            return data ? new Date(data).toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            }) : '';
                        }
                    },
                    {
                        "data": "vendor_bank.bank_name", // Access nested data
                        "render": function(data, type, full, meta) {
                            // Ensure data exists before rendering
                            return data ? data : '';
                        }
                    },
                    {
                        "data": "file_name"
                    },
                    {
                        "data": "file_type"
                    },
                    {
                        "data": "status"
                    },

                    {
                        "data": "not_found"
                    },
                    {
                        "data": "missing_from_file"
                    },

                    {
                        "data": "conflict"
                    },
                    {
                        "data": "amount_mismatch"
                    },
                    {
                        "data": "date_mismatch"
                    },

                    {
                        "data": "total_record"
                    },
                    {
                        "data": "created_at",
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
                        "data": null,
                        "render": function(data, type, row) {
                            var showReconUrl = "{{ route('show_recon_by_file', ['id' => ':id']) }}";
                            return '<a href="' + showReconUrl.replace(':id', row.id) +
                                '" class="btn btn-primary btn-sm">View </a>';
                        }
                    }
                ]
            });


            // Range slider and table synchronization
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
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                // Your DataTable options here
            });

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
        });
    </script> --}}
@endsection
