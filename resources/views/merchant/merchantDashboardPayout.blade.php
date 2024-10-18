<div class="row">
<div class="col-sm-12">
                           <div class="c-dashboardInfo col-lg-3 col-md-6">

                            <div class="wrap">

                                <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total GTV </h4>
                                <h5 id="gtvHeading">
                                            <!-- (Last 10 days) -->
                                        </h5>
                                <span class="hind-font caption-12 c-dashboardInfo__count"  id="gtvBox">₹ {{$payoutDashboard->totalAmount}}</span>
                                <div class="icon">
                                        <i class="ion ion-ios-ribbon"></i>
                                    </div>
                            </div>

                            </div>


                            <div class="c-dashboardInfo col-lg-3 col-md-6">

                            <div class="wrap">

                                <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title"> Successful Transactions</h4>
                                <h5 id="gtvHeading">
                                            <!-- (Last 10 days) -->
                                        </h5>
                                <span class="hind-font caption-12 c-dashboardInfo__count"   id="transactionsBox">₹ {{$payoutDashboard->totalSuccessTransaction}}</span>
                                <div class="icon">
                                        <i class="ion ion-ios-paper"></i>
                                    </div>
                                    <br>
                            </div>

                            </div>

 </div>

</div>

                        
                        
                        <!-- <div class="row">
                            <div class="col-lg-6 col-xs-6">

                            
                                <div class="small-box bg-teal-active" style="text-align: center;">
                                    <div class="inner">
                                        <h3>Total GTV</h3>
                                        <h5 id="gtvHeading">
                                       
                                        </h5>
                                        <div id="gtvBox"><b>₹{{$payoutDashboard->totalAmount}}</b></div>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-ios-ribbon"></i>
                                    </div>
                                    <br>
                                </div>
                            </div> 

                            <div class="clearfix visible-xs-block"></div>
                            <div class="col-lg-6 col-xs-6">
                            
                                <div class="small-box bg-fuchsia-active" style="text-align: center;">
                                    <div class="inner">
                                        <h3>Successful Transactions</h3>
                                        <h5 id="transactionHeading">
                                         
                                        </h5>
                                        <div id="transactionsBox"><i
                                                class="fa fa-hashtag"></i><b>{{$payoutDashboard->totalSuccessTransaction}}</b>
                                        </div>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-ios-paper"></i>
                                    </div>
                                    <br>

                                </div>
                            </div>
                            <div class="clearfix visible-xs-block"></div>
                        </div> -->