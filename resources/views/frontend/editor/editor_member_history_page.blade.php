<form id="Submiteditor_chief_form">
<div class="row">
<input type="hidden" name="videoupload_id" id="videoupload_id" value="{{ $video_list->id }}" />
<input type="hidden" name="author_id" id="author_id" value="{{ $video_list->user_id }}" />
<input type="hidden" name="majorcategory_id" id="majorcategory_id" value="{{ $video_list->majorcategory_id }}" />
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="pass_to">Pass to<b
                                class="required">*</b></label>
                        <select id="pass_to" name="pass_to" class="custom-select">
                            <option value="">Select</option>   
                            @foreach ($editor_chief_option as $editor_chief_option_value)
                                <option value="{{ $editor_chief_option_value->id }}" {{ in_array($editor_chief_option_value->id, $pass_to) ? 'selected' : '' }}>{{ $editor_chief_option_value->option }}</option>
                            @endforeach                     
                        </select>
                        <span id="pass_to_error" class="required"></span>
                    </div>
                </div>
                <div class="col-lg-3" id="editorial_member_div" style="display:none;">
                    <div class="form-group">
                        <label for="editorial_member_id">Editorial Member<b
                                class="required">*</b></label>
                        <select id="editorial_member_id" name="editorial_member_id[]" class="select2bs4" multiple="multiple">
                            <option value="">Select</option>   
                            @foreach ($editorial_member_list as $editorial_member_list_value)
                                <option value="{{ $editorial_member_list_value->id }}" {{ in_array($editorial_member_list_value->id, $editorial_member) ? 'selected' : '' }}>{{ $editorial_member_list_value->name }} {{ $editorial_member_list_value->email }}</option>
                            @endforeach                             
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 input-fix" id="reviewer_div" style="display:none;">
                    <div class="form-group">
                        <label for="reviewer_email">Reviewer<b
                                class="required">*</b></label>
                        <select id="reviewer_email" name="reviewer_email[]" class="reviewer_email" multiple="multiple">
                            @foreach ($reviewer_list as $reviewer_list_value)
                                @php
                                    $emailOnly = strtok($reviewer_list_value, ' '); // Get only the email part
                                    $displayText = $reviewer_list_value; // The complete display text
                                @endphp
                                <option value="{{ $emailOnly }}" {{ in_array($emailOnly, $reviewer_emails) ? 'selected' : '' }}>{{ $displayText }}</option>
                            @endforeach                            
                        </select>
                    </div>
                </div>
                <div class="col-lg-3" id="publisher_div" style="display:none;">
                    <div class="form-group">
                        <label for="publisher_id">Publisher<b class="required">*</b></label>
                        <select id="publisher_id" name="publisher_id" class="custom-select">
                            <option value="">Select</option> 
                            @foreach ($publisher_list as $publisher_list_value)
                                <option value="{{ $publisher_list_value->id }}" {{ in_array($publisher_list_value->id, $publisher_ids) ? 'selected' : '' }}>{{ $publisher_list_value->email }}</option>
                            @endforeach                           
                        </select>
                    </div>
                </div>
                <div class="col-lg-3" id="status_for_authors_div" style="display:none;">
                    <div class="form-group">
                        <label for="status_for_authors">Status<b class="required">*</b></label>
                        <select id="status_for_authors" name="status_for_authors" class="custom-select">
                            <option value="">Select</option> 
                                @if (!is_null($last_record_for_editor_chief))
                                @php
                                    $corresponding_author_status = optional($last_record_for_editor_chief->first())->corresponding_author_status;
                                @endphp
                                    <option value="1" {{ $corresponding_author_status == 1 ? 'selected' : '' }}>Rejected</option>
                                    <option value="2" {{ $corresponding_author_status == 2 ? 'selected' : '' }}>Revise</option>

                                @else
                                    <option value="1">Rejected</option>
                                    <option value="2">Revise</option>
                                @endif           
                        </select>
                    </div>
                </div>
                <div class="col-lg-6" id="message_div" style="display:none;">
                    <div class="form-group">
                        <label for="message">Editor Message<b
                                class="required">*</b></label>
                        {{-- <textarea rows="3" id="message" name="message" class="form-control blackText">{{ $last_message }}</textarea> --}}
                        <textarea rows="3" id="message" name="message" class="form-control blackText text-limit" placeholder="Max 6000 characters" data-maxlength="6000" data-show-char=".char-count"></textarea>
                    </div>
                </div>
            </div>

@if($video_list->withdraw_video == 0 && $video_list->currently_assigned_to_editorial_member == Auth::user()->id)
    @if((isset($check_last_record->videohistorystatus_id) && $check_last_record->videohistorystatus_id != '18' && $check_last_record->videohistorystatus_id != '3' && $check_last_record->videohistorystatus_id != '23' && $check_last_record->videohistorystatus_id != '24' && $check_last_record->videohistorystatus_id != '19' && $check_last_record->videohistorystatus_id != '26' && $check_last_record->videohistorystatus_id != '6' && ($check_last_record->send_from_user_id == Auth::id() || $check_last_record->send_to_user_id == Auth::id())))
   
        <div class="osahan-area text-center mt-3">
            <button type="submit" class="btn btn-outline-primary" id="editor_chief_form_Submit">Submit</button>
        </div>
    @elseif((isset($check_last_record->videohistorystatus_id) && $check_last_record->corresponding_author_status == '1' && $check_last_record->send_to_user_id == Auth::id()))
    
        <div class="osahan-area text-center mt-3">
            <button type="submit" class="btn btn-outline-primary" id="editor_chief_form_Submit">Submit</button>
        </div>
    @elseif((isset($check_last_record->videohistorystatus_id) && $check_last_record->withdraw_reviewer == '1' && $check_last_record->send_to_user_id == Auth::id()))
    
        <div class="osahan-area text-center mt-3">
            <button type="submit" class="btn btn-outline-primary" id="editor_chief_form_Submit">Submit</button>
        </div>
    @endif
@endif

    </form>
    
<div id="reviewer_div_form" style="display:none;">
<form id="Submiteditor_reviewer_form">
<input type="hidden" name="videoupload_id_editor" id="videoupload_id_editor" value="{{ $video_list->id }}" />
    <div class="main-title addMoreButton">
        <h5>Reviewer</h5>
        <a class="btn btn-primary add_editorReviewerDiv">Add More</a>
        <span class="max_warning_message red" style="margin-left: 10px;"></span>
    </div>
    <div id="editorReviewerDiv">
        <div class="row editorReviewerSection">
            
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="editorRevieweremail">Email</label>
                    <input type="email" name="name[1][editorRevieweremail][]" id="editorRevieweremail"
                        class="form-control blackText editorRevieweremail">
                </div>
            </div>
        </div>

    </div>
    @if($video_list->withdraw_video == 0 && $video_list->currently_assigned_to_editorial_member == Auth::user()->id)
        <div class="osahan-area text-center mt-3">
                <button type="submit" class="btn btn-outline-primary" id="Submiteditor_reviewer_form_Submit">Add Reviewer</button>
        </div>
    @endif
</form>
</div>
    <hr/>


@if($video_list->withdraw_video == 0 && $video_list->currently_assigned_to_editorial_member == Auth::user()->id)
    @if((isset($reviewers_list_to_withdraw) && !empty($reviewers_list_to_withdraw)))
        <div class="osahan-area text-center mt-3" id="withdraw_reviewer_div">
            <form action="{{ route('withdraw.reviewer') }}" method="POST" onsubmit="return confirm('Are you sure you want to withdraw the reviewer?');">
                @csrf
                <div class="row">
                <div class="col-lg-3 input-fix">
                        <h5>Withdraw Reviewer</h5>
                    <div class="form-group">
                        <label for="withdraw_reviewer_email">Reviewer<b
                                class="required">*</b></label>
                        <input type="hidden" name="videoupload_id" id="videoupload_id" value="{{ $video_list->id }}" />
                        <select id="withdraw_reviewer_email" name="withdraw_reviewer_email[]" class="withdraw_reviewer_email" multiple="multiple">
                            @foreach ($reviewers_list_to_withdraw as $reviewers_list_to_withdraw_value)
                                <option value="{{ $reviewers_list_to_withdraw_value->id.'__##__'.$reviewers_list_to_withdraw_value->reviewer_email }}">{{ $reviewers_list_to_withdraw_value->reviewer_email }}</option>
                            @endforeach                            
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 input-fix">
                    <div class="form-group">
                        <h5 style="visibility:hidden">Withdraw Reviewer</h5>
                        <label for="withdraw_reviewer_email" style="visibility:hidden">Reviewer<b
                                class="required">*</b></label>
                    <div class="osahan-area text-center">
                        <button type="submit" class="btn btn-outline-primary">Withdraw Reviewer</button>
                    </div>
                    </div>
                </div>
                </div>
            </form>
        </div>
    @endif
@endif

@if(!empty($last_record_of_reviewer_for_authors))
<div class="osahan-area text-center mt-3">
    <p>Reviewer's last message: <a href="#" class="view-message" data-message-id="{{ $last_record_of_reviewer_for_authors->videohistories_id }}">View message</a></p>   
</div>
@endif
@include('frontend.include.history')