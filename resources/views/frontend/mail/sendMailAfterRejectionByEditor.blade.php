<!DOCTYPE html>
<html lang="en">
    <body>
    @if($user_type == 'authors')
        <p>Dear Corresponding Author,</p>
            <p>The Editorial Team has reached a “Reject” decision on your submitted video “{{ $video_details->unique_number }}”.</p>
            <p>Please consider submitting a new video to {{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <p>Thank you for placing your trust in ResearchVideos.</p>
            <p>Best Regards,</p>
            <p>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>
            <p>Editor ("{{ $video_details->category_name }}")</p>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
    
    @elseif($user_type == 'admin')
        <p>Hi,</p>
        <p>The editor “{{ Auth::user()->email }}” reached a "Reject" decision </p>
        <p>on the video “{{ $video_details->unique_number }}”, </p>
        <p>submitted by the corresponding author “{{ $plain_author_email }}”, </p>
        <p>under the discipline “{{ $video_details->category_name }}”.</p>
    @endif
    </body>
</html> 