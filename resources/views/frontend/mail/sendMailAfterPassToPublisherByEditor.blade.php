<!DOCTYPE html>
<html lang="en">
    <body>
    @if($user_type == 'publisher')
        <p>Dear Publisher,</p>
        <p>The editor has reached an “Accept” decision on video “{{ $video_details->unique_number }}” submitted for publication in discipline “{{ $video_details->category_name }}”, under licence type “{{ $video_details->membershipplan_id == 1 ? 'Regular' : 'Open-access' }}”.</p>
        <p>Please complete the final necessary steps in order to publish this video.</p>
        <br/>
        <br/>
        <p>{{ config('constants.urls.live_url') }}.</p>  
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    @elseif($user_type == 'editor')
        <p>Dear Editor,</p>
        <p>Thank you for your “Accept” for publication decision on video “{{ $video_details->unique_number }}”</p>      
        <p>Your time and effort are very much appreciated</p>      
        <br/>
        <br/>        
        <p>Best regards,</p>   
        <p>{{ config('constants.urls.live_url') }}.</p> 
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   

    @elseif($user_type == 'authors')
        <p>Dear Corresponding Author,</p>
        <p>I am pleased to inform you that the editor has reached an "Accept" for publication decision on your submitted video “{{ $video_details->unique_number }}”.</p>
        <p>Your video will be handled by our publisher team members for processing. Our publisher team members will contact you very soon to do a final proof reading before the online publication of your video.</p>
        <p>You will receive a notification by email as soon as your video is published online.</p>
        <p>Thank you for publishing with ResearchVideos.</p>
        <br/>
        <br/>
        <p>Best Regards,</p>
        <p>"{{ Auth::user()->name }}" "{{ Auth::user()->last_name }}",</p>
        <p>Editor ("{{ $video_details->category_name }}"),</p>
        <p>{{ config('constants.urls.live_url') }}.</p> 
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>          
    
    @elseif($user_type == 'admin')
        <p>Hi admin,</p>
        <p>The editor “{{ Auth::user()->email }}” reached an “Accept” for publication decision </p>
        <p>on video “{{ $video_details->unique_number }}”, </p>
        <p>submitted by the corresponding author “{{ $corresponding_author_details->email }}”, </p>
        <p>under the discipline “{{ $video_details->category_name }}”</p>
    @endif
    </body>
</html> 