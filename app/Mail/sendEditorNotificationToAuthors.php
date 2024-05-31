<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class sendEditorNotificationToAuthors extends Mailable
{
    use Queueable, SerializesModels;
    public $video_id,$user_type,$encrypted_author_email,$register_type,$video_list,$encrypted_majorcategory_id,$encrypted_role,$plain_author_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($video_id,$user_type,$author_email,$register_type)
    {
        $this->video_id = $video_id;
        $this->video_list = single_video_details($this->video_id);
        $this->user_type = $user_type;
        $this->register_type = $register_type;
        $this->plain_author_email = $author_email;
        $this->encrypted_author_email = Crypt::encrypt($author_email);
        $this->encrypted_role = ($user_type == 'corresponding_author') ? Crypt::encrypt('corresponding_author') : Crypt::encrypt('author');
        $this->encrypted_majorcategory_id = Crypt::encrypt($this->video_list->majorcategory_id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Decision on Video Submission : (“::'.$this->video_list->unique_number.'”)',
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
            view: 'frontend.mail.sendEditorNotificationToAuthors',
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
