@extends('layouts.merchantcontent')
@section('merchantcontent')
    <style>
        .downbut {
            background: #3097d1;
            box-sizing: border-box;
            border-radius: 25px;
        }

        fieldset {
            border: revert;
            padding: 16px;
            margin-top: 16px;
        }

        .margTop {
            margin-top: -1.5%;

        }

        .lineht {
            line-height: 1.9;
        }

        .colr {
            color: #f6e084;

        }

        .padtop {
            padding-top: 4px;
        }
    </style>

    <section id="about-1" class="about-1">
        <div class="container-1">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                    <div class="content-1 pt-4 pt-lg-0">
                        <h3 class="margH">Verfication Process Corrections </h3>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!--Module Banner-->
    <div class="row">
        <div class="col-sm-12 padding-left-30">
            <div class="panel panel-default">
                <div class="panel-heading">

                </div>
                <div class="panel-body panelH">
                    <div class="tab-content">
                        <div id="business-info" class="tab-pane fade in active">
                            <form class="form-horizontal" id="personal-info-form">


                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="panel panel-primary lineht margTop">
                                            <div class="panel-heading">
                                                <div class="panel-title text-left">
                                                    Text Field Corrections
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        @if (count($merchant_updated_details))
                                                            @foreach ($merchant_updated_details as $row)
                                                                <div class="form-group">
                                                                    <label class="control-label col-sm-4"
                                                                           for="{{ $row->field_name }}">{{ $row->field_label }}:<span
                                                                                class="mandatory">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control"
                                                                               id="{{ $row->field_name }}"
                                                                               name="{{ $row->field_name }}"
                                                                               value="{{ $row->value }}"
                                                                               placeholder="{{ $row->field_name }}"
                                                                               onkeyup="ValidateRecorrect({{ $row->field_name }},{{ $row->error }});">
                                                                        <div id="{{ $row->field_name }}"></div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif


                                                    </div>
                                                </div>
                                            </div>
                                        </div>









                                    </div>
                                </div>
                                <div id="view_doc_details"></div>
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

                                                        @if (count($merchant_docupdated_details))
                                                            @foreach ($merchant_docupdated_details as $row)
                                                                <div class="form-group">
                                                                    <label class="control-label col-sm-4"
                                                                           for="{{ $row->doc_name }}">{{ $row->file_name }}:
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="{{ $row->doc_name }}"
                                                                               id="{{ $row->doc_name }}file-1"
                                                                               mid="{{ $row->row_id }}"
                                                                               class="inputfile-new form-control inputfile-2"
                                                                               data-multiple-caption="{count} files selected" />
                                                                        <label for="{{ $row->doc_name }}file-1"
                                                                               class="custom-file-upload">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                 width="20" height="17"
                                                                                 viewBox="0 0 20 17">
                                                                                <path
                                                                                        d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                                                            </svg>
                                                                            <span id="{{ $row->doc_name }}_file">

                                                                                <span
                                                                                        id="{{ $row->doc_name }}_file_not_exist">Choose
                                                                                    a
                                                                                    file...</span>

                                                                            </span>
                                                                        </label>

                                                                        <div id="{{ $row->error }}"></div>
                                                                    </div>

                                                                </div>
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>








                                        <!-- show personal details response modal starts-->

                                        <!-- Item personal details response modal ends-->
                                    </div>
                                </div>

                            </form>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
