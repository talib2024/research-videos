<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi</p>
            <p>Thankyou. Your purchage will be confirmed soon by our financial team.</p>
            <p>Your purchased plan details are:</p>
            <p><b>Plan name: </b>{{ $plan_name }}</p>
            <p><b>Plan price: </b>{{ $amount }}</p>
            <p>Please Check the attached uploaded transaction receipt by you.</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 