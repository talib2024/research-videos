<!DOCTYPE html>
<html lang="en">
    <body>
        {{-- <p>Dear {{ $plain_reviewer_email }}</p>
            <p>You have been selected as a reviewer for a video.</p>
            <p>Please click the url to accept/deny the request. After accepting, you will get a mail to review the video.</p>

            <p>URL:
            <a href="{{ route('reviewer.acceptance',[$encrypted_reviewer_email,$encrypted_video_id,$encrypted_majorcategory_id]) }}">Please click here</a>
            </p>
        <p>Thanks</p> --}}
        <p>Dear "{{ $reviewer_details->name }} {{ $reviewer_details->surname }}",</p>
         <p>You are kindly invited to review the video entitled "{{ $video_list->video_title }}" submitted for potential publication in ResearchVideos under the "{{ $video_list->category_name }}" discipline.</p>
            <p>If you agree to review this video, kindly follow this link "<a href="{{ route('reviewer.acceptance',[$encrypted_reviewer_email,$encrypted_video_id,$encrypted_majorcategory_id,$video_history_details->id]) }}">link to agree</a>."</p>
            <p>If you decline the review, please follow this link "<a href="{{ route('reviewer.acceptance',[$encrypted_reviewer_email,$encrypted_video_id,$encrypted_majorcategory_id,$video_history_details->id]) }}">link to decline</a>."</p>
            <p>Thank you for your time and consideration.</p>
        
        <br>
        <br>
        <p>Best Regards,</p>
        <p>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>
        <p>{{ $video_list->category_name }}</p>
        <p>{{ config('constants.urls.live_url') }}</p>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 