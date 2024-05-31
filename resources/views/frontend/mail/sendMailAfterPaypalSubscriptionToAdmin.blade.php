<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi</p>
            <p>A buyer has subscribed a plan by paypal.</p>
            <p>Buyer details are:</p>
            <p><b>Buyer name: </b>{{ Auth::user()->name }}</p>
            <p><b>Buyer email: </b>{{ Auth::user()->email }}</p>
            <p><b>Buyer address: </b>{{ Auth::user()->address }}</p>
            <p><b>IP address: </b>{{ $transaction_details->ip_address }}</p>
            <br/>
            <p>Purchase details are:</p>
            <p><b>Buying date: </b>{{ \Carbon\Carbon::parse($transaction_details->created_at)->format('Y/m/d  H:i:s') }}</p>
            <p><b>Transaction ID: </b>{{ $transaction_details->transaction_id }}</p>
            <p><b>Plan name: </b>{{ $subscriptionplans_details->plan_name }}</p>
            <p><b>Plan price: </b>${{ $subscriptionplans_details->amount }}</p>
    </body>
</html> 