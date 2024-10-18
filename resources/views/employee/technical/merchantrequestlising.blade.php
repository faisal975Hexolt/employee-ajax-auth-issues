@php

$vendor_banks = App\RyapayVendorBank::get_vendorbank();

@endphp

@extends('layouts.employeecontent')

@section('employeecontent')

<style>

    


    .card {

        border: thin solid #ccc;

        border-radius: 10px;

        padding: 5px 5px 5px 5px;

        margin: 5px 5px 5px 5px;

    }



    .thinText {

        font-size: 1.125rem;

        line-height: 1.75rem;

    }



    .strongText {

        font-weight: 600;

        letter-spacing: 0.5px;

    }



    .headlineText {

        font-weight: 900;

        letter-spacing: 2.5px;



    }



    .transactiongid {

        color: #3c8dbc;

        cursor: pointer;

    }

</style>



<h3>Merchant Requests</h3>









<div class="table-responsive">

    <table class="table table-striped table-bordered text-nowrap" id="MerchantRequestListing">



        <thead>

            <tr>

                <th>#</th>

                <th>Merchant</th>



                <th>Request</th>

                <th>Status</th>

                <th>Time & Date</th>

                <th>Action</th>



            </tr>

        </thead>

        <tbody>

            @foreach ($results as $index=>$result)



            <tr>

                <td>{{$index+1}}</td>

                <td>{{$result->merchant->name}}</td>

                <td>{{$result->request}}</td>

                @if ($result->status == 0)

                <td>No Action</td>

                @else

                <td>Action Taken</td>

                @endif



                <td>{{$result->created_at}}</td>

                <td>

                    <form action="{{route('merchantRequestStatusUpdate')}}" method="POST">

                    {{ csrf_field() }}

                        <input type="hidden" value="{{$result->request_id}}" name="id">

                        <button class="btn btn-success">Update Status</button>

                    </form>

                </td>

            </tr>



            @endforeach









        </tbody>

    </table>

</div>

<script>
 document.addEventListener('DOMContentLoaded',function(){
  $(function() {

    var table = $('#MerchantRequestListing').DataTable({
        order: [[1, 'desc']]
    });

  });

  });


</script>

@endsection