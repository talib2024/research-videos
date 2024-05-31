@extends('frontend.include.auth_includes.frontendauthapp')
@section('content')
      <div class="col-md-5 p-5 bg-white full-height authLeftSection">
         <div class="login-main-left">
            @include('frontend.include.auth_includes.header')
            <form action="{{ route('organization.register.post') }}" method="post" autoComplete="off">
            @csrf
               {{-- <div class="form-group">
                  <label for="organization_type"
                        class="organization_type_level">Institution Type<b class="red">*</b></label>
                  <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input"
                           name="organization_type" id="main_organization"
                           value="1" checked="checked" {{ old('organization_type') == 1 ? 'checked' : ''}}>
                        <label class="custom-control-label common_text_size"
                           for="main_organization">Select if registering as a main institute.</label>
                  </div>
                  <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input"
                           name="organization_type" id="employee_of_organization"
                           value="2" {{ old('organization_type') == 2 ? 'checked' : ''}}>
                        <label class="custom-control-label common_text_size"
                           for="employee_of_organization">Select if registering as an employee of any institute.</label>
                  </div>
               </div> --}}
               
               {{-- <div class="form-group main_organization_div" style="display:none;">
                  <label>Institute Name <b class="required">*</b></label><span class="required">{{ $errors->first('main_institute_name') }}</span>
                  <input type="text" name="main_institute_name" value="{{ old('main_institute_name') }}" class="form-control" placeholder="Enter Institute Name">
               </div>
               <div class="form-group employee_of_organization_div" style="display:none;">
                  <label>Institute Name <b class="required">*</b></label><span class="required">{{ $errors->first('employee_institute_name') }}</span>
                  <input type="text" name="employee_institute_name" id="employee_institute_name" value="{{ old('employee_institute_name') }}" class="form-control" placeholder="Enter Institute Name">
                  <input type="hidden" name="institute_id" id="institute_id" value="{{ old('institute_id') }}" class="form-control" required readonly>
                  <div id="employee_institute_name_list" class="dropdown"></div> 
               </div> --}}
               <div class="form-group">
                  <label>Email <b class="required">*</b></label><span class="required">{{ $errors->first('email') }}</span>
                  <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter work email">
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
               {{-- <p class="light-gray auth_P">Already have an institution account? <a href="{{ route('organization.login') }}">Click here to sign in for Institution</a></p> --}}
               <p class="light-gray auth_P">Already have an institution account? <a href="{{ route('organization.login') }}">Sign In</a></p>
            </div>
         </div>
      </div>
   @include('frontend.auth.rightSection')
@endsection