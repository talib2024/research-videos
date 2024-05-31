<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class sendMailAfterWireTransfer extends Mailable
{
    use Queueable, SerializesModels;
    public $transaction_receipt,$video_id,$video_list;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fileName_transaction_receipt_image,$video_id)
    {
        $this->transaction_receipt = $fileName_transaction_receipt_image;
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
            subject: 'Wire Transfer Payment',
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
            view: 'frontend.mail.sendMailAfterWireTransfer',
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
