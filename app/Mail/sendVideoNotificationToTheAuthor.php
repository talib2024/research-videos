<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class sendVideoNotificationToTheAuthor extends Mailable
{
    use Queueable, SerializesModels;
    public $video_id,$video_list,$eligible_editorial_member_email,$user_type,$plain_email,$register_type,$encrypted_author_email,$encrypted_role,$encrypted_majorcategory_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($video_id,$eligible_editorial_member_email,$user_type,$plain_email,$register_type,$majorcategory_id)
    {
        $this->video_id = $video_id;
        $this->video_list = single_video_details($this->video_id);
        $this->eligible_editorial_member_email = $eligible_editorial_member_email;
        $this->user_type = $user_type;
        $this->plain_email = $plain_email;
        $this->register_type = $register_type;
        $this->encrypted_author_email = Crypt::encrypt($plain_email);
        $this->encrypted_role = ($user_type == 'corresponding_author') ? Crypt::encrypt('corresponding_author') : Crypt::encrypt('author');
        $this->encrypted_majorcategory_id = Crypt::encrypt($majorcategory_id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'New video submission : (“'.$this->video_list->unique_number.'”)',
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
            view: 'frontend.mail.sendVideoNotificationToTheAuthor',
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
