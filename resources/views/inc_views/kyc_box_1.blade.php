@if($merchant_detail->field_name!='comp_gst1')
@foreach(($merchant_detail->kycResult) as $key => $value)
                                
                   <b> {{ $key }}: </b>
                      @if(gettype($value)=='string')
                      {{$value}}
                            @elseif(gettype($value)=='array')
                            [
                            @foreach($value as $rkey => $rvalue)
                            <b> {{ $rkey." : ".$rvalue."," }} </b>
                            @endforeach
                            ]

                      @endif
                    
                    
                    <br>
@endforeach
@endif