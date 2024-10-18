


@if($details)
<ol>
      
            <li><b><u>Status:{{$details['current_registration_status']}}</b></u></li>
            <li>GSTNO:{{$details['gstin']}}</li>
            <li>Register Date:{{$details['register_date']}}</li>
            @if($details['register_cancellation_date'])
                <li>Suspended Date:{{$details['register_cancellation_date']}}</li>
            @endif
            
            
                  </li>
</ol>

@endif