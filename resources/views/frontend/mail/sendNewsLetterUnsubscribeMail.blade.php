<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $email }}</p>
        <p>You have successfully unsubscribed from ResearchVideos newsletter.</p>
            <p>To Subscribe again, click the URL: <a href="{{ route('welcome') }}">Subscribe again ?</a></p>

        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 