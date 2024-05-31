<!DOCTYPE html>
<html lang="en">
    <body>
    @if($user_type == 'editorial_member')
        <p>Dear Editor,</p>
            <p>A new video “{{ $video_details->unique_number }}” has been submitted to {{ config('constants.urls.live_url') }} for potential publication.</p>
            <p>Please login to your account on {{ config('constants.urls.live_url') }} to pass this video to at least two reviewers, take a decision, or to pass it to another Editorial Member.</p>
            <br/>
            <br/>
            <p>Thank you for your time and dedication.</p>
            <p>{{ config('constants.urls.live_url') }}.</p>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    
    @elseif($user_type == 'admin')
        <p>Hi admin,</p>
        <p>The editor “{{ Auth::user()->email }}” </p>
        <p>has assigned the video “{{ $video_details->unique_number }}” </p>
        <p>to a new editor {{ $new_editor_email }}. </p>
        <p>This video was submitted by the corresponding author “{{ $corresponding_author_details->email }}”, </p>
        <p>under the discipline “{{ $video_details->category_name }}”.</p>
    @endif
    </body>
</html> 