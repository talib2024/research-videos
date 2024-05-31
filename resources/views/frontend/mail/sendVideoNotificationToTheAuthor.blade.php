<!DOCTYPE html>
<html lang="en">
    <body>
        @if($user_type == 'corresponding_author')
        <p>Dear Corresponding Author,</p>
            <p>This email is to confirm the successful submission of your video entitled: "{{ $video_list->video_title }}" to {{ config('constants.urls.live_url') }} under the discipline: "{{ $video_list->category_name }}".</p>
            <p>Your video will now be processed by the corresponding Editor.</p>
            <p>Thank you for placing your trust in ResearchVideos.</p>
            <br/><br/>
            <p>Best Regards.</p>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
        @elseif($user_type == 'author')
        <p>Dear Corresponding Author,</p>
            <p>This email is to confirm the successful submission of your video entitled: "{{ $video_list->video_title }}" to {{ config('constants.urls.live_url') }} under the discipline: "{{ $video_list->category_name }}".</p>
            <p>Your video will now be processed by the corresponding Editor.</p>            
            <p>Video url is: <a href="{{ route('video.edit', $video_list->id) }}">Click here to watch the video.</a></p>            
            
            @if($register_type == 'signup')
            <p>If you are not yet registered as an author, please follow this link to register and have access to the uploaded video.</p>
            <p><a href="{{ route('reviewer.register',[$encrypted_author_email,$encrypted_majorcategory_id,$encrypted_role]) }}">Please click here to create your account.</a></p>
            @else
            <p><a href="{{ route('member.login') }}">Please click here to login your account.</a></p>
            @endif

            <p>Thank you for placing your trust in ResearchVideos.</p>
            <br/><br/>
            <p>Best Regards.</p>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
        @endif
    </body>
</html> 