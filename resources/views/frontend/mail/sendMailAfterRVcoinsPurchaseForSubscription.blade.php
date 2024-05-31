<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi</p>

        @if($user_type == 'user')
            <p>Thanks for your purchase.</p>
            <p>Your purchased details are:</p>
            <p><b>Buying date: </b>{{ \Carbon\Carbon::parse($transaction_details->created_at)->format('Y/m/d  H:i:s') }}</p>
            <p><b>Plan name: </b>{{ $subscriptionplans_details->plan_name }}</p>
            <p><b>RVcoins: </b>{{ $subscriptionplans_details->rv_coins_price }}</p>
            <br/>
            <b>{{ config('constants.urls.live_url') }}</b>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   
        @else
            {{-- for admin --}}
            <p>A buyer has purchased a video by RVcoins.</p>
            <p>Buyer details are:</p>
             <p><b>Buyer name: </b>{{ Auth::user()->name }}</p>
            <p><b>Buyer email: </b>{{ Auth::user()->email }}</p>
            <p><b>Buyer address: </b>{{ Auth::user()->address }}</p>
            <p><b>IP address: </b>{{ $transaction_details->ip_address }}</p>
            <br/>
            <p>Purchase details are:</p>
            <p><b>Buying date: </b>{{ \Carbon\Carbon::parse($transaction_details->created_at)->format('Y/m/d  H:i:s') }}</p>
            <p><b>Plan name: </b>{{ $subscriptionplans_details->plan_name }}</p>
            <p><b>RVcoins: </b>{{ $subscriptionplans_details->rv_coins_price }}</p>
        @endif
    </body>
</html> 