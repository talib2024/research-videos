<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailWhenSelectAnotherEditorialMember extends Mailable
{
    use Queueable, SerializesModels;
    public $user_type,$video_details,$new_editor_email,$corresponding_author_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_type,$video_details,$new_editor_email)
    {
        $this->user_type = $user_type;
        $this->video_details = $video_details;
        $this->new_editor_email = $new_editor_email;
        $this->corresponding_author_details = get_user_details($this->video_details->user_id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Editor Assignment  : (“'.$this->video_details->unique_number.'”)',
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
            view: 'frontend.mail.sendMailWhenSelectAnotherEditorialMember',
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
