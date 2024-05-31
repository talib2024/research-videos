
    <div class="row">
      @if(!empty($last_record_for_corresponding_author) && (($last_record_for_corresponding_author->videohistorystatus_id == '26' && $last_record_for_corresponding_author->send_from_as == 'Corresponding-Author' && $last_record_for_corresponding_author->corresponding_author_email == Auth::user()->email) || ($last_record_for_corresponding_author->videohistorystatus_id == '1' && $last_record_for_corresponding_author->send_from_as == 'Corresponding-Author' && $last_record_for_corresponding_author->corresponding_author_email == Auth::user()->email) ))
        <div class="col-lg-3">
            <div class="form-group">
                <label>Last selected option</label>
                <input type="text" value="{{ $last_record_for_corresponding_author->last_selected_option }}" class="form-control blackText" readonly disabled />
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label>Last added message</label>
                <textarea class="form-control blackText" readonly disabled >{{ $last_record_for_corresponding_author->message }}</textarea>
            </div>
        </div>
    @endif
    <div class="col-lg-3">
    @if($last_record_of_reviewer_for_authors && $last_record_of_reviewer_for_authors->message_visibility == 1)
    <p>Reviewer's last message: <a href="#" class="view-message" data-message-id="{{ $last_record_of_reviewer_for_authors->videohistories_id }}">View message</a></p>
    @endif
    @if($last_record_of_editor_member_for_authors && $last_record_of_editor_member_for_authors->message_visibility == 1)
    <p>Editor's last message: <a href="#" class="view-message" data-message-id="{{ $last_record_of_editor_member_for_authors->videohistories_id }}">View message</a></p>
    @endif
    </div>
        
    @if($check_last_record->videohistorystatus_id == '26' && $check_last_record->send_from_as == 'editorial-member' && $check_last_record->corresponding_author_email == Auth::user()->email && $check_last_record->corresponding_author_status == 2)
        <div class="col-lg-6">
            <div class="osahan-area text-center mt-5">
            <a href="{{ route('video.show',$video_list->id) }}" class="btn btn-outline-primary" id="Author_form_Submit">Update this video</a>
            </div>
        </div>
    @endif
    

     @if($check_last_record->videohistorystatus_id != '6' && $check_last_record->videohistorystatus_id != '18' && $check_last_record->videohistorystatus_id != '19' && $check_last_record->videohistorystatus_id != '23' && $check_last_record->videohistorystatus_id != '24' && $video_list->withdraw_video == 0 && $video_list->user_id == Auth::user()->id)
        <div class="osahan-area text-center mt-3">
        <form action="{{ route('withdraw.video', $video_list->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to withdraw the video?');">
            @csrf
            <div class="osahan-area text-center mt-5">
                <button type="submit" class="btn btn-outline-primary">Withdraw Video</button>
            </div>
        </form>
    </div>
    @endif
        
    </div>
@include('frontend.include.history')