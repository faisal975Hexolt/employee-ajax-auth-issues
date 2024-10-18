

@php $details=$kyc->kycResult; @endphp

@if($merchant_detail->field_name=='mer_aadhar_number')
<ol>
      <li>Name:{{$details['user_full_name']}}</li>
      <li>DOB:{{$details['user_dob']}}</li>
      <li>Address:
             <ul>
                  @foreach($details['user_address'] as $rkey => $rvalue)
                        <li><b>{{ucwords($rkey)}}</b> : {{$rvalue }}</li>
                  @endforeach
             </ul>
      </li>
</ol>
@elseif($merchant_detail->field_name=='comp_gst')

      <ol>
            <li>Business Constitution:{{$details['business_constitution']}}</li>
            <li>Business Nature:
                  <ul>
                        @foreach($details['business_nature'] as $rkey => $rvalue)
                              <li>{{$rvalue }}</li>
                        @endforeach
                  </ul>
            </li>

            <li>
                Central Jurisdiction:{{$details['central_jurisdiction']}}
            </li>
            <li>Status:{{$details['current_registration_status']}}</li>
            <li>GSTNO:{{$details['gstin']}}</li>
            <li>Legal Name:{{$details['legal_name']}}</li>
            
            <li>Register Date:{{$details['register_date']}}</li>
            @if($details['register_cancellation_date'])
                <li>Cancel Date:{{$details['register_cancellation_date']}}</li>
            @endif
            <li>Address :
                  <ul>
                  @foreach($details['primary_business_address'] as $rkey => $rvalue)
                  
                        <li>{{$rkey}}: {{$rvalue }}</li>
                  
                 @endforeach
                  </ul>
            
      </ul>

      @elseif($merchant_detail->field_name=='bank_acc_no')
        <ol>
           <li>Beneficiary name:{{$details['beneficiary_name']}}</li>
           <li>Status : {{$details['verification_status']}}</li>
       </ol>

       
       @elseif($merchant_detail->field_name=='mer_pan_number')
        <ol>
           <li>No:{{$details['pan_number']}}</li>
           <li>Status : {{$details['pan_status']}}</li>
           <li>Name : {{$details['user_full_name']}}</li> 
           <li>Type : {{$details['pan_type']}}</li> 
          
      </ol>
      @elseif($merchant_detail->field_name=='comp_pan_number')
        <ol>
           <li>No:{{$details['pan_number']}}</li>
           <li>Status : {{$details['pan_status']}}</li>
           <li>Name : {{$details['user_full_name']}}</li> 
           <li>Type : {{$details['pan_type']}}</li> 
          
      </ol>

      @elseif($merchant_detail->field_name=='bank_ifsc_code')

      <ol>
      <li>Address:{{$details['address']}}</li>
    

      <li>
          Bank:{{$details['bank']}}
      </li>
      <li>Branch:{{$details['branch']}}</li>
      <li>Code:{{$details['ifsc']}}</li>
      <li>Details:{{$details['centre'] ."|".$details['city']."|".$details['district']}}</li>
      <li>MICR:{{$details['micr']}}</li>
    
      </ol>

      @elseif($merchant_detail->field_name=='comp_cin')

      <ol>
            <li>Company Name:{{$details['company_info']['company_name']}}</li>
            <li>Type:{{$details['company_info']['company_type']}}</li>
            <li>Registration Type:{{$details['company_info']['registration_number']}}</li>
            <li>Roc Code:{{$details['company_info']['roc_code']}}</li>
            <li>Category:{{$details['company_info']['company_category']}}</li>
            <li>Date_of_Incorporation:{{$details['company_info']['date_of_incorporation']}}</li>
            @if(gettype($details['company_info']['primary_registered_address'])=='array' )
                   
            @else
                   <li>Address:{{$details['company_info']['primary_registered_address']}}</li>
            @endif
           
            <li>Directors: Total <strong>{{count($details['directors_info'] )}}</strong>
                  
                        @foreach($details['directors_info'] as $rkey => $rvalue)
                        <ul>
                              <li>Din Number: {{$rvalue['din_number'] }}</li>
                              <li>Name: {{$rvalue['director_name'] }}</li>
                              <li>Start date: {{$rvalue['start_date'] }}</li>
                              <li>End date: {{$rvalue['end_date'] }}</li>
                              <li>Surrendered din: {{$rvalue['surrendered_din'] }}</li>
                        </ul>
                              ----------------------------
                        @endforeach
                        
                  
            </li>
           
            
      </ol>
      
      @endif


