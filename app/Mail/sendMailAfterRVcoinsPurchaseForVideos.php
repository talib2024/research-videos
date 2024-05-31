<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailAfterRVcoinsPurchaseForVideos extends Mailable
{
    use Queueable, SerializesModels;
    public $user_type,$video_id,$video_list,$transaction_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_type,$video_id,$transaction_details)
    {
        $this->transaction_details = $transaction_details;
        $this->user_type = $user_type;
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
            subject: 'Video Purchase Details',
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
            view: 'frontend.mail.sendMailAfterRVcoinsPurchaseForVideos',
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
