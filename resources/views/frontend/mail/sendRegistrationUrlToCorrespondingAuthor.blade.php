<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $corrauthor_email }}</p>
            <p>You have accepted the invitation for reviewing the video.</p>

            <p>URL:
            @if($type == 'signup')
            <a href="{{ route('reviewer.register',[$encrypted_corrauthor_email,$encrypted_majorcategory_id,$encrypted_role]) }}">Please click here to create your account.</a>
            @else
            <a href="{{ route('member.login') }}">Please click here to login your account.</a>
            @endif
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