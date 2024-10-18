@extends('layouts.employeecontent')
@section('employeecontent')

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- CSS -->
        {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css"> --}}

        <!-- JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    </head>
    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="tab-content">

                        <div id="payout_settings" class="tab-pane fade in active">


                            <div class="row">

                                <div class="col-sm-12">
                                    <div style="margin-top:30px; margin-bottom:100px; ">
                                        <table class="table table-striped table-bordered text-nowrap "
                                            id="payout-merchant-table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Merchant Id</th>
                                                    <th>Name</th>
                                                    <th>Company Name</th>
                                                    <th>Company Type</th>
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
                </div>
            </div>
        </div>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script>
        $(document).ready(function() {
            var table = $('#payout-merchant-table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false, // Disable the search functionality
                "ajax": "{{ route('getApprovedPayoutMerchants') }}",
                "columns": [{
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "merchant_gid"
                    },
                    {
                        "data": "mer_name"
                    },
                    {
                        "data": "business_name"
                    },
                    {
                        "data": "type_name"
                    },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            var url = '{{ route('merchantPayoutDetails', ':id') }}';
                            url = url.replace(':id', row.id);
                            return `<a href="${url}" class="btn btn-primary btn-sm">View Details</a>`;
                        }

                    }
                ]
            });


        });
    </script>
@endsection
