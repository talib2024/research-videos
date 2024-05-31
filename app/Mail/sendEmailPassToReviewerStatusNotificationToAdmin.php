<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendEmailPassToReviewerStatusNotificationToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $reviewer_emails,$video_id,$corresponding_author_email,$video_list;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reviewer_emails,$video_id,$corresponding_author_email)
    {
        $this->video_id = $video_id;
        $this->video_list = single_video_details($this->video_id);
        $this->reviewer_emails = $reviewer_emails;
        $this->corresponding_author_email = $corresponding_author_email;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Invitation to review a video at ResearchVideos',
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
            view: 'frontend.mail.sendEmailPassToReviewerStatusNotificationToAdmin',
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
