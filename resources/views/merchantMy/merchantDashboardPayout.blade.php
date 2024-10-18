 <div class="row">
                            <div class="col-lg-6 col-xs-6">

                                <!-- small box -->
                                <div class="small-box bg-teal-active" style="text-align: center;">
                                    <div class="inner">
                                        <h3>Total GTV</h3>
                                        <h5 id="gtvHeading">
                                            <!-- (Last 10 days) -->
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
                                <!-- small box -->
                                <div class="small-box bg-fuchsia-active" style="text-align: center;">
                                    <div class="inner">
                                        <h3>Successful Transactions</h3>
                                        <h5 id="transactionHeading">
                                            <!-- (Last 10 days) -->
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
                        </div>