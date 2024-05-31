<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $to_email }}</p>
            <br/>   
            <p>Hello,</p>
            <br/>                  
            <p><a href="{{ route('member.register') }}">Click here to register</a> to join ResearchVideos.net</p>
            <br/>
            <p>ResearchVideos is a new cutting-edge scientific research video platform.</p>
            <br/>
            <p>ResearchVideos is developed by the community of researchers and academics.</p>
            <br/>
            <p>ResearchVideos will reshape the scholarly publishing in the era of the metaverse and digital revolution.</p>
            <br/>    
            <br/>                  
            <p>This is an invitation by:</p>
            <br/>
            {{-- <p>Name: <span>{{ $user_details->name }}</span></p> --}}
            <p>email: <span>{{ $user_details->email }}</span></p>
            <br/>
            <br/>            
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>                
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 