<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear Admin,</p>
            <p>Delete Account email_address_of_this_user: <a href="{{ route('adminusers.destroy', $user->id) }}">{{ $user->email }}</a></p>
        <p>Thank you</p>
    </body>
</html> 