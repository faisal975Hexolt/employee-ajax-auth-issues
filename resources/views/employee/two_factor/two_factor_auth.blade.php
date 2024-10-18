@extends('layouts.employeecontent')
@section('employeecontent')
<script src="https://unpkg.com/@bitjson/qr-code@1.0.2/dist/qr-code.js"></script>
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="{{session('page-active')?'':'active'}}"><a data-toggle="tab" class="show-pointer" data-target="#mydetails">Authentication</a></li>
                    
            </div>
            <style>

.switch {

  position: relative;

  display: inline-block;

  width: 60px;

  height: 34px;

}



.switch input { 

  opacity: 0;

  width: 0;

  height: 0;

}



.slider {

  position: absolute;

  cursor: pointer;

  top: 0;

  left: 0;

  right: 0;

  bottom: 0;

  background-color: #ccc;

  -webkit-transition: .4s;

  transition: .4s;

}



.slider:before {

  position: absolute;

  content: "";

  height: 26px;

  width: 26px;

  left: 4px;

  bottom: 4px;

  background-color: white;

  -webkit-transition: .4s;

  transition: .4s;

}



input:checked + .slider {

  background-color: #2196F3;

}



input:focus + .slider {

  box-shadow: 0 0 1px #2196F3;

}


.form-horizontal .form-group {
    margin-left: 10px;
    margin-right: 10px;
}
input:checked + .slider:before {

  -webkit-transform: translateX(26px);

  -ms-transform: translateX(26px);

  transform: translateX(26px);

}



/* Rounded sliders */

.slider.round {

  border-radius: 34px;

}



.slider.round:before {

  border-radius: 50%;

}



.text-bold {

    font-weight: bold;

}

</style>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="mydetails" class="tab-pane fade {{session('page-active')?'':'in active'}}">
                        <div class="row">
                            <div class="col-sm-12">
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                    <div>
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>Error!</strong>{{$error}}
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                                @if(session("message"))
                                    <div>
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>Success!</strong> {{session("message")}}
                                        </div>                                        
                                    </div>
                                @endif

                                @if(session('success'))

                                     <div>
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>Success!</strong> {{session("success")}}
                                        </div>                                        
                                    </div>

                              @endif

                              @if(session('error'))

                                             <div>
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>Error!</strong>{{session('error')}}
                                        </div>
                                    </div>

                                  @endif
                                      @if($user->tf_auth == 1)
                                      <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                                        <form class="form-horizontal" action="{{ route('employee.2fa_auth') }}" method="post" autocomplete="off">
                                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                                          <div class="card">
                                            <div class="card-header" style="background-color: #FFFFFF;">
                                              <h4 class="card-title mb-1">TWO FACTOR AUTHENTICATION</h4>
                                              <br>
                                              <hr>
                                            </div>
                                            <div class="card-body pt-0">
                                              <div class="form-group1">
                                                <label class="text-bold">2FA AUTHENTICATION STATUS</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label class="switch">
                                                  <input type="checkbox" name="tfa_status" {{ $user->tf_auth == 1 ? 'checked' : '' }} >
                                                  <span class="slider"></span>
                                                </label>
                                              </div>
                                              <div class="row">
                                                <div class="form-group" style="text-align-last: center;">
                                                  <label for="" class="text-bold">BACKUP CODES</label>
                                                  @forelse($codes_arr as $code)
                                                  <p class="text-bold">{{ $code }}</p>
                                                  @empty
                                                  <p class="text-bold">GENERATED AFTER 2FA CONFIGURATION</p>
                                                  @endforelse
                                                </div>
                                              </div>
                                              <div class="form-group mb-0 mt-3 justify-content-end" >
                                                <div>
                                                  <button type="submit" name="" class="btn btn-success" style="float:right;font-size:20px;">Update</button>
                                                </div>
                                              </div>
                                              <input type="hidden" name="user_id" value="{{ $userId }}">
                                              <input type="hidden" name="tfa_secret" value="{{ $tf_auth_secret }}">
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                      @else
                                      <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                                        <form class="form-horizontal" action="{{ route('employee.2fa_auth') }}" method="post" autocomplete="off">
                                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                                          <div class="card box-shadow-0">
                                            <div class="card-header" style="background-color: #FFFFFF;">
                                              <h4 class="card-title mb-1">STEPS TO CONFIGURE 2FA</h4>
                                              <hr>
                                            </div>
                                            <div class="card-body pt-0">
                                              <ul class="text-bold">
                                                <li>Step 1 - SCAN THE FOLLOWING QR CODE WITH A TWO-FACTOR AUTHENTICATION APP ON YOUR PHONE.</li><br>
                                                <!-- <img id="2fa_configuration" src="{{ $qr_link }}"> -->
                                                <qr-code
                        id="qr1"
                        contents="{{ $qr_link }}"
                        module-color="#000000"
                        position-ring-color="#000000"
                        position-center-color="#000000"
                        mask-x-to-y-ratio="1.2"
                        style="
                          width: 200px;
                          height: 200px;
                          margin: 2em auto;
                          background-color: #fff;
                        "
                      >
                        Scan
                      </qr-code>

                                                
                                                <br><br>
                                                <li>Step 2 - ENTER THE SECURITY CODE GENERATED BY YOUR TWO-FACTOR AUTHENTICATION APP..</li><br>
                                                <input type="text" style="font-size:25px;width:50%;" class="form-control" name="otp"><br><br>
                                                <li>Step 3- CLICK ON UPDATE.</li><br>
                                                <button type="submit" name="" class="btn btn-success" style="float:right;font-size:20px;">Update</button>
                                              </ul>
                                            </div>
                                            <input type="hidden" name="tfa_status" value="1">
                                            <input type="hidden" name="user_id" value="{{ $userId }}">
                                            <input type="hidden" name="tfa_secret" value="{{ $tf_auth_secret }}">
                                          </div>
                                        </form>
                                      </div>
                                      @endif
                            </div>
                        </div>
                    </div>
                   
                 
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
