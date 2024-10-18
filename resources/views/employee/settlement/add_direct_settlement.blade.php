<div id="basic">
    <div class="form-group">
        <label for="input" class="col-sm-3 control-label">Merchant:<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <select id="merchant_id" name="merchant_id" class="form-control merchant_id">
                <option value="">-select merchant-</option>
                @foreach (App\User::get_merchant_lists() as $merchant)
                    <option value="{{ $merchant->id }}">{{ $merchant->mid . ' : ' . $merchant->merchant_gid }}</option>
                @endforeach
            </select>


            <div id="merchant_id_error" class="text-danger"></div>
        </div>
    </div>



    <div class="form-group">
        <label for="input" class="col-sm-3  control-label">Amount:<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" name="direct_amount" id="direct_amount" class="form-control trans_amount"
                value="">
            <div id="direct_amount_error" class="text-danger"></div>
        </div>
    </div>

    <div class="form-group">
        <label for="input" class="col-sm-3 control-label">Transaction Type:<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <div class="form-check-inline col-sm-4">
                <label class="form-check-label">
                    <input type="radio" checked class="form-check-input" value="credit" name="transaction_type">Credit
                </label>
            </div>
            <div class="form-check-inline col-sm-4">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" value="debit" name="transaction_type">Debit
                </label>
            </div>
        </div>
    </div>


    <div class="form-group">
        <label for="input" class="col-sm-3 control-label">Description:<span class="text-danger">*</span></label>
        <div class="col-sm-8">

            <textarea name="description" id="description" class="form-control"></textarea>
            <div id="description_error" class="text-danger"></div>
        </div>
    </div>

    <input type="hidden" name="mode" value="direct">





</div>
