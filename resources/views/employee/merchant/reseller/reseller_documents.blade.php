@extends('layouts.employeecontent')
@section('employeecontent')
    <style>
        input[type="file"] {
            display: block !important;
        }
    </style>

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- JavaScript -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    </head>
    <div class="row">
        <a href="{{ route('resellerManage') }}" class="btn btn-secondary"> <button  class="btn btn-primary">Back</button></a>
        <div class="col-sm-12 padding-20">

            


            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                action="{{ route('storeResellerDocuments') }}">
                @csrf <!-- Add CSRF token for security -->

                <!-- Reseller ID -->
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="hidden" id="reseller_id" name="reseller_id" value="{{ request()->route('id') }}"
                            class="form-control">
                        <span class="text-danger" role="alert">{{ $errors->first('reseller_id') }}</span>
                    </div>
                </div>

                <!-- PAN Card -->
                <div class="form-group">
                    <label for="pan_card" class="control-label col-sm-4">PAN Card:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="pan_card" id="pan_card">
                        <span class="text-danger" role="alert">{{ $errors->first('pan_card') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->pan_card)
                            <div>
                                <h5>Uploaded PAN Card Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'pan_card']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- Aadhar Card -->
                <div class="form-group">
                    <label for="aadhar_card" class="control-label col-sm-4">Aadhar Card:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="aadhar_card" id="aadhar_card">
                        <span class="text-danger" role="alert">{{ $errors->first('aadhar_card') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->aadhar_card)
                            <div>
                                <h5>Uploaded Aadhar Card Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'aadhar_card']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- MOA -->
                <div class="form-group">
                    <label for="moa" class="control-label col-sm-4">MOA:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="moa" id="moa">
                        <span class="text-danger" role="alert">{{ $errors->first('moa') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->moa)
                            <div>
                                <h5>Uploaded MOA Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'moa']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- AOA -->
                <div class="form-group">
                    <label for="aoa" class="control-label col-sm-4">AOA:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="aoa" id="aoa">
                        <span class="text-danger" role="alert">{{ $errors->first('aoa') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->aoa)
                            <div>
                                <h5>Uploaded AOA Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'aoa']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- GST -->
                <div class="form-group">
                    <label for="gst" class="control-label col-sm-4">GST:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="gst" id="gst">
                        <span class="text-danger" role="alert">{{ $errors->first('gst') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->gst)
                            <div>
                                <h5>Uploaded GST Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'gst']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- Business PAN -->
                <div class="form-group">
                    <label for="business_pan" class="control-label col-sm-4">Business PAN:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="business_pan" id="business_pan">
                        <span class="text-danger" role="alert">{{ $errors->first('business_pan') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->business_pan)
                            <div>
                                <h5>Uploaded Business PAN Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'business_pan']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- Incorporation -->
                <div class="form-group">
                    <label for="incorporation" class="control-label col-sm-4">Incorporation:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="incorporation" id="incorporation">
                        <span class="text-danger" role="alert">{{ $errors->first('incorporation') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->incorporation)
                            <div>
                                <h5>Uploaded Incorporation Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'incorporation']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- Cancel Cheque -->
                <div class="form-group">
                    <label for="cancel_cheque" class="control-label col-sm-4">Cancel Cheque:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="cancel_cheque" id="cancel_cheque">
                        <span class="text-danger" role="alert">{{ $errors->first('cancel_cheque') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->cancel_cheque)
                            <div>
                                <h5>Uploaded Cancel Cheque Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'cancel_cheque']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- Agreement Document -->
                <div class="form-group">
                    <label for="agreement_document" class="control-label col-sm-4">Agreement Document:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" name="agreement_document"
                            id="agreement_document">
                        <span class="text-danger" role="alert">{{ $errors->first('agreement_document') }}</span>

                        @if ($resellerDocs !=null && $resellerDocs->agreement_document)
                            <div>
                                <h5>Uploaded Agreement Document:</h5>
                                <a href="{{ route('download-reseller-document', ['resellerId' => request()->route('id'), 'file' => 'agreement_document']) }}"
                                    class="btn btn-sm btn-info" target="_blank">Download Document</a>
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>






        </div>
    </div>
@endsection
