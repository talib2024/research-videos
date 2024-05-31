<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear Admin,</p>
         <p> A reviewer {{ $reviewer_emails }}”,</p>
         <p> has been invited by the Editor “{{ Auth::user()->email }}”, </p>
        <p> to review the video “{{ $video_list->unique_number }}”, </p>
        <p> submitted by the corresponding author “{{ $corresponding_author_email }}”, </p>
       <p>  under the discipline “{{ $video_list->category_name }}”</p>
    </body>
</html> 