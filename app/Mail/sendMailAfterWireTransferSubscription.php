<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class sendMailAfterWireTransferSubscription extends Mailable
{
    use Queueable, SerializesModels;
    public $transaction_receipt,$plan_name,$amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fileName_transaction_receipt_image,$plan_name,$amount)
    {
        $this->transaction_receipt = $fileName_transaction_receipt_image;
        $this->plan_name = $plan_name;
        $this->amount = $amount;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Subscription Wire Transfer Details',
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
            view: 'frontend.mail.sendMailAfterWireTransferSubscription',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $path = storage_path('app/public/uploads/wire_transfer_receipt/' . $this->transaction_receipt);

        return [
            Attachment::fromPath($path)
            ->as('transaction receipt'),
        ];
    }
}
