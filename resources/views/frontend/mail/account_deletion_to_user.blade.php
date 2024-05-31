<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $user->name }}</p>
            Your request to delete your account at ResearchVideos has been registered.  
It will be treated soon by our technical support team. You will receive a confirmation notice to your email address !
        <p>Thank you</p>
            <br/>
            <b>{{ config('constants.urls.live_url') }}</b>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 