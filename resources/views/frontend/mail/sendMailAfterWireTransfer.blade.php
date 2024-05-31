<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi</p>
            <p>Thank you. Your purchase will be confirmed soon by our financial team.</p>
            <p>Your purchased video is:</p>
            <p><a href="{{ route('video.details',$video_list->id) }}">{!! generate_rvoi_link($video_list->short_name,$video_list->videohistories_created_at,$video_list->unique_number) !!}</a></p>
            <p>Please Check the attached uploaded transaction receipt by you.</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 