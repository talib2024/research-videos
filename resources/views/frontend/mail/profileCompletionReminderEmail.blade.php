<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $user->name }}</p>
            <p>Your profile is completed only {{ $progress_count }}%</p>
            <p>Please complete your profile.</p>

            <p>URL:
            <a href="{{ config('constants.urls.url') }}">{{ config('constants.urls.url') }}</a>
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