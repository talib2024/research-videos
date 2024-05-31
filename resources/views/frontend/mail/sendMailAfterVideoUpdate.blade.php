<!DOCTYPE html>
<html lang="en">
    <body>
    @if($user_type == 'authors')
        <p>Dear Corresponding Author,</p>
            <p>This email is to confirm the successful submission of your revised video to "{{ $video_details->category_name }}".</p>
            <p>Your video “{{ $video_details->unique_number }}” will now be processed by the corresponding Editor.</p>    
            <br/>
            <br/>
            <p>Thank you for placing your trust in ResearchVideos.</p>
            <p>Best Regards.</p>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
    @elseif($user_type == 'editorial_member')
        <p>Dear Editor, </p>
        <p>A revised version of the video “{{ $video_details->unique_number }}” has been resubmitted for potential publication in your discipline.</p>
        <p>Please login to your account on {{ config('constants.urls.live_url') }} to pass this video to at least two reviewers, take a decision, or to pass it to another Editorial Member.</p>
        <p>Thank you for your time and dedication.</p>
        <p>{{ config('constants.urls.live_url') }}</p>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    @elseif($user_type == 'admin')
        <p>Hi,</p>
        <p>A revised version of the video “{{ $video_details->unique_number }}” has been resubmitted </p>
        <p>and assigned to the Editor "{{ $editor_mail }}". </p>
        <p>This video was submitted by the corresponding author “{{ Auth::user()->email }}”,</p>
        <p>under the discipline “{{ $video_details->category_name }}”.</p>
    @endif
    </body>
</html> 