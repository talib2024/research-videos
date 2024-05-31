<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMessageToSubscribedNewsLetterUsers extends Mailable
{
    use Queueable, SerializesModels;
    public $email,$encrypted_email,$subject,$content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$encrypted_email,$subject,$message)
    {
        $this->email = $email;
        $this->encrypted_email = $encrypted_email;
        $this->subject = $subject;
        $this->content = $message;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
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
            view: 'frontend.mail.sendMessageToSubscribedNewsLetterUsers',
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
