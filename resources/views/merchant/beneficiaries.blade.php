@extends('layouts.merchantcontent')

@section('merchantcontent')

<style>

    .flex-container {

        display: flex;

        flex-wrap: nowrap;



    }



    .flex-container>div {



        width: 400px;

        margin: 10px;

        text-align: center;





    }



    .addbutton {

        position: relative;



        bottom: 45px;

        transform: translate(-50%, -50%);

        transition: all 1s;

        /* background: #3097d1; */

        box-sizing: border-box;

        border-radius: 25px;

    }



    .submitButton {

        margin-top: 2rem;

    }



    .formmargins {

        margin-top: 10px;

        margin-bottom: 10px;

    }



   

    .dropdown-menu>li>a>span {

        color: #5d5f63;

    }



   

</style>



<!-- <div id="buton-1">

    <button class="btn btn-dark" id="Show">Show</button>

    <button class="btn btn-danger" id="Hide">Remove</button>

</div> -->



<!-- <section id="about-1" class="about-1">

    <div class="container-1">



        <div class="row">



            <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">

                <div class="content-1 pt-4 pt-lg-0">



                    <h3>Beneficiaries</h3>

                    <p>Get started with accepting payments right away</p>



                    <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>

                </div>

            </div>

            <div class="col-lg-6" data-aos="zoom-in" id="img-dash">

                <img src="{{ asset('assets/img/dash-bnr.png') }}" width="450" height="280" class="img-fluid" alt="dash-bnr.png">

            </div>

        </div>



    </div>

</section> -->

<section id="about-1" class="about-1">
    <div class="container-1">
        <div class="row">
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
                <h3 class="margH">Beneficiaries </h3>
         
            </div>
        </div>
       
        </div>

    </div>
</section> 





<div class="container mx-auto">

    <div class="flex flex-row">



        <div class="basis-1/3" style="margin-bottom:10px;">

            <button type="button" class="rounded-lg bg-cyan-600 px-3 py-1 text-white" data-toggle="modal" data-target="#exampleModal">

               

            </button>

        </div>



        <div class="basis-1/3"></div>



        <div class="basis-1/3">



            <div class="flex justify-start gap-4" id="options" style="display:none;">

                <div class="">

                    <button type="button" class="rounded-lg bg-cyan-600 px-5 py-3 text-white" data-toggle="modal" data-target="#deleteModal">

                        Delete

                    </button>

                </div>



                <div class="">

                    <form action="/merchant/edit_beneficiaries">

                        <input type="hidden" id="edit_ids" name="edit_ids">

                        <button type="submit" class="rounded-lg bg-cyan-600 px-5 py-3 text-white">Edit </button>

                    </form>

                </div>



                <div class="">

                    <form action="/merchant/make_beneficiaries_group">

                        <input type="hidden" id="ben_ids" name="ben_ids">

                        <button type="submit" class="rounded-lg bg-cyan-600 px-5 py-3 text-white">Group </button>

                    </form>

                </div>

            </div>

        </div>



    </div>

</div>









<div class="row" style="margin-left:15px;">

    <div class="col-11">

        <table id="contacts" class="table table-striped" style="width:100%;">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Beneficiary Id</th>

                    <th>Name</th>

                    <th>Mobile</th>

                    <th>Upi Id</th>

                    <th>Account Number</th>

                    <th>Ifsc Code</th>

                    <th>Group</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($beneficiaries as $key=>$ben)

                <tr>

                    <td>{{$key+1}}</td>

                    <td><input type="checkbox" name="id[]" value="{{$ben->id}}"> {{$ben->beneficiary_id}}</td>

                    <td>{{$ben->contacts->name ?? ''}}</td>

                    <td>{{$ben->contacts->mobile ?? ''}}</td>

                    <td>{{$ben->upi_id}}</td>

                    <td>{{$ben->account_number}}</td>

                    <td>{{$ben->ifsc_code}}</td>

                    <td>{{$ben->group->group_name ?? ''}}</td>

                </tr>

                @endforeach



            </tbody>



        </table>

    </div>

</div>







<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" style="color:#1abc9c;">Add Beneficiary</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div id="paylink-add-form">

                    <ul class="nav nav-tabs">

                        <li class="active" id="add-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-paylink">Add Beneficiary</a></li>

                        <li id="add-bulk-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-bulk-paylink">Add Bulk Beneficiary</a></li>

                    </ul>

                    <div class="tab-content">

                        <div id="add-paylink" class="tab-pane fade in active">

                            <div class="form-container">

                                <div id="" class="text-center"></div>

                                <form class="form-horizontal" id="" method="POST" action="/merchant/add_single_beneficiary" autocomplete="off">

                                    <div class="form-group">

                                    <label class="control-label col-sm-4 label-left" for="amount">Contact:<span class="mandatory">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">









                                                <select class="selectpicker" name="contact_id" id="contact_id" required data-live-search="true">

                                                    <option data-tokens="">--SELECT--</option>

                                                    <option data-tokens="addnew" value="addnew" data-content="<span class='badge badge-success'>Add new</span>">Add New</option>

                                                    @foreach ($contacts as $contact)

                                                    <option data-tokens="{{$contact->id}}" value="{{$contact->id}}">{{$contact->name}}</option>

                                                    @endforeach



                                                </select>

                                            </div>



                                        </div>



                                    </div>



                                    <div id="contact" style="display:none;">





                                        <div class="row formmargins">

                                            <div>

                                                <label class="control-label col-sm-2" for="amount">Name:<span class="mandatory">*</span></label>

                                                <div class="col-sm-4">

                                                    <div class="input-group">

                                                        <input type="text" class="form-control" name="contact_name" id="" aria-describedby="basic-addon1">

                                                    </div>

                                                </div>

                                            </div>



                                            <div>

                                                <label class="control-label col-sm-2" for="contact_mobile">Mobile:<span class="mandatory">*</span></label>

                                                <div class="col-sm-4">

                                                    <input type="text" class="form-control" name="contact_mobile" id="contact_mobile" value="" placeholder="" />



                                                    <div id="paylink_for_error"></div>

                                                </div>

                                            </div>



                                        </div>



                                        <div class="row formmargins">

                                            <label class="control-label col-sm-2" for="contact_email">Email:</label>

                                            <div class="col-sm-4">

                                                <input type="email" class="form-control" name="contact_email" id="" placeholder="">



                                            </div>

                                            <label class="control-label col-sm-2" for="contact_address">Address:</label>

                                            <div class="col-sm-4">

                                                <input type="text" class="form-control" name="contact_address" id="" placeholder="">



                                            </div>

                                        </div>



                                        <div class="form-group">

                                            <label class="" for="paymentfor">State:</label>

                                            <div class="col-sm-12">

                                                <select class="form-control" name="contact_state" id="">

                                                    @foreach ($states as $state)

                                                    <option value="{{$state->id}}">{{$state->state_name}}</option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>



                                        <div class="form-group">

                                            <label class="" for="paymentfor">Pincode:</label>

                                            <div class="col-sm-12">



                                                <input type="text" class="form-control" name="contact_pincode" id="" value="" />





                                            </div>

                                        </div>

                                    </div>

                                    

                                    <div class="form-group">

                                        <label class="text-secondary control-label col-sm-4 label-left" for="contact_email">Account No:<span class="mandatory">*</span></label>

                                        <div class="col-sm-8">

                                           <div class="input-group1">

                                            <span id="accountnumber_error" class="text-danger"></span>

                                            <input type="text" class="form-control" required name="ben_acc_no" id="accountNumber" placeholder="">



                                          </div>

                                        </div>

                                    </div>

                                    





                                    <div class="form-group">

                                        <label class="text-secondary control-label col-sm-4 label-left" for="contact_address">Ifsc Code:<span class="mandatory">*</span></label>



                                        <div class="col-sm-8">

                                            <span id="ifsc_error" class="text-danger"></span>

                                            <input type="text" class="form-control" required name="ben_ifsc_no" id="ifsc" placeholder="">



                                        </div>

                                    </div>



                                    <div class="form-group">



                                        <label class="text-secondary control-label col-sm-4 label-left" for="upi_id">Upi Id:<span class="mandatory">*</span></label>

                                        <div class="col-sm-8">

                                            <span id="upi_error" class="text-danger"></span>

                                            <input type="text" class="form-control" required name="ben_upi_id" id="upi_id" value="" placeholder="" />



                                            <div id="paylink_for_error"></div>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="text-secondary control-label col-sm-4 label-left" for="paymentfor">Group:</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <select class="selectpicker" data-live-search="true">

                                                    <option data-tokens=""></option>



                                                </select>







                                            </div>

                                        </div>





                                    </div>





                                    <div class="form-group">

                                        <div class="col-sm-offset-2 col-sm-4">

                                            <button type="submit" onclick="return validator()" class="rounded-lg bg-green-600 px-3 py-2 text-white">Submit</button>

                                        </div>

                                    </div>



                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                </form>

                            </div>

                        </div>

                        <div id="add-bulk-paylink" class="tab-pane fade in">

                            <form method="POST" action="/merchant/add_bulk_beneficiaries" enctype="multipart/form-data">

                                <div class="text-center" id="paylink-bulk-response-message"></div>

                                <table class="table table-responsive">

                                    <caption class="text-center">Only Xls,Xlsx files can upload</caption>

                                    <tbody>

                                        <tr>

                                            <td for="paylinkfile">Beneficiaries File Upload</td>

                                            <td colspan="2">

                                                <input type="file" name="beneficiaries" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />

                                                <label for="file-2">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">

                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />

                                                    </svg>

                                                    <span id="paylink-bulkupload">Choose a file&hellip;</span>

                                                </label>

                                            </td>

                                            </tr>

                                            <tr>

                                            <td></td>

                                           

                                            <td><input type="submit" class="rounded-lg bg-green-600 px-3 py-2 text-white" value="Upload"></td>

                                            <td><input type="reset" id="reset-bulk-paylink-form" class="rounded-lg bg-red-600 px-3 py-2 text-white" value="Reset"></td>

                                       

                                            </tr>

                                    </tbody>

                                    <tfoot>

                                        <h5 class="text-danger">Note:Download this<a href="/download/payout_benefeciaries.xls"><strong> sample file </strong></a>for your reference</h5>

                                    </tfoot>

                                </table>

                                <input type="hidden" name="_token" value="{{csrf_token()}}">

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- deleteModal -->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-sm" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" style="color:#1abc9c;">Are You Sure ?</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">





                <form action="/merchant/delete_beneficiaries" method="POST">

                    <input type="hidden" id="delete_ids" name="delete_ids" value="">

                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                    <div class=" container" style="margin: 0 60px;">

                        <div class="columns-2">



                            <button type="submit" class="rounded-lg bg-green-600 px-3 py-2 text-white">Yes</button>

                            <button type="button" class="rounded-lg bg-red-600 px-3 py-2 text-white" data-dismiss="modal" aria-label="Close">

                                Close

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<script>

    $('input[name="id[]"]').change(function() {

        console.log(this.value);



        var searchIDs = $("input[name='id[]']:checked").map(function() {

            return $(this).val();

        }).get(); // <----

        console.log(searchIDs);

        $("#delete_ids").val(searchIDs);

        $("#edit_ids").val(searchIDs);

        $("#ben_ids").val(searchIDs);

        console.log(searchIDs.length);



        if (searchIDs.length > 0) {

            $('#options').show();

        }

        else{

            $('#options').hide();

        }

    });

</script>



<script>

    function validator() {



        var ifsc = $.trim($("#ifsc").val());

        var accountNumber = $.trim($("#accountNumber").val());

        var upiId = $.trim($("#upi_id").val());





        var accountcheck = $.ajax({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },

            type: "POST",

            async: false,

            dataType: "json",

            url: '/merchant/validate_account_number',

            data: {

                "acc": accountNumber

            }



        }).responseText;







        if (accountcheck != "Not Found") {



            $("#accountnumber_error").html("Account Number is already Registered");

            $("#accountNumber").focus();

            return false;

        } else {



            $("#accountnumber_error").html("");

        }







        var upicheck = $.ajax({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },

            type: "POST",

            async: false,

            dataType: "json",

            url: '/merchant/validate_upi',

            data: {

                "upi": upiId

            }



        }).responseText;



        console.log(upicheck)



        if (upicheck != "Not Found") {



            $("#upi_error").html("Upi Id is already Registered");

            $("#upi_id").focus();

            return false;

        } else {



            $("#upi_error").html("");

        }







        console.log(ifsc, accountNumber, upiId);



        if ((accountNumber.length === 0)) {

            console.log('acc empty');

            $("#accountnumber_error").html("Account Number is Empty");

            $("#accountNumber").focus();

            return false;

        } else if ((accountNumber.length < 9) || (accountNumber.length > 18)) {

            console.log('acc not valid');

            $("#accountnumber_error").html("Account Number is Invalid");

            $("#accountNumber").focus();

            return false;

        }





        if ((ifsc.length === 0)) {

            console.log('ifsc empty');

            $("#ifsc_error").html("IFSC Code is Empty");

            $("#ifsc").focus();

            return false;

        } else if (/^[A-Z]{4}0[A-Z0-9]{6}$/.test(ifsc) == false) {

            console.log('not valid');

            $("#ifsc_error").html("Ifsc Code is Invalid");

            $("#ifsc").focus();

            return false;

        } else if (/^[A-Z]{4}0[A-Z0-9]{6}$/.test(ifsc) == true) {

            $("#ifsc_error").html("");

        }



        if ((upiId.length === 0)) {

            console.log('Upi Id is empty');

            $("#upi_error").html("Upi Id is Empty");

            $("#upi_id").focus();

            return false;

        } else if (/^[\w.-]+@[\w.-]+$/.test(upiId) == false) {

            console.log('not valid nahi re baba');

            $("#upi_error").html("Upi Id is Invalid");

            $("#upi_id").focus();

            return false;

        }





        console.log('submitted');

        return false;

    }

</script>



<script>

    $('#contact_mobile').on('keyup keydown change', function(e) {

        if ($(this).val() > 999999999 &&

            e.keyCode !== 46 &&

            e.keyCode !== 8

        ) {

            e.preventDefault();

            $(this).val(this.value);

        }

    })

</script>











@endsection