@extends('frontend.include.auth_includes.frontendauthapp')
@section('content')
      <div class="col-md-5 p-5 bg-white full-height authLeftSection">
         <div class="login-main-left">
            @include('frontend.include.auth_includes.header')
            <form action="{{ route('reviewer.register.post') }}" method="post">
            @csrf
               <div class="form-group">
                  <label>Email <b class="required">*</b></label><span class="required">{{ $errors->first('email') }}</span>
                  <input type="text" value="{{$reviewer_email }}" class="form-control" placeholder="Enter email" readonly disabled>
                  <input type="hidden" name="email" value="{{$reviewer_email }}" class="form-control" placeholder="Enter email">
                  <input type="hidden" name="encrypted_majorcategory_id" value="{{$encrypted_majorcategory_id }}" class="form-control" placeholder="Enter email">
                  <input type="hidden" name="encrypted_roles" value="{{$encrypted_roles }}" class="form-control" placeholder="Enter email">
               </div>
               <div class="form-group">
                  <label>Password <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character."></i><b class="required">*</b></label><span class="required">{{ $errors->first('password') }}</span>
                  <input type="password" name="password" class="form-control" placeholder="Password">
               </div>
               <div class="form-group">
                  <label for="password-confirm">{{ __('Confirm Password') }} <b class="required">*</b></label>
                  <input type="password" class="form-control" name="password_confirmation">
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
                  <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Sign Up</button>
               </div>
            </form>
            <div class="text-center mt-1">
               <p class="light-gray auth_P" style="font-size:13px;">Already have an Account? <a href="{{ route('member.login') }}">Sign In</a></p>
            </div>
         </div>
      </div>
   @include('frontend.auth.rightSection')
@endsection