

            @if($vendor=="Pythru")

                <div class="row">
                            <div class="col-sm-12">
                               @if(count($info[$vendor])<1)
                                   <div class="btn btn-primary pull-right btn-sm margin-bottom-lg add-vendor-key-admin" id="add-vendor-key-admin" mid="{{$merchant_id}}" vendor="{{$vendor}}"  rowid="">
                                       Add Keys 
                                   </div>
                               @endif
                           
                            </div>
                        </div>

                   <div id="pythrutable" >
                                    <table class="table table-striped table-bordered">
                                        <h4>Pythru</h4>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Merchant</th>
                                                <th>Merchant Alias Name</th>
                                                <th>Merchant Id</th>
                                                <th>Merchant Terminal Id</th>
                                                <th>Virtual Address</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($info[$vendor] as $index=>$pythruKeys)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$pythruKeys->name}}</td>
                                                <td>{{$pythruKeys->merchant_name}}</td>
                                                <td>{{$pythruKeys->mid}}</td>
                                                <td>{{$pythruKeys->mcc}}</td>
                                                <td>{{$pythruKeys->VPA}}</td>
                                                <td>{{ Carbon\Carbon::parse($pythruKeys->date)->format('d-m-Y H:i:s')}}</td>

                                                <td> 

                                                    <button accesskey="n" type="button" name="edit_vendor_config" mid="{{$pythruKeys->merchant_id}}" vendor="{{$vendor}}"  rowid="{{$pythruKeys->id}}" class="btn btn-success btn-sm pull-right edit_vendor_config" ><b><i class="fa fa-edit fa-fw"></i>Edit</b></button>

                                                <button class="btn btn-danger btn-sm pull-right vendorDeleteModal"  data-id="{{$pythruKeys->id}}" data-vendor="{{$vendor}}" ><i class="fa fa-trash fa-fw"></i>Delete</b></button></td>


                                                </td>
                                               

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                     @else

                        no data found

                     @endif                
