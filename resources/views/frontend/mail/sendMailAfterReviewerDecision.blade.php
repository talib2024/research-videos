<!DOCTYPE html>
<html lang="en">
    <body>
    @if($user_type == 'editor')
        <p>Dear Editor,</p>
            <p>The status of the video "{{ $video_list->unique_number }}" was changed by the reviewer: "{{ Auth::user()->email }}".</p>       
            <p>Please login to your account and make a decision on this video as soon as possible.</p>       
           
            <br/>
            <br/>
            <p>Thank you for your time and efforts. Very much appreciated.</p>
            <p>Our best regards,</p>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
    @elseif($user_type == 'admin')
        <p>Hi,</p>
        <p>The status of the video "{{ $video_list->unique_number }}" was changed by the reviewer: "{{ Auth::user()->email }}".</p>
    @endif
    </body>
</html> 