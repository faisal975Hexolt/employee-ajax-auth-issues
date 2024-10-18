                                      <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Business Type:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="business_type_id" id="business_type_id" class="form-control" required="required" readonly>
                                                        <option value="">--Select--</option>
                                                        @foreach(App\BusinessType::business_type() as $index => $businesstype)
                                                            <option  value="{{$businesstype->id}}">{{$businesstype->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            