<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendCommonNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $video_id,$video_status_updated_by,$unique_numbers,$video_list;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($video_id,$video_status_updated_by,$video_status)
    {
        $this->video_id = $video_id;
        $this->video_status_updated_by = $video_status_updated_by;
        $this->unique_numbers = $video_status->unique_number;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Video status Notification',
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
            view: 'frontend.mail.sendCommonNotificationMail',
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
