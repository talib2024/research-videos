<!DOCTYPE html>
<html lang="en">
    <body>
    @if($sendTo == 'foradmin')
        <p>Dear Admin,</p>
            <p>You have assigned a subscription plan to a user.</p>
            <p>User details are:</p>
            <p><b>User name: </b>{{ $user_details->name }}</p>
            <p><b>User email: </b>{{ $user_details->email }}</p>
            <br/>
            <p>Subscription details are:</p>
            <p><b>Subscription date: </b>{{ \Carbon\Carbon::parse($transaction_details->created_at)->format('Y/m/d  H:i:s') }}</p>
            <p><b>Plan name: </b>{{ $subscriptionplans_details->plan_name }}</p>
        <p>Thank you</p>
    @endif
    @if($sendTo == 'foruser')
        <p>Dear {{ $user_details->email }},</p>
          <p>You have been assigned a subscription plan by admin.</p>
            <p>Your subscription details are:</p>
            <p><b>Subscription date: </b>{{ \Carbon\Carbon::parse($transaction_details->created_at)->format('Y/m/d  H:i:s') }}</p>
            <p><b>Plan name: </b>{{ $subscriptionplans_details->plan_name }}</p>
        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    @endif
    </body>
</html> 