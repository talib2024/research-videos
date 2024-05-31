<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear Admin,</p>
        @if($status == 'accept')
            <p>The reviewer “{{ $reviewer_emails }}”, </p>
            <p>invited by the Editor “{{ $editor_details->email }}”, has accepted the invitation</p> 
            <p>to review the video “{{ $video_list->unique_number }}”,</p> 
            <p>submitted by the corresponding author “{{ $corresponding_author_details->email }}”, </p>
            <p>under the discipline "{{ $video_list->category_name }}".</p>
        @elseif($status == 'decline')
           <p>The reviewer “{{ $reviewer_emails }}”,</p> 
           <p> invited by the Editor “{{ $editor_details->email }}”, denied the invitation</p> 
           <p> to review the video “{{ $video_list->unique_number }}”,</p> 
           <p> submitted by the corresponding author “{{ $corresponding_author_details->email }}”, </p>
           <p> under the discipline "{{ $video_list->category_name }}".</p>
        @endif
    </body>
</html> 