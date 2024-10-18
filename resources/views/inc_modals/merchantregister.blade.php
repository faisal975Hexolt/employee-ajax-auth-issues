<div class="modal fade register-merchant-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Add Merchant</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form id="register_merchant_form" method="post" action="{{route('register_merchant')}}" enctype="multipart/form-data" vemail="{{route('validate_merchant_mail')}}" vmobile="{{route('validate_merchant_mail')}}">
                                            {{csrf_field()}}

                                            <div class="">


                                                <div class="row" style="margin-left:10px;margin-right:10px;">
                                                    <input type="hidden" id="modalcounter" value="0">
                                                    <div class="col-12" id="personaldetails">
                                                        <div class="">
                                                            <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4>

                                                            <div class="form-group form-fit">


                    <div class="form-group col-sm-12">
                            <label for="input" class="col-sm-3 control-label">Name:<span class="mandatory">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" required="required" name="name" id="m_name" class="form-control" value="" >
                            </div>
                    </div>

                     <div class="form-group col-sm-12">
                            <label for="input" class="col-sm-3 control-label">Email:<span class="mandatory">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" required="required" name="email" id="m_email" class="form-control" value="" >
                            </div>
                    </div>
                    <input type="hidden" name="mode" value="basic">

                     <div class="form-group col-sm-12">
                            <label for="input" class="col-sm-3 control-label">Mobile:<span class="mandatory">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" required="required" name="mobile_no" id="mobile" class="form-control" value="" >
                            </div>
                    </div>


                     <div class="form-group col-sm-12">
                            <label for="input" class="col-sm-3 control-label">Password:<span class="mandatory">*</span></label>
                            <div class="col-sm-7">
                                <input type="password" required="required" name="password" id="password" class="form-control" value="" >
                            </div>
                    </div>
                   
                                                               

                                                              

                                                            </div>
                                                        </div>
                                                    </div>

                                                  

                                               

                                                   

                                                    <!-- //upload files -->
                                                    <div class="col-12" id="uploadfiles" >
                                                        <div class="">
                                                                  <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                                                <button class="btn btn-primary registerMer" id="registerMer"  type="submit">
                                                                    Submit
                                                                </button>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <!-- enduplad files -->

                                                    <div id="showerror" class="text-danger text-center my-3"></div>

                                                </div>

                                            </div>



                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>