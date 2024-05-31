<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request AS RequestFacades;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Mail\sendRegistrationUrlToReviewer;
use App\Mail\sendRegistrationUrlToCorrespondingAuthor;
use App\Mail\sendNewsletterWelcomeMail;
use App\Mail\sendNewsLetterUnsubscribeMail;
use App\Mail\sendContactForm;
use App\Mail\sendContactFormToUser;
use App\Mail\invitationNotificationForRegister;
use App\Mail\sendNewsletterNotificationToAdmin;
use App\Mail\sendMailAfterReviewersActionToTheAdmin;
use App\Mail\sendMailForInstitutionRegistrationRequest;
use Illuminate\Support\Facades\Response;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Majorcategory;
use App\Models\Videoupload;
use App\Models\Country;
use App\Models\Likeunlikecounter;
use App\Models\Videotype;
use App\Models\Videosubtype;
use App\Models\User;
use App\Models\Membershipplan;
use App\Models\Coauthor;
use App\Models\Selectedcoauthor;
use App\Models\Userrole;
use App\Models\Watchlaterlist;
use App\Models\videohistory;
use App\Models\Userprofile;
use App\Models\Newslettersubscription;
use App\Models\Transcation;
use App\Models\Subscriptionplan;
use App\Models\Subcategory;
use App\Models\VideoView;
use App\Models\Institutionrequest;
use App\Models\Sorteditorspage;

class MenuController extends Controller
{ 
    public function __construct()
    { 
        $this->middleware('checkUserStatus');       
    }
    public function index()
    {
        $video_list = video_uploads(); // in App/Helper.php
        $majorCategory = major_category(); // in App/Helper.php
        return view('frontend.home',compact('majorCategory','video_list'));
    }    
    public function video_details($id,$sortingOption = null)
    {
    // Fetch all subcategories    
    $selected_video_majorcategory_id = DB::table('videouploads')->select('majorcategory_id')->where('id',$id)->first();

    $video_lists = video_uploads_except_this_id($id,$selected_video_majorcategory_id->majorcategory_id,$sortingOption); // in App/Helper.php
   
    if($video_lists['video_list']->isEmpty())
    {
        $video_lists = video_uploads_except_this_id_other_videos($id,$sortingOption); // in App/Helper.php
    }
    $video_list_all = $video_lists['video_list'];
    $all_subcategories = DB::table('subcategories')->select('id','subcategory_name')->get();

        $video_list = DB::table('videouploads')
                ->leftjoin('majorcategories','majorcategories.id','=','videouploads.majorcategory_id')
                ->leftjoin('videotypes','videotypes.id','=','videouploads.videotype_id')
                ->leftjoin('users','users.id','=','videouploads.user_id')
                ->leftjoin('membershipplans','membershipplans.id','=','videouploads.membershipplan_id')
                ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
                ->leftJoin('videohistories', 'videohistories.id', '=', 'videouploads.videohistory_id')
                ->select('videouploads.*','membershipplans.plan','majorcategories.category_name','majorcategories.short_name','videotypes.video_type','users.name as author_name','users.last_name as author_lastName','watchlaterlists.type as watch_list_type','videohistories.videohistorystatus_id as videohistories_videohistorystatus_id','videohistories.created_at as videohistories_created_at',
                DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
            );
        
            // Check if user is logged in
            if (Auth::check()) {
                $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
                    ->leftJoin('transcations', function ($join) {
                        $join->on('transcations.item_id', '=', 'videouploads.id')
                            ->where('transcations.user_id', '=', Auth::user()->id)
                            ->where('transcations.item_type', '=', 'video');
                    })
                    ->leftJoin('transcations as subscription_data', function ($join) {
                        $join->on('subscription_data.user_id', '=', 'videouploads.user_id')
                            ->where('subscription_data.user_id', '=', Auth::user()->id)
                            ->where('subscription_data.item_type', '=', 'subscription')
                            ->where('subscription_data.is_payment_done', '=', 1)
                            ->whereDate('subscription_data.subscription_start_date', '<=', now())
                            ->whereDate('subscription_data.subscription_end_date', '>=', now());
                    })
                    ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
                    ->leftJoin('transcations as subscription_data_institute', function ($join) {
                        $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                            ->where('subscription_data_institute.is_payment_done', '=', 1)
                            ->where('subscription_data_institute.is_active', '=', 1)
                            ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                            ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
                    })
                    ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
            } else {
                $video_list->addSelect(DB::raw('0 as hasPaid'));
                $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
                $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
            }

            $video_list = $video_list->where('videouploads.id',$id)
                ->first();
        $likecount = Likeunlikecounter::where('videoupload_id',$id)->count();
        $video_view_count = VideoView::where('video_id',$id)->count();
        
        $coauthors = DB::table('coauthors')->where('videoupload_id',$id)->get();
        $data1 = [];
        $data2 = [];
        $data3 = [];
        $data4 = [];
        $data5 = [];
        $data6 = [];
        $first_author_data = [];
        $co_author_data = [];
        $corresponding_author_data = [];
        $reviewer_author_data = [];
        $author_data = [];
        foreach ($coauthors as $coauthors) 
        {
            $name = '';
            $surname = '';
            if(!empty($coauthors->name))
            {
                $name = $coauthors->name;
            }
            if(!empty($coauthors->surname))
            {
                $surname = ' '.$coauthors->surname;
            }

            if($coauthors->authortype_id == 1)
            {
                $data1[] = $name.$surname;
                $first_author_data = implode(", ",$data1);

                if(trim($first_author_data) == "")
                {
                    $video_uploader_details = DB::table('users')->where('id',$coauthors->user_id)->first();
                    $data5[] = $video_uploader_details->name.' '.$video_uploader_details->last_name;
                    $first_author_data = implode(", ",$data5);
                }
            }
            if($coauthors->authortype_id == 2)
            {
                $data2[] = $name.$surname;
                $co_author_data = implode(", ",$data2);                
            }
            if($coauthors->authortype_id == 3)
            {
                $data3[] = $name.$surname;
                $corresponding_author_data = implode(", ",$data3);  
                $corresponding_author_data = $corresponding_author_data .' ( '. $coauthors->email .' )';              
            }
            if($coauthors->authortype_id == 4)
            {
                $data4[] = $name.$surname;
                $reviewer_author_data = implode(", ",$data4);                
            }
            if($coauthors->authortype_id == 5)
            {
                $data6[] = $name.$surname;
                $author_data = implode(", ",$data6);                
            }
        }
        
        return view('frontend.video_page',compact('video_list','video_view_count','video_list_all','all_subcategories','likecount','author_data','first_author_data','co_author_data','corresponding_author_data','reviewer_author_data'));
    }
    public function category_wise_video($id,$sortingOption = null)
    {
        $video_lists = video_based_on_category($id,$sortingOption);
        $video_list_all = $video_lists['video_list'];
        $all_subcategories = $video_lists['all_subcategories'];
        $category_name = category_name($id);
        $major_category_id = $id;
        return view('frontend.scientific_disciplines_wise_video',compact('video_list_all','category_name','all_subcategories','major_category_id'));
    }
    public function editorial_board_wise_video($id)
    {
        $editor_board_list = DB::table('userprofiles')
                        ->select(
                            'users.id',
                            'users.name',
                            'users.last_name',
                            'users.profile_pic',
                            'users.institute_name',
                            'users.position',
                            'users.city',
                            'countries.name as country_name',
                            'userprofiles.subcategory_id',
                            'userprofiles.user_description',
                            DB::raw('GROUP_CONCAT(DISTINCT subcategories.subcategory_name) as subcategory_names')
                        )
                        ->leftJoin('users', 'users.id', '=', 'userprofiles.user_id')
                        ->leftJoin('countries', 'countries.id', '=', 'users.country_id')
                        ->leftJoin('subcategories', function ($join) {
                            $join->on(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(userprofiles.subcategory_id, "$[*]"))'), 'LIKE', DB::raw('CONCAT("%", subcategories.id, "%")'));
                        })
                        ->where('userprofiles.majorcategory_id', $id)
                        ->where('userprofiles.editorrole_id', '=', 2)
                        ->groupBy('users.id', 'users.name', 'users.last_name', 'users.profile_pic', 'users.institute_name', 'users.position', 'users.city', 'countries.name', 'userprofiles.subcategory_id','userprofiles.user_description')
                        ->orderBy('users.name', 'ASC')
                        //->get();
                        ->paginate( config('constants.pagination.editorial_items_per_page') );                                                            

        $category_name = category_name($id);
        $subcategory_list = subcategory_list($id);
        return view('frontend.editorial_board_wise_video',compact('editor_board_list','category_name','subcategory_list'));
    }
    public function editorial_board_members()
    {
        $sorteditorspage_data = Sorteditorspage::first();
        $editor_board_list = DB::table('userprofiles')
                        ->select(
                            'users.id',
                            'users.name',
                            'users.last_name',
                            'users.profile_pic',
                            'users.institute_name',
                            'users.position',
                            'users.city',
                            'countries.name as country_name',
                            'userprofiles.subcategory_id',
                            'majorcategories.category_name',
                            DB::raw('GROUP_CONCAT(DISTINCT subcategories.subcategory_name) as subcategory_names')
                        )
                        ->leftJoin('users', 'users.id', '=', 'userprofiles.user_id')
                        ->leftJoin('countries', 'countries.id', '=', 'users.country_id')
                        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'userprofiles.majorcategory_id')
                        ->leftJoin('subcategories', function ($join) {
                            $join->on(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(userprofiles.subcategory_id, "$[*]"))'), 'LIKE', DB::raw('CONCAT("%", subcategories.id, "%")'));
                        })
                        ->where('userprofiles.editorrole_id', '=', 2)
                        ->where('userprofiles.visible_status', '=', 1)
                        ->groupBy('users.id', 'users.name', 'users.last_name', 'users.profile_pic', 'users.institute_name', 'users.position', 'users.city', 'countries.name', 'userprofiles.subcategory_id', 'majorcategories.category_name');
                        //->orderBy('majorcategories.category_name', 'ASC');
        $editor_board_list->when($sorteditorspage_data->sorting_option == '1' && $sorteditorspage_data->order_by == '1', function ($query) {
            return $query->orderBy('users.editorial_board_numbering', 'ASC');
        });
        $editor_board_list->when($sorteditorspage_data->sorting_option == '1' && $sorteditorspage_data->order_by == '2', function ($query) {
            return $query->orderBy('users.editorial_board_numbering', 'DESC');
        });
        $editor_board_list->when($sorteditorspage_data->sorting_option == '2' && $sorteditorspage_data->order_by == '1', function ($query) {
            return $query->orderBy('users.name', 'ASC');
        });
        $editor_board_list->when($sorteditorspage_data->sorting_option == '2' && $sorteditorspage_data->order_by == '2', function ($query) {
            return $query->orderBy('users.name', 'DESC');
        });
        //$editor_board_list = $editor_board_list->paginate( config('constants.pagination.editorial_items_per_page') );
        $editor_board_list = $editor_board_list->paginate( $sorteditorspage_data->editorial_member_per_page );
                                                            

        //$category_name = category_name($id);
        return view('frontend.editorial_board_list',compact('editor_board_list'));
    }
    public function reviewer_acceptance($encrypted_reviewer_email,$video_id,$encrypted_majorcategory_id,$video_history_id)
    {
        $reviewer_email = Crypt::decrypt($encrypted_reviewer_email);
        $id = Crypt::decrypt($video_id);
        $accept_deny_option = accept_deny_option_reviewer();
        $check_last_record = check_last_record($id);
        $check_action_by_reviewer = DB::table('videohistories')
                                        ->where('videoupload_id',$id)
                                        ->where('send_from_as','Reviewer')
                                        ->where('send_to_as','editorial-member')
                                        ->where('reviewer_email',$reviewer_email)
                                        ->where('videohistory_id',$video_history_id)
                                        ->first();
        $video_history_record_based_on_id = video_history_record_based_on_id($video_history_id);
        // echo '<pre>';
        // print_r($check_action_by_reviewer);exit;
        return view('frontend.reviewer.reviewer_acceptance',compact('encrypted_reviewer_email','encrypted_majorcategory_id','reviewer_email','id','accept_deny_option','check_last_record','check_action_by_reviewer','video_history_id','video_history_record_based_on_id'));
    }   
    public function store_history_by_reviewer(Request $request)
    {
        //$check_last_record = check_last_record($request->videoupload_id);
        // if(($check_last_record->videohistorystatus_id == '5' && $check_last_record->send_from_as == 'editorial-member') || ($check_last_record->videohistorystatus_id == '8' && $check_last_record->send_from_as == 'Reviewer'))
        // {
            // if($check_last_record->videohistorystatus_id == '8' && $check_last_record->send_from_as == 'Reviewer')
            // {
            //     $send_from_user_id =  $check_last_record->send_to_user_id;
            // }
            // else
            // {
            //     $send_from_user_id =  $check_last_record->send_from_user_id;
            // }
            $video_history_record_baed_on_id = video_history_record_based_on_id($request->video_history_id);
            $send_from_user_id =  $video_history_record_baed_on_id->send_from_user_id;
            $videohistory = new videohistory();
            $videohistory->videoupload_id = $request->videoupload_id;
            $videohistory->videohistorystatus_id = $request->videohistorystatus_id;
            //$videohistory->send_from_user_id = Auth::user()->id;
            $videohistory->send_to_user_id = $send_from_user_id;
            $videohistory->message = $request->message;
            $videohistory->send_from_as = 'Reviewer';
            $videohistory->send_to_as = 'editorial-member';
            $videohistory->reviewer_email = $request->reviewer_email;
            $videohistory->review_action_by_reviewer = 1;
            $videohistory->videohistory_id = $request->video_history_id;
            if($request->videohistorystatus_id == 7)
            {
                $videohistory->is_accepted_by_reviewer = 1;
            }
            $videohistory->save();

            //Start check if the reviewer's email exist or not
            $editorial_member_details = get_user_details($send_from_user_id);
            $check_user = User::where('email',$request->reviewer_email)->first();
            if($request->videohistorystatus_id == 7)
            {
                // If accepts
                if(!$check_user)
                {
                    $type = 'signup';
                    Mail::to($request->reviewer_email)->send(new sendRegistrationUrlToReviewer($request->reviewer_email,$request->encrypted_reviewer_email,$request->encrypted_majorcategory_id,$type,'reviewer',$request->videoupload_id,'accept',$send_from_user_id));
                    Mail::to($editorial_member_details->email)->send(new sendRegistrationUrlToReviewer($request->reviewer_email,$request->encrypted_reviewer_email,$request->encrypted_majorcategory_id,$type,'editorial_member',$request->videoupload_id,'accept',$send_from_user_id));
                }
                else
                {
                    //Start Check if user is not registered as a reviewer, then update as reviewer
                    $role_update = Userrole::updateOrCreate([                            
                        'user_id' => $check_user->id,
                        'role_id' => 4,                              
                    ],[
                        'role_id' => 4,                              
                    ]);
                    //End Check if user is not registered as a reviewer, then update as reviewer
                    $type = 'login';
                    Mail::to($request->reviewer_email)->send(new sendRegistrationUrlToReviewer($request->reviewer_email,$request->encrypted_reviewer_email,$request->encrypted_majorcategory_id,$type,'reviewer',$request->videoupload_id,'accept',$send_from_user_id));
                    Mail::to($editorial_member_details->email)->send(new sendRegistrationUrlToReviewer($request->reviewer_email,$request->encrypted_reviewer_email,$request->encrypted_majorcategory_id,$type,'editorial_member',$request->videoupload_id,'accept',$send_from_user_id));
                }

                // To the admin
                $admin_email = config('constants.emails.admin_email');
                Mail::to($admin_email)->send(new sendMailAfterReviewersActionToTheAdmin($request->reviewer_email,$send_from_user_id,$request->videoupload_id,'accept'));
                $request->session()->flash('success', 'Thankyou for accepting to review this video. You will receive an email to process further. Please check your email.');
                return response()->json(['success'=>'Successfully']);
            }
            else
            {
                // If deny
                $type = 'notype';
                Mail::to($request->reviewer_email)->send(new sendRegistrationUrlToReviewer($request->reviewer_email,$request->encrypted_reviewer_email,$request->encrypted_majorcategory_id,$type,'reviewer',$request->videoupload_id,'decline',$send_from_user_id));
                Mail::to($editorial_member_details->email)->send(new sendRegistrationUrlToReviewer($request->reviewer_email,$request->encrypted_reviewer_email,$request->encrypted_majorcategory_id,$type,'editorial_member',$request->videoupload_id,'decline',$send_from_user_id));
                // To the admin
                $admin_email = config('constants.emails.admin_email');
                Mail::to($admin_email)->send(new sendMailAfterReviewersActionToTheAdmin($request->reviewer_email,$send_from_user_id,$request->videoupload_id,'decline'));
                $request->session()->flash('deny', 'You have denied this video to review.');
                return response()->json(['success'=>'Successfully']);
            }
            //End check if the reviewer's email exist or not
        // }
        // else
        // {
        //     $request->session()->flash('success', 'Already accepted by someone.');
        //     return response()->json(['success'=>'failed']);
        // }
    }
    public function corrauthor_acceptance($encrypted_corrauthor_email,$video_id,$encrypted_majorcategory_id)
    {
        $corrauthor_email = Crypt::decrypt($encrypted_corrauthor_email);
        $id = Crypt::decrypt($video_id);
        $accept_deny_option = accept_deny_option_corr_author();
        $check_last_record = check_last_record($id);
        return view('frontend.correspondingauthor.corrauthor_acceptance',compact('encrypted_corrauthor_email','encrypted_majorcategory_id','corrauthor_email','id','accept_deny_option','check_last_record'));
    } 
    public function store_history_by_corresponding_author(Request $request)
    {
        $check_last_record = check_last_record($request->videoupload_id);
        if(($check_last_record->videohistorystatus_id == '3' && $check_last_record->send_from_as == 'editorial-member') || ($check_last_record->videohistorystatus_id == '27' && $check_last_record->send_from_as == 'Corresponding-Author'))
        {
            if($check_last_record->videohistorystatus_id == '27' && $check_last_record->send_from_as == 'Corresponding-Author')
            {
                $send_from_user_id =  $check_last_record->send_to_user_id;
            }
            else
            {
                $send_from_user_id =  $check_last_record->send_from_user_id;
            }
            $videohistory = new videohistory();
            $videohistory->videoupload_id = $request->videoupload_id;
            $videohistory->videohistorystatus_id = $request->videohistorystatus_id;
            $videohistory->send_to_user_id = $send_from_user_id;
            $videohistory->message = $request->message;
            $videohistory->send_from_as = 'Corresponding-Author';
            $videohistory->send_to_as = 'editorial-member';
            $videohistory->corresponding_author_email = $request->corrauthor_email;
            $videohistory->save();

            //Start check if the reviewer's email exist or not
            $check_user = User::where('email',$request->corrauthor_email)->first();
            if($request->videohistorystatus_id == 26)
            {
                // If accepts
                if(!$check_user)
                {
                    $type = 'signup';
                    Mail::to($request->corrauthor_email)->send(new sendRegistrationUrlToCorrespondingAuthor($request->corrauthor_email,$request->encrypted_corrauthor_email,$request->encrypted_majorcategory_id,$type));
                }
                else
                {
                    $type = 'login';
                    Mail::to($request->corrauthor_email)->send(new sendRegistrationUrlToCorrespondingAuthor($request->corrauthor_email,$request->encrypted_corrauthor_email,$request->encrypted_majorcategory_id,$type));
                }

                $request->session()->flash('success', 'Thankyou for accepting to review this video. You will receive an email to process further. Please check your email.');
                return response()->json(['success'=>'Successfully']);
            }
            else
            {
                // If deny
                $request->session()->flash('deny', 'You have denied this video to review.');
                return response()->json(['success'=>'Successfully']);
            }
            //End check if the reviewer's email exist or not
        }
        else
        {
            $request->session()->flash('success', 'Already accepted by someone.');
            return response()->json(['success'=>'failed']);
        }
    }
    public function subscription()
    {
        $subscriptionPlans = Subscriptionplan::where('status',1)->orderBy('sequence')->get();
        return view('frontend.subscription',compact('subscriptionPlans'));
    }
    public function channels()
    {
        return view('frontend.channels');
    }
    public function single_channels()
    {
        return view('frontend.single_channels');
    }
    public function video_upload()
    {
        return view('frontend.video_upload');
    }
    public function page_404()
    {
        return view('frontend.page_404');
    }
    public function blank_page()
    {
        return view('frontend.blank_page');
    }
    public function history_page()
    {
        return view('frontend.history_page');
    }
    public function categories_page()
    {
        return view('frontend.categories_page');
    }
    public function subscription_page()
    {
        return view('frontend.subscription_page');
    }
    public function institution_register()
    {
        return view('frontend.institute.institution_register');
    }
    public function contact_us()
    {
        return view('frontend.contact_us');
    }
    public function terms_n_condition()
    {
        return view('frontend.terms_n_condition');
    }
    public function about()
    {
        return view('frontend.about');
    }
    public function advance_search_view()
    {
        session()->forget('advance_search_request');
        $Videotype = Videotype::where('status',1)->orderBy('sequence')->get();
        $Videosubtype = Videosubtype::where('status',1)->orderBy('sequence')->get();
        $majorcategory = Majorcategory::where('status',1)->orderBy('sequence')->get();
        $paymentype = Membershipplan::where('status',1)->orderBy('sequence')->get();
        return view('frontend.advance_search',compact('Videotype','Videosubtype','majorcategory','paymentype'));
    }
    public function advance_search_post(Request $request)
    {
        $video_list_all = [];
        $all_subcategories = '';
        if ($request->filled('search_value') || $request->filled('author_name') || $request->filled('reviewer_name') ||$request->filled('video_title') || $request->filled('keywords') || $request->filled('majorcategory_id') || $request->filled('videotype_id') || $request->filled('references') || $request->filled('abstract') || $request->filled('subcategory_id_search') || $request->filled('online_publishing_licence') || $request->filled('unique_number') || $request->filled('videosubtype_id')) 
        {
            $video_lists = search_videos($request); // in App/Helper.php
            $video_list_all = $video_lists['video_list'];
            $all_subcategories = $video_lists['all_subcategories'];
        }
        session()->put('advance_search_request', $request->all());
        $Videotype = Videotype::where('status',1)->orderBy('sequence')->get();
        $Videosubtype = Videosubtype::where('status',1)->orderBy('sequence')->get();
        $majorcategory = Majorcategory::where('status',1)->orderBy('sequence')->get();
        $paymentype = Membershipplan::where('status',1)->orderBy('sequence')->get();
        $subcategory_data = Subcategory::where('majorcategory_id',$request->majorcategory_id)->get();
        return view('frontend.advance_search',compact('video_list_all','Videotype','Videosubtype','majorcategory','all_subcategories','paymentype','subcategory_data'));
        //return Redirect()->back()->withInput()->with(['Videotype' => $Videotype, 'majorcategory' => $majorcategory]);
        // return redirect()->route('show.advance.search')
        //             ->withInput()
        //             ->with(['Videotype' => $Videotype, 'majorcategory' => $majorcategory]);
    }
    public function all_search_get()
    {
        session()->forget('advance_search_request');
        $Videotype = Videotype::where('status',1)->orderBy('sequence')->get();
        $Videosubtype = Videosubtype::where('status',1)->orderBy('sequence')->get();
        $majorcategory = Majorcategory::where('status',1)->orderBy('sequence')->get();
        $paymentype = Membershipplan::where('status',1)->orderBy('sequence')->get();
        return view('frontend.advance_search',compact('Videotype','Videosubtype','majorcategory','paymentype'));
    }
    public function all_search_post(Request $request)
    {
        $video_list_all = [];
        $all_subcategories = '';
        if ($request->filled('search_value')) 
        {
            $video_lists = search_all_videos($request); // in App/Helper.php
            $video_list_all = $video_lists['video_list'];
            $all_subcategories = $video_lists['all_subcategories'];
        }
        session()->put('advance_search_request', $request->all());
        $Videotype = Videotype::where('status',1)->orderBy('sequence')->get();
        $Videosubtype = Videosubtype::where('status',1)->orderBy('sequence')->get();
        $majorcategory = Majorcategory::where('status',1)->orderBy('sequence')->get();
        $paymentype = Membershipplan::where('status',1)->orderBy('sequence')->get();
        return view('frontend.advance_search',compact('video_list_all','Videotype','Videosubtype','majorcategory','all_subcategories','paymentype'));
    }
    public function post_newsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newslettersubscriptions',
            'captcha' => 'required|captcha',
        ], [
            'required' => 'This field is required',
            'email' => 'Please enter a valid email address',
            'unique' => 'You have already subscribed with this email',
            'captcha.captcha' => 'Invalid captcha',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Your existing logic for successful form submission goes here
        $newslettersubscription = new Newslettersubscription();
        $newslettersubscription->email = $request->email;
        $newslettersubscription->save();
        $encrypted_email = Crypt::encrypt($request->email);
        $admin_email = config('constants.emails.admin_email');
        Mail::to($request->email)->send(new sendNewsletterWelcomeMail($request->email,$encrypted_email));
        $subscription_type = 1; // 1 for subscription and 2 for unsubscription
        Mail::to($admin_email)->send(new sendNewsletterNotificationToAdmin($request->email,$subscription_type,$newslettersubscription));
        return response()->json(['success' => 'Subscribed Successfully!']);
    }
    public function newsletter_unscubscribe($email)
    {
        $email = Crypt::decrypt($email);
        $is_email_exist = Newslettersubscription::where('email',$email)->first();
        if($is_email_exist)
        {
            $is_email_exist->delete($is_email_exist->id);
            $admin_email = config('constants.emails.admin_email');
            Mail::to($email)->send(new sendNewsLetterUnsubscribeMail($email));
            $newslettersubscription = '';
            $subscription_type = 2; // 1 for subscription and 2 for unsubscription
            Mail::to($admin_email)->send(new sendNewsletterNotificationToAdmin($email,$subscription_type,$newslettersubscription));
        }
        return redirect()->route('welcome');
    }
    public function site_map()
    {
        return view('frontend.site_map');
    }

    public function isFree($videoId)
    {
        // Implement your logic to check if the video is free
        $videoId = Crypt::decrypt($videoId);
        $result = Videoupload::select('membershipplan_id')->find($videoId);
        $isFree = $result->membershipplan_id == '2' ? true : false;
        return response()->json(['isFree' => $isFree]);
    }

    public function isPaid($videoId)
    {
        // Implement your logic to check if the video is paid
        $videoId = Crypt::decrypt($videoId);
        $result = Videoupload::select('membershipplan_id')->find($videoId);
        $isPaid = $result->membershipplan_id == '1' ? true : false;
        return response()->json(['isPaid' => $isPaid]);
    }

    public function hasPaid($videoId)
    {
        $videoId = Crypt::decrypt($videoId);
        $transaction_data = Transcation::where('user_id',Auth::user()->id)
                                        ->where('item_type','video')
                                        ->where('item_id',$videoId)
                                        ->where('is_payment_done',1)
                                        ->first();
        if($transaction_data)
        {
            $hasPaid = true;
        }
        else
        {
            $hasPaid = false;
        }
        // Example: Replace the following line with your actual condition
        return response()->json(['hasPaid' => $hasPaid]);
    }

    public function isMember($videoId)
    {
        // Implement your logic to check if the video is available for members
        // Example: Replace the following line with your actual condition
        return response()->json(['isMember' => true]);
    }

    public function isMembershipActive() {
        $today = now();
        $userId = Auth::user()->id;
    
        $subscription_data = Transcation::where('user_id', $userId)
            ->where('item_type', 'subscription')
            ->where('is_payment_done', 1)
            ->whereDate('subscription_start_date', '<=', $today)
            ->whereDate('subscription_end_date', '>=', $today)
            ->first();
    
            if($subscription_data)
            {
                $isMembershipActive = true;
            }
            else
            {
                $isMembershipActive = false;
            }
    
        return response()->json(['isMembershipActive' => $isMembershipActive]);
        //return response()->json(['isMembershipActive' => false]);
    }
    public function video_register_view($videoId) 
    {    
        $videoId = Crypt::decrypt($videoId);
        $ipAddress = RequestFacades::ip();

        $view_response = VideoView::where('ip_address',$ipAddress)->where('video_id',$videoId)->first();

        if(!$view_response)
        {
            $videoView = new VideoView();
            $videoView->video_id = $videoId;
            $videoView->ip_address = $ipAddress;
            $videoView->user_id = Auth::id();
            $videoView->save();
        }
        $view_count = VideoView::where('video_id',$videoId)->count();
        // Return a JSON response
        return response()->json(['view_count' => $view_count,'id' => $videoId]);
    }
    
    public function subscription_plan()
    {
        return view('frontend.payment.subscription_plan');
    }
    public function get_sub_category(Request $request)
    {
        $subcategories = Subcategory::where('majorcategory_id', $request->majorcategory_id)
                                        ->where('status',1)
                                        ->get();
        return response()->json([
            'status' => 'success',
            'subcategories' => $subcategories,
        ]);
    }
    public function submit_contact_form(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',  
            'affiliation' => 'required',  
            'country' => 'required',  
            'email' => 'required|email',  
            'subject' => 'required',  
            'message' => 'required', 
            'captcha' => 'required|captcha' 
        ], [        
            'required' => 'This field is required', 
            'email' => 'Not a valid email', 
            'captcha.captcha' => 'Invalid captcha'
        ]);
        
        if($request->subject == 'Research Video Contents')
        {
            $email = 'content@researchvideos.net';
        }
        elseif($request->subject == 'Online Payments')
        {
            $email = 'finance@researchvideos.org';
        }
        elseif($request->subject == 'Copyrights')
        {
            $email = 'copyright@researchvideos.net';
        }
        elseif($request->subject == 'Technical Help')
        {
             $email = 'support@researchvideos.net';
        }
        elseif($request->subject == 'Partnerships')
        {
             $email = 'contact@researchvideos.net';
        }
        elseif($request->subject == 'Sponsoring')
        {
             $email = 'contact@researchvideos.net';
        }
        elseif($request->subject == 'Other')
        {
             $email = 'contact@researchvideos.net';
        }
        Mail::to($email)->send(new sendContactForm($request));
        Mail::to($request->email)->send(new sendContactFormToUser());
        $request->session()->flash('success', 'Message sent successfully.');
        return response()->json(['success'=>'Successfully']);
    }
    public function submit_institution_register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',  
            'affiliation' => 'required',  
            'country' => 'required',  
            'email' => 'required|email',  
            'subject' => 'required',  
            'captcha' => 'required|captcha' 
        ], [        
            'required' => 'This field is required', 
            'email' => 'Not a valid email', 
            'captcha.captcha' => 'Invalid captcha'
        ]);        
        $institutionrequest = new Institutionrequest();
        $institutionrequest->name = $request->name;
        $institutionrequest->affiliation = $request->affiliation;
        $institutionrequest->country = $request->country;
        $institutionrequest->email = $request->email;
        $institutionrequest->subject = 'Institution Register Request';
        $institutionrequest->message = $request->message;
        $institutionrequest->save();

        Mail::to('contact@researchvideos.net')->send(new sendMailForInstitutionRegistrationRequest('admin',$request));
        Mail::to($request->email)->send(new sendMailForInstitutionRegistrationRequest('user',$request));
        $request->session()->flash('success', 'Message sent successfully.');
        return response()->json(['success'=>'Successfully']);
    }
    public function invite_new_member($user_id_encrypt)
    {
        $user_id_decrypt = Crypt::decrypt($user_id_encrypt);
        $user_details  = get_user_details($user_id_decrypt);
        if($user_details)
        {
            return view('frontend.invite_new_member',compact('user_id_encrypt'));
        }
    }
    public function invite_member_send(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'emails' => 'required|array',
            'emails.*' => 'required|email',  
            'captcha' => 'required|captcha' 
        ], [        
            'emails.required' => 'At least one email is required',
            'emails.*.required' => 'Email field is required',
            'emails.*.email' => 'Invalid email format',
            'captcha.required' => 'Captcha is required',
            'captcha.captcha' => 'Invalid captcha'
        ]);
        $user_id = Crypt::decrypt($request->id);
        $user_details = get_user_details($user_id);
        foreach($request->emails as $email)
        {
            Mail::to($email)->send(new invitationNotificationForRegister($email,$user_details));
        }

        $request->session()->flash('success', 'The invitation email is sent.');

        return response()->json(['success'=>'Successfully','redirect'=>route('invite.new.member',$request->id)]);
    }
    public function search_by_rvoi_link()
    {
        return view('frontend.search_by_rvoi_link');
    }
    public function search_by_rvoi_link_get_data(Request $request)
    {
        $query = $request->get('search');
        
        if(!empty($query))
        {
        $data = Videoupload::where('rvoi_link', 'LIKE', "%$query%")
                                  ->where('is_published', 1)
                                  ->select('rvoi_link','id')
                                  ->get();

        }
        else
        {
            $data = [];
        }
        $output='';
        if(count($data)>0){
            $output ='
                <table class="rvoi_search_table table">
                <thead>';
                    foreach($data as $row){
                        $output .='
                        <tr>
                        <th id="'.$row->id.'" data-id="' . $row->id . '">'.$row->rvoi_link.'</th>
                        </tr>
                        ';
                    }
            $output .= '
            </thead>
                </table>';
        }
        else{
            $output .='No results';
        }
        return $output;
    }
    public function export_bibtex($video_id)
    {
        $video_id = Crypt::decrypt($video_id);
        $corr_authors = DB::table('coauthors')
                            ->where('videoupload_id',$video_id)
                            ->where('authortype_id','3') // 3 for corresponding author
                            ->get();
        
        foreach($corr_authors as $corr_authors_value)
        {
            $name = '';
            $surname = '';
            if(!empty($corr_authors_value->name))
            {
                $name = $corr_authors_value->name;
            }
            if(!empty($corr_authors_value->surname))
            {
                $surname = ' '.$corr_authors_value->surname;
            }
            $corr_author_array[] = $name.$surname;
            $corresponding_author_data = implode(", ",$corr_author_array);  
        }
                
        $video_details = single_video_details($video_id);
        $rvoi_link = generate_rvoi_link($video_details->short_name,$video_details->historycurrentstatus_created_at,$video_details->unique_number);
        $entries = [
            [
                'video_unique_id' => $video_details->unique_number,
                'author' => $corresponding_author_data,
                'title' => $video_details->video_title,
                'journal' => 'ResearchVideos',
                'year' => Carbon::parse($video_details->historycurrentstatus_created_at)->year,
                'month' => Carbon::parse($video_details->historycurrentstatus_created_at)->format('F'),
                'doi' => $rvoi_link
            ],
        ];
        $bibtex = $this->convertToBibTeX($entries);
        $filename = 'RV'.$video_details->unique_number;
        $response = Response::make($bibtex);
        $response = ['filename'=>$filename, 'content'=>$response->getContent()];

        return response()->json($response);
    }
    private function convertToBibTeX($entries)
    {
        $bibtex = '';

        foreach ($entries as $entry) {
            $bibtex .= "@Article{" . $entry['video_unique_id'] . ",\n";
            $bibtex .= "  AUTHOR = {" . $entry['author'] . "},\n";
            $bibtex .= "  TITLE = {" . $entry['title'] . "},\n";
            $bibtex .= "  JOURNAL = {" . $entry['journal'] . "},\n";
            $bibtex .= "  YEAR = {" . $entry['year'] . "},\n";
            $bibtex .= "  MONTH = {" . $entry['month'] . "},\n";
            $bibtex .= "  URL = {" . $entry['doi'] . "}\n";
            $bibtex .= "}\n\n";
        }

        return $bibtex;
    }

    public function test_crop_video()
    {
        $video_path = storage_path('app/public/uploads/vide_Upload2_image/1702563745_file_example_MP4_480_1_5MG.mp4');
        $croppedVideoPath = storage_path('app/public/uploads/vide_Upload2_image/cropped_video.mp4');
    
        //$ffmpegCommand = "C:/FFmpeg/bin/ffmpeg -i " . $video_path . " -ss 00:00:00 -t 00:00:20 " . $croppedVideoPath;
        //$ffmpegCommand = "ffmpeg -i " . $video_path . " -ss 00:00:00 -t 00:00:20 " . $croppedVideoPath;
        //$test = exec($ffmpegCommand);
        //echo $test;
    }
    public function sub_category_wise_video($id,$sortingOption = null)
    {
        $video_lists = video_based_on_sub_category($id,$sortingOption);
        $video_list_all = $video_lists['video_list'];
        $all_subcategories = $video_lists['all_subcategories'];
        $category_name = sub_category_name($id);
        $major_category_id = $id;
        return view('frontend.sub_scientific_disciplines_wise_video',compact('video_list_all','category_name','all_subcategories','major_category_id'));
    }
    public function guide_for_authors()
    {
        $data = subcategoryDetails();
        return view('frontend.for_authors.guide_for_authors',compact('data'));
    }
    public function tutorials()
    {
        return view('frontend.for_authors.tutorials');
    }
    public function open_science()
    {
        return view('frontend.for_authors.open_science');
    }
    public function societies_and_publishers()
    {
        return view('frontend.societies_and_publishers');
    }
    public function faq()
    {
        return view('frontend.faq');
    }
    public function authors_services()
    {
        $live_url = config('constants.urls.live_url');
        return view('frontend.for_authors.authors_services',compact('live_url'));
    }
    public function user_details($user_id)
    {
        $data  = get_user_details($user_id);
        $user_details = [
            'first_name' => $data->name,
            'last_name' => $data->last_name,
            'user_description' => $data->user_description

        ];
        return response()->json(['user_details' => $user_details,'status' => 'success']);
    }
    public function video_generation()
    {
        return view('frontend.video_generation');
    }
    public function data_sharing()
    {
        return view('frontend.data_sharing');
    }
    public function show_videos($filename,$type,$unique_number)
    {
        $video_details = DB::table('videouploads')
                            ->select('main_folder_name','category_folder_name')
                            ->where('unique_number',$unique_number)
                            ->first();
        $main_folder_name = $video_details->main_folder_name;
        $category_folder_name = $video_details->category_folder_name;

        if($type == 'full')
        {
            $playlist = 'uploads/'.$main_folder_name.'/'.$category_folder_name.'/'.$unique_number.'/encrypted_files/'.$filename;
            $media_path = 'uploads/'.$main_folder_name.'/'.$category_folder_name.'/'.$unique_number.'/encrypted_files/';
        }
        else
        {
            $playlist = 'uploads/'.$main_folder_name.'/'.$category_folder_name.'/'.$unique_number.'/encrypted_files/'.$filename;
            $media_path = 'uploads/'.$main_folder_name.'/'.$category_folder_name.'/'.$unique_number.'/encrypted_files/';
        }
        return FFMpeg::dynamicHLSPlaylist()
            ->fromDisk('public')
            ->open($playlist)
            ->setKeyUrlResolver(function ($key) use ($main_folder_name,$category_folder_name,$unique_number) {
                return route('video.key', ['key' => $key,'main_folder_name' => $main_folder_name,'category_folder_name' => $category_folder_name,'unique_number' => $unique_number]);
            })
            ->setMediaUrlResolver(function ($mediaFilename) use($media_path) {
                return Storage::disk('public')->url($media_path . $mediaFilename);
            })
            ->setPlaylistUrlResolver(function ($filename) use ($type,$unique_number) {
                return route('video.player.show', ['filename'=>$filename,'type'=>$type,'video_id'=>$unique_number]);
            });
    }
    public function video_key($key,$main_folder_name,$category_folder_name,$unique_number)
    {  
        $media_path = 'uploads/'.$main_folder_name.'/'.$category_folder_name.'/'.$unique_number.'/encrypted_files/';
        return Storage::disk('public')->download($media_path.$key);
    }
    public function showVideoImage($unique_number)
    {
        $video_details = DB::table('videouploads')
                            ->select('main_folder_name','category_folder_name')
                            ->where('unique_number',$unique_number)
                            ->first();
        $main_folder_name = $video_details->main_folder_name;
        $category_folder_name = $video_details->category_folder_name;

        $imagePath = 'uploads/'.$main_folder_name.'/'.$category_folder_name.'/'.$unique_number . '/'.$unique_number.'_screenshot.webp';       

        // Construct the path to the image file

        if (Storage::disk('public')->exists($imagePath)) {
            $imageContent = Storage::disk('public')->get($imagePath);

            // Return the image content as response with appropriate content type
            return response($imageContent)->header('Content-Type', 'image/webp');
        } else {
            abort(404); // Image not found
        }
    }
    public function special_issue()
    {
        // $special_issue = DB::table('specialissues')
        //                     ->leftJoin('users','users.id','=','specialissues.user_id')
        //                     ->leftJoin('userprofiles','userprofiles.user_id','=','specialissues.user_id')
        //                     ->leftJoin('countries', 'countries.id', '=', 'users.country_id')
        //                     ->select('specialissues.*','users.name','users.last_name','users.profile_pic','users.institute_name','users.city','countries.name as country_name','userprofiles.user_description')
        //                     ->orderBy('id','DESC')
        //                     ->get();

        $specialIssues = DB::table('specialissues')->orderBy('id', 'DESC')->get();

        foreach ($specialIssues as $issue) {
            $issue->user_ids = json_decode($issue->user_id, true); // Decode JSON to array
        }

        $userDetails = [];
        foreach ($specialIssues as $issue) {
            if (!empty($issue->user_ids)) {
                $users = DB::table('users')
                    ->leftJoin('userprofiles', 'userprofiles.user_id', '=', 'users.id')
                    ->leftJoin('countries', 'countries.id', '=', 'users.country_id')
                    ->whereIn('users.id', $issue->user_ids)
                    ->select('users.*', 'userprofiles.user_description', 'countries.name as country_name')
                    ->get();
                $userDetails[$issue->id] = $users;
            }
        }

        foreach ($specialIssues as $issue) {
            $issue->users = $userDetails[$issue->id] ?? [];
        }

        // Now you can return $specialIssues with the associated user data
        // echo '<pre>';
        // print_r($specialIssues);
        // exit;
        $special_issue = $specialIssues;

        return view('frontend.special_issue',compact('special_issue'));                            
    }
}
