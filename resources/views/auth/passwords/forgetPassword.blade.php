@php

use App\Classes\ValidationMessage;

@endphp

@extends('layouts.password')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Reset Password <h4 class="forgot-form-heading">We'll send you an email to reset your password</h4><a href="{{'/'}}" class="back-link">Back</a></div>
                  <div class="card-body">


  
                    @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    @if (Session::has('error'))
                         <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif
  
                      <form action="{{ route('forget.password.post') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>

                        
                        
                          <div class="col-md-6 offset-md-2">
                          <div class="auth-buttons-group">

                                <input type="submit" class="purple-btn" value="Send Password Reset Link">

                            </div>
                                  
                              
                          </div>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection