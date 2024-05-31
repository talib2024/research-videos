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
                <div class="col-lg-3" id="reviewer_div" style="display:none;">
                    <div class="form-group">
                        <label for="reviewer_email">Reviewer<b
                                class="required">*</b></label>
                        <select id="reviewer_email" name="reviewer_email[]" class="select2bs4" multiple="multiple">
                            <option value="">Select</option>     
                            @foreach ($reviewer_list as $reviewer_list_value)
                                <option value="{{ $reviewer_list_value }}" {{ in_array($reviewer_list_value, $reviewer_emails) ? 'selected' : '' }}>{{ $reviewer_list_value }}</option>
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
                <div class="col-lg-6" id="message_div" style="display:none;">
                    <div class="form-group">
                        <label for="message">Message<b
                                class="required">*</b></label>
                        <textarea rows="3" id="message" name="message" class="form-control blackText">{{ $last_message }}</textarea>
                    </div>
                </div>
            </div>
@if((isset($check_last_record->videohistorystatus_id) && $check_last_record->videohistorystatus_id != '18' && $check_last_record->videohistorystatus_id != '7' && $check_last_record->send_to_user_id == Auth::id()) || (empty($check_last_record->send_to_user_id)))
    <div class="osahan-area text-center mt-3">
        <button type="submit" class="btn btn-outline-primary" id="editor_chief_form_Submit">Submit</button>
    </div>
@endif
</form>
@include('frontend.include.history')