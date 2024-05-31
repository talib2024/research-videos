<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear Admin,</p>

        @if($subscription_type == '1')
            <p>One user is Subscribed for the latest newsletters with us.</p>
            <br/>
            <p><b>Subscribed user email:  </b>{{ $user_email }}</p>
            <p><b>Subscribed date: </b>{{ \Carbon\Carbon::parse($newslettersubscription_details->created_at)->format('Y/m/d') }}</p>
        @else
            <p>One user is Un-subscribed for the latest newsletters with us.</p>
            <br/>
            <p><b>User email:  </b>{{ $user_email }}</p>
            <p><b>Unsubscribed date: </b>{{ \Carbon\Carbon::now()->format('Y/m/d') }}</p>
        @endif
            
        <p>Thank you</p>
    </body>
</html> 