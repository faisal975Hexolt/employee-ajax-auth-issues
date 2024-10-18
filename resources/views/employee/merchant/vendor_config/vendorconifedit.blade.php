

            @if($vendor=="Pythru")
                    <!-- //Pythru -->

                

                        
                                            <div id="pythru" >
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Pythru Merchant Name:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="pythru_merchant_name" id="pythru_merchant_name" class="form-control" value="{{$info['Pythru']->merchant_name}}">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Merchant Id:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="pythru_mid" id="pythru_mid" class="form-control" value="{{$info['Pythru']->mid}}">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Merchant Terminal Id:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="pythru_mcc" id="pythru_mcc" class="form-control" value="{{$info['Pythru']->mcc}}">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Merchant Virtual Address:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="pythru_vpa" id="pythru_vpa" class="form-control" value="{{$info['Pythru']->VPA}}">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <!-- //Pythru -->

                                            <input type="hidden" name="table_row" value="{{$info['Pythru']->id}}">

            @endif


            <input type="hidden" name="merchant_id" value="{{$merchant}}">
            <input type="hidden" name="vendor_id" value="{{\App\RyapayVendorBank::where('bank_name', $vendor)->first(['id'])->id;}}">
            <input type="hidden" name="vendor" value="{{$vendor}}">
