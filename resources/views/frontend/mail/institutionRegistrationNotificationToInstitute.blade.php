<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{  $user->name }}</p>
            <p>A user is registered through your institute. Details are below:</p>

            <p>User ID: <b>{{ $user->unique_member_id }}</b></p>
            <p>User email: <b>{{ $user->email }}</b></p>

        <p>Please login to your account and verifiy the user.</p>

        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 