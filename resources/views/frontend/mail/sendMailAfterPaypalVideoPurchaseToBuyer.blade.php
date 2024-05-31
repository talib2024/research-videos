<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi</p>
            <p>Thanks for your purchase.</p>
            <p>Your purchased details are:</p>
            <p><b>Buying date: </b>{{ \Carbon\Carbon::parse($transaction_details->created_at)->format('Y/m/d  H:i:s') }}</p>
            <p><b>Transaction ID: </b>{{ $transaction_details->transaction_id }}</p>
            <p><b>Video Title: </b>{{ $video_list->video_title }}</p>
            <p><b>Video Id: </b>{{ $video_list->unique_number }}</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 