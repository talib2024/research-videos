<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendNewsletterNotificationToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $user_email,$subscription_type,$newslettersubscription_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_email,$subscription_type,$newslettersubscription_details)
    {
        $this->user_email = $user_email;
        $this->subscription_type = $subscription_type;        
        $this->newslettersubscription_details = $newslettersubscription_details; 
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        if($this->subscription_type == '1')
        {
            return new Envelope(
                subject: 'Newsletter Subscription Notification',
            );
        }
        else
        {
            return new Envelope(
                subject: 'Newsletter Un-Subscription Notification',
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
            view: 'frontend.mail.sendNewsletterNotificationToAdmin',
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
