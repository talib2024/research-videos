<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use DB;
use Illuminate\Support\Facades\Crypt;

class sendAcceptanceEmailToReviewer extends Mailable
{
    use Queueable, SerializesModels;
    public $video_history_details,$encrypted_video_id;
    public $encrypted_reviewer_email;
    public $plain_reviewer_email,$encrypted_majorcategory_id,$reviewer_details,$plain_video_id,$video_list;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($encrypted_video_id,$encrypted_reviewer_email,$plain_reviewer_email,$encrypted_majorcategory_id)
    {
        $this->reviewer_details = DB::table('coauthors')
                                    ->select('name','surname')
                                    ->where('email',$plain_reviewer_email)
                                    ->where('authortype_id',4)
                                    ->first();
        $this->plain_video_id = Crypt::decrypt($encrypted_video_id);
        $this->video_list = single_video_details($this->plain_video_id);
        $this->encrypted_video_id = $encrypted_video_id;
        $this->encrypted_reviewer_email = $encrypted_reviewer_email;
        $this->plain_reviewer_email = $plain_reviewer_email;
        $this->encrypted_majorcategory_id = $encrypted_majorcategory_id;
        $this->video_history_details = DB::table('videohistories')
                                            ->where('videoupload_id',$this->plain_video_id)
                                            ->where('send_from_as','editorial-member')
                                            ->where('send_to_as','Reviewer')
                                            ->where('reviewer_email',$this->plain_reviewer_email)
                                            ->where('is_latest_record_for_reviewer_from_editor',1)
                                            ->first();
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
            view: 'frontend.mail.sendAcceptanceEmailToReviewer',
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
