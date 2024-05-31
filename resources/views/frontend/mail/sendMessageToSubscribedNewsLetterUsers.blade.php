<!DOCTYPE html>
<html lang="en">
    <body>
        <p>Dear {{ $email }}</p>
        <p>{!! $content !!}</p>

        <br/><br/>
            <p>To unsubscribe please click the below link.</p>

            <p>URL:
            <a href="{{ route('newsletter.unscubscribe',$encrypted_email) }}">Unsubscribe from this NewsLetter ?</a>
            </p>
        <p>Thank you</p>
        <br/>
        <b>{{ config('constants.urls.live_url') }}</b>
        <br/>
        <br/>
        <br/>
        <b>"** This is an automatically generated email **" </b>   
    </body>
</html> 