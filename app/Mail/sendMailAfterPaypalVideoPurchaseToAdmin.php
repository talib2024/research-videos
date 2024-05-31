<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailAfterPaypalVideoPurchaseToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $transaction_details,$video_id,$video_list;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction_details,$video_id)
    {
        $this->transaction_details = $transaction_details;
        $this->video_id = $video_id;
        $this->video_list = single_video_details($this->video_id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Paypal Video Purchase from a buyer',
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
            view: 'frontend.mail.sendMailAfterPaypalVideoPurchaseToAdmin',
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
