@if($table_name=='transaction')
    <div class="row" style="margin-top:15px;">
                                    <div class="col-sm-12 mb-5">
                                      
                                        <div class="col-sm-6">
                                            
                                              <label for="">Payment Mode</label>
                                            <select id="listmode" name="mode" class="form-control " >
                                                <option value="">All Mode</option>
                                                 @foreach (\App\Classes\Helpers::payment_report_mode()  as $r=>$mode )
                                                <option value="{{$r}}">{{ucwords($mode)}}</option>
                                                @endforeach
                                            </select>
                                            
                                            
                                        </div>

                                        <div class="col-sm-6">
                                            
                                              <label for="">Status</label>
                                            <select id="liststatus" name="status" class="form-control " >
                                               <option value="">All Status</option>
                                                 @foreach (\App\Classes\Helpers::payment_report_status()  as $r=>$status )
                                                <option value="{{$status}}">{{ucwords($status)}}</option>
                                                @endforeach
                                            </select>
                                            
                                            
                                        </div>
                                    </div>
                                    
                                </div>
              @elseif($table_name=='refund')

              <div class="row" style="margin-top:15px;">
                                    <div class="col-sm-12 mb-5">
                                      
                                        <div class="col-sm-6 hide">
                                            
                                              <label for="">Payment Mode</label>
                                            <select id="listmode" name="mode" class="form-control " >
                                                <option value="">All Mode</option>
                                                 @foreach (\App\Classes\Helpers::payment_report_mode()  as $r=>$mode )
                                                <option value="{{$r}}">{{ucwords($mode)}}</option>
                                                @endforeach
                                            </select>
                                            
                                            
                                        </div>

                                        <div class="col-sm-6 ">
                                            
                                              <label for="">Status</label>
                                            <select id="liststatus" name="status" class="form-control " >
                                               <option value="">All Status</option>
                                                 @foreach (\App\Classes\Helpers::refund_report_status()  as $r=>$status )
                                                <option value="{{$status}}">{{frefund_status($status)}}</option>
                                                @endforeach
                                            </select>
                                            
                                            
                                        </div>
                                    </div>
                                    
                                </div>


              @elseif($table_name=='settlement')

              <div class="row" style="margin-top:15px;">
                                    <div class="col-sm-12 mb-5">
                                      
                                        <div class="col-sm-6 hide">
                                            
                                              <label for="">Payment Mode</label>
                                            <select id="listmode" name="mode" class="form-control " >
                                                <option value="">All Mode</option>
                                                 @foreach (\App\Classes\Helpers::payment_report_mode()  as $r=>$mode )
                                                <option value="{{$r}}">{{ucwords($mode)}}</option>
                                                @endforeach
                                            </select>
                                            
                                            
                                        </div>

                                        <div class="col-sm-6 ">
                                            
                                              <label for="">Status</label>
                                            <select id="liststatus" name="status" class="form-control " >
                                               <option value="">All Status</option>
                                                 @foreach (\App\Classes\Helpers::settlement_report_status()  as $r=>$status )
                                                <option value="{{$status}}">{{fsettlement_status($status)}}</option>
                                                @endforeach
                                            </select>
                                            
                                            
                                        </div>
                                    </div>
                                    
                                </div>

              @endif