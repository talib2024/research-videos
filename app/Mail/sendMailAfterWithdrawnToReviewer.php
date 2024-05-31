<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use DB;

class sendMailAfterWithdrawnToReviewer extends Mailable
{
    use Queueable, SerializesModels;
    public $reviewer_email,$user_type,$video_id,$reviewer_details,$video_list;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reviewer_email,$user_type,$video_id)
    {
        $this->reviewer_details = DB::table('coauthors')
                                    ->select('name','surname')
                                    ->where('email',$reviewer_email)
                                    ->where('videoupload_id',$video_id)
                                    ->where('authortype_id',4)
                                    ->first();
        $this->user_type = $user_type;
        $this->reviewer_email = $reviewer_email;
        $this->video_list = single_video_details($video_id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Notification to Reviewer ',

        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'frontend.mail.sendMailAfterWithdrawnToReviewer',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
