<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear user,</p>

        @if($status == '1')
        <p>You have been successfully activated by your institution. You can login from below url:</p>
        <p>URL:
            <a href="{{ route('organization.login') }}">Login from here!</a>
        </p>
        @else
        <p>You have been successfully deactivated by your institution. Please contact your institute.</p>
        @endif

        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 