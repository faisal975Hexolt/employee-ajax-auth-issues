@extends('layouts.merchantcontent')

@section('merchantcontent')




<style>

    .accountscard {

        background-color: white;

        border-radius: 1rem;

        padding: 10px;



    }



    [type=button], [type=reset], [type=submit], button {

    -webkit-appearance: button;

     background-color: #3097D1;

    background-image: none;

}

</style>



<section id="about-1" class="about-1">

    <div class="container-1">



        <h1>Accounts</h1>



    </div>

</section>





<h3 class="mb-4 text-center font-bold mt-3">Payout Report</h3>



<form action="{{route('payout_reports')}}" method="GET">

<div class="">

     <div class="row">
                                        <div class="col-sm-12">

                                            <div class="row" style="margin-top:15px;">
                                                <div class="col-sm-12 mb-5">





                                                    <div class="col-sm-6 ">

                                                        <input class="form-control searchFilter" id="datetimes"
                                                            name="datetimes" placeholder="MM/DD/YYYY" type="text"
                                                            value="{{request()->input('datetimes')}}">
                                                        <input type="hidden" name="trans_from_date" value="">
                                                        <input type="hidden" name="trans_to_date" value="">

                                                        <span class="src">
                                                            <i
                                                                class="fa fa-calendar ecollect-transaction-form-summary"></i></span>
                                                    </div>

                                                     <div class="col-sm-6 ">
                                                         
                                                        <select id="liststatus" name="status"
                                                            class="form-control ">
                                                             <option {{ request()->input('status') == "SUCCESS" ? "selected" :""}} value="SUCCESS">Success</option>

                <option {{ request()->input('status') == "PROCESSING" ? "selected" :""}} value="PROCESSING">{{ucwords(strtolower('PROCESSING'))}}</option>

                <option {{ request()->input('status') == "PENDING" ? "selected" :""}} value="PENDING">Pending</option>

                <option {{ request()->input('status') == "FAILED" ? "selected" :""}} value="FAILED">Failed</option>
                                                        </select>
                                                    </div>



                                                </div>
                                            </div>

        </div>
    </div>

                                            <div class="row" style="margin-top:15px;margin-bottom: 15px;">
                                                <div class="col-sm-12 mb-5">
<div class="row">
    <div class="col-sm-6 ">

                                                       <input type="submit" name="submit" value="Search" class="btn btn-primary form-control ">
                                                    </div>

  </div>
</div>
</div>

</div>

</form>



<div class="row" style="margin-left:15px;">

    <div class="col-11">

        <table id="contacts" class="table table-striped">

            <thead>

                <tr>

                    <th>#</th>

                    <th>At</th>

                    <th>Reference Id</th>

                    <th>Beneficiary Id</th>

                    <th>Mode</th>

                    <th>Amount</th>

                    <th>Status</th>

                    <th>Transfer Id</th>

                    <th>Beneficiary Name</th>

                    <th>Beneficiary Bank Account</th>

                    <th>Ifsc</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($transactions as $index=>$transaction)

                <tr>

                    <td>{{$index+1}}</td>

                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y g:i A')}}</td>

                    <td>{{$transaction->reference_id}}</td>

                    <td>{{$transaction->ben_id}}</td>

                    <td>{{$transaction->transfer_mode}}</td>

                    <td>{{$transaction->amount}}</td>

                    <td>{{$transaction->status}}</td>

                    <td>{{$transaction->transfer_id}}</td>

                    <td>{{$transaction->ben_name}}</td>

                    <td>{{$transaction->ben_ifsc}}</td>

                    <td>{{$transaction->ben_bank_acc}}</td>





                </tr>

                @endforeach



            </tbody>



        </table>

    </div>

</div>







<script>

$(function() {

  $('input[name="datetimes"]').daterangepicker({

    timePicker: true,

    

    locale: {

      format: 'Y/MM/DD '

    }

  });

});



</script>











    @endsection