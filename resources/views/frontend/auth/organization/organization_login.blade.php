@extends('frontend.include.auth_includes.frontendauthapp')
@section('content')
   <div class="col-md-5 p-5 bg-white full-height authLeftSection">
      <div class="login-main-left">
         @include('frontend.include.auth_includes.header')
         @if(session('message'))
            <div class="alert alert-success">
               {{ session('message') }}
            </div>
         @elseif(session('error'))
            <div class="alert alert-danger">
               {{ session('error') }}
            </div>
         @endif
         <form action="{{ route('organization.login.post') }}" method="post">
         @csrf
            <div class="form-group">
               <label>Email <b class="required">*</b></label><span class="required">{{ $errors->first('email') }}</span>
               <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
               <label>Password <b class="required">*</b></label><span class="required">{{ $errors->first('password') }}</span>
               <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
               <label>Captcha <b class="required">*</b></label><span class="required">{{ $errors->first('captcha') }}</span>
               <div class="captcha">
                  <span>{!! captcha_img() !!}</span>
                  <button type="button" class="btn btn-danger captchaButton" class="reload" id="reload">
                        &#x21bb;
                  </button>
               </div>
            </div>
            <div class="form-group">
               <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">

            </div>
            <div class="mt-4">
               <div class="row">
                  <div class="col-12">
                     <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Sign In</button>
                  </div>
               </div>
            </div>
         </form>
         <div class="text-center mt-2">
            {{-- <p class="light-gray auth_P" style="font-size:13px;">Don’t have an Institution account? <a href="{{ route('organization.register') }}">Click here to sign up for Institution account</a></p> --}}
            <p class="light-gray auth_P" style="font-size:13px;">Don’t have an Institution account? <a href="{{ route('organization.register') }}">Sign Up</a></p>
         </div>
         <div class="text-center mt-0">
            <p class="light-gray auth_P">Forgot your password? <a href="{{ route('forgot.password') }}">Forgot password</a></p>
         </div>
         <div class="text-center mt-0">
            <p class="light-gray auth_P">Restore your account? <a href="{{ route('restore.account') }}">Restore account</a></p>
         </div>
      </div>
   </div>
   @include('frontend.auth.rightSection')
@endsection