<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use App\Mail\correspondingAuthorNotification;
use App\Mail\sendVideoNotificationToTheEditorNChief;
use App\Mail\sendCommonNotificationMail;
use App\Mail\sendVideoNotificationToTheAuthor;
use App\Mail\sendMailAfterVideoUpdate;
use App\Mail\sendMailAfterNewVideoToTheAdmin;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use FFMpeg\Format\Video\X264;
use App\Models\Videotype;
use App\Models\Videosubtype;
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
use App\Models\Subcategory;
use App\Models\VideoView;

class VideoUploadController extends Controller
{   
    public function __construct()
    { 
        $this->middleware(['auth','userRole','checkUserStatus']);  
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country_list = Country::all();
        $coauthor = Coauthor::where('status',1)->get();
        $Videotype = Videotype::where('status',1)->orderBy('sequence')->get();
        $Videosubtype = Videosubtype::where('status',1)->orderBy('sequence')->get();
        $majorcategory = Majorcategory::where('status',1)->orderBy('sequence')->get();
        $paymentype = Membershipplan::where('status',1)->orderBy('sequence')->get();
        return view('frontend.video_upload.video_upload',compact('country_list','Videotype','Videosubtype','majorcategory','paymentype','coauthor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());exit;
        $validatedData = $request->validate([
            'video_title' => 'required',  
            'keywords' => 'required',  
            'references' => 'required',  
            'abstract' => 'required',  
            'declaration_of_interests' => 'required',  
            'declaration_remark' => 'required_if:declaration_of_interests,2',
            'videotype_id' => 'required',  
            'videosubtype_id' => 'required',  
            'majorcategory_id' => 'required',        
            'subcategory_id' => 'required',        
            'terms_n_conditions' => 'required',        
            'membershipplan_id' => 'required',   
            //'video_price' => 'required_if:membershipplan_id,1',           
            'vide_Upload' => 'required|mimes:mp4|max:100000', 
            //'captcha' => 'required|captcha' 
        ], [        
            'required' => 'This field is required',        
            'declaration_remark.required_if' => 'This field is required',  
            'captcha.captcha' => 'Invalid captcha'
        ]);
        

        DB::beginTransaction();
        try {
        $filteredKeywords = array_filter($request->keywords, function ($value) {
            // Remove null values from the array
            return $value !== null;
        });
        $uniquen_number = $this->generateUniqueNumber();
        $videoupload = new Videoupload();
        $videoupload->user_id = Auth::id();
        $videoupload->unique_number = $uniquen_number;
        $videoupload->videostatus_id = 1;
        $videoupload->videotype_id = $request->videotype_id;
        $videoupload->videosubtype_id = $request->videosubtype_id;
        $videoupload->majorcategory_id = $request->majorcategory_id;
        $videoupload->subcategory_id = json_encode($request->subcategory_id);
        $videoupload->video_title = $request->video_title;
        $videoupload->keywords = json_encode($filteredKeywords);
        $videoupload->references = $request->references;
        $videoupload->abstract = $request->abstract;
        $videoupload->declaration_of_interests1 = $request->declaration_of_interests;
        $videoupload->acknowledge = $request->acknowledge;
        $videoupload->doi_link = $request->doi_link;
        if($videoupload->declaration_of_interests1 == 2)
        {
            $videoupload->declaration_remark = $request->declaration_remark;
        }  
        $videoupload->membershipplan_id = $request->membershipplan_id;
        $videoupload->terms_n_conditions = $request->terms_n_conditions;

        if($request->hasFile('vide_Upload')){

                $major_category_details = get_majorcategories($request->majorcategory_id);
                $folderName = str_replace(' ', '_', $major_category_details->category_name);
                $vide_Upload2_image = $request->file('vide_Upload');
                $extension = $vide_Upload2_image->getClientOriginalExtension();
                $newFileName = $uniquen_number . '.' . $extension;
                $newFileName_cropped_file = $uniquen_number . '_cropped.' . $extension;
                //$new_directory = mkdir('app/public/uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number, 0777, true);
                $filePath = $vide_Upload2_image->storeAs('uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number, $newFileName, 'public');
                $video_path_url = asset(Storage::url($filePath));
           
            // Start crop the video
                $video_path = storage_path('app/public/uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number.'/'.$newFileName);
                $croppedVideoPath = storage_path('app/public/uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number.'/'.$newFileName_cropped_file);
                $cropped_video_path_url = url('/storage/uploads/Videos_to_Revise/' . $folderName.'/'.$uniquen_number . '/' . $newFileName_cropped_file);
            
                //$ffmpegCommand = "C:/FFmpeg/bin/ffmpeg -i " . $video_path . " -ss 00:00:00 -t 00:00:20 " . $croppedVideoPath;
                $ffmpegCommand = "ffmpeg -i " . $video_path . " -ss 00:00:00 -t 00:00:45 -preset ultrafast " . $croppedVideoPath;
                $test = exec($ffmpegCommand);
            // End crop the video

           
            // start encrypting the videos
                // $additionalParameters = ['-preset:v','medium'];
            // $highBitrate = (new X264)->setKiloBitrate(1000)->setAdditionalParameters($additionalParameters);
            //start encrypting fulllength files
            $encryptedFolderPath = storage_path('app/public/uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number . '/encrypted_files/');
            if (!file_exists($encryptedFolderPath)) {
                mkdir($encryptedFolderPath, 0755, true); // Create the folder recursively
            }
            $filePath_fulllength = storage_path('app/public/uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number.'/'.$newFileName);
            $encryptedPath_fulllength = $encryptedFolderPath . $uniquen_number . '.m3u8';
            $cmd_fulllength = "ffmpeg -i " . $filePath_fulllength . " -codec:v libx264 -b:v 1000k -preset:v ultrafast -hls_time 300 -hls_playlist_type vod -hls_segment_type mpegts ".$encryptedPath_fulllength;
            $test_fulllength = exec($cmd_fulllength);

                // FFMpeg::fromDisk('public')
                //     ->open($filePath) // Provide the path relative to the 'local' disk
                //     ->exportForHLS()
                //     ->withRotatingEncryptionKey(function ($filename, $contents) use ($folderName,$uniquen_number) {
                //         Storage::disk('public')->put('uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number . '/encrypted_files/' . $filename, $contents);
                //     })
                //     ->addFormat($highBitrate)
                //     ->save('uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number . '/encrypted_files/'.$uniquen_number.'.m3u8');
            //end encrypting fulllength files
            //start encrypting cropped files
            $encryptedPath_cropped = $encryptedFolderPath . $uniquen_number . '_cropped.m3u8';
            $cmd_cropped = "ffmpeg -i " . $croppedVideoPath . " -codec:v libx264 -b:v 1000k -preset:v ultrafast -hls_time 300 -hls_playlist_type vod -hls_segment_type mpegts ".$encryptedPath_cropped;
            $test_cropped = exec($cmd_cropped);
                // FFMpeg::fromDisk('public')
                //     ->open('uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number.'/'.$newFileName_cropped_file) // Provide the path relative to the 'local' disk
                //     ->exportForHLS()
                //     ->withRotatingEncryptionKey(function ($filename, $contents) use ($folderName,$uniquen_number) {
                //         Storage::disk('public')->put('uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number . '/encrypted_files/' . $filename, $contents);
                //     })
                //     ->addFormat($highBitrate)
                //     ->save('uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number . '/encrypted_files/'.$uniquen_number.'_cropped.m3u8');

            FFMpeg::fromDisk('public')
                ->open('uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number.'/'.$newFileName_cropped_file) // Provide the path relative to the 'local' disk
                ->getFrameFromSeconds(3)
                ->export()
                ->save('uploads/Videos_to_Revise/'.$folderName.'/'.$uniquen_number . '/'.$uniquen_number.'_screenshot.webp');
            //end encrypting cropped files
            // end encrypting the videos

            $videoupload->full_video_url = $video_path_url;
            $videoupload->short_video_url = $cropped_video_path_url;
            $videoupload->main_folder_name = 'Videos_to_Revise';
            $videoupload->category_folder_name = $folderName;
            $videoupload->uploaded_video = $newFileName;
        }
        $videoupload->save();
        // Assuming $data is the array you provided
        $data = $request->name;
        
         // Storing data for the second index
        // if (isset($data['5']['correspondingauthorcheck'])) {
        //     $authorData = [];        
        //     for ($i = 0; $i < count($data['5']['authorname']); $i++) {
        //         $authorData[] = [
        //             'user_id' => Auth::id(),
        //             'videoupload_id' => $videoupload->id,
        //             'authortype_id' => $data['5']['correspondingauthorcheck'][$i] == '1' ? 3 : 5,
        //             'name' => isset($data['5']['authorname'][$i]) ? $data['5']['authorname'][$i] : null,
        //             'surname' => isset($data['5']['authorsurname'][$i]) ? $data['5']['authorsurname'][$i] : null,
        //             'affiliation' => isset($data['5']['authoraffiliation'][$i]) ? $data['5']['authoraffiliation'][$i] : null,
        //             'email' => isset($data['5']['authoremail'][$i]) ? $data['5']['authoremail'][$i] : null,
        //             'country_id' => isset($data['5']['authorcountry'][$i]) ? $data['5']['authorcountry'][$i] : null,
        //             'created_at' => now(),
        //             'updated_at' => now()
        //         ];
        //     }
        //     Coauthor::insert($authorData);
        // }

        if (isset($data['3']['correspondingauthorname'])) {
            $correspondingAuthorData = [];        
            for ($i = 0; $i < count($data['3']['correspondingauthorname']); $i++) {
                $correspondingAuthorData[] = [
                    'user_id' => Auth::id(),
                    'videoupload_id' => $videoupload->id,
                    'authortype_id' => 3,
                    'name' => isset($data['3']['correspondingauthorname'][$i]) ? $data['3']['correspondingauthorname'][$i] : null,
                    'surname' => isset($data['3']['correspondingauthorsurname'][$i]) ? $data['3']['correspondingauthorsurname'][$i] : null,
                    'affiliation' => isset($data['3']['correspondingauthoraffiliation'][$i]) ? $data['3']['correspondingauthoraffiliation'][$i] : null,
                    'email' => isset($data['3']['correspondingauthoremail'][$i]) ? $data['3']['correspondingauthoremail'][$i] : null,
                    'country_id' => isset($data['3']['correspondingauthorcountry'][$i]) ? $data['3']['correspondingauthorcountry'][$i] : null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            Coauthor::insert($correspondingAuthorData);
        }

        if (isset($data['5']['authorname']) && !empty($data['5']['authoremail'][0])) {
            $authorData = [];        
            for ($i = 0; $i < count($data['5']['authorname']); $i++) {
                $authorData[] = [
                    'user_id' => Auth::id(),
                    'videoupload_id' => $videoupload->id,
                    'authortype_id' => 5,
                    'name' => isset($data['5']['authorname'][$i]) ? $data['5']['authorname'][$i] : null,
                    'surname' => isset($data['5']['authorsurname'][$i]) ? $data['5']['authorsurname'][$i] : null,
                    'affiliation' => isset($data['5']['authoraffiliation'][$i]) ? $data['5']['authoraffiliation'][$i] : null,
                    'email' => isset($data['5']['authoremail'][$i]) ? $data['5']['authoremail'][$i] : null,
                    'country_id' => isset($data['5']['authorcountry'][$i]) ? $data['5']['authorcountry'][$i] : null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            Coauthor::insert($authorData);
        }

        // Storing data for the second index
        if (isset($data['4']['reviewername'])) {
            $reviewerData = [];        
            for ($i = 0; $i < count($data['4']['reviewername']); $i++) {
                $reviewerData[] = [
                    'user_id' => Auth::id(),
                    'videoupload_id' => $videoupload->id,
                    'authortype_id' => 4,
                    'name' => isset($data['4']['reviewername'][$i]) ? $data['4']['reviewername'][$i] : null,
                    'surname' => isset($data['4']['reviewersurname'][$i]) ? $data['4']['reviewersurname'][$i] : null,
                    'affiliation' => isset($data['4']['revieweraffiliation'][$i]) ? $data['4']['revieweraffiliation'][$i] : null,
                    'email' => isset($data['4']['revieweremail'][$i]) ? $data['4']['revieweremail'][$i] : null,
                    'country_id' => isset($data['4']['reviewercountry'][$i]) ? $data['4']['reviewercountry'][$i] : null,
                    'is_proposed_reviewer' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            Coauthor::insert($reviewerData);
        }

        $user_details = User::find(Auth::id());
        $user_details->role_id = 2; // Change role from member to author
        $user_details->save();

        $check_role = Userrole::where('user_id',Auth::id())->where('role_id',2)->first(); 
        // 2 means author       
        if(empty($check_role))
        {
            $courseoffer = Userrole::updateOrCreate([                            
                'user_id' => Auth::id(),
                'role_id' => 2,                                 
            ],[                                
                'role_id' => 2,                        
            ]);
        }
        $check_role_corresponding_author = Userrole::where('user_id',Auth::id())->where('role_id',7)->first(); 
        // 2 means author       
        if(empty($check_role_corresponding_author))
        {
            $courseoffer = Userrole::updateOrCreate([                            
                'user_id' => Auth::id(),
                'role_id' => 7,                                 
            ],[                                
                'role_id' => 7,                        
            ]);
        }

        $check_highest_priority = check_highest_priority($request->majorcategory_id);
        if ($check_highest_priority) 
        {
            $get_eligible_editorial_member = $check_highest_priority->user_id;
        } 
        else 
        {
            $get_eligible_editorial_member = get_eligible_user($request->majorcategory_id,$request->subcategory_id);
            if (is_object($get_eligible_editorial_member)) 
            {
                $get_eligible_editorial_member = $get_eligible_editorial_member->send_to_user_id;
            }
            else
            {
                $get_eligible_editorial_member = $get_eligible_editorial_member;
            }
        }
        
        // Start save into history table        
        $videohistory = new videohistory();
        $videohistory->videoupload_id = $videoupload->id;
        $videohistory->videohistorystatus_id = 1; // from videohistorystatuses table
        $videohistory->send_from_user_id = Auth::id();
        $videohistory->send_to_user_id = $get_eligible_editorial_member;
        $videohistory->send_from_as = 'Author';
        $videohistory->send_to_as = 'editorial-member';
        //$videohistory->send_to_as = 'editor-in-chief';
        $videohistory->save();
        // End save into history table

        $get_eligible_editorial_member_details = get_user_details($get_eligible_editorial_member);

        $videoupload_update = Videoupload::find($videoupload->id);
        $videoupload_update->currently_assigned_to_editorial_member = $get_eligible_editorial_member;
        $videoupload_update->save();
        $admin_email = config('constants.emails.admin_email');
        $ccRecipients = [$admin_email];
        // To the editor
        Mail::to($get_eligible_editorial_member_details->email)->send(new sendVideoNotificationToTheEditorNChief($videoupload->id));
        // To the author and corresponding author
        Mail::to(Auth::user()->email)->send(new sendVideoNotificationToTheAuthor($videoupload->id,$get_eligible_editorial_member_details->email,'corresponding_author',Auth::user()->email,'login',$request->majorcategory_id));
        // To the admin
        Mail::to($admin_email)->send(new sendMailAfterNewVideoToTheAdmin($videoupload->id,$get_eligible_editorial_member_details->email));
        if (isset($data['5']['authorname']) && !empty($data['5']['authoremail'])) 
        {
            for ($i = 0; $i < count($data['5']['authorname']); $i++) 
            {
                $check_user = User::where('email',$data['5']['authoremail'])->first();
                if(!$check_user)
                {
                    $type = 'signup';
                    if(!empty($data['5']['authoremail'][$i]))
                    {
                        Mail::to($data['5']['authoremail'][$i])->send(new sendVideoNotificationToTheAuthor($videoupload->id,$get_eligible_editorial_member_details->email,'author',$data['5']['authoremail'][$i],$type,$request->majorcategory_id));
                    }
                }
                else
                {
                    $type = 'login';if(!empty($data['5']['authoremail'][$i]))
                    {
                        Mail::to($data['5']['authoremail'][$i])->send(new sendVideoNotificationToTheAuthor($videoupload->id,$get_eligible_editorial_member_details->email,'author',$data['5']['authoremail'][$i],$type,$request->majorcategory_id));
                    }
                }
            }
        }
        switch_role_session('2');
        $request->session()->flash('success', 'Record saved successfully.');
        $request->session()->flash('videoid', $videoupload->unique_number);
        DB::commit();
        return response()->json(['success'=>'Successfully','redirect' => route('my.account')]);
        } catch (\Exception $e) {
            // Rollback the transaction if any operation fails
            DB::rollBack();

            // Log or handle the exception
            // For example:
            // Log::error($e->getMessage());

            // Return error response
            return response()->json(['error' => 'Video is not uploaded successfully. Please try again.']);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check_last_record = check_last_record($id);
        if(!empty($check_last_record) && (($check_last_record->videohistorystatus_id == '26' && $check_last_record->send_from_as == 'editorial-member' && $check_last_record->corresponding_author_email == Auth::user()->email && $check_last_record->corresponding_author_status == 2) || ($check_last_record->videohistorystatus_id == '3' && $check_last_record->send_from_as == 'editorial-member' && $check_last_record->corresponding_author_email == Auth::user()->email)))
        {
            // for corresponding author
            $user_profile_data = Userprofile::where('user_id', Auth::user()->id)->first();
            $country_list = Country::all();
            $coauthor = Coauthor::where('status',1)->get();
            $Videotype = Videotype::where('status',1)->orderBy('sequence')->get();
            $Videosubtype = Videosubtype::where('status',1)->orderBy('sequence')->get();
            $majorcategory = Majorcategory::where('status',1)->orderBy('sequence')->get();
            $paymentype = Membershipplan::where('status',1)->orderBy('sequence')->get();

            $video_list = single_video_details($id);
            $video_list->keywords = json_decode($video_list->keywords, true);
            $video_list->subcategory_id = json_decode($video_list->subcategory_id, true);
            $subcategory_data = Subcategory::where('majorcategory_id',$video_list->majorcategory_id)->get();
            $likecount = Likeunlikecounter::where('videoupload_id',$id)->count();       
            $video_view_count = VideoView::where('video_id',$id)->count();  
            $coauthors = DB::table('coauthors')->where('videoupload_id',$id)->get();
            $response = response()->view('frontend.video_upload.video_view',compact('country_list','video_view_count','subcategory_data','Videotype','Videosubtype','majorcategory','paymentype','coauthor','video_list','likecount','coauthors'));
        }
        elseif(!empty($check_last_record) && (($check_last_record->videohistorystatus_id == '6' && ($check_last_record->send_from_user_id == Auth::id() || $check_last_record->send_to_user_id == Auth::id())) || ($check_last_record->videohistorystatus_id == '18' && ($check_last_record->send_from_user_id == Auth::id() || $check_last_record->send_to_user_id == Auth::id())) || ($check_last_record->videohistorystatus_id == '19' && ($check_last_record->send_from_user_id == Auth::id() || $check_last_record->send_to_user_id == Auth::id())) || ($check_last_record->videohistorystatus_id == '24' && ($check_last_record->send_from_user_id == Auth::id() || $check_last_record->send_to_user_id == Auth::id()))))
        {
            // for corresponding publisher
            $user_profile_data = Userprofile::where('user_id', Auth::user()->id)->first();
            $country_list = Country::all();
            $coauthor = Coauthor::where('status',1)->get();
            $Videotype = Videotype::where('status',1)->orderBy('sequence')->get();
            $Videosubtype = Videosubtype::where('status',1)->orderBy('sequence')->get();
            $majorcategory = Majorcategory::where('status',1)->orderBy('sequence')->get();
            $paymentype = Membershipplan::where('status',1)->orderBy('sequence')->get();

            $video_list = single_video_details($id);
            $video_list->keywords = json_decode($video_list->keywords, true);
            $video_list->subcategory_id = json_decode($video_list->subcategory_id, true);
            $subcategory_data = Subcategory::where('majorcategory_id',$video_list->majorcategory_id)->get();
            $likecount = Likeunlikecounter::where('videoupload_id',$id)->count();       
            $video_view_count = VideoView::where('video_id',$id)->count();  
            $coauthors = DB::table('coauthors')->where('videoupload_id',$id)->get();
            $response = response()->view('frontend.video_upload.video_view',compact('country_list','video_view_count','subcategory_data','Videotype','Videosubtype','majorcategory','paymentype','coauthor','video_list','likecount','coauthors'));
        }
        else
        {
            return redirect()->route('video.edit',$id);
        }
        // Set Cache-Control headers
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');

        // Return the response
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {    
        $user_profile_data = Userprofile::where('user_id', Auth::user()->id)->first();
        $country_list = Country::all();
        $coauthor = Coauthor::where('status',1)->where('videoupload_id',$id)->get();
        $Videotype = Videotype::where('status',1)->orderBy('sequence')->get();
        $Videosubtype = Videosubtype::where('status',1)->orderBy('sequence')->get();
        $majorcategory = Majorcategory::where('status',1)->orderBy('sequence')->get();
        $paymentype = Membershipplan::where('status',1)->orderBy('sequence')->get();

        $video_list = single_video_details($id);
        $video_list->keywords = json_decode($video_list->keywords, true);
        $video_list->subcategory_id = json_decode($video_list->subcategory_id, true);
        $subcategory_data = Subcategory::where('majorcategory_id',$video_list->majorcategory_id)->get();
        $likecount = Likeunlikecounter::where('videoupload_id',$id)->count();  
        $video_view_count = VideoView::where('video_id',$id)->count();      
        $coauthors = DB::table('coauthors')->where('videoupload_id',$id)->get();

        // Start for history
            //Start Editorial chief
            //$editor_chief_option = editor_chief_option();
            if($user_profile_data)
            {
                $editorial_member_list = editorial_member_list($user_profile_data->majorcategory_id);
                $reviewer_list = reviewer_list($user_profile_data->majorcategory_id,$id);
                $publisher_list = publisher_list();
            }
            else
            {
                $editorial_member_list = '';
                $reviewer_list = '';
                $publisher_list = '';
            }            
            //End Editorial chief

            $passed_by_name = passed_by_name($id,'4',Auth::user()->id);        
            $editorial_member_option = editorial_member_option();
            $editor_chief_option = editorial_member_option();
            $accept_deny_option = accept_deny_option(); // currently not in use
            $reviewer_option = reviewer_option();
            $pass_revise_option = pass_revise_option();
            $check_last_record = check_last_record($id);
            $video_history = video_history($id);
            $publisher_option = publisher_option();
            $send_to_user_id_for_publisher = passed_by_name($id,'6',Auth::user()->id);
            $get_condition_to_delete_record_for_author = get_condition_to_delete_record_for_author($id);
            // Start to get last submission for different-different roles
            $pass_to = [];
            $editorial_member = [];
            $reviewer_emails = [];
            $last_message = '';
            $publisher_ids = [];
            // For Editorial chief
            $last_record_for_editor_chief = videohistory::where('videoupload_id',$id)
                                                ->where('send_from_user_id',Auth::id())
                                                ->where('send_from_as','editorial-member')
                                                ->where('last_record_for_chief_editor',1)
                                                ->get();
            if ($last_record_for_editor_chief->isEmpty())
            {
                // if pass to another editorial member, the last record
                $last_record_for_editor_chief = videohistory::where('videoupload_id',$id)
                                                ->where('videohistorystatus_id',25)
                                                ->where('send_to_user_id',Auth::id())
                                                ->where('send_from_as','editorial-member')
                                                ->where('send_to_as','editorial-member')
                                                ->latest('created_at') // Assuming 'created_at' is the timestamp column you want to use
                                                ->get();
            }
            // echo '<pre>';
            // print_r($last_record_for_editor_chief);exit;
            if($last_record_for_editor_chief)
            {
                foreach($last_record_for_editor_chief as $last_record_for_editor_chief)
                {
                    if($last_record_for_editor_chief->videohistorystatus_id == '26')
                    {
                        $last_record_for_editor_chief_videohistorystatus_id = '3';
                    }
                    else
                    {
                        $last_record_for_editor_chief_videohistorystatus_id = $last_record_for_editor_chief->videohistorystatus_id;
                    }
                    array_push($pass_to, $last_record_for_editor_chief_videohistorystatus_id);
                    if($last_record_for_editor_chief->send_to_as == 'Reviewer')
                    {
                        array_push($reviewer_emails, $last_record_for_editor_chief->reviewer_email);
                    }
                    if($last_record_for_editor_chief->send_to_as == 'Publisher')
                    {
                        array_push($publisher_ids, $last_record_for_editor_chief->send_to_user_id);
                    }
                    $last_message = $last_record_for_editor_chief->message;              
                }
            }
            // Editorial member
            $last_record_for_editor_member = DB::table('videohistories')
                                                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                                                ->select('videohistorystatuses.option as last_selected_option','videohistories.message','videohistories.videohistorystatus_id','videohistories.message_visibility','videohistories.id as videohistories_id')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('send_from_as','editorial-member')
                                                ->where('videohistories.send_from_user_id',Auth::user()->id)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first();
            $last_record_of_editor_member_for_authors = DB::table('videohistories')
                                                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                                                ->select('videohistorystatuses.option as last_selected_option','videohistories.message','videohistories.videohistorystatus_id','videohistories.message_visibility','videohistories.id as videohistories_id')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('send_from_as','editorial-member')
                                                ->where('send_to_as','Corresponding-Author')
                                                ->where('videohistorystatus_id',26)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first();
            // Reviewer
            $last_record_for_reviewer = DB::table('videohistories')
                                                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                                                ->select('videohistorystatuses.option as last_selected_option','videohistories.*','videohistories.id as videohistories_id')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('send_from_as','Reviewer')
                                                ->where('videohistories.reviewer_email',Auth::user()->email)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first();
            $last_record_of_reviewer_for_authors = DB::table('videohistories')
                                                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                                                ->select('videohistorystatuses.option as last_selected_option','videohistories.message','videohistories.videohistorystatus_id','videohistories.message_visibility','videohistories.id as videohistories_id')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('send_from_as','Reviewer')
                                                ->where('send_to_as','editorial-member')
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first();
            $last_record_for_withdraw_reviewer = DB::table('videohistories')
                                                ->select('withdraw_reviewer','is_pass_to_other_than_reviewer')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('videohistories.videohistorystatus_id',5)
                                                ->where('send_from_as','editorial-member')
                                                ->where('send_to_as','Reviewer')
                                                ->where('videohistories.reviewer_email',Auth::user()->email)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first();
            
            // corresponding author
            $last_record_for_corresponding_author = DB::table('videohistories')
                                                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                                                ->select('videohistorystatuses.option as last_selected_option','videohistories.message','videohistories.send_from_as','videohistories.corresponding_author_email','videohistories.videohistorystatus_id','videohistories.message_visibility','videohistories.corresponding_author_status')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('send_from_as','Corresponding-Author')
                                                ->where('videohistories.corresponding_author_email',Auth::user()->email)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first();   
            // Publisher
            $last_record_for_publisher = DB::table('videohistories')
                                                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                                                ->select('videohistorystatuses.option as last_selected_option','videohistories.message','videohistories.videohistorystatus_id')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('send_from_as','Publisher')
                                                ->where('videohistories.send_from_user_id',Auth::user()->id)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first(); 
            // reviewer's list to withdraw   
            $reviewers_list_to_withdraw = DB::table('videohistories')
                                                ->where('videoupload_id',$id)
                                                ->where('videohistorystatus_id',5)
                                                ->where('send_from_as','editorial-member')
                                                ->where('send_from_user_id',Auth::user()->id)
                                                ->where('is_latest_record_for_reviewer_from_editor',1)
                                                ->get();         
            // End to get last submission for different-different roles
        // End for history
        // echo '<pre>';
        // print_r($check_last_record);
        
        // echo '<br/>';
        // print_r($last_record_for_corresponding_author);
        // exit;
        $response = response()->view('frontend.video_upload.video_edit',compact('last_record_of_editor_member_for_authors','last_record_of_reviewer_for_authors','country_list','video_view_count','subcategory_data','Videotype','Videosubtype','majorcategory','paymentype','coauthor','video_list','likecount','coauthors','editor_chief_option','editorial_member_list','passed_by_name','accept_deny_option','pass_revise_option','check_last_record','video_history','reviewer_list','pass_to','editorial_member','reviewer_emails','last_message','last_record_for_editor_member','last_record_for_reviewer','publisher_list','publisher_ids','publisher_option','send_to_user_id_for_publisher','last_record_for_publisher','last_record_for_corresponding_author','editorial_member_option','reviewer_option','get_condition_to_delete_record_for_author','last_record_for_editor_chief','reviewers_list_to_withdraw','last_record_for_withdraw_reviewer'));

        // Set Cache-Control headers
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');

        // Return the response
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // echo $id;exit;
        // echo '<pre>';
        // print_r($request->all());exit;
        $validatedData = $request->validate([
            'video_title' => 'required',  
            'keywords' => 'required',  
            'references' => 'required',  
            'abstract' => 'required',  
            'declaration_of_interests' => 'required',  
            'declaration_remark' => 'required_if:declaration_of_interests,2',
            'videotype_id' => 'required',  
            'videosubtype_id' => 'required',  
            'majorcategory_id' => 'required',           
            'subcategory_id' => 'required',     
            'terms_n_conditions' => 'required',        
            'membershipplan_id' => 'required',   
            //'video_price' => 'required_if:membershipplan_id,1',   
            'vide_Upload' => 'sometimes|mimes:mp4|max:100000',  
            'message' => 'required',  
            //'captcha' => 'required|captcha' 
        ], [        
            'required' => 'This field is required',        
            'declaration_remark.required_if' => 'This field is required',  
            'captcha.captcha' => 'Invalid captcha'  
        ]);  
        DB::beginTransaction();
        try {
            if(Session::has('loggedin_role')) {
                $user_role_id = Session::get('loggedin_role');
            } else {
                $user_role_id = Auth::user()->role_id;
            }
        $filteredKeywords = array_filter($request->keywords, function ($value) {
            // Remove null values from the array
            return $value !== null;
        });
        $jsonKeywords = json_encode($filteredKeywords);
        $videoupload = Videoupload::find($id);
        //$videoupload->videotype_id = $request->videotype_id;
        //$videoupload->videosubtype_id = $request->videosubtype_id;
        //$videoupload->majorcategory_id = $request->majorcategory_id;
        //$videoupload->subcategory_id = json_encode($request->subcategory_id);
        if($user_role_id == '7')
        {
            // update only if corresponding author
            $videoupload->video_title = $request->video_title;
            $videoupload->keywords = $jsonKeywords;
            $videoupload->references = $request->references;
            $videoupload->abstract = $request->abstract;
            $videoupload->declaration_of_interests1 = $request->declaration_of_interests;
            $videoupload->acknowledge = $request->acknowledge;
            $videoupload->doi_link = $request->doi_link;
            if($videoupload->declaration_of_interests1 == 2)
            {
                $videoupload->declaration_remark = $request->declaration_remark;
            }  
            $videoupload->membershipplan_id = $request->membershipplan_id;
            // if($videoupload->membershipplan_id == 1)
            // {
            //     $videoupload->video_price = $request->video_price;
            // }        
            $videoupload->terms_n_conditions = $request->terms_n_conditions;
        }
        if($request->hasFile('vide_Upload')){            
            
            if($user_role_id == '5')
            {
                // in case of publisher
                $video_folder_name = $videoupload->main_folder_name;
                $category_folder_name = $videoupload->category_folder_name;
            }
            else
            {
                // in case of corresponding author
                $video_folder_name = 'Videos_to_Revise';
                $category_folder_name = $videoupload->category_folder_name;
            }
            Storage::disk('public')->deleteDirectory('uploads/'.$video_folder_name.'/'.$category_folder_name.'/'.$videoupload->unique_number);
            $uniquen_number = $videoupload->unique_number;
            $major_category_details = get_majorcategories($request->majorcategory_id);
            $folderName = str_replace(' ', '_', $major_category_details->category_name);
            $vide_Upload2_image = $request->file('vide_Upload');
            $extension = $vide_Upload2_image->getClientOriginalExtension();
            $newFileName = $uniquen_number . '.' . $extension;
            $newFileName_cropped_file = $uniquen_number . '_cropped.' . $extension;
            //$new_directory = mkdir('app/public/uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number, 0755, true);
            $filePath = $vide_Upload2_image->storeAs('uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number, $newFileName, 'public');
            $video_path_url = asset(Storage::url($filePath));
           
            // Start crop the video
            $video_path = storage_path('app/public/uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number.'/'.$newFileName);
            $croppedVideoPath = storage_path('app/public/uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number.'/'.$newFileName_cropped_file);
            $cropped_video_path_url = url('/storage/uploads/'.$video_folder_name.'/' . $folderName.'/'.$uniquen_number . '/' . $newFileName_cropped_file);
        
            //$ffmpegCommand = "C:/FFmpeg/bin/ffmpeg -i " . $video_path . " -ss 00:00:00 -t 00:00:20 " . $croppedVideoPath;
            $ffmpegCommand = "ffmpeg -i " . $video_path . " -ss 00:00:00 -t 00:00:45 -preset ultrafast " . $croppedVideoPath;
            $test = exec($ffmpegCommand);
            // End crop the video

            // start encrypting the videos
            //$highBitrate = (new X264)->setKiloBitrate(1000);
            //start encrypting fulllength files

            $encryptedFolderPath = storage_path('app/public/uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number . '/encrypted_files/');
            if (!file_exists($encryptedFolderPath)) {
                mkdir($encryptedFolderPath, 0755, true); // Create the folder recursively
            }
            $filePath_fulllength = storage_path('app/public/uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number.'/'.$newFileName);
            $encryptedPath_fulllength = $encryptedFolderPath . $uniquen_number . '.m3u8';
            $cmd_fulllength = "ffmpeg -i " . $filePath_fulllength . " -codec:v libx264 -b:v 1000k -preset:v ultrafast -hls_time 300 -hls_playlist_type vod -hls_segment_type mpegts ".$encryptedPath_fulllength;
            $test_fulllength = exec($cmd_fulllength);

            // FFMpeg::fromDisk('public')
            //     ->open($filePath) // Provide the path relative to the 'local' disk
            //     ->exportForHLS()
            //     ->withRotatingEncryptionKey(function ($filename, $contents) use ($video_folder_name,$folderName,$uniquen_number) {
            //         Storage::disk('public')->put('uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number . '/encrypted_files/' . $filename, $contents);
            //     })
            //     ->addFormat($highBitrate)
            //     ->save('uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number . '/encrypted_files/'.$uniquen_number.'.m3u8');
            //end encrypting fulllength files

            //start encrypting cropped files
            $encryptedPath_cropped = $encryptedFolderPath . $uniquen_number . '_cropped.m3u8';
            $cmd_cropped = "ffmpeg -i " . $croppedVideoPath . " -codec:v libx264 -b:v 1000k -preset:v ultrafast -hls_time 300 -hls_playlist_type vod -hls_segment_type mpegts ".$encryptedPath_cropped;
            $test_cropped = exec($cmd_cropped);

            // FFMpeg::fromDisk('public')
            //     ->open('uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number.'/'.$newFileName_cropped_file) // Provide the path relative to the 'local' disk
            //     ->exportForHLS()
            //     ->withRotatingEncryptionKey(function ($filename, $contents) use ($video_folder_name,$folderName,$uniquen_number) {
            //         Storage::disk('public')->put('uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number . '/encrypted_files/' . $filename, $contents);
            //     })
            //     ->addFormat($highBitrate)
            //     ->save('uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number . '/encrypted_files/'.$uniquen_number.'_cropped.m3u8');
            //end encrypting cropped files

            FFMpeg::fromDisk('public')
                ->open('uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number.'/'.$newFileName_cropped_file) // Provide the path relative to the 'local' disk
                ->getFrameFromSeconds(3)
                ->export()
                ->save('uploads/'.$video_folder_name.'/'.$folderName.'/'.$uniquen_number . '/'.$uniquen_number.'_screenshot.webp');
            // end encrypting the videos
            

            $videoupload->full_video_url = $video_path_url;
            $videoupload->short_video_url = $cropped_video_path_url;
            $videoupload->main_folder_name = $video_folder_name;
            $videoupload->category_folder_name = $folderName;
            $videoupload->uploaded_video = $newFileName;
           
        }
        $videoupload->save();

        $data = $request->name;

        if($user_role_id == '7')
        {
            // Only if corresponding author
            //Start Delete first from the coauthors table
            Coauthor::where('user_id', Auth::id())->where('videoupload_id', $videoupload->id)->delete();
            //End Delete first from the coauthors table
            if (isset($data['3']['correspondingauthorname'])) {
                $correspondingAuthorData = [];        
                for ($i = 0; $i < count($data['3']['correspondingauthorname']); $i++) {
                    $correspondingAuthorData[] = [
                        'user_id' => Auth::id(),
                        'videoupload_id' => $videoupload->id,
                        'authortype_id' => 3,
                        'name' => isset($data['3']['correspondingauthorname'][$i]) ? $data['3']['correspondingauthorname'][$i] : null,
                        'surname' => isset($data['3']['correspondingauthorsurname'][$i]) ? $data['3']['correspondingauthorsurname'][$i] : null,
                        'affiliation' => isset($data['3']['correspondingauthoraffiliation'][$i]) ? $data['3']['correspondingauthoraffiliation'][$i] : null,
                        'email' => isset($data['3']['correspondingauthoremail'][$i]) ? $data['3']['correspondingauthoremail'][$i] : null,
                        'country_id' => isset($data['3']['correspondingauthorcountry'][$i]) ? $data['3']['correspondingauthorcountry'][$i] : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                Coauthor::insert($correspondingAuthorData);
            }
            if (isset($data['5']['authorname']) && !empty($data['5']['authoremail'][0])) {
                $authorData = [];        
                for ($i = 0; $i < count($data['5']['authorname']); $i++) {
                    $authorData[] = [
                        'user_id' => Auth::id(),
                        'videoupload_id' => $videoupload->id,
                        'authortype_id' => 5,
                        'name' => isset($data['5']['authorname'][$i]) ? $data['5']['authorname'][$i] : null,
                        'surname' => isset($data['5']['authorsurname'][$i]) ? $data['5']['authorsurname'][$i] : null,
                        'affiliation' => isset($data['5']['authoraffiliation'][$i]) ? $data['5']['authoraffiliation'][$i] : null,
                        'email' => isset($data['5']['authoremail'][$i]) ? $data['5']['authoremail'][$i] : null,
                        'country_id' => isset($data['5']['authorcountry'][$i]) ? $data['5']['authorcountry'][$i] : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                Coauthor::insert($authorData);
            }

            // Storing data for the second index
            if (isset($data['4']['reviewername'])) {
                $reviewerData = [];        
                for ($i = 0; $i < count($data['4']['reviewername']); $i++) {
                    $reviewerData[] = [
                        'user_id' => Auth::id(),
                        'videoupload_id' => $videoupload->id,
                        'authortype_id' => 4,
                        'name' => isset($data['4']['reviewername'][$i]) ? $data['4']['reviewername'][$i] : null,
                        'surname' => isset($data['4']['reviewersurname'][$i]) ? $data['4']['reviewersurname'][$i] : null,
                        'affiliation' => isset($data['4']['revieweraffiliation'][$i]) ? $data['4']['revieweraffiliation'][$i] : null,
                        'email' => isset($data['4']['revieweremail'][$i]) ? $data['4']['revieweremail'][$i] : null,
                        'country_id' => isset($data['4']['reviewercountry'][$i]) ? $data['4']['reviewercountry'][$i] : null,
                        'is_proposed_reviewer' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                Coauthor::insert($reviewerData);
            }
        }
        
        $check_last_record = check_last_record($id);
        if(!empty($check_last_record) && (($check_last_record->videohistorystatus_id == '26' && $check_last_record->send_from_as == 'editorial-member' && $check_last_record->corresponding_author_email == Auth::user()->email) || ($check_last_record->videohistorystatus_id == '3' && $check_last_record->send_from_as == 'editorial-member' && $check_last_record->corresponding_author_email == Auth::user()->email)))
        {
            // if login with corresponding author
            $get_editorial_details = DB::table('videohistories')
                                        ->select('send_to_user_id','send_from_user_id','corresponding_author_email')
                                        ->where('videoupload_id',$videoupload->id)
                                        ->where('videohistorystatus_id',26)
                                        ->where('corresponding_author_email',Auth::user()->email)
                                        ->orderBy('id','desc')
                                        ->first();
            
            // Start save into history table
            $videohistory = new videohistory();
            $videohistory->videoupload_id = $videoupload->id;
            $videohistory->videohistorystatus_id = 1; // from videohistorystatuses table
            $videohistory->send_from_user_id = Auth::id();
            $videohistory->send_to_user_id = $get_editorial_details->send_from_user_id;
            //$videohistory->send_from_as = 'Author';
            $videohistory->send_from_as = 'Corresponding-Author';
            $videohistory->send_to_as = 'editorial-member';
            $videohistory->message = $request->message;
            $videohistory->corresponding_author_email = $get_editorial_details->corresponding_author_email;
            $videohistory->save();
            // End save into history table
            //switch_role_session('2');
            $send_to_mail = get_user_details($get_editorial_details->send_from_user_id);
            $admin_email = config('constants.emails.admin_email');
            $video_status = single_video_details($videoupload->id);
            $author_details = author_details('5',$videoupload->id);
            $ccAuthorRecipients_array = [];
            foreach($author_details as $author_details_values)
            {
                array_push($ccAuthorRecipients_array, $author_details_values->email);
            }
            // mail send to editor
            Mail::to($send_to_mail->email)->send(new sendMailAfterVideoUpdate('editorial_member',$video_status,$send_to_mail->email));
            // mail send to authors and corresponding author
            if(!empty($ccAuthorRecipients_array) && (isset($ccAuthorRecipients_array[0]) && !empty($ccAuthorRecipients_array[0])))
            {
                Mail::to(Auth::user()->email)->cc($ccAuthorRecipients_array)->send(new sendMailAfterVideoUpdate('authors',$video_status,$send_to_mail->email));
            }
            else
            {
                Mail::to(Auth::user()->email)->send(new sendMailAfterVideoUpdate('authors',$video_status,$send_to_mail->email));
            }           
            // mail send to admin
            Mail::to($admin_email)->send(new sendMailAfterVideoUpdate('admin',$video_status,$send_to_mail->email));
        }
        $request->session()->flash('success', 'Record updated successfully.');
        DB::commit();
        return response()->json(['success'=>'Successfully','redirect' => route('video.edit',$videoupload->id)]);
        } catch (\Exception $e) {
            // Rollback the transaction if any operation fails
            DB::rollBack();

            // Log or handle the exception
            // For example:
            // Log::error($e->getMessage());

            // Return error response
            return response()->json(['error' => 'Video is not updated successfully. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function generateUniqueNumber() {
        $uniqueNumber = uniqid(); // Generate a random number
        // Check if the number already exists in the table
        $exists = DB::table('videouploads')->where('unique_number', $uniqueNumber)->exists();
    
        if ($exists) {
            // If the number already exists, generate a new one
            return $this->generateUniqueNumber();
        } else {
            // If the number is unique, return it
            return $uniqueNumber;
        }
    }
    public function update_video_likes(Request $request)
    {
        $videoId = $request->input('videoId');
        $like = $request->input('like');
        $validatedData = $request->validate([
            'videoId' => 'required',  
            'like' => 'required'
        ], [        
            'required' => 'This field is required'
        ]);  

        $getdata = Likeunlikecounter::where('user_id', Auth::id())
                                    ->where('videoupload_id', $videoId)
                                    ->where('type', $like)
                                    ->first();
        if($getdata)
        {
            $like_text = $like == '1' ? 'liked' : 'unliked';
            return response()->json(['status'=> 'fail','message' => 'You have already '.$like_text.' this video']);
        }
        // Add your logic here
        $likeunlike = new Likeunlikecounter();
        $likeunlike->user_id = Auth::id();
        $likeunlike->videoupload_id = $videoId;
        $likeunlike->type = $like;
        $likeunlike->save();
        // $like_unlike_count = Likeunlikecounter::where('user_id', Auth::id())
        //                             ->where('videoupload_id', $videoId)
        //                             ->where('type', $like)
        //                             ->count();
        $like_unlike_count = Likeunlikecounter::where('videoupload_id', $videoId)
                                    ->where('type', $like)
                                    ->count();
        return response()->json(['status'=> 'success','like_unlike_count' => $like_unlike_count]);
    }
    public function watch_later_video(Request $request)
    {
        $videoId = $request->input('videoId');
        $isadded = $request->input('isadded');
        $validatedData = $request->validate([
            'videoId' => 'required',  
            'isadded' => 'required',  
        ], [        
            'required' => 'This field is required'
        ]);  
        
        $type = $isadded == 1 ? 0 : 1;
        $courseoffer = Watchlaterlist::updateOrCreate([                            
            'user_id' =>  Auth::id(),                                
            'videoupload_id' =>  $videoId,                                
        ],[                                
            'type' => $type                       
        ]);
        return response()->json(['status'=> 'success','type' => $type]);
    }

    public function video_delete(Request $request,$id)
    {
       $video_id = Crypt::decrypt($id);
       $video = Videoupload::where('id', $video_id)->first();
       if (!$video) {
        // Handle if video not found
        return redirect()->back()->with('error', 'Video not found');
        }
        Storage::disk('public')->deleteDirectory('uploads/'.$video->main_folder_name.'/'.$video->category_folder_name.'/'.$video->unique_number);
        // Delete the record from the database
        $video->delete();

        // delete from Coauthor
        DB::table('coauthors')->where('videoupload_id', $video_id)->delete();

        // delete from history table
        DB::table('videohistories')->where('videoupload_id', $video_id)->delete();

        $request->session()->flash('deletesuccess', 'The video is deleted successfully.');
        return redirect()->route('my.account');
    }
    public function download_video($id)
    {
         // Retrieve the video record from the database based on $id
    $video = Videoupload::findOrFail($id); // Assuming 'Video' is your model name
    
    // Check if the file exists in the storage
        if (Storage::disk('public')->exists('uploads/'.$video->main_folder_name.'/'.$video->category_folder_name.'/'.$video->unique_number)) {
            // If the file exists, generate a response to download the file
            return response()->download(storage_path("app/public/uploads/".$video->main_folder_name.'/'.$video->category_folder_name.'/'.$video->unique_number.'/'.$video->uploaded_video));
        } else {
            // If the file doesn't exist, return a 404 Not Found response
            abort(404);
        }
    }
    
}
