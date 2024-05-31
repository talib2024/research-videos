<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi,</p>
            <p>Status of a video is changed by the user {{ $video_status_updated_by }}.</p>
            <p>Video ID: <b>{{ $unique_numbers }}</b></p>
            <p>Video URL:</p>
            <p><a href="{{ route('video.edit',$video_id) }}">Click here to check video.</a></p>
            <p>Thank you</p>
    </body>
</html> 