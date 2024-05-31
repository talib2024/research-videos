<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailAfterRVcoinsPurchaseForSubscription extends Mailable
{
    use Queueable, SerializesModels;
    public $user_type,$item_id,$subscriptionplans_details,$transaction_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_type,$item_id,$transaction_details)
    {
        $this->transaction_details = $transaction_details;
        $this->user_type = $user_type;
        $this->item_id = $item_id;
        $this->subscriptionplans_details = subscriptionplans_details($this->item_id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Subscription Details',
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
            view: 'frontend.mail.sendMailAfterRVcoinsPurchaseForSubscription',
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
