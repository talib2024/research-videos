@extends('frontend.include.auth_includes.frontendauthapp')
@section('content')
               <div class="col-md-5 p-5 bg-white full-height authLeftSection">
                  <div class="login-main-left">
                     @include('frontend.include.auth_includes.header')
                     @if(session('error'))
                        <div class="alert alert-danger">
                           {{ session('error') }}
                        </div>
                     @endif
                     <form action="{{ route('reset.password.post') }}" method="POST">
                     @csrf
                        <div class="form-group">
                           <label>Email</label><span class="required">{{ $errors->first('email') }}</span>
                           <input type="text" name="email" value="{{ $user_email }}" class="form-control" readonly>
                           <input type="hidden" name="token" value="{{ $token }}">
                        </div>
                        <div class="form-group">
                           <label>Password <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character."></i><b class="required">*</b></label><span class="required">{{ $errors->first('password') }}</span>
                           <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                           <label for="password-confirm">{{ __('Confirm Password') }} <b class="required">*</b></label>
                           <input type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="mt-4">
                           <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Reset Password</button>
                        </div>
                     </form>
                     {{-- <div class="text-center mt-5">
                        <p class="light-gray">Already have an Account? <a href="{{ route('member.login') }}">Sign In</a></p>
                     </div> --}}
                  </div>
               </div>
   @include('frontend.auth.rightSection')
@endsection