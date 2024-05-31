<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMailAfterReviewersActionToTheAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $editor_details,$corresponding_author_details,$reviewer_emails,$video_id,$corresponding_author_email,$video_list,$status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reviewer_emails,$editor_id,$video_id,$status)
    {
        $this->video_id = $video_id;
        $this->video_list = single_video_details($this->video_id);
        $this->editor_details = get_user_details($editor_id);
        $this->corresponding_author_details = get_user_details($this->video_list->user_id);
        $this->reviewer_emails = $reviewer_emails;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        if($this->status == 'accept')
        {
            return new Envelope(
                subject: 'Accepted review task : (“'.$this->video_list->unique_number.'”)',
            );
        }
        elseif($this->status == 'decline')
        {
            return new Envelope(
                subject: 'Declined review task : (“'.$this->video_list->unique_number.'”)',
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
            view: 'frontend.mail.sendMailAfterReviewersActionToTheAdmin',
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
