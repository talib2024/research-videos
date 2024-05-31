<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendAcceptanceEmailToCorrespondingAuthor extends Mailable
{
    use Queueable, SerializesModels;
    public $encrypted_video_id;
    public $encrypted_corr_author_email;
    public $plain_corr_author_email,$encrypted_majorcategory_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($encrypted_video_id,$encrypted_corr_author_email,$plain_corr_author_email,$encrypted_majorcategory_id)
    {
        $this->encrypted_video_id = $encrypted_video_id;
        $this->encrypted_corr_author_email = $encrypted_corr_author_email;
        $this->plain_corr_author_email = $plain_corr_author_email;
        $this->encrypted_majorcategory_id = $encrypted_majorcategory_id;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Video Acceptance Email',
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
            view: 'frontend.mail.sendAcceptanceEmailToCorrespondingAuthor',
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
