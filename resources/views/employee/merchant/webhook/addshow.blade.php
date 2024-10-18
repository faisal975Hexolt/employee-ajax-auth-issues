              @if($mode=="add")




                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Webhook URL <span class="mandatory">*</span></label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="webhook_url" id="webhook_url" value="" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="secretkey" class="control-label col-sm-4">Secret key</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="secret_key" id="secret_key" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="active" class="control-label  col-sm-4">Webhook active</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="is_active" id="is_active" value="Y">
                                            </div>
                                        </div>
                                        <hr>
                                         <div class="col-sm-12 text-center">
                                            <strong style="">Events:</strong>

                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Payment Failed</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="payment_failed" id="payment_failed" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Payment Captured</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="payment_captured" id="payment_captured" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Transfer Processed</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="transfer_processed" id="transfer_processed" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Refund Processed</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="refund_processed" id="refund_processed" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Refund Created</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="refund_created" id="refund_created" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Refund Speed Changed</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="refund_speed_changed" id="refund_speed_changed" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Order Paid</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="order_paid" id="order_paid" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Dispute Created</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="dispute_created" id="dispute_created" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Dispute Won</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="dispute_won" id="dispute_won" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Dispute Lost</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="dispute_lost" id="dispute_lost" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Dispute Closed</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="dispute_closed" id="dispute_closed" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Dispute Lost</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="dispute_lost" id="dispute_lost" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Dispute Won</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="dispute_won" id="dispute_won" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Settlement Procssed</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="settlement_processed" id="settlement_processed" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Invoice Paid</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="invoice_paid" id="invoice_paid" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Invoice Partially Paid</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="invoice_partially_paid" id="invoice_partially_paid" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Invoice Expired</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="invoice_expired" id="invoice_expired" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Paylink Paid</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="paylink_paid" id="paylink_paid" value="Y">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="webhookurl" class="control-label col-sm-4">Paylink Partially Paid</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="paylink_partially_paid" id="paylink_partially_paid" value="Y">
                                            </div>
                                            <label for="webhookurl" class="control-label col-sm-4">Paylink Cancelled</label>
                                            <div class="col-sm-2 text-center">
                                                <input type="checkbox" class="center-checkbox" name="paylink_cancelled" id="paylink_cancelled" value="Y">
                                            </div>
                                        </div>
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" id="id" value="">
                                   


              @elseif($mode=="edit")

              		 @if(count($webhookdata) > 0)
                                    @foreach($webhookdata as $hook)

                                    <div class="modal-body1">
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Webhook URL <span class="mandatory">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="webhook_url" id="webhook_url" value="{{$hook->webhook_url}}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="secretkey" class="control-label col-sm-4">Secret key</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" name="secret_key" id="secret_key" value="{{$hook->secret_key}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="active" class="control-label  col-sm-4">Webhook active</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="is_active" id="is_active" value="Y" {{ ($hook->is_active == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                          <hr>  	
                                          <div class="col-sm-12 text-center">
                                            <strong style="">Events:</strong>
                                            <hr>

                                        </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Payment Failed</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="payment_failed" id="payment_failed" value="Y" {{ ($hook->payment_failed == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Payment Captured</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="payment_captured" id="payment_captured" value="Y" {{ ($hook->payment_captured == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Transfer Processed</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="transfer_processed" id="transfer_processed" value="Y" {{ ($hook->transfer_processed == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Refund Processed</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="refund_processed" id="refund_processed" value="Y" {{ ($hook->refund_processed == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Refund Created</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="refund_created" id="refund_created" value="Y" {{ ($hook->refund_created == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Refund Speed Changed</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="refund_speed_changed" id="refund_speed_changed" value="Y" {{ ($hook->refund_speed_changed == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Order Paid</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="order_paid" id="order_paid" value="Y" {{ ($hook->order_paid == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Dispute Created</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="dispute_created" id="dispute_created" value="Y" {{ ($hook->dispute_created == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Dispute Won</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="dispute_won" id="dispute_won" value="Y" {{ ($hook->dispute_won == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Dispute Lost</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="dispute_lost" id="dispute_lost" value="Y" {{ ($hook->dispute_lost == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Dispute Closed</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="dispute_closed" id="dispute_closed" value="Y" {{ ($hook->dispute_closed == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Dispute Lost</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="dispute_lost" id="dispute_lost" value="Y" {{ ($hook->dispute_lost == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Dispute Won</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="dispute_won" id="dispute_won" value="Y" {{ ($hook->dispute_won == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Settlement Procssed</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="settlement_processed" id="settlement_processed" value="Y" {{ ($hook->settlement_processed == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Invoice Paid</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="invoice_paid" id="invoice_paid" value="Y" {{ ($hook->invoice_paid == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Invoice Partially Paid</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="invoice_partially_paid" id="invoice_partially_paid" value="Y" {{ ($hook->invoice_partially_paid == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Invoice Expired</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="invoice_expired" id="invoice_expired" value="Y" {{ ($hook->invoice_expired == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Paylink Paid</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="paylink_paid" id="paylink_paid" value="Y" {{ ($hook->paylink_paid == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="webhookurl" class="control-label col-sm-4">Paylink Partially Paid</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="paylink_partially_paid" id="paylink_partially_paid" value="Y" {{ ($hook->paylink_partially_paid == 'Y') ?'checked':''}}>
                                                </div>
                                                <label for="webhookurl" class="control-label col-sm-4">Paylink Cancelled</label>
                                                <div class="col-sm-2 text-center">
                                                    <input type="checkbox" class="center-checkbox" name="paylink_cancelled" id="paylink_cancelled" value="Y" {{ ($hook->paylink_cancelled == 'Y') ?'checked':''}}>
                                                </div>
                                            </div>
                                            <input type="hidden" name="id" id="id" value="{{$hook->id}}">
                                            {{csrf_field()}}
                                        </div>


                                    @endforeach

                      @endif	

              @endif


               <input type="hidden" name="mode" id="mode" value="<?=$mode?>">
               <input type="hidden" name="merchant_id" id="merchant_id" value="<?=$merchant_id?>">
               <input type="hidden" name="rowid" id="rowid" value="<?=$rowid?>">

                