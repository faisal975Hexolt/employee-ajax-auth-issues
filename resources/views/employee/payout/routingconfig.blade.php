@php

$vendor_banks = App\RyapayVendorBank::get_vendorbank();

@endphp

@extends('layouts.employeecontent')

@section('employeecontent')



<h3>Routing Configuration</h3>



<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Add Routing Configuration</button>



<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Routing Configuration form</h4>

            </div>

            <div class="modal-body">



                <form action="/manage/save_routing_config" method="POST" class="form-horizontal" role="form">

                    {{csrf_field()}}



                    <div class="form-group form-fit">

                        <label for="input" class="col-sm-3 control-label">Merchant:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="merchant_id" id="" class="form-control">

                                @foreach ($user as $users)

                                <option value="{{$users->id}}">{{$users->name}}</option>

                                @endforeach

                            </select>

                        </div>



                    </div>



                    <div class="form-group form-fit">

                        <label for="input" class="col-sm-3 control-label">IMPS:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="imps" id="" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                        <label for="input" class="col-sm-3 control-label">NEFT:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="neft" id="" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="form-group form-fit">

                        <label for="input" class="col-sm-3 control-label">RTGS:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="rtgs" id="" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                        <label for="input" class="col-sm-3 control-label">UPI:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="upi" id="" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="form-group form-fit">

                        <label for="input" class="col-sm-3 control-label">PAYTM:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="paytm" id="" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                        <label for="input" class="col-sm-3 control-label">AMAZON:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="amazon" id="" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                    </div>



                    <div class="px-5 py-3 text-center">

                        <button class="btn btn-primary" type="submit">Save</button>

                    </div>

                </form>

            </div>

        </div>



    </div>

</div>







<div id="razorpaytable" style="margin-top:30px;">

    <table class="table table-striped table-bordered">



        <thead>

            <tr>

                <th>#</th>

                <th>Merchant Id</th>

                <th>Merchant</th>



                <th>Imps</th>

                <th>Neft</th>

                <th>Rtgs</th>

                <th>Upi</th>

                <th>Paytm</th>

                <th>Amazon</th>

                <th>Date</th>

                <th>Action</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($payoutVendors as $index=>$value)

            <tr>

                <td>{{$index+1}}</td>
                <td>{{$value->merchant->merchant_gid}}</td>
                <td>{{$value->merchantbusiness->business_name}}</td>



                <td>{{$value->imps_vendor}}</td>

                <td>{{$value->neft_vendor}}</td>

                <td>{{$value->rtgs_vendor}}</td>



                <td>{{$value->upi_vendor}}</td>

                <td>{{$value->paytm_vendor}}</td>

                <td>{{$value->amazon_vendor}}</td>

                <td>{{ Carbon\Carbon::parse($value->created_at)->format('d-m-Y H:i:s')  }}</td>

                <td>

                    <button class="btn" data-toggle="modal" data-id="{{$value->id}}" data-target="#deleteModal"><ion-icon style="color:red; font-size: 19px;" name="trash-outline"></ion-icon></button>

                    <button class="btn " data-toggle="modal" data-id="{{$value->id}}" data-imps="{{$value->imps}}" data-neft="{{$value->neft}}" data-rtgs="{{$value->rtgs}}" data-upi="{{$value->upi}}" data-paytm="{{$value->paytm}}" data-amazon="{{$value->amazon}}" data-target="#editModal"><ion-icon style="color:#2980b9; font-size: 19px;" name="create-sharp" ></ion-icon></button>

                </td>



            </tr>

            @endforeach

        </tbody>

    </table>

</div>





<!-- deleteModal -->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-sm" style="margin-top:150px" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="exampleModalLongTitle">Are you sure ?</h4>

            </div>

            <div class="modal-footer">

                <form action="/manage/delete_routing_config" method="POST">

                    {{csrf_field()}}

                    <input type="hidden" id="getId" name="id">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-danger">Yes</button>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- enddeleteModal -->



<!-- editMOdal -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg" style="margin-top:150px" role="document">



        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Edit Routing Configuration </h4>

            </div>

            <div class="modal-body">



                <form action="/manage/edit_routing_config" method="POST" class="form-horizontal" role="form">

                    {{csrf_field()}}



                    <input type="hidden" id="getId" name="id">



                    <div class="form-group form-fit">

                        <label for="input" class="col-sm-3 control-label">IMPS:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="imps" id="imps" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                        <label for="input" class="col-sm-3 control-label">NEFT:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="neft" id="neft" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="form-group form-fit">

                        <label for="input" class="col-sm-3 control-label">RTGS:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="rtgs" id="rtgs" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                        <label for="input" class="col-sm-3 control-label">UPI:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="upi" id="upi" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="form-group form-fit">

                        <label for="input" class="col-sm-3 control-label">PAYTM:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="paytm" id="paytm" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                        <label for="input" class="col-sm-3 control-label">AMAZON:<span class="text-danger">*</span></label>

                        <div class="col-sm-3">

                            <select name="amazon" id="amazon" class="form-control">

                                @foreach ($vendors as $vendor)

                                <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>

                                @endforeach

                            </select>

                        </div>

                    </div>



                    <div class="px-5 py-3 text-center">

                        <button class="btn btn-primary" type="submit">Save</button>

                    </div>

                </form>

            </div>

        </div>



    </div>

</div>

<!-- endeditMOdal -->





<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>



<script>

    $('#deleteModal').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget) // Button that triggered the modal

        var id = button.data('id')





        console.log(id);

        var modal = $(this)

        modal.find('#getId').val(id)





    })

</script>





<script>

    $('#editModal').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget) // Button that triggered the modal

        var id = button.data('id')

        var imps = button.data('imps')

        var neft = button.data('neft')

        var rtgs = button.data('rtgs')

        var upi = button.data('upi')

        var paytm = button.data('paytm')

        var amazon = button.data('amazon')





        console.log(id,imps,neft,rtgs,upi,paytm,amazon);



        var modal = $(this)

        modal.find('#getId').val(id)

        modal.find('#imps').val(imps)

        modal.find('#neft').val(neft)

        modal.find('#rtgs').val(rtgs)

        modal.find('#upi').val(upi)

        modal.find('#paytm').val(paytm)

        modal.find('#amazon').val(amazon)





    })

</script>

@endsection