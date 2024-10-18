                                      <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Business Type:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="business_type_id" id="business_type_id" class="form-control" required="required" disabled>
                                                        <option value="">--Select--</option>
                                                        @foreach(App\BusinessType::business_type() as $index => $businesstype)
                                                            <option {{$merchantcharge[0]->business_type_id==$businesstype->id?'selected':''}} value="{{$businesstype->id}}">{{$businesstype->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Business Category:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="business_category_id" id="business_category_id" class="form-control" required="required" disabled>
                                                        <option value="">--Select--</option>
                                                        @foreach(App\BusinessCategory::get_category() as $index => $businessCat)
                                                            <option {{$merchantcharge[0]->business_category_id==$businessCat->id?'selected':''}}  value="{{$businessCat->id}}">{{$businessCat->category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label for="input" class="col-sm-3 control-label">Business Sub Category:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="business_sub_category_id" id="business_sub_category_id" class="form-control" required="required" disabled>
                                                        <option value="">--Select--</option>
                                                        @foreach(getbusinessSubcategoryHelper($merchantcharge[0]->business_category_id) as $index => $businessCat)
                                                            <option {{$merchantcharge[0]->business_sub_category_id==$businessCat->id?'selected':''}}  value="{{$businessCat->id}}">{{$businessCat->sub_category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>