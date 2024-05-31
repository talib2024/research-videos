<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailAfterVideoPublished extends Mailable
{
    use Queueable, SerializesModels;
    public $user_type,$video_details,$corresponding_author_details,$editor_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_type,$video_details)
    {
        $this->user_type = $user_type;
        $this->video_details = $video_details;
        $this->corresponding_author_details = get_user_details($this->video_details->user_id);
        $this->editor_details = get_user_details($this->video_details->currently_assigned_to_editorial_member);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Published Video : (“'.$this->video_details->unique_number.'”)',
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
            view: 'frontend.mail.sendMailAfterVideoPublished',
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
