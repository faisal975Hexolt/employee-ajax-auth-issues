
@if($for=='all')

<button class="btn btn-success btn-sm" onclick="MakeMerchantLive('{{$approvedmerchant->id}}',this)">Make Live</button>
                  
                   
                    <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#passwordModal" data-merchantid={{$approvedmerchant->id}} >
                               Change Password
                    </button> -->
                    <a href="{{route('merchant-details-view',$approvedmerchant->id)}}" class="edit btn btn-success btn-sm"><ion-icon name="create-outline"></ion-icon></a>
         @elseif($for=='account_status') 
         	{{ucwords($approvedmerchant->merchant_status)}}
          <button style="{{$approvedmerchant->merchant_status == 'active'?'':'display:none'}}" id="inactive-btn" class="btn btn-danger btn-sm merchant-inactive-btn" onclick="MakeMerchantInactive('{{$approvedmerchant->id}}',this)" data-merchantstatus={{$approvedmerchant->merchant_status}}>Make Inactive</button>
                    <button style="{{$approvedmerchant->merchant_status == 'active'?'display:none':''}}" id="active-btn" class="btn btn-primary btn-sm  merchant-active-btn" onclick="MakeMerchantInactive('{{$approvedmerchant->id}}',this)" data-merchantstatus={{$approvedmerchant->merchant_status}}>Make active</button>
                      
         @else
            <a href="javascript:void(0)" onclick="verifyMerchantDetails('{{$approvedmerchant->id}}')">{{$approvedmerchant->merchant_gid}}</a>

          @endif