<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi, {{ $payment_details->email }}</p>
            <p>Your subscription plan is going to expire. Please login to your account and renew the plan.</p>

            <p>URL:
            <a href="{{ route('member.login') }}">click here to login.</a>
            </p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 