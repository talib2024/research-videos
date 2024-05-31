<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi</p>
            <p>Thanks for your purchase.</p>
            <p>Your purchased details are:</p>
            <p><b>Buying date: </b>{{ \Carbon\Carbon::parse($transaction_details->created_at)->format('Y/m/d  H:i:s') }}</p>
            <p><b>Transaction ID: </b>{{ $transaction_details->transaction_id }}</p>
            <p><b>Plan name: </b>{{ $subscriptionplans_details->plan_name }}</p>
            <p><b>Plan price: </b>${{ $subscriptionplans_details->amount }}</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 