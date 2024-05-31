<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi</p>
            <p>A buyer has purchased a video by paypal.</p>
            <p>Buyer details are:</p>
            <p><b>Buyer name: </b>{{ Auth::user()->name }}</p>
            <p><b>Buyer email: </b>{{ Auth::user()->email }}</p>
            <p><b>Buyer address: </b>{{ Auth::user()->address }}</p>
            <p><b>IP address: </b>{{ $transaction_details->ip_address }}</p>
            <br/>
            <p>Purchase details are:</p>
            <p><b>Buying date: </b>{{ \Carbon\Carbon::parse($transaction_details->created_at)->format('Y/m/d  H:i:s') }}</p>
            <p><b>Transaction ID: </b>{{ $transaction_details->transaction_id }}</p>
            <p><b>Video Title: </b>{{ $video_list->video_title }}</p>
            <p><b>Video Id: </b>{{ $video_list->unique_number }}</p>
    </body>
</html> 