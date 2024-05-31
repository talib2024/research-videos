<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $user->name }}</p>
        <p>Your account has been created with us. You can login using below credentials.</p>

            <p>URL:
            <a href="{{ route('member.login') }}">Click here to login!</a>
            </p>
            <p><b>Email: {{ $user->email }}</b></p>
            <p><b>Password: {{ $request_password }}</b></p>

            <p><b>Note: </b>Please change your password after logging into your account.</p>
            
            <p>&nbsp;</p>
            {{-- <p>You can invite to the new members for registering here, after clicking the below link.</p>
            <p>URL:
            <a href="{{ route('invite.new.member',Crypt::encrypt($user->id)) }}">Invite a new member</a>
            </p> --}}
            <p>You can click on this link <a href="{{ route('invite.new.member',Crypt::encrypt($user->id)) }}">Invite a new member</a> to invite new members to register.</p>
        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 