@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid contact-us-details">
            <div class="row">
                <div class="col-lg-6">
                    <div class="main-title">
                        <h6>You can insert multiple emails to invite.</h6>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    @if (session('success'))
                        <div class="col-lg-10 successDiv">
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        </div>
                    @endif
                    <form id="invite_new_member">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="{{ $user_id_encrypt }}" />
                        </div>
                        <div class="main-title addMoreButton">
                            <h5>Enter Emails</h5>
                            <button class="btn btn-primary add_emailsDiv">Add More</button>
                            <span class="max_warning_message_emails red" style="margin-left: 10px;"></span>
                        </div>

                        <div id="emailsDiv" class="row">
                            <!-- Original Section -->
                            <div class="col-lg-3 email-section keywod_section1">
                                <div class="form-group">
                                    <label for="emails" class="email_label">Email 1<b class="red">*</b></label>
                                    <input type="text" name="emails[]"
                                        class="form-control blackText">
                                </div>
                            </div>
                        </div>
                             <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Captcha</label>
                                            <div class="captcha_video">
                                                <span>{!! captcha_img() !!}</span>
                                                <button type="button" class="btn btn-danger captchaButton_video" class="reload_video" id="reload_video">
                                                        &#x21bb;
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Enter Captcha<b class="required">*</b></label><span class="required">{{ $errors->first('captcha') }}</span>
                                            <input id="captcha_video" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                            <span class="custom_error required" id="captcha_videos-error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="osahan-area text-center mt-3">
                                <button type="submit" class="btn btn-outline-primary"
                                    id="invite_new_member_Submit">Invite</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    @endsection
    @push('pushjs')
        @include('frontend.include.jsForDifferentPages.invite_new_members_js')
    @endpush
