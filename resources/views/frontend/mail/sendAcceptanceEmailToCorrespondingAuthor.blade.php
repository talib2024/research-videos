<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $plain_corr_author_email }}</p>
            <p>You have been selected as a corresponding author for a video.</p>
            <p>Please click the url to accept/deny the request. After accepting, you will get a mail to review the video.</p>

            <p>URL:
            <a href="{{ route('corrauthor.acceptance',[$encrypted_corr_author_email,$encrypted_video_id,$encrypted_majorcategory_id]) }}">Please click here</a>
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