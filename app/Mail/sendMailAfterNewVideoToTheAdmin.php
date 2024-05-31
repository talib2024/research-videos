<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailAfterNewVideoToTheAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $video_id,$video_list,$eligible_editorial_member_email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($video_id,$eligible_editorial_member_email)
    {
        $this->video_id = $video_id;
        $this->video_list = single_video_details($this->video_id);
        $this->eligible_editorial_member_email = $eligible_editorial_member_email;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'New video submission : (“'.$this->video_list->unique_number.'”)',
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
            view: 'frontend.mail.sendMailAfterNewVideoToTheAdmin',
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
