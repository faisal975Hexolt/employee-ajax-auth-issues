@if($for=='payment')
     <a href="javascript:transactionDetailsView('{{$tid}}')">{{$tid}}</a>

@elseif($for=='refund')
	<a class="btn btn-danger btn-sm" href="javascript:transactionRefund('{{$tid}}')">{{'Initiate'}}</a>
@endif