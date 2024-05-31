<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendAcceptanceEmailToReviewer;
use App\Mail\sendRegistrationUrlToReviewer;
use App\Mail\sendAcceptanceEmailToCorrespondingAuthor;
use App\Mail\sendVideoNotificationToTheEditorNChief;
use App\Mail\sendCommonNotificationMail;
use App\Mail\sendEditorNotificationToAuthors;
use App\Mail\sendMailAfterRejectionByEditor;
use App\Mail\sendMailWhenSelectAnotherEditorialMember;
use App\Mail\sendMailAfterPassToPublisherByEditor;
use App\Mail\sendMailAfterVideoPublished;
use App\Mail\sendEmailPassToReviewerStatusNotificationToAdmin;
use App\Mail\sendMailAfterReviewerDecision;
use App\Mail\sendMailAfterPublisherDecisionExceptPublished;
use App\Mail\sendMailAfterWithdrawnToReviewer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;
use App\Models\Videotype;
use App\Models\Majorcategory;
use App\Models\Videoupload;
use App\Models\User;
use App\Models\Membershipplan;
use App\Models\Coauthor;
use App\Models\Selectedcoauthor;
use App\Models\Country;
use App\Models\Userrole;
use App\Models\Likeunlikecounter;
use App\Models\Watchlaterlist;
use App\Models\videohistory;
use App\Models\Userprofile;

class HistoryController extends Controller
{   
    public function __construct()
    {   
        $this->middleware(['auth','userRole','checkUserStatus'])->except('show_history_messages');  
    }
    public function editor_in_chief_store_history(Request $request)
    {
        DB::beginTransaction();
        try {
        // update last record by chief editor
        $status = videohistory::where('videoupload_id', $request->videoupload_id)
                                ->where('send_from_as','editorial-member')
                                ->update(array('last_record_for_chief_editor' => 0)); 
        // update last record by chief editor 

        // Start, if editor selects any option except reviewer then all the reviewers will be withdrew
            $get_reviewers_emails = DB::table('coauthors')
                ->where('videoupload_id', $request->videoupload_id)
                ->where('authortype_id', 4)
                ->pluck('email');

            $get_accepted_reviewers_emails = DB::table('videohistories')
                ->where('videoupload_id', $request->videoupload_id)
                ->where('videohistorystatus_id', 7)
                ->where('is_accepted_by_reviewer', 1)
                ->pluck('reviewer_email');

            if($get_reviewers_emails->isNotEmpty()) 
            {    
                videohistory::where('videoupload_id', $request->videoupload_id)
                    ->where('videohistorystatus_id', 5)
                    ->where('send_from_as', 'editorial-member')
                    ->where('send_to_as', 'Reviewer')
                    ->whereIn('reviewer_email', $get_reviewers_emails)
                    //->update(['withdraw_reviewer' => 1]);
                    ->update(['is_pass_to_other_than_reviewer' => 1]);

                videohistory::where('videoupload_id', $request->videoupload_id)
                    ->where('videohistorystatus_id', 7)
                    ->where('send_from_as', 'Reviewer')
                    ->where('send_to_as', 'editorial-member')
                    ->whereIn('reviewer_email', $get_reviewers_emails)
                    //->update(['withdraw_reviewer' => 1]);   
                    ->update(['is_pass_to_other_than_reviewer' => 1]);         

                foreach($get_reviewers_emails as $get_reviewers_email_value)
                {
                    if ($get_accepted_reviewers_emails->contains($get_reviewers_email_value)) 
                    {
                        videohistory::where('videoupload_id', $request->videoupload_id)
                                ->where('videohistorystatus_id', 7)
                                ->where('is_accepted_by_reviewer', 1)
                                ->where('reviewer_email', $get_reviewers_email_value)
                                ->update(['is_accepted_by_reviewer' => 0]);      
                        Mail::to($get_reviewers_email_value)->send(new sendMailAfterWithdrawnToReviewer($get_reviewers_email_value,'reviewer',$request->videoupload_id));
                    }
                }
            }
        // End, if editor selects any option except reviewer then all the reviewers will be withdrew

        $data = [];
        //if(isset($request->editorial_member_id) && !empty($request->editorial_member_id))
        if(isset($request->pass_to) && !empty($request->pass_to) && ($request->pass_to == '4'))
        {  
            foreach($request->editorial_member_id as $editorial_member_ids)
            {
                $data[] = [
                    'videoupload_id' => $request->videoupload_id,
                    'videohistorystatus_id' => $request->pass_to,
                    'send_from_user_id' => Auth::user()->id,
                    'send_to_user_id' => $editorial_member_ids,
                    'message' => $request->message,
                    'send_from_as' => 'editor-in-chief',
                    'send_to_as' => 'editorial-member',
                    'last_record_for_chief_editor' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } 
            videohistory::insert($data); 
        }
        elseif(isset($request->pass_to) && !empty($request->pass_to) && ($request->pass_to == '5'))
        {
            foreach($request->reviewer_email as $reviewer_emails)
            {
                $video_history_update = videohistory::where('videoupload_id', $request->videoupload_id)
                                        ->where('send_from_as','editorial-member')
                                        ->where('send_to_as','Reviewer')
                                        ->where('reviewer_email',$reviewer_emails)
                                        ->update(array('is_latest_record_for_reviewer_from_editor' => 0));
                $data[] = [
                    'videoupload_id' => $request->videoupload_id,
                    'videohistorystatus_id' => $request->pass_to,
                    'send_from_user_id' => Auth::user()->id,
                    //'send_to_user_id' => $request->reviewer_email,
                    'message' => $request->message,
                    'send_from_as' => 'editorial-member',
                    'send_to_as' => 'Reviewer',
                    'reviewer_email' => $reviewer_emails,
                    'last_record_for_chief_editor' => 1,
                    'is_latest_record_for_reviewer_from_editor' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            videohistory::insert($data); 
            $corresponding_author_details = get_user_details($request->author_id);
            foreach($request->reviewer_email as $reviewer_emails)
            {
                $encrypted_video_id = Crypt::encrypt($request->videoupload_id);
                $encrypted_majorcategory_id = Crypt::encrypt($request->majorcategory_id);
                $encrypted_reviewer_email = Crypt::encrypt($reviewer_emails);
                $plain_reviewer_email = $reviewer_emails; 
                $admin_email = config('constants.emails.admin_email');
                // To the each reviewer
                Mail::to($reviewer_emails)->send(new sendAcceptanceEmailToReviewer($encrypted_video_id,$encrypted_reviewer_email,$plain_reviewer_email,$encrypted_majorcategory_id));
                // To the admin
                Mail::to($admin_email)->send(new sendEmailPassToReviewerStatusNotificationToAdmin($reviewer_emails,$request->videoupload_id,$corresponding_author_details->email));
            }
        }
        //elseif(isset($request->publisher_id) && !empty($request->publisher_id))
        elseif(isset($request->pass_to) && !empty($request->pass_to) && ($request->pass_to == '6'))
        {
            $videohistory = new videohistory();
            $videohistory->videoupload_id = $request->videoupload_id;
            $videohistory->videohistorystatus_id = $request->pass_to;
            $videohistory->send_from_user_id = Auth::user()->id;
            $videohistory->send_to_user_id = $request->publisher_id;
            $videohistory->message = $request->message;
            $videohistory->send_from_as = 'editorial-member';
            $videohistory->send_to_as = 'Publisher';
            $videohistory->last_record_for_chief_editor = 1;
            $videohistory->save();

            $send_to_mail = get_user_details($request->publisher_id);
            $video_status = single_video_details($request->videoupload_id);
            $author_details = author_details('5',$request->videoupload_id);
            $corr_author_details = author_details('3',$request->videoupload_id);
            $ccAuthorRecipients_array = [];
            foreach($author_details as $author_details_values)
            {
                array_push($ccAuthorRecipients_array, $author_details_values->email);
            }

            // mail send to publisher
            Mail::to($send_to_mail->email)->send(new sendMailAfterPassToPublisherByEditor('publisher',$video_status));
            // Mail send to the editor
            Mail::to(Auth::user()->email)->send(new sendMailAfterPassToPublisherByEditor('editor',$video_status));
            // mail send to admin
            $admin_email = config('constants.emails.admin_email');
            Mail::to($admin_email)->send(new sendMailAfterPassToPublisherByEditor('admin',$video_status)); 
            // mail send to authors
            Mail::to($corr_author_details[0]->email)->cc($ccAuthorRecipients_array)->send(new sendMailAfterPassToPublisherByEditor('authors',$video_status)); 
            
            
        }
        elseif(isset($request->pass_to) && !empty($request->pass_to) && ($request->pass_to == '25'))
        {
            $validatedData = $request->validate([
                'videoupload_id' => 'required',  
                'message' => 'required', 
            ], [        
                'required' => 'This field is required'
            ]);
            // pass to another editorial member

            $video_id = $request->videoupload_id;
            $videoupload_details = Videoupload::find($video_id);
            $videoupload_details->subcategory_id = json_decode($videoupload_details->subcategory_id, true);
            $get_eligible_editorial_member = get_eligible_user_to_pass_another_member($videoupload_details->majorcategory_id,$videoupload_details->subcategory_id);
            
            if($get_eligible_editorial_member == 'norecord')
            {
                //$request->session()->flash('success', 'There is no any other editorial member available yet.');
                return response()->json(['success'=>'fail','msg'=>'There is no any other editorial member available yet.']); 
            }
            else
            {
                $get_eligible_editorial_member_id = $get_eligible_editorial_member;
                // Start save into history table        
                $videohistory = new videohistory();
                $videohistory->videoupload_id = $video_id;
                $videohistory->videohistorystatus_id = 25; // from videohistorystatuses table
                $videohistory->send_from_user_id = Auth::id();
                $videohistory->send_to_user_id = $get_eligible_editorial_member_id;
                $videohistory->send_from_as = 'editorial-member';
                $videohistory->send_to_as = 'editorial-member';
                $videohistory->message = $request->message;
                $videohistory->last_record_for_chief_editor = 1;
                $videohistory->save();

                $get_eligible_editorial_member_details = get_user_details($get_eligible_editorial_member_id);

                $videoupload_update = Videoupload::find($video_id);
                // echo '<pre>';
                // print_r($videoupload_update);exit;
                $videoupload_update->currently_assigned_to_editorial_member = $get_eligible_editorial_member_id;
                $videoupload_update->save();

                $video_status = single_video_details($video_id);
                // mail send to another editorial member
                Mail::to($get_eligible_editorial_member_details->email)->send(new sendMailWhenSelectAnotherEditorialMember('editorial_member',$video_status,$get_eligible_editorial_member_details->email));
                // mail send to admin
                $admin_email = config('constants.emails.admin_email');
                Mail::to($admin_email)->send(new sendMailWhenSelectAnotherEditorialMember('admin',$video_status,$get_eligible_editorial_member_details->email));               
                
                //$request->session()->flash('success', 'Updated successfully.');
                //return response()->json(['success'=>'Successfully']); 
            }
        }
        else
        {
            //Start get corresponding author of this video
            $authors = DB::table('coauthors')
                                ->select('email as author_email')
                                ->where('videoupload_id',$request->videoupload_id)
                                ->where('authortype_id',5)
                                ->get();
            $corr_author_details = DB::table('coauthors')
                                ->select('email as corr_author_email')
                                ->where('videoupload_id',$request->videoupload_id)
                                ->where('authortype_id',3)
                                ->first();
            $user_details = DB::table('users')->select('id')->where('email',$corr_author_details->corr_author_email)->first();
            if($request->status_for_authors == '2')
            {                
                $data[] = [
                    'videoupload_id' => $request->videoupload_id,
                    'videohistorystatus_id' => '26',
                    'send_from_user_id' => Auth::user()->id,
                    'send_to_user_id' => $user_details->id,
                    'message' => $request->message,
                    'send_from_as' => 'editorial-member',
                    'send_to_as' => 'Corresponding-Author',
                    'corresponding_author_email' => $corr_author_details->corr_author_email,
                    'last_record_for_chief_editor' => 1,
                    'corresponding_author_status' => $request->status_for_authors,
                    'message_visibility' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                videohistory::insert($data);

            foreach($authors as $author_emails_for_mail)
            {
                $check_user = User::where('email',$author_emails_for_mail->author_email)->first();
                if(!$check_user)
                {
                    $type = 'signup';
                    if(!empty($author_emails_for_mail->author_email))
                    {
                        Mail::to($author_emails_for_mail->author_email)->send(new sendEditorNotificationToAuthors($request->videoupload_id,'author',$author_emails_for_mail->author_email,$type));
                    }
                }
                else
                {
                    $type = 'login';
                    if(!empty($author_emails_for_mail->author_email))
                    {
                        Mail::to($author_emails_for_mail->author_email)->send(new sendEditorNotificationToAuthors($request->videoupload_id,'author',$author_emails_for_mail->author_email,$type));
                    }
                }
            }

            // To corresponding author
            $type = 'notype';
            Mail::to($corr_author_details->corr_author_email)->send(new sendEditorNotificationToAuthors($request->videoupload_id,'corresponding_author',$corr_author_details->corr_author_email,$type));
            
            // To admin
            $admin_email = config('constants.emails.admin_email');
            $type = 'notype';
            Mail::to($admin_email)->send(new sendEditorNotificationToAuthors($request->videoupload_id,'admin',$corr_author_details->corr_author_email,$type));            
            }
            elseif($request->status_for_authors == '1')
            {       
                // Rejection case         
                $data[] = [
                    'videoupload_id' => $request->videoupload_id,
                    'videohistorystatus_id' => '26',
                    'send_from_user_id' => Auth::user()->id,
                    'send_to_user_id' => $user_details->id,
                    'message' => $request->message,
                    'send_from_as' => 'editorial-member',
                    'send_to_as' => 'Corresponding-Author',
                    'corresponding_author_email' => $corr_author_details->corr_author_email,
                    'last_record_for_chief_editor' => 1,
                    'corresponding_author_status' => $request->status_for_authors,
                    'message_visibility' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                videohistory::insert($data);
            
            $ccAuthorRecipients_array = [];
            foreach($authors as $author_emails_for_mail)
            {
                array_push($ccAuthorRecipients_array, $author_emails_for_mail->author_email);
            }
            $video_status = single_video_details($request->videoupload_id);
            // mail send to authors and corresponding author
            Mail::to($corr_author_details->corr_author_email)->cc($ccAuthorRecipients_array)->send(new sendMailAfterRejectionByEditor('authors',$video_status,$corr_author_details->corr_author_email));
            // mail send to admin
            $admin_email = config('constants.emails.admin_email');
            Mail::to($admin_email)->send(new sendMailAfterRejectionByEditor('admin',$video_status,$corr_author_details->corr_author_email));
            }
            //End get corresponding author of this video
        }
        DB::commit();
        $request->session()->flash('success', 'Updated successfully.');
        return response()->json(['success'=>'Successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction if any operation fails
            DB::rollBack();

            // Log or handle the exception
            // For example:
            // Log::error($e->getMessage());

            // Return error response
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function editor_store_reviewer(Request $request)
    {
        $data = $request->name;
        if (isset($data['1']['editorRevieweremail'])) {
            $reviewerData = [];        
            for ($i = 0; $i < count($data['1']['editorRevieweremail']); $i++) {
                if(isset($data['1']['editorRevieweremail'][$i]))
                {
                    $reviewerData[] = [
                        'user_id' => Auth::id(),
                        'videoupload_id' => $request->videoupload_id_editor,
                        'authortype_id' => 4,
                        'email' => isset($data['1']['editorRevieweremail'][$i]) ? $data['1']['editorRevieweremail'][$i] : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];                    
                }
            }
            Coauthor::insert($reviewerData);
            $request->session()->flash('success', 'Reviewers added successfully!');
            return response()->json(['success'=>'Successfully']);
        }
    }
    public function store_history_by_editorial_member(Request $request)
    {
        $check_last_record = check_last_record($request->videoupload_id);
        if(($check_last_record->videohistorystatus_id == '4' && $check_last_record->send_from_as == 'editor-in-chief') || ($check_last_record->videohistorystatus_id == '8' && $check_last_record->send_from_as == 'editorial-member') || ($check_last_record->videohistorystatus_id == '7' && $check_last_record->send_from_user_id == Auth::id()) || ($check_last_record->send_to_user_id == Auth::id()))
        {
            $videohistory = new videohistory();
            $videohistory->videoupload_id = $request->videoupload_id;
            $videohistory->videohistorystatus_id = $request->videohistorystatus_id;
            $videohistory->send_from_user_id = Auth::user()->id;
            $videohistory->send_to_user_id = $request->send_to_user_id;
            $videohistory->message = $request->message;
            $videohistory->send_from_as = 'editorial-member';
            $videohistory->send_to_as = 'editor-in-chief';
            $videohistory->save();
            $request->session()->flash('success', 'Updated successfully.');
            return response()->json(['success'=>'Successfully']);
        }
        else
        {
            $request->session()->flash('success', 'Already accepted by someone.');
            return response()->json(['success'=>'failed']);
        }
    } 
    public function store_history_by_reviewer_login(Request $request)
    {
        $videohistory = new videohistory();
        $videohistory->videoupload_id = $request->videoupload_id;
        $videohistory->videohistorystatus_id = $request->videohistorystatus_id;
        $videohistory->send_from_user_id = Auth::user()->id;
        $videohistory->send_to_user_id = $request->send_to_user_id;
        $videohistory->message = $request->message;
        $videohistory->send_from_as = 'Reviewer';
        $videohistory->send_to_as = 'editorial-member';
        $videohistory->reviewer_email = $request->reviewer_email;
        $videohistory->save();
        $send_to_mail = get_user_details($request->send_to_user_id);
        $admin_email = config('constants.emails.admin_email');

        // Mail send to the editor
        Mail::to($send_to_mail->email)->send(new sendMailAfterReviewerDecision('editor',$request->videoupload_id));
        // Mail send to the admin
        Mail::to($admin_email)->send(new sendMailAfterReviewerDecision('admin',$request->videoupload_id));
        
        $request->session()->flash('success', 'Updated successfully.');
        return response()->json(['success'=>'Successfully']);
    }
    public function store_history_by_publisher(Request $request)
    {
        if($request->videohistorystatus_id == '18')
        {
            $main_folder_name = 'Videos_Published';
        }
        elseif($request->videohistorystatus_id == '19')
        {
            $main_folder_name = 'Videos_Unpublished';
        }
        elseif($request->videohistorystatus_id == '23')
        {
            $main_folder_name = 'Videos_to_Revise';
        }
        elseif($request->videohistorystatus_id == '24')
        {
            $main_folder_name = 'Videos_on_Hold';
        }
        $single_video_details = single_video_details($request->videoupload_id);
        //Start Move folder
        $category_directory_path = storage_path('app/public/uploads/'.$main_folder_name.'/'.$single_video_details->category_folder_name);
        if (!is_dir($category_directory_path)) {
            // Create the directory if it doesn't exist
            mkdir($category_directory_path, 0755, true); // The third parameter ensures recursive directory creation
        }
        $sourcePath_fullvideo = storage_path('app/public/uploads/'.$single_video_details->main_folder_name.'/' . $single_video_details->category_folder_name.'/' . $single_video_details->unique_number);
        $destinationPath_fullvideo = storage_path('app/public/uploads/'.$main_folder_name.'/' . $single_video_details->category_folder_name.'/' . $single_video_details->unique_number);
        File::move($sourcePath_fullvideo, $destinationPath_fullvideo);
        $path_url_fullvideo = url('/storage/uploads/'.$main_folder_name.'/' . $single_video_details->category_folder_name.'/'. $single_video_details->unique_number.'/' . $single_video_details->uploaded_video);
        if(preg_match('/^(.+)\.(\w+)$/', $single_video_details->uploaded_video, $matches))
        {
            // $matches[1] contains the filename without the extension
            // $matches[2] contains the file extension            
            // Concatenate extra numbers to the filename
            $filename_croppedvideo = $matches[1] . '_cropped' . '.' . $matches[2];
        }
        $path_url_croppedvideo = url('/storage/uploads/'.$main_folder_name.'/' . $single_video_details->category_folder_name.'/'. $single_video_details->unique_number.'/' . $filename_croppedvideo);
        
        //End Move folder

        $videohistory = new videohistory();
        $videohistory->videoupload_id = $request->videoupload_id;
        $videohistory->videohistorystatus_id = $request->videohistorystatus_id;
        $videohistory->send_from_user_id = Auth::user()->id;
        $videohistory->send_to_user_id = $request->send_to_user_id;
        $videohistory->message = $request->message;
        $videohistory->send_from_as = 'Publisher';
        $videohistory->send_to_as = 'editorial-member';
        $videohistory->save();
        if($request->videohistorystatus_id == '18')
        {
            // if published
            $single_video_details = single_video_details($request->videoupload_id);
            $rvoi_link = generate_rvoi_link($single_video_details->short_name,now(),$single_video_details->unique_number);

            $videoPublished = Videoupload::find($request->videoupload_id);
            $videoPublished->is_published = 1;
            $videoPublished->videohistory_id = $videohistory->id;
            $videoPublished->membershipplan_id = $request->membershipplan_id;
            if($videoPublished->membershipplan_id == 1)
            {
                $videoPublished->video_price = $request->video_price;
                $videoPublished->rv_coins_price = $request->rv_coins_price;
            }  
            $videoPublished->rvoi_link = $rvoi_link;
            $videoPublished->full_video_url = $path_url_fullvideo;
            $videoPublished->short_video_url = $path_url_croppedvideo;
            $videoPublished->main_folder_name = $main_folder_name;
            $videoPublished->save();

            $video_status = single_video_details($request->videoupload_id);
            $editorial_member_details = get_user_details($video_status->currently_assigned_to_editorial_member);
            $author_details = author_details('5',$request->videoupload_id);
            $corr_author_details = author_details('3',$request->videoupload_id);
            $ccAuthorRecipients_array = [];
            foreach($author_details as $author_details_values)
            {
                array_push($ccAuthorRecipients_array, $author_details_values->email);
            }

            // mail send to publisher
            Mail::to(Auth::user()->email)->send(new sendMailAfterVideoPublished('publisher',$video_status));
            // mail send to admin
            $admin_email = config('constants.emails.admin_email');
            Mail::to($admin_email)->send(new sendMailAfterVideoPublished('admin',$video_status));

            // mail send to authors
            Mail::to($corr_author_details[0]->email)->cc($ccAuthorRecipients_array)->send(new sendMailAfterVideoPublished('authors',$video_status)); 
            // mail send to editor
            Mail::to($editorial_member_details->email)->send(new sendMailAfterVideoPublished('editorial_member',$video_status));
        }
        else
        {
            $videoPublished = Videoupload::find($request->videoupload_id);
            $videoPublished->is_published = 0;
            $videoPublished->videohistory_id = null;
            $videoPublished->rvoi_link = null;
            $videoPublished->full_video_url = $path_url_fullvideo;
            $videoPublished->short_video_url = $path_url_croppedvideo;
            $videoPublished->main_folder_name = $main_folder_name;
            $videoPublished->save();

            $send_to_mail = get_user_details($request->send_to_user_id);
            $admin_email = config('constants.emails.admin_email');
            //$ccRecipients = [$admin_email, Auth::user()->email];
            //$video_status = single_video_details($request->videoupload_id);
            //Mail::to($send_to_mail->email)->cc($ccRecipients)->send(new sendCommonNotificationMail($request->videoupload_id,Auth::user()->email,$video_status));
           
            // Mail send to the editor
            Mail::to($send_to_mail->email)->send(new sendMailAfterPublisherDecisionExceptPublished('editor',$request->videoupload_id));
            // Mail send to the admin
            Mail::to($admin_email)->send(new sendMailAfterPublisherDecisionExceptPublished('admin',$request->videoupload_id));
        }
        
        $request->session()->flash('success', 'Updated successfully.');
        return response()->json(['success'=>'Successfully']);
    } 

    public function pass_to_another_editorial_member(Request $request)
    {
        $validatedData = $request->validate([
            'video_id' => 'required',  
            'message' => 'required', 
        ], [        
            'required' => 'This field is required'
        ]); 

        $video_id = Crypt::decrypt($request->video_id);
        $videoupload_details = Videoupload::find($video_id);
        $get_eligible_editorial_member = get_eligible_user_to_pass_another_member($videoupload_details->majorcategory_id,$videoupload_details->subcategory_id);
        if($get_eligible_editorial_member == 'norecord')
        {
            $request->session()->flash('success', 'There is no any other editorial member available yet.');
            return response()->json(['success'=>'Successfully']); 
        }
        else
        {
            // Start save into history table        
            $videohistory = new videohistory();
            $videohistory->videoupload_id = $video_id;
            $videohistory->videohistorystatus_id = 1; // from videohistorystatuses table
            $videohistory->send_from_user_id = Auth::id();
            $videohistory->send_to_user_id = $get_eligible_editorial_member;
            $videohistory->send_from_as = 'editorial-member';
            $videohistory->send_to_as = 'editorial-member';
            $videohistory->save();

            $get_eligible_editorial_member_details = get_user_details($get_eligible_editorial_member);

            $videoupload_update = Videoupload::find($video_id);
            $videoupload_update->currently_assigned_to_editorial_member = $get_eligible_editorial_member;
            $videoupload_update->save();

            $admin_email = config('constants.emails.admin_email');
            $ccRecipients = [$admin_email, Auth::user()->email];
            Mail::to($get_eligible_editorial_member_details->email)->cc($ccRecipients)->send(new sendVideoNotificationToTheEditorNChief($video_id));
            $request->session()->flash('success', 'Updated successfully.');
            return response()->json(['success'=>'Successfully']);   
        }     
    }
    public function show_history_messages(Request $request)
    {
        $videohistory = videohistory::select('message')->find($request->historyid);
        return response()->json(['success'=>'Successfully','record'=>$videohistory]);
    }
    public function show_history_messages_visibility(Request $request)
    {
        $videohistory = videohistory::find($request->historyId);
        $videohistory->message_visibility = $request->isChecked;
        $videohistory->save();
        return response()->json(['success'=>'Successfully']);
    }
    public function withdraw_reviewer(Request $request)
    {
        $video_history_array = [];
        foreach($request->withdraw_reviewer_email as $withdraw_reviewer_email_value)
        {
            $withdraw_reviewer_emails_records = explode("__##__",$withdraw_reviewer_email_value);
            $videohistory_id = $withdraw_reviewer_emails_records['0'];
            array_push($video_history_array,$videohistory_id);

            $videohistory_records = videohistory::select('id')->where('videohistory_id',$videohistory_id)->where('videohistorystatus_id',7)->first();
            if($videohistory_records)
            {
                $videohistory_id_new = $videohistory_records->id;
                array_push($video_history_array,$videohistory_id_new);
            }
        }
        videohistory::whereIn('id', $video_history_array)->update(['withdraw_reviewer' => 1]);
        foreach($request->withdraw_reviewer_email as $withdraw_reviewer_email_values)
        {
            $withdraw_reviewer_emails_records = explode("__##__",$withdraw_reviewer_email_values);
            $reviewer_email = $withdraw_reviewer_emails_records['1'];
            videohistory::where('videoupload_id', $request->videoupload_id)
                                ->where('videohistorystatus_id', 7)
                                ->where('is_accepted_by_reviewer', 1)
                                ->where('reviewer_email', $reviewer_email)
                                ->update(['is_accepted_by_reviewer' => 0]); 
            // Mail to the reviewer
            Mail::to($reviewer_email)->send(new sendMailAfterWithdrawnToReviewer($reviewer_email,'reviewer',$request->videoupload_id));
        }
        return redirect()->back()->with('success', 'Reviewer withdrawn successfully.');
    }
    public function withdraw_video(Request $request,$id)
    {
        $videoupload_details = Videoupload::find($id);
        $videoupload_details->withdraw_video = 1;
        $videoupload_details->save();
        return redirect()->back()->with('success', 'Video withdrawn successfully.');
    }
}
