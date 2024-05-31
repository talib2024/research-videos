@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid contact-us-details">
            <div class="row">
                <div class="col-lg-2">
                    <div class="main-title">
                        <h6>Please accept or deny.</h6>
                    </div>
                </div>
                
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">                        
                        @if (session('success'))
                        <div class="col-lg-10 successDiv">
                            <div class="alert alert-success" role="alert">
                                Thankyou for accepting to review this video. You will receive an email to process further. Please check your email.
                            </div>
                        </div>
                        @elseif(session('deny'))
                        <div class="col-lg-10 successDiv">
                            <div class="alert alert-success" role="alert">
                                You have denied this video to review.
                            </div>
                        </div>
                        @else
                            @if(($check_last_record->videohistorystatus_id == '27' && $check_last_record->send_from_as == 'Corresponding-Author') &&  $check_last_record->corresponding_author_email == $corrauthor_email)

                                <h5>You have declained the video to review.</h5>
                            @elseif(($check_last_record->videohistorystatus_id == '3' && $check_last_record->send_from_as == 'editorial-member') || ($check_last_record->videohistorystatus_id == '27' && $check_last_record->send_from_as == 'Corresponding-Author'))
                                <form id="acceptancecorresponding_author_member_form">
                                    <div class="row">
                                        <input type="hidden" name="videoupload_id" id="videoupload_id" value="{{ $id }}" />
                                        <input type="hidden" name="corrauthor_email" id="corrauthor_email" value="{{ $corrauthor_email }}" />
                                        <input type="hidden" name="encrypted_corrauthor_email" id="encrypted_corrauthor_email" value="{{ $encrypted_corrauthor_email }}" />
                                        <input type="hidden" name="encrypted_majorcategory_id" id="encrypted_majorcategory_id" value="{{ $encrypted_majorcategory_id }}" />

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="videohistorystatus_id">Option<b class="required">*</b></label>
                                                <select id="videohistorystatus_id" name="videohistorystatus_id"
                                                    class="custom-select">
                                                    <option value="">Select</option>
                                                    @foreach ($accept_deny_option as $accept_deny_option_value)
                                                        <option value="{{ $accept_deny_option_value->id }}">
                                                            {{ $accept_deny_option_value->option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="message">Message<b class="required">*</b></label>
                                                <textarea rows="3" id="message" name="message" class="form-control blackText"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="osahan-area text-center mt-3">
                                        <button type="submit" class="btn btn-outline-primary"
                                            id="acceptancecorresponding_author_member_form_Submit">Update</button>
                                    </div>

                                </form> 
                            @else
                                <h5>Already accepted.</h5>
                            @endif
                        @endif
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    @endsection
@push('pushjs')
    @include('frontend.include.jsForDifferentPages.corresponding_author_history_page')  
@endpush