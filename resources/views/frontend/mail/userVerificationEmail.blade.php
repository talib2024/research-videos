<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $user->name }}</p>
            <p>Your account has been created, please activate your account by clicking this link</p>
            <p>
                <a href="{{ route('user.verify',$user->email_verification_token) }}">
                {{ route('user.verify',$user->email_verification_token) }}
                </a>
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