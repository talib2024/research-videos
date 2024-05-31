<!DOCTYPE html>
<html lang="en">
    <body>
    @if($user_type == 'corresponding_author' || $user_type == 'author')
        <p>Dear Corresponding Author,</p>
            <p>The editor and reviewers have reached a “Revise” decision on your submitted video "{{ $video_list->unique_number }}".</p>
            <p>You have 15 days to address the comments by Editor and Reviewers, and resubmit a revised version of your video.</p>
        @if($user_type == 'corresponding_author')
            <p>When ready, as corresponding author, you must login to your account and complete the revision by using this “<a href="{{ route('member.login') }}">Please click here to login your account.</a>”</p>
            
        @elseif($user_type == 'author')         
            
            @if($register_type == 'signup')
            <p>If you are not yet registered as an author, please follow this link to register and have access to the uploaded video.</p>
            <p><a href="{{ route('reviewer.register',[$encrypted_author_email,$encrypted_majorcategory_id,$encrypted_role]) }}">Please click here to create your account.</a></p>
            @else
            <p><a href="{{ route('member.login') }}">Please click here to login your account.</a></p>
            @endif
        @endif
           
            <br/>
            <br/>
            <p>Thank you for placing your trust in ResearchVideos.</p>
            <p>Best Regards,</p>
            <p>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>
            <p>Editor ("{{ $video_list->category_name }}")</p>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
    @elseif($user_type == 'admin')
        <p>Hi,</p>
        <p>The editor “{{ Auth::user()->last_name }}” reached a “Revise” decision </p>
        <p>on the video “{{ $video_list->unique_number }}”, </p>
        <p>submitted by the corresponding author “{{ $plain_author_email }}”, </p>
        <p>under the discipline “{{ $video_list->category_name }}”.</p>
    @endif
    </body>
</html> 