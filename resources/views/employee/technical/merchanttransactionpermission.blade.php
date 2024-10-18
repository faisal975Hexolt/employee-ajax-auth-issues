@php

$vendor_banks = App\RyapayVendorBank::get_vendorbank();

@endphp

@extends('layouts.employeecontent')

@section('employeecontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<style>

    .dataTables_filter {

/*        display: none;*/

    }

</style>



<h3>Merchant Services</h3>



<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">

    Add New

</button>





<div style="margin-top:30px; margin-bottom:100px; ">

    <table class="table table-striped table-bordered" id="transactions">



        <thead>

            <tr>

                <th>#</th>
                <th>Merchant Id</th>
                <th>Merchant</th>

                <th>Payout</th>

                <th>Payin</th>

                <th>Utilities</th>

                <th>Settlements</th>

                <th>Pennydrop</th>

                <th>Last Updated</th>

                <th>Action</th>



            </tr>

        </thead>

        <tbody>

            @foreach ($storedPermissions as $index=>$permissions)

            <tr>

                <td>{{$index+1}}</td>
                <td>{{$permissions->merchant_gid}}</td>
                <td>{{$permissions->business_name}}</td>

                @if($permissions->payout == 1)

                <td class="text-success">Enabled</td>



                @else

                <td class="text-danger">Disabled</td>



                @endif



                @if($permissions->payin == 1)

                <td class="text-success">Enabled</td>



                @else

                <td class="text-danger">Disabled</td>



                @endif


                 @if($permissions->utilities == 1)

                <td class="text-success">Enabled</td>



                @else

                <td class="text-danger">Disabled</td>



                @endif

                 @if($permissions->settlements == 1)

                <td class="text-success">Enabled</td>



                @else

                <td class="text-danger">Disabled</td>



                @endif



                @if($permissions->pennydrop == 1)

                <td class="text-success">Enabled</td>



                @else

                <td class="text-danger">Disabled</td>



                @endif



                <td>{{\Carbon\Carbon::parse($permissions->created_at)->format('M d, Y H:m:s')}}</td>

                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-merchant="{{$permissions->merchant_id}}" data-payout="{{$permissions->payout}}" data-payin="{{$permissions->payin}}" data-pennydrop="{{$permissions->pennydrop}}" data-utilities="{{$permissions->utilities}}" data-settlements="{{$permissions->settlements}}">

                <ion-icon name="create-outline"></ion-icon>

                    </button>

                </td>







            </tr>

            @endforeach









        </tbody>

    </table>

</div>





<!-- addModal -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="exampleModalLabel">Add Merchant Services </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form action="{{route('addMerchantServices')}}" method="POST">

                {!! csrf_field() !!}

                    <div class="form-group">

                        <label for="exampleInputPassword1">Merchants</label>

                        <select name="merchant" id="" class="form-control">

                            @foreach ($merchants as $merchant)

                            <option value="{{$merchant->id}}">{{$merchant->mid." : ".$merchant->merchant_gid}}</option>

                            @endforeach

                        </select>

                    </div>



                    <div class="form-group">

                        <label for="exampleInputPassword1">Payout</label>

                        <select name="payout" id="" class="form-control">



                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>



                        </select>

                    </div>



                    <div class="form-group">

                        <label for="exampleInputPassword1">Payin</label>

                        <select name="payin" id="" class="form-control">

                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>





                        </select>

                    </div>

                    <div class="form-group">

                        <label for="exampleInputPassword1">Utilities</label>

                        <select name="utilities" id="utilities" class="form-control">

                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>





                        </select>

                    </div>




                     <div class="form-group">

                        <label for="exampleInputPassword1">Settlements</label>

                        <select name="settlements" id="settlements" class="form-control">

                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>





                        </select>

                    </div>





                    <div class="form-group">

                        <label for="exampleInputPassword1">Pennydrop</label>

                        <select name="pennydrop" id="" class="form-control">



                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>



                        </select>

                    </div>





            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button  type="submit" class="btn btn-primary">Save </button>

            </div>

            </form>

        </div>

    </div>

</div>

<!-- endaddmodal -->



<!-- EditModal -->

<div class="modal fade editModal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="exampleModalLabel">Edit Merchant Services</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

            <form action="{{route('editMerchantServices')}}" method="POST">

                {!! csrf_field() !!}

                <input type="hidden" id="merchant" name="merchant">

                    <div class="form-group">

                        <label for="exampleInputPassword1">Payout</label>

                        <select name="payout" id="payout" class="form-control">



                            <option value="0">Disabled</option>

                            <option  value="1">Enabled</option>



                        </select>

                    </div>



                    <div class="form-group">

                        <label for="exampleInputPassword1">Payin</label>

                        <select name="payin" id="payin" class="form-control">

                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>





                        </select>

                    </div>



                     <div class="form-group">

                        <label for="exampleInputPassword1">Utilities</label>

                        <select name="utilities" id="utilities" class="form-control">

                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>





                        </select>

                    </div>




                     <div class="form-group">

                        <label for="exampleInputPassword1">Settlements</label>

                        <select name="settlements" id="settlements" class="form-control">

                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>





                        </select>

                    </div>





                    <div class="form-group">

                        <label for="exampleInputPassword1">Pennydrop</label>

                        <select name="pennydrop" id="pennydrop" class="form-control">



                            <option value="0">Disabled</option>

                            <option value="1">Enabled</option>



                        </select>

                    </div>





            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-primary">Save </button>

            </div>

            </form>

        </div>

    </div>

</div>

<!-- endaddmodal -->










<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

{{-- 

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}









<script>



    $(document).ready(function(){
    $(document).on('shown.bs.modal','.editModal', function (event) {
         // DO EVENTS
        var button = $(event.relatedTarget) // Button that triggered the modal

        var id = button.data('merchant')

        var payout = button.data('payout')  

        var payin = button.data('payin')

        var pennydrop = button.data('pennydrop')

         var utilities = button.data('utilities')  

          var settlements = button.data('settlements')


        console.log(id,payout,payin,pennydrop,button,settlements,utilities);

        var modal = $(this)

        modal.find('#merchant').val(id);

        modal.find('#payout').val(payout).change();

        modal.find('#payin').val(payin).change();

        modal.find('#utilities').val(utilities).change();
        modal.find('#settlements').val(settlements).change();

        modal.find('#pennydrop').val(pennydrop).change();
    });
});

    

    $('#editModal').on('shown.bs.modal', function (event) {

       

       

})

</script>

























@endsection