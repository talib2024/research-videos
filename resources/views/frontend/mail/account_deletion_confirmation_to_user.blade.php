<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $user->name }},</p>
            <p>Following your request, your account with the login '{{ $user->email }}' was successfully deleted ! We look forward to welcoming you back at {{ config('constants.urls.live_url') }} !</p>
        <p>Thank you</p>
            <br/>
            <b>{{ config('constants.urls.live_url') }}</b>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 