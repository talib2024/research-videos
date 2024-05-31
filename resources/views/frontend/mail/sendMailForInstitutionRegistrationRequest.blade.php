<!DOCTYPE html>
<html lang="en">
    <body>
    @if($user_type == 'admin')
        <p>Hi,</p>
            <p>Institution Register Request.</p>
            <br/>
            <b>Name: </b><span>{{ $request_data->name }}</span>
            <br/>
            <b>Institution Name: </b><span>{{ $request_data->affiliation }}</span>
            <br/>
            <b>Country: </b><span>{{ $request_data->country }}</span>
            <br/>
            <b>Institution Representative Email: </b><span>{{ $request_data->email }}</span>            
            <br/>
            <b>Message: </b><span>{{ $request_data->message }}</span>
        <p>Thank you</p>
    @elseif($user_type == 'user')
        <p>Hello,</p>
            <p>Your Message to {{ config('constants.urls.live_url') }} was successfully Received !</p>
            <br/>
            <p>We will contact you as soon as possible.. </p>
            <br/>
            <p>Thank you for contacting us, </p>
            <br/>
            <b>{{ config('constants.urls.live_url') }} </b>
            <br/>
            <br/>
            <br/>
            <b>"** This is an automatically generated email **" </b>   

    @endif
    </body>
</html> 