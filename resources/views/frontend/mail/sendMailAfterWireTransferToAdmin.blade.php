<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi,</p>
            <p>A buyer has purchased a video.</p>
            <p>Buyer Email: <b>{{ Auth::user()->email }}</b></p>
            <p>Purchased video is:</p>
            <p><a href="{{ route('video.details',$video_list->id) }}">{!! generate_rvoi_link($video_list->short_name,$video_list->videohistories_created_at,$video_list->unique_number) !!}</a></p>
            <p>Please Check the attached uploaded transaction receipt by the buyer.</p>
    </body>
</html> 