@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid contact-us-details">
            <div class="row">
                @if (session('success'))
                    <div class="col-md-12">
                        <div class="single-video-info-content box mb-3" id="introduction">
                                <h5 align="center">Thank you.</h5>
                                <h5 align="center">Your message was successfully sent to ResearchVideos.net. We will contact you as soon as possible.</h5>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-box mar-0 form-box-borderRadius">
                                    <h4 align="center" style="word-break: break-all;">ResearchVideos</h4>
                                    <h6 class="red" style="font-size: 20px !important;">Address </h6><span>
                                        <p class="auth_P">2108 N ST STE N</p>
                                        <p class="auth_P">Sacramento, CA 95816</p>
                                        <p class="auth_P">USA</p>

                                    </span>
                                    <h6 class="red" style="font-size: 20px !important;">Email <br><span></h6>
                                    <h6 class="text-primary text-center"><img class="img-fluid" alt="" src="{{ asset('frontend/img/contact_us.png') }}"><h6>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-contact">
                                    <h6>As a representative agent, you are requesting to register your institution:</h6>
                                    <form id="institutionRregisterForm">
                                        <label class="control-label">Name <span class="required">*</span></label>
                                        <input class="form-control border-form-control" value="" placeholder="Name"
                                            type="text" name="name" id="name"><br>
                                        
                                        <label class="control-label">Institution Name <span class="required">*</span></label>
                                        <input class="form-control border-form-control" value="" placeholder="Institution Name"
                                            type="text" name="affiliation" id="affiliation"><br>

                                        <label class="control-label">Country <span class="required">*</span></label>
                                        <input class="form-control border-form-control" value="" placeholder="Country"
                                            type="text" name="country" id="country"><br>

                                        <label class="control-label">Institution Representative Email <span class="required">*</span></label>
                                        <input class="form-control border-form-control" value="" placeholder="Institution Representative Email"
                                            type="text" name="email" id="email"><br>

                                        <label class="control-label">Subject <span class="required">*</span></label>
                                        <input class="form-control border-form-control"
                                            type="text" name="subject" id="subject" value="Institution Register Request" readonly><br>

                                        <label class="control-label">Message</label>
                                        <textarea class="form-control border-form-control" placeholder="Message" name="message" id="message" rows="10"></textarea><br>

                                        <div class="captcha_contact">
                                            <span>{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-danger captchaButton_contact"
                                                class="reload_contact" id="reload_contact">
                                                &#x21bb;
                                            </button>
                                        </div>
                                        <label>Enter Captcha<b class="required">*</b></label><span
                                            class="required">{{ $errors->first('captcha') }}</span>
                                        <input id="captcha" type="text" class="form-control"
                                            placeholder="Enter Captcha" name="captcha">
                                        <span class="custom_error required" id="captcha_contact-error"></span>

                                        <div class="osahan-area text-center mt-3">
                                            <button type="submit" class="btn btn-outline-primary"
                                                id="institutionRregisterFormSendButton">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- /.container-fluid -->
    @endsection


    @push('pushjs')
        @include('frontend.include.jsForDifferentPages.institution_register_js')
    @endpush
