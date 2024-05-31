<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use DB;

class sendRegistrationUrlToReviewer extends Mailable
{
    use Queueable, SerializesModels;
    public $reviewer_email, $encrypted_reviewer_email, $encrypted_majorcategory_id,$type,$encrypted_role,$user_type,$video_id,$status_type,$reviewer_details,$video_list,$editorial_member_details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reviewer_email,$encrypted_reviewer_email,$encrypted_majorcategory_id,$type,$user_type,$video_id,$status_type,$editorial_member_id)
    {
        $this->reviewer_details = DB::table('coauthors')
                                    ->select('name','surname')
                                    ->where('email',$reviewer_email)
                                    ->where('authortype_id',4)
                                    ->first();
        $this->video_list = single_video_details($video_id);
        $this->user_type = $user_type;
        $this->editorial_member_details = get_user_details($editorial_member_id);
        $this->status_type = $status_type;
        $this->reviewer_email = $reviewer_email;
        $this->encrypted_reviewer_email = $encrypted_reviewer_email;
        $this->encrypted_majorcategory_id = $encrypted_majorcategory_id;
        $this->type = $type;
        $this->encrypted_role = Crypt::encrypt('Reviewer');
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        if($this->status_type == 'accept')
        {
            return new Envelope(
                subject: 'Accepted review task : (“'.$this->video_list->unique_number.'”)',
            );
        }
        elseif($this->status_type == 'decline')
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
            view: 'frontend.mail.sendRegistrationUrlToReviewer',
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
