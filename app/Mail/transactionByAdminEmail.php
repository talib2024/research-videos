<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class transactionByAdminEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $transaction_details,$sendTo,$user_details,$item_id,$subscriptionplans_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sendTo,$user_details,$transaction_details,$item_id)
    {
        $this->sendTo = $sendTo;
        $this->user_details = $user_details;
        $this->transaction_details = $transaction_details;
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
            subject: 'Transaction By Admin',
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
            view: 'frontend.mail.transactionByAdminEmail',
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
