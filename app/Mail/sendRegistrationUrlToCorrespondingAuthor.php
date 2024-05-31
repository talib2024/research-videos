<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class sendRegistrationUrlToCorrespondingAuthor extends Mailable
{
    use Queueable, SerializesModels;
    public $corrauthor_email, $encrypted_corrauthor_email, $encrypted_majorcategory_id,$type,$encrypted_role;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($corrauthor_email,$encrypted_corrauthor_email,$encrypted_majorcategory_id,$type)
    {
        $this->corrauthor_email = $corrauthor_email;
        $this->encrypted_corrauthor_email = $encrypted_corrauthor_email;
        $this->encrypted_majorcategory_id = $encrypted_majorcategory_id;
        $this->type = $type;
        $this->encrypted_role = Crypt::encrypt('Corresponding-Author');
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: ($this->type == 'signup') ? 'Registration Url To Corresponding Author' : 'Login Url To Corresponding Author',
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
            view: 'frontend.mail.sendRegistrationUrlToCorrespondingAuthor',
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
