<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear Editor,</p>
            <p>A new video “{{ $video_list->unique_number }}” has been submitted to ResearchVideos.net for potential publication in your scientific discipline.</p>
            <p>Kindly login to pass this video to at least two reviewers, take a decision, or to pass it to another Editorial Member.</p>
            <p>Thank you for your time and dedication.</p>
            <br/>
            <br/>
            <p>{{ config('constants.urls.live_url') }}</p>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 