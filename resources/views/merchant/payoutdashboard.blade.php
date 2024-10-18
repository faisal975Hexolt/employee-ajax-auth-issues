@extends('layouts.merchantcontent')

@section('merchantcontent')



 <link href="{{ asset('css/ionicons_fonts.css') }}" rel="stylesheet">

<section id="about-1" class="about-1 ">

    <div class="container-1">



        <div class="row">

            <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">

                <div class="content-1 pt-4 pt-lg-0">



                    <h3>Welcome to Payout Dashboard</h3>


                </div>

            </div>
        </div>
    </div>
</section>



<section class="content">
    <!-- Your Page Content Here -->
    <img class="filter-loader" style="display: none;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <!-- Default box -->
                <div class="box">
                    <div class="box-header with-border">
                        <div class="col-sm-12 no-padding">
                            <div class="form-group" id="report_selection_range_id">
                                <label for="dashboard_selection_range" class="control-label col-sm-4 required pull-right"
                                   >Select date range:</label>

 

                                 <div class="social-bx tab-content">
                                <div class="src">
                                    <form id="dashboard-form-payout">

                                        <input class="form-control payouttopmarg" id="dash_date_range_payout"
                                            name="dash_date_range_payout"  readonly placeholder="MM/DD/YYYY" type="text" value="">

                                        <input type="hidden" name="dash_from_date"
                                            value="{{session('dash_from_date')}}">

                                        <input type="hidden" name="dash_to_date" value="{{session('dash_to_date')}}">

                                        <input type="hidden" name="perpage" value="10">
                                        <i class="fa fa-calendar dash-fa-calendar-summary payouttopmarg"></i>
                                        <input type="hidden" name="module" value="dash_payout">

                                        {{csrf_field()}}

                                    </form>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                        <div id="dashboard_payout_summary_view"></div>
                        <!-- /.box-body -->
                        <!--
                            <div class="box-footer">
                                Box Footer Content
                            </div>
                            -->
                        <!-- /.box-footer-->
                    </div>
                    <!-- /.box -->

                </div>
            </div>
        </div>

        <div class="row transrow"> 
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title" id="gtvTitle">Gross Transaction Value and Transaction Count
                            <!-- (Last 10 days) -->
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="gtvGraph"></div>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>

    </div>
</section>





<script>
document.addEventListener("DOMContentLoaded", function() {

    getDashboardPayout();



});
</script>


@endsection