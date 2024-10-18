@php
    use App\User;
    $merchants = User::get_tmode_docupload_merchants();
@endphp 

@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="documentt-verify">Document Verify</a></li>  
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="#documentt-verify" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('merchant-document','paysel-7WRwwggm')}}" class="btn btn-primary btn-sm pull-right">Go Back</a>
                            </div>
                        </div>
                        <div class="row padding-10">
                            <div class="col-sm-12">
                                @if($module == "docscreen")
                                    @if($form == "create")
                                        <form id="merchant-details-form" method="POST" class="form-horizontal">
                                        <table class="table table-bordered table-hover">
                                        <thead>
                                                    <tr>
                                                        <th>Feild Name</th>
                                                        <th>Value</th>
                                                        <th>Remark</th>
                                                        <th width="40%">Details</th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($merchant_details as $index => $merchant_detail)
                                            <tr  class="{{$merchant_detail->field_verified=='N'?'needupdated':'updated'}}">
                                            <td>
                                                
                                               {{$merchant_detail->field_label}}
                                              </td>
                                            <td>
                                                      {{$merchant_detail->field_value}}
                                            </td>
                                            <td>  <div class="form-group">
                                                <div class="radio">
                                                     <label>
                                                         @if($merchant_detail->field_verified =='Y')
                                                            {{'No Correction'}}
                                                         @else
                                                            {{'Correction'}}
                                                         @endif
                                                     </label>

                                                   
                                                </div>
                                            </div></td>
                                            <td>

                                                @if($merchant_detail->kycResult)
                                                  @if(in_array($merchant_detail->field_name, array('mer_aadhar_number','comp_gst','bank_acc_no','bank_ifsc_code','mer_pan_number','comp_pan_number','comp_cin')))
                                                     @include('inc_views.kyc_box_2',['kyc' => $merchant_detail]) 
                                                  @else
                                                     @include('inc_views.kyc_box_1',['kyc' => $merchant_detail]) 
                                                  @endif
                                                      
                                                @endif
                                            </td>
                                                        
                                            
                                            
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        </form>
                                        <form id="document-details-form" method="POST" class="form-horizontal">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>File</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($documents as $index => $value)
                                                    <tr class="{{$value->doc_verified=='N'?'needupdated':'updated'}}">
                                                        <td>{{$value->file_name}}</td>
                                                        <td>
                                                            <div class="col-sm-12">
                                                               
                                                                <div id="{{$value->doc_name}}_error"></div>
                                                            </div>
                                                            @if(!empty($value->file_ext))
                                                            <a href="{{URL::to('/')}}/document-verify/download/merchant-document/{{$folder_name}}/{{$value->file_ext}}">{{$value->file_name}}</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="radio">

                                                                 <label>
                                                         @if($value->doc_verified =='Y')
                                                            {{'No Correction'}}
                                                         @else
                                                            {{'Correction'}}
                                                         @endif
                                                     </label>
                                                               
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </form>
                                        <div class="row">
                                           
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                       
                                              
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
