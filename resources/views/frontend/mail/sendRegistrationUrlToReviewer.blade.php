<!DOCTYPE html>
<html lang="en">
    <body>
        @if($user_type == 'reviewer')
            <p>Dear "{{ $reviewer_details->name }}   {{ $reviewer_details->surname }}",</p>

            @if($status_type == 'accept')
                <p>Thank you for accepting to review the submitted video “{{ $video_list->unique_number }}”.</p>    
                @if($type == 'signup') 
                    <p>If you are not yet registered as a reviewer, please follow this link to register and have access to the uploaded video.</p>
                    <a href="{{ route('reviewer.register',[$encrypted_reviewer_email,$encrypted_majorcategory_id,$encrypted_role]) }}">Click here!</a>
                @else       
                    <p>To submit your comments please use this: “<a href="{{ route('member.login') }}">Click here!</a>”.</p>
                @endif
                    <p>Thank you for your time and consideration.</p>

            @elseif($status_type == 'decline')
                <p>Thank you for your “declined review task” confirmation.</p>
                <p>Hoping that you will accept other review invitations in the future,</p>
                <p>Wishing an excellent time,</p>
            @endif
            <br>
            <br>
            <p>Best Regards,</p>
            <p>Professor "{{ $editorial_member_details->name }}" "{{ $editorial_member_details->last_name }}"</p>
            <p>Editor ("{{ $video_list->category_name }}")</p>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   

        @elseif($user_type == 'editorial_member')

            <p>Dear Editor,</p>
            @if($status_type == 'accept')
                <p>A reviewer has accepted your invitation to review the submitted video "{{ $video_list->unique_number }}".</p>
                <p>You may notify the reviewer if they do not submit their review within 15 days.</p>
             @elseif($status_type == 'decline')
                <p>The reviewer "{{ $reviewer_email }}" has denied your invitation to review the submitted video “{{ $video_list->unique_number }}”</p>
                <p>Please login to your account on {{ config('constants.urls.live_url') }} to pass this video to a new reviewer, take a decision, or to pass it to another Editorial Member.</p>
            @endif
            <br/>
            <br/>
            <p>Thank you for your time and dedication.</p>
            <p>{{ config('constants.urls.live_url') }}</p>       
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
        @endif
    </body>
</html> 