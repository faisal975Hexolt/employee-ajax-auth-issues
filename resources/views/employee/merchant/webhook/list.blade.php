 <div class="row">
                            <div class="col-sm-12">
                               @if(empty($webhook_data))
                                   <div class="btn btn-primary pull-right btn-sm margin-bottom-lg add-webhook-admin" id="add-webhook-admin" mode="add" rowid="" mid="<?=$merchant_id?>">
                                       Add Webhook
                                   </div>
                               @endif
                           
                            </div>
                        </div>
                             <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Webhookurl</th>
                                                <th>Active</th>
                                                <th>No Events Added</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="web-hook-details">
                                            @if(!empty($webhook_data))
                                                    @foreach($webhook_data as $row)
                                                     @php

                                                        $eventscount = 0;
                                                        $tablevalues = ["webhook_url","is_active","created_date"];
                                                        $webhookURL = "";
                                                        $isActive = "";
                                                        $tablerowhtml = "";
                                                        $createdDate = "";
                                                        $rowId='';
                                                        $merchantId='';
                                                       
                                                      @endphp

                                                         @foreach($row as $key => $value)

                                                         @php

                                                                       
                                                               if($value == "Y" && $key!="is_active")
                                                               {
                                                                    $eventscount = $eventscount+1;
                                                               }
                                                               if($key == "webhook_url")
                                                               {
                                                                  $webhookURL = $value;
                                                               }
                                                               if($key == "is_active")
                                                               {
                                                                 if($value == "Y")
                                                                 {
                                                                    $isActive = "Active";
                                                                  }else{
                                                                    $isActive = "In Active";
                                                                   }
                                                               }
                                                               if($key == "created_date")
                                                               {
                                                                 $createdDate = $value;
                                                               }
                                                               if($key == "id")
                                                               {
                                                                 $rowId=$value;
                                                               }

                                                               if($key == "created_merchant")
                                                               {
                                                                 $merchantId=$value;
                                                               }
                                                         @endphp


                                                         @endforeach

                                                        <tr>
                                                            <td>{{$webhookURL}}</td>
                                                            <td>{{$isActive}}</td>
                                                            <td>{{$eventscount}} Events Added</td>
                                                            <td>{{$createdDate}}</td>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm editWebhookadmin add-webhook-admin" mode="edit" rowid="{{$rowId}}" mid="{{$merchantId}}">Edit
                                                                </button>
                                                            </td>
                                                            
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center">No Data Found</td>
                                                    </tr>
                                                @endif 
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>