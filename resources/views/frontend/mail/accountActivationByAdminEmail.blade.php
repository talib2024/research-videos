<!DOCTYPE html>
<html lang="en">
    <body>
    @if($sendTo == 'foradmin')
        <p>Dear Admin,</p>
            <p>A user is activated from your side.</p>
            <p><b>Email: </b>{{ $user_details->email }}</p>
        <p>Thank you</p>
    @endif
    @if($sendTo == 'foruser')
        <p>Dear {{ $user_details->email }},</p>
            <p>Your account is activated. Please login to you account.</p>
             <p>URL:
                <a href="{{ route('welcome') }}">Click here!</a>
             </p>
        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    @endif
    </body>
</html> 