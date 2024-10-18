@if(!empty($merchantusage))

<div class="form-group form-fit">
    <label for="input" class="col-sm-3 control-label">Merchant Id:</label>
    <div class="col-sm-7">
        <input type="hidden" name="created_merchant" id="created_merchant" value="{{$merchantusage->created_merchant}}">
        <select name="created_merchant1" id="created_merchant1" class="form-control " disabled required="required"
            onchange="getMerchantBusinessType(this,'merchant-routing-form')">
            <option value="">--Select--</option>
            @foreach(App\User::get_merchant_gids() as $index => $merchant)
            <option {{$merchantusage->created_merchant==$merchant->id?'selected':''}} value="{{$merchant->id}}">{{$merchant->merchant_gid}}</option>
            @endforeach
        </select>
        <div id="created_merchant_error" class="text-danger"></div>
    </div>

</div>



<div class="form-group form-fit">
    <label for="input" class="col-sm-3 control-label">Minimum Ticket Size:<span class="text-danger">*</span></label>
    <div class="col-sm-7">
        <input type="text" name="minimum_ticket_size" id="minimum_ticket_size" class="form-control" value="{{$merchantusage->minimum_ticket_size}}"  placeholder="Minimum Ticket Size">
        <div id="minimum_ticket_size_error" class="text-danger"></div>
    </div>
    
</div>

<div class="form-group form-fit">
    <label for="input" class="col-sm-3 control-label">Maximum Ticket Size:<span class="text-danger">*</span></label>
    <div class="col-sm-7">
        <input type="text" name="maximum_ticket_size" id="maximum_ticket_size" class="form-control" value="{{$merchantusage->maximum_ticket_size}}"  placeholder="Maximum Ticket Size">
        <div id="maximum_ticket_size_error" class="text-danger"></div>
    </div>
    
</div>


<div class="form-group form-fit">
    <label for="input" class="col-sm-3 control-label">Daily Total Limit:<span class="text-danger">*</span></label>
    <div class="col-sm-7">
        <input type="text" name="daily_total_limit" id="daily_total_limit" class="form-control" value="{{$merchantusage->daily_total_limit}}" placeholder="Daily Total Limit">
        <div id="daily_total_limit_error" class="text-danger"></div>
    </div>
    
</div>



@else
<div class="form-group form-fit">
    <label for="input" class="col-sm-3 control-label">Merchant Id :</label>
    <div class="col-sm-7">
        <select name="created_merchant" id="merchant_list_usage" class="form-control merchant_list_usage" required="required"
            onchange="getMerchantBusinessType(this,'merchant-routing-form')">
            {{-- <option value="">--Select--</option> --}}
            {{-- @foreach(App\User::get_merchant_gids() as $index => $merchant)
            <option value="{{$merchant->id}}">{{$merchant->merchant_gid}}</option>
            @endforeach --}}
        </select>
        <div id="created_merchant_error" class="text-danger"></div>
    </div>

</div>



<div class="form-group form-fit">
    <label for="input" class="col-sm-3 control-label">Minimum Ticket Size:<span class="text-danger">*</span></label>
    <div class="col-sm-7">
        <input type="text" name="minimum_ticket_size" id="minimum_ticket_size" class="form-control" value=""  placeholder="Minimum Ticket Size">
        <div id="minimum_ticket_size_error" class="text-danger"></div>
    </div>
    
</div>

<div class="form-group form-fit">
    <label for="input" class="col-sm-3 control-label">Maximum Ticket Size:<span class="text-danger">*</span></label>
    <div class="col-sm-7">
        <input type="text" name="maximum_ticket_size" id="maximum_ticket_size" class="form-control" value=""  placeholder="Maximum Ticket Size">
        <div id="maximum_ticket_size_error" class="text-danger"></div>
    </div>
    
</div>


<div class="form-group form-fit">
    <label for="input" class="col-sm-3 control-label">Daily Total Limit:<span class="text-danger">*</span></label>
    <div class="col-sm-7">
        <input type="text" name="daily_total_limit" id="daily_total_limit" class="form-control" value="" placeholder="Daily Total Limit">
        <div id="daily_total_limit_error" class="text-danger"></div>
    </div>
    
</div>

@endif


