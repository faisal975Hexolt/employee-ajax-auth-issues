@php use Carbon\Carbon;@endphp
 @if($mode=="edit")
                                            <div id="edit" >
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Merchant Name:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="e_name" id="e_name" class="form-control" value="{{$info['data']->name}}" disabled>
                                                        <div id="e_name_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="settlement_brief_gid" value="{{$info['data']->settlement_brief_gid}}">

                                                

                                              

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Period:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="transaction_form" id="transaction_form" class="form-control" disabled value="{{Carbon::parse($info['data']->transaction_form)->format('jS M Y h:i:s A') }}">
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <input type="text" name="transaction_to" id="transaction_to" class="form-control" disabled value="{{Carbon::parse($info['data']->transaction_to)->format('jS M Y h:i:s A') }}">
                                                    </div>
                                                </div>


                                                 <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Transaction Amount:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="transaction_amount" id="transaction_amount" class="form-control" disabled value="{{$info['data']->transaction_amount}}">
                                                    </div>

                                                   
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Transaction Charges:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="transaction_total_charged_amount" id="transaction_total_charged_amount" class="form-control" disabled value="{{$info['data']->transaction_total_charged_amount}}">
                                                    </div>

                                                   
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Transaction Adjustments:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="transaction_total_adjustment" id="transaction_total_adjustment" class="form-control" disabled value="{{$info['data']->transaction_total_adjustment}}">
                                                    </div>

                                                   
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Transaction Refunds:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="transaction_total_refunded" id="transaction_total_refunded" class="form-control" disabled value="{{$info['data']->transaction_total_refunded}}">
                                                    </div>

                                                   
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Settling Amount:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="transaction_total_settlement" id="transaction_total_settlement" class="form-control" disabled value="{{$info['data']->transaction_total_settlement}}">
                                                    </div>

                                                   
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Status:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="transaction_form" id="transaction_form" class="form-control" disabled value="{{ucwords($info['data']->settlement_status)}}">
                                                    </div>

                                                   
                                                </div>



                                                 <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">UTR No:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="bank_utr" id="bank_utr" class="form-control"  value="{{ucwords($info['data']->bank_utr)}}">

                                                        <small class="text-sm-left"  id="bank_utr_ajax_error">{{ $errors->first('bank_utr') }}</small>

                                                    </div>

                                                   
                                                </div>
                                         </div>
            @endif