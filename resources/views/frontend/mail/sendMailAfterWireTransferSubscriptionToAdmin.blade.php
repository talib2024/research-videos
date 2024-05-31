<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi,</p>
            <p>A buyer has subscribed a plan by wire transefer.</p>
            <p>Buyer Email: <b>{{ Auth::user()->email }}</b></p>
            <p>Purchased plan details are:</p>
            <p><b>Plan name: </b>{{ $plan_name }}</p>
            <p><b>Plan price: </b>{{ $amount }}</p>
            <p>Please Check the attached uploaded transaction receipt by the buyer.</p>
    </body>
</html> 