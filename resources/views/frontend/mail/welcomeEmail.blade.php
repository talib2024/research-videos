<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $user->name }}</p>
        <p>Thank you for registering with us.</p>
            <p>Your profile is completed only {{ $progress_count }}%</p>
            <p>Please complete your profile.</p>

            <p>URL:
            <a href="{{ config('constants.urls.url') }}">{{ config('constants.urls.url') }}</a>
            </p>
            
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