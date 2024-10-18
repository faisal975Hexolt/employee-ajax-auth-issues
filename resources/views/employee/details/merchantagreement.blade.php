<?php $merchnatAgreement = $data['merchnatAgreement']; ?>
<div class="form-group">
    <label class="control-label col-sm-4" for="comp_pan_card">Agreement
        Document: <span class="text-danger">*</span></label>
    <div class="col-sm-4">
        <input type="file" name="agreement_file" id="file-agreement" class="inputfile form-control inputfile-agreement"
            uid="{{ $merchnatAgreement['created_merchant'] }}" />
        <label for="file-agreement" class="custom-file-upload">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                <path
                    d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
            </svg>
            <span id="comp_pan_card_file">
                @if (!empty($merchnatAgreement['agreement_file']))
                    <span id="comp_pan_card_file_exist">{{ $merchnatAgreement['agreement_file'] }}</span>
                @else
                    <span id="comp_pan_card_file_not_exist">Choose a
                        file...</span>
                @endif
            </span>
        </label>
        @if (!empty($merchnatAgreement['agreement_file']))
            <button type="reset" class="buttonA125" data-name="agreement_file"
                data-id="{{ $merchnatAgreement['id'] }}" data-uid="{{ $merchnatAgreement['created_merchant'] }}">
                <i class="fa fa-times"></i>
            </button>
        @endif
        <div id="agreement_file_error"></div>
    </div>
    <div class="col-sm-4">
        @if (!empty($merchnatAgreement['agreement_file']))
            <a class="btn btn-success" style="color:#160606"
                href="{{ route('admin-download-agreement', [$merchnatAgreement['merchant_gid'], $merchnatAgreement['agreement_file']]) }} ">{{ $merchnatAgreement['agreement_file'] }}
                <i class="fa fa-download" style="color:rgb(21, 8, 1)"></i>
            </a>
        @endif
    </div>
</div>


@if (isset($data['merchnatAgreement']))

    @if ($merchnatAgreement['agreement_esigned_file'])
        <div class="form-group">
            <label class="control-label col-sm-4" for="comp_pan_card">Signed Agreement
                Document: <span class="text-danger">*</span></label>

            <div class="col-sm-4">

                <a class="btn btn-success" style="color:#160606"
                    href=" {{ route('admin-download-agreement', [$merchnatAgreement['merchant_gid'], $merchnatAgreement['agreement_esigned_file']]) }}">{{ 'Download' }}
                    <i class="fa fa-download" style="color:rgb(21, 8, 1)"></i>
                </a>
            </div>


        </div>
    @endif
@endif
