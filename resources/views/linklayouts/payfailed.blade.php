@extends("layouts.link")
@section("content")
<div class="container">
    <div class="col-sm-12">
        <div class="message-div">
            <div class="container courses-container">
                <div class="row">
                    <div class="course-expiry">
                        <div class="container course-payink-expiry">
                            <div class="row">
                                <div class="card-header">
                                    <img src="{{ asset('new/img/s2Pay_Logo_white.png')}}" class="img-responsive card-logo" alt="{{env('APP_NAME')}}" width="120px" height="100px" >
                                    <h4 class="card-header-message">Thank you for using our {{env('APP_NAME')}}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body">
                                    <p class="card-message">
                                    Hi {{$response["emailId"]}},<br>
                                    Your {{$response["description"]}} on {{$response["date"]}} having transaction Id {{$response["transactionId"]}} 
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-footer">
                                    <p>Powered by <span class="power"><a href="/">{{env('APP_NAME_FULL')}}</a></span></p> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection