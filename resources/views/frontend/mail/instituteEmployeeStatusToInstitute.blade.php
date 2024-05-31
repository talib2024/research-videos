<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{  $user->name }}</p>
            <p>You have successfully {{ $status == '1' ? 'activated' : 'deactivated' }} an user. Details are below:</p>

            <p>User ID: <b>{{ $user->unique_member_id }}</b></p>
            <p>User email: <b>{{ $user->email }}</b></p>

        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 