<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $author_name }}</p>
            <p>You are selected as corresponding author for the video.</p>

            <p>URL:
            <a href="{{ route('video.details',[$video_id]) }}">Please click here</a>
            </p>
        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 