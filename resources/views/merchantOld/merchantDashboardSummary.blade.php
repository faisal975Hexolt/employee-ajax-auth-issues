<?php 

$total_trans=0;

$success=0;

$failed=0;

$pending=0;

$cancelled=0;

function rate($a,$b){

    if($b==0 || $a==0){

        return 0;

    }

    $c=($a/$b)*100;

    return round($c,2);

}

foreach ($transactions['success_rate'] as $key => $value) {

        $total_trans+=$value->total;

        if($value->transaction_status=='failed'){

            $failed=$value->total;

        }elseif($value->transaction_status=='cancelled'){

            $cancelled=$value->total;

        }elseif($value->transaction_status=='success'){

            $success=$value->total;

        }elseif($value->transaction_status=='pending'){

            $pending=$value->total;

        }

    

}



$transaction_sccess_amount=0;



if(isset($transactions['payment_amount'])){

    foreach ($transactions['payment_amount'] as $key => $amount) {

        $transaction_sccess_amount+=$amount->amount;

    }

}



?>



<div id="row">
    <div class="col-md-12">

        <!-- <div class="container">  -->

            <!-- <div class="row align-items-stretch"> -->
         

                <div class="c-dashboardInfo col-lg-3 col-md-6">

                    <div class="wrap">

                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total GTV </h4><span class="hind-font caption-12 c-dashboardInfo__count">₹ {{$transaction_sccess_amount}}</span>

                    </div>

                </div>
    
                <div class="c-dashboardInfo col-lg-3 col-md-6">

                    <div class="wrap">

                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Successful Transactions</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$success}} | {{rate($success,$total_trans)}}%</span>

                    </div>

                </div>

                 <div class="c-dashboardInfo col-lg-3 col-md-6">

                    <div class="wrap">

                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Amount Refunded
                            </h4><span class="hind-font caption-12 c-dashboardInfo__count">₹ 0</span>
                    </div>

                </div>

                 <div class="c-dashboardInfo col-lg-3 col-md-6">

                    <div class="wrap">

                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">ChargeBack Amount </h4><span class="hind-font caption-12 c-dashboardInfo__count">₹ 0</span>

                    </div>

                </div>

                   <div class="c-dashboardInfo col-lg-3 col-md-6 hideItem">

                    <div class="wrap">

                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total No of Transactions</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$total_trans}}</span>

                    </div>

                </div>

                <div class="c-dashboardInfo col-lg-3 col-md-6 hideItem">

                    <div class="wrap">

                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total No of failed Transactions</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$failed}} | {{rate($failed,$total_trans)}}%</span>

                    </div>

                </div>

                <div class="c-dashboardInfo col-lg-3 col-md-6 hideItem">

                    <div class="wrap">

                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total No of Pending Transactions</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$pending}} | {{rate($pending,$total_trans)}}% </span>

                    </div>

                </div>

                <div class="c-dashboardInfo col-lg-3 col-md-6 hideItem">

                    <div class="wrap">

                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total No of Cancelled Transactions</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$cancelled}} | {{rate($cancelled,$total_trans)}}%</span>

                    </div>

                </div>
           
            <!-- </div> -->
   </div>

    <div class="col-md-12">
        <div class="social-bx tab-content"> 
                <div id="dash-graphs-summary-1" >
                    <div class="col-sm-12 col-sm-offset-1 card">
                    <div   id="gtvGraph"></div>

                    </div>
                </div>

                <div class=" hideItem">
                        <div class="col-sm-12 col-sm-offset-1">
                            <div class="box" id="graph-summary-1">
                            </div>
                        </div>
                </div> 

        </div>
    </div> 
    
    <div class="col-md-12">
          <div class="social-bx tab-content"> 

                <div class="col-sm-6 col-sm-offset-1 card col-sm-6-dash">

                        <div class="box" id="graph-summary-2">

                        </div>

                </div>

            

                <div class="col-sm-6 col-sm-offset-1 card col-sm-6-dash">

                            <div class="box" id="graph-summary-3">

                                    

                        </div>

                </div>
            </div>

    </div> 

</div>


