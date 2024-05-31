<!DOCTYPE html>
<html lang="en">
    <body>
    @if($sendTo == 'foradmin')
        <p>Dear Admin,</p>
            <p>A user is requested for the account activation. Please activate the account from the admin panel.</p>
            <p><b>Requested Email: </b>{{ $user_email }}</p>
        <p>Thank you</p>
    @endif
    </body>
</html> 