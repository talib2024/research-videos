@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid contact-us-details">
            <div class="row">
                <div class="col-lg-6">
                    <div class="main-title">
                        <h6>Please Accept or Deny to Review.</h6>
                    </div>
                </div>
                
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">  
                @if(isset($video_history_record_based_on_id) && !empty($video_history_record_based_on_id) && ($video_history_record_based_on_id->withdraw_reviewer == 0) && ($video_history_record_based_on_id->is_pass_to_other_than_reviewer == 0))                      
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
                            {{-- @if(($check_last_record->videohistorystatus_id == '8' && $check_last_record->send_from_as == 'Reviewer') &&  $check_last_record->reviewer_email == $reviewer_email) --}}
                            @if(($check_action_by_reviewer) && ($check_action_by_reviewer->videohistorystatus_id == '8' && $check_action_by_reviewer->send_from_as == 'Reviewer') &&  $check_action_by_reviewer->reviewer_email == $reviewer_email)

                                <h5>You have declained the video to review.</h5>
                            @elseif(($check_action_by_reviewer) && ($check_action_by_reviewer->videohistorystatus_id == '7' && $check_action_by_reviewer->send_from_as == 'Reviewer') &&  $check_action_by_reviewer->reviewer_email == $reviewer_email)
                                <h5>You have already accepted the video to review!</h5>
                                
                            {{-- @elseif(($check_last_record->videohistorystatus_id == '5' && $check_last_record->send_from_as == 'editorial-member') || ($check_last_record->videohistorystatus_id == '8' && $check_last_record->send_from_as == 'Reviewer')) --}}
                            @else
                                <form id="acceptanceReviewer_member_form">
                                    <div class="row">
                                        <input type="hidden" name="videoupload_id" id="videoupload_id" value="{{ $id }}" />
                                        <input type="hidden" name="video_history_id" id="video_history_id" value="{{ $video_history_id }}" />
                                        <input type="hidden" name="reviewer_email" id="reviewer_email" value="{{ $reviewer_email }}" />
                                        <input type="hidden" name="encrypted_reviewer_email" id="encrypted_reviewer_email" value="{{ $encrypted_reviewer_email }}" />
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
                                                <label for="message">Message</label>
                                                <textarea rows="3" id="message" name="message" class="form-control blackText"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="osahan-area text-center mt-3">
                                        <button type="submit" class="btn btn-outline-primary"
                                            id="acceptanceReviewer_form_Submit">Update</button>
                                    </div>

                                </form> 
                            @endif
                        @endif
                    @else
                        <h5>This page is expired.</h5>

                    @endif
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    @endsection
@push('pushjs')
    @include('frontend.include.jsForDifferentPages.reviewer_history_page_js')  
@endpush