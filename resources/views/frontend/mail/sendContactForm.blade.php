<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Hi,</p>
            <p>One message from the contact form.</p>
            <br/>
            <b>Name: </b><span>{{ $request_data->name }}</span>
            <br/>
            <b>Affiliation: </b><span>{{ $request_data->affiliation }}</span>
            <br/>
            <b>Country: </b><span>{{ $request_data->country }}</span>
            <br/>
            <b>Email: </b><span>{{ $request_data->email }}</span>
            <br/>
            <b>Subject: </b><span>{{ $request_data->subject }}</span>
            <br/>
            <b>Message: </b><span>{{ $request_data->message }}</span>

            
        <p>Thank you</p>
    </body>
</html> 