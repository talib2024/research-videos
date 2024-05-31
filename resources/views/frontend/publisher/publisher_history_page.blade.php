<form id="SubmitPublisher_form">
    <div class="row">
        {{-- @if (!empty($last_record_for_editor_member) && $last_record_for_editor_member->videohistorystatus_id == '7')
<div class="col-lg-6">
<div class="form-group">
<label>Last selected option</label>
<input type="text" value="{{ $last_record_for_editor_member->last_selected_option }}" class="form-control blackText" readonly disabled />
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Last added message</label>
<textarea class="form-control blackText" readonly disabled >{{ $last_record_for_editor_member->message }}</textarea>
</div>
</div>
@endif --}}
        <input type="hidden" name="videoupload_id" id="videoupload_id" value="{{ $video_list->id }}" />
        <input type="hidden" name="send_to_user_id" id="send_to_user_id"
            value="{{ $send_to_user_id_for_publisher->passed_by_id }}" class="form-control blackText" />
        {{-- @if (($check_last_record->videohistorystatus_id == '4' && $check_last_record->send_from_as == 'editor-in-chief') || ($check_last_record->videohistorystatus_id == '8' && $check_last_record->send_from_as == 'editorial-member'))
<div class="col-lg-6">
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
</div>
@else --}}
        @if (!empty($last_record_for_publisher))
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="videohistorystatus_id">Option<b class="required">*</b></label>
                    <select id="videohistorystatus_id" name="videohistorystatus_id" class="custom-select">
                        <option value="">Select</option>
                        @foreach ($publisher_option as $publisher_option_value)
                            <option value="{{ $publisher_option_value->id }}"
                                {{ $last_record_for_publisher->videohistorystatus_id == $publisher_option_value->id ? 'selected' : '' }}>
                                {{ $publisher_option_value->option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="videohistorystatus_id">Option<b class="required">*</b></label>
                    <select id="videohistorystatus_id" name="videohistorystatus_id" class="custom-select">
                        <option value="">Select</option>
                        @foreach ($publisher_option as $publisher_option_value)
                            <option value="{{ $publisher_option_value->id }}">
                                {{ $publisher_option_value->option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        {{-- @endif --}}

        <div class="col-lg-6" id="message_div">
            <div class="form-group">
                <label for="message">Publisher Message<b class="required">*</b></label>
                @if (!empty($last_record_for_publisher))
                    {{-- <textarea rows="3" id="message" name="message" class="form-control blackText">{{ $last_record_for_publisher->message }}</textarea> --}}
                    <textarea rows="3" id="message" name="message" class="form-control blackText text-limit" placeholder="Max 6000 characters" data-maxlength="6000" data-show-char=".char-count"></textarea>
                @else
                    <textarea rows="3" id="message" name="message" class="form-control blackText text-limit" placeholder="Max 6000 characters" data-maxlength="6000" data-show-char=".char-count"></textarea>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 oninePublishingDiv" style="display:none;">
            <div class="form-group">
                <label for="membershipplan_id">Online Publishing Licence<b class="required">*</b></label>
                <select id="membershipplan_idss" name="membershipplan_id" class="custom-select">
                    <option value="">Select</option>
                    @foreach ($paymentype as $paymentype_update)
                        <option value="{{ $paymentype_update->id }}" {{ $paymentype_update->id == $video_list->membershipplan_id ? 'selected' : '' }}>
                            {{ $paymentype_update->plan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
            <div class="col-lg-3 videoAmountDiv" style="display:none;">
                <div class="form-group">
                    <label for="video_price">Video Amount<b class="required">*</b></label>
                    <input type="text" id="video_price" name="video_price" class="form-control blackText"
                        value="{{ $video_list->video_price }}">
                </div>
            </div>
            <div class="col-lg-3 videoAmountDiv" style="display:none;">
                <div class="form-group">
                    <label for="rv_coins_price">Video RVcoins<b class="required">*</b></label>
                    <input type="text" id="rv_coins_price" name="rv_coins_price" class="form-control blackText"
                        value="{{ $video_list->rv_coins_price }}">
                </div>
            </div>
    </div>
@if($video_list->withdraw_video == 0)
    @if (
        ($check_last_record->videohistorystatus_id == '6' && $check_last_record->send_to_user_id == Auth::id()) ||
            ($check_last_record->videohistorystatus_id == '18' && $check_last_record->send_from_user_id == Auth::id()) ||
            ($check_last_record->videohistorystatus_id == '19' && $check_last_record->send_from_user_id == Auth::id()) ||
            ($check_last_record->videohistorystatus_id == '23' && $check_last_record->send_from_user_id == Auth::id()) ||
            ($check_last_record->videohistorystatus_id == '24' && $check_last_record->send_from_user_id == Auth::id()))
        <div class="osahan-area text-center mt-3">
            <button type="submit" class="btn btn-outline-primary" id="publisher_form_Submit">Update</button>
        </div>
    @endif
@endif

</form>
@include('frontend.include.history')
@push('pushjs')
<script>
const membershipplan_id_value = "{{ isset($video_list->membershipplan_id) ? $video_list->membershipplan_id : '' }}";
const video_price = "{{ isset($video_list->video_price) ? $video_list->video_price : '' }}";
const is_published = "{{ isset($video_list->is_published) ? $video_list->is_published : '' }}";
if(is_published == '1')
{
    $(".oninePublishingDiv").show();
    if(membershipplan_id_value == '1')
    {
        $(".videoAmountDiv").show();
    }
    else 
    {
        $(".videoAmountDiv").hide();
    }
}
else 
{
    $(".oninePublishingDiv").hide();
}

$('#membershipplan_idss').on('change', function() {
    if (this.value == '1') {
        $(".videoAmountDiv").show();
    } else {
        $(".videoAmountDiv").hide();
    }
});
$('#videohistorystatus_id').on('change', function() {
    if (this.value == '18') 
    {
        $(".oninePublishingDiv").show();
        if($('#membershipplan_idss').val() == '1')
        {
            $(".videoAmountDiv").show();
        }
        else
        {
            $(".videoAmountDiv").hide();
        }
    } 
    else 
    {
        $(".oninePublishingDiv").hide();
        $(".videoAmountDiv").hide();
    }
});
</script>
@endpush
