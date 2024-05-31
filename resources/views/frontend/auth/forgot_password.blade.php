@extends('frontend.include.auth_includes.frontendauthapp')
@section('content')
               <div class="col-md-5 p-5 bg-white full-height authLeftSection">
                  <div class="login-main-left">
                     @include('frontend.include.auth_includes.header')
                     @if(session('message'))
                        <div class="alert alert-success">
                           {{ session('message') }}
                        </div>
                     @endif
                     <form action="{{ route('forget.password.post') }}" method="POST">
                     @csrf
                        <div class="form-group">
                           <label>Enter Registered Email <b class="required">*</b></label><span class="required">{{ $errors->first('email') }}</span>
                           <input type="text" name="email" class="form-control" placeholder="Enter Registered Email">
                        </div>
                        <div class="mt-4">
                           <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Send Password Reset Link</button>
                        </div>
                     </form>
                     <div class="text-center mt-5">
                        <p class="light-gray auth_P">Don’t have an account? <a href="{{ route('member.register') }}">Sign Up</a></p>
                     </div>
                  </div>
               </div>
   @include('frontend.auth.rightSection')
@endsection