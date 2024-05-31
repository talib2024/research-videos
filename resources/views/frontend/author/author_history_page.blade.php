@if(isset($check_last_record->videohistorystatus_id) && $check_last_record->videohistorystatus_id == '3')
<div class="row">
    <input type="hidden" name="videoupload_id" id="videoupload_id" value="{{ $video_list->id }}" />
    <input type="hidden" name="author_id" id="author_id" value="{{ $video_list->user_id }}" />
    <div class="col-lg-6">
        <div class="form-group">
            <label for="message">Remark</label>
            <textarea rows="3" readonly disabled class="form-control blackText">{{ $check_last_record->message }}</textarea>
        </div>
    </div>
    {{-- <div class="osahan-area text-center mt-5">
        <a href="{{ route('video.show',$video_list->id) }}" class="btn btn-outline-primary" id="Author_form_Submit">Update this video</a>
    </div> --}}
</div>
@endif
@if(isset($get_condition_to_delete_record_for_author) && $get_condition_to_delete_record_for_author['totalRecords'] == '1' && $get_condition_to_delete_record_for_author['lastRecord']->send_from_user_id == Auth::id() && $get_condition_to_delete_record_for_author['lastRecord']->send_from_as == 'Author')

    <form id="deleteVideo" action="{{ route('video.delete', Crypt::encrypt($video_list->id)) }}" method="POST">
        @csrf
        <input type="hidden" name="videoupload_id" id="videoupload_id" value="{{ $video_list->id }}" />
        <input type="hidden" name="author_id" id="author_id" value="{{ $video_list->user_id }}" />
        <div class="osahan-area text-center mt-5">
            <a href="#" class="btn btn-outline-primary" id="delete_Author_form_Submit">Delete this video</a>
        </div>
    </form>
@endif
@include('frontend.include.history')
