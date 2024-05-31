<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear Admin,</p>
        <p>A new video “{{ $video_list->unique_number }}”,</p>
        <p>has been submitted by the corresponding author “{{ Auth::user()->email }}”, </p>
        <p>under the discipline “{{ $video_list->category_name }}”. </p>
        <p>This video has been assigned to the Editor “{{ $eligible_editorial_member_email }}” </p>

    </body>
</html> 