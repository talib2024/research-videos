<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear Admin,</p>
        @if($type == 'signup')
            <p>A new user is just completed the signup process on the ResearchVideos.net ! The email verification is pending.</p>
            <p>Details are as following:</p>
            <p><b>Email: </b>{{ $user->email }}</p>
            <p><b>Ip address: </b>{{ $user->user_registered_ip_address }}</p>
            <p><b>Date: </b>{{ \Carbon\Carbon::parse($user->created_at)->format('Y/m/d  H:i:s') }}</p>
        @elseif($type == 'emailverification')
            <p>A new user has confirmed his registeration to ResearchVideos.net !</p>
            <p>Details are as following:</p>
            <p><b>Email: </b>{{ $user->email }}</p>
            <p><b>Date: </b>{{ \Carbon\Carbon::parse($user->email_verified_at)->format('Y/m/d  H:i:s') }}</p>
        @endif
        <p>Thank you</p>
    </body>
</html> 