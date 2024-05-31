<!DOCTYPE html>
<html lang="en">
    <body>
        @if($user_type == 'reviewer')
            <p>Dear "{{ $reviewer_details->name }}   {{ $reviewer_details->surname }}",</p>

                <p>This is inform you that the Editorial board had reached to a decision on the video "{{ $video_list->unique_number }}".</p>
            <br>
            <br>
            <br>
            <p>Best Regards,</p>
            <p>Kindly yours,</p>
            <p>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>
            <p>Editorial Board Member</p>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
        @endif
    </body>
</html> 