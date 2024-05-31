<!DOCTYPE html>
<html lang="en">
    <body>
    @if($user_type == 'authors')
        <p>Dear Authors,</p>
            <p>Congratulations!</p>           
            <p>Your video “{{ $video_details->unique_number }}” is now available online via this “::<a href="{{ route('video.details', $video_details->id) }}">{{ route('video.details', $video_details->id) }}</a>”.</p> 
            <p>We encourage you to share this link on your social media.</p> 
            <p>We are looking forward to receiving your new research videos in future submissions.</p> 
            <br/>
            <br/>
            <p>Thank you for placing your trust in ResearchVideos.</p>
            <p>Our Best Regards.</p>
            <p>{{ config('constants.urls.live_url') }}.</p> 
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
    @elseif($user_type == 'editorial_member')
        <p>Dear Editor, </p>
        <p>This is to inform you that the accepted video “{{ $video_details->unique_number }}”, submitted by the corresponding author “{{ $corresponding_author_details->email }}”, under the discipline “{{ $video_details->category_name }},” has been published online.</p>
        <br>
        <br>
        <p>Thank you for your time and dedication.</p>
        <p>Best Regards.</p>
        <p>{{ config('constants.urls.live_url') }}.</p> 
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    @elseif($user_type == 'admin')
        <p>Hi admin,</p>
        <p>The accepted video “{{ $video_details->unique_number }}” </p>
        <p>by the Editor “{{ $editor_details->email }}”, </p>
        <p>submitted by the corresponding author “{{ $corresponding_author_details->email }}”, </p>
        <p>under the discipline “{{ $video_details->category_name }},” </p>
        <p>has been published online on {{ config('constants.urls.live_url') }}</p>
    @elseif($user_type == 'publisher')
        <p>Dear Publisher,</p>
        <p>This is to inform you that the accepted video "{{ $video_details->unique_number }}", submitted by the corresponding author “{{ $corresponding_author_details->email }}”, under the discipline “{{ $video_details->category_name }},” has been published online.</p>    
        <br/>
        <br/>        
        <p>Best regards,</p>   
        <p>{{ config('constants.urls.live_url') }}.</p> 
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    @endif
    </body>
</html> 