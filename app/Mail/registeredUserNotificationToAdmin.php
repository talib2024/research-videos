<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class registeredUserNotificationToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $user, $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$type)
    {
        $this->user = $user;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        if($this->type == 'signup')
        {
            return new Envelope(
                subject: 'New user signup process !',
            );
        }
        elseif($this->type == 'emailverification')
        {
            return new Envelope(
                subject: 'A new user has registered !',
            );
        }
        
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'frontend.mail.registeredUserNotificationToAdmin',
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
