<form id="Submitreviewer_member_form">
    <div class="row">
      @if(!empty($last_record_for_reviewer) && $last_record_for_reviewer->videohistorystatus_id == '7')
        <div class="col-lg-6" style="display:none;">
            <div class="form-group">
                <label>Last selected option</label>
                <input type="text" value="{{ $last_record_for_reviewer->last_selected_option }}" class="form-control blackText" readonly disabled />
            </div>
        </div>
        <div class="col-lg-6" style="display:none;">
            <div class="form-group">
                <label>Last added message</label>
                <textarea class="form-control blackText" readonly disabled >{{ $last_record_for_reviewer->message }}</textarea>
            </div>
        </div>
    @endif
        <input type="hidden" name="videoupload_id" id="videoupload_id" value="{{ $video_list->id }}" />
        <input type="hidden" name="send_to_user_id" id="send_to_user_id" value="{{ $last_record_for_reviewer->send_to_user_id }}" class="form-control blackText" />
        <input type="hidden" name="reviewer_email" id="reviewer_email" value="{{ $last_record_for_reviewer->reviewer_email }}" class="form-control blackText" />
       
            {{-- <div class="col-lg-6">
                <div class="form-group">
                    <label for="videohistorystatus_id">Option<b class="required">*</b></label>
                    <select id="videohistorystatus_id" name="videohistorystatus_id" class="custom-select">
                        <option value="">Select</option>
                        @foreach ($accept_deny_option as $accept_deny_option_value)
                            <option value="{{ $accept_deny_option_value->id }}">
                                {{ $accept_deny_option_value->option }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
        
            {{-- <div class="col-lg-6">
                <div class="form-group">
                    <label for="videohistorystatus_id">Option<b class="required">*</b></label>
                    <select id="videohistorystatus_id" name="videohistorystatus_id" class="custom-select">
                        <option value="">Select</option>
                        @foreach ($pass_revise_option as $pass_revise_option_value)
                            <option value="{{ $pass_revise_option_value->id }}" {{ $pass_revise_option_value->id == $last_record_for_reviewer->videohistorystatus_id ? 'selected' : '' }}>
                                {{ $pass_revise_option_value->option }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="videohistorystatus_id">Option<b class="required">*</b></label>
                    <select id="videohistorystatus_id" name="videohistorystatus_id" class="custom-select">
                        <option value="">Select</option>
                        @foreach ($reviewer_option as $reviewer_option_value)
                            <option value="{{ $reviewer_option_value->id }}" {{ $reviewer_option_value->id == $last_record_for_reviewer->videohistorystatus_id ? 'selected' : '' }}>
                                {{ $reviewer_option_value->option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        <div class="col-lg-6" id="message_div">
            <div class="form-group">
                <label for="message">Reviewer Message<b class="required">*</b></label>
                {{-- <textarea rows="3" id="message" name="message" class="form-control blackText">{{ $last_record_for_reviewer->message }}</textarea> --}}
                <textarea rows="3" id="message" name="message" class="form-control blackText text-limit" placeholder="Max 6000 characters" data-maxlength="6000" data-show-char=".char-count"></textarea>
            </div>
        </div>
    </div>
@if($video_list->withdraw_video == 0 && (!empty($last_record_for_withdraw_reviewer) && ($last_record_for_withdraw_reviewer->withdraw_reviewer == 0) && ($last_record_for_withdraw_reviewer->is_pass_to_other_than_reviewer == 0)))
     @if ($last_record_for_reviewer->videohistorystatus_id == '7' && $last_record_for_reviewer->send_from_as == 'Reviewer' && $last_record_for_reviewer->withdraw_reviewer == '0' && $last_record_for_reviewer->reviewer_email == Auth::user()->email)
        <div class="osahan-area text-center mt-3">
            <button type="submit" class="btn btn-outline-primary" id="reviewer_form_Submit">Update</button>
        </div>
    @endif
@endif
    
</form>
@include('frontend.include.history')