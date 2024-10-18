@if (count($result['merchant_docupdated_details']))
<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-primary lineht margTop">
            <div class="panel-heading">
                <div class="panel-title text-left">
                    Document Field Corrections
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        
                            @foreach ($result['merchant_docupdated_details'] as $row)
                                <div class="form-group">
                                    <label class="control-label col-sm-4"
                                        for="{{ $row->doc_name }}">{{ $row->file_name }}:
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="file" name="{{ $row->doc_name }}"
                                            id="{{ $row->doc_name }}file-1" uid="{{$result['merchant_id']}}" mid="{{ $row->row_id }}"
                                            class="inputfile-new form-control inputfile-2"
                                            data-multiple-caption="{count} files selected" />
                                        <label for="{{ $row->doc_name }}file-1" class="custom-file-upload">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                                viewBox="0 0 20 17">
                                                <path
                                                    d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                            </svg>

                                            <span id="{{ $row->doc_name }}_file">
                                                @if(!empty($row->is_present))
                                                    <span id="{{ $row->doc_name }}_file_exist">{{$row->file_name}}</span>
                                                @else
                                                    <span id="{{ $row->doc_name }}_file_not_exist">Choose a file...</span>
                                                @endif
                                            </span>
                                        </label>



                                        <div id="{{ $row->error }}"></div>
                                    </div>

                                    <div class="col-sm-4">

                                        @if(!empty($row->is_present))

                                            <button type="reset" data-uid="{{ $result['merchant_id'] }}" class="button125" data-name="{{$row->doc_name}}" data-id="{{$row->row_id}}">
                                                    <i class="fa fa-times"></i>
                                            </button>
                                           <a class="btn btn-success" style="color:#160606" href="/download/merchant-document/{{$row->file}}" >{{$row->file_name}}
                                               <i class="fa fa-download" style="color:rgb(21, 8, 1)"></i>
                                           </a>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                      

                    </div>
                </div>
            </div>
        </div>








        <!-- show personal details response modal starts-->

        <!-- Item personal details response modal ends-->
    </div>
</div>
  @endif