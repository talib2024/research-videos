<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Country;
use App\Models\role;
use App\Models\Userrole;
use App\Models\Userprofile;
use App\Models\Editorrole;
use App\Models\Majorcategory;
use App\Models\Subcategory;
use App\Models\Rvcoinsrewardtype;
use App\Models\Rvcoin;
use App\Models\Coauthor;
use App\Models\Videotype;
use App\Models\Videosubtype;
use App\Models\Membershipplan;
use App\Models\Likeunlikecounter;
use App\Models\VideoView;
use App\Models\videohistory;
use App\Models\Videoupload;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\accountDeletionConfirmationToUser;
use App\Mail\welcomeEmailByAdmin;
use App\Mail\accountActivationByAdminEmail;
use App\Mail\userVerificationEmail;
use App\Mail\registeredUserNotificationToAdmin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller
{  
    public function __construct()
    {
        $this->middleware(['auth','adminRole']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_details = User::where('role_id','!=',1)->where('is_organization','!=',1)->orderBy('created_at','desc')->get();
        return view('backend.users.usersList', compact('user_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {                     
        $country_list = Country::all();
        $roles = role::where('id','!=',1)->whereIn('id',['3','5'])->get();
        $editor_role = Editorrole::where('status',1)->where('id',2)->get();
        $major_category = Majorcategory::where('status',1)->get();
        return view('backend.users.user_create', compact('country_list','roles','editor_role','major_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
        ],
        [
            'required'=> 'This field is required',
            'email.email'=> 'Invalid email format',
            'email.unique'=> 'This email address is already registered',
            'password.regex' => 'Invalid password format',
            'password.min' => 'Password must be at least 8 characters long',
            'password.confirmed' => 'Password does not match',
            'captcha.captcha' => 'Invalid captcha'
        ]);

        $user = User::create([
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'unique_member_id' => $this->generateUniqueNumber(),
            'role_id' => 6,
        ]);
        $userRole = Userrole::create([
            'user_id' => $user->id,
            'role_id' => 6,
        ]);
        $user_profile = Userprofile::updateOrCreate([                            
            'user_id' => $user->id                                
        ],[
            'wallet_id'  =>  $this->generateUniqueNumberwallet_id(),                              
        ]);
        $rvCoins = Rvcoin::create([
            'user_id' => $user->id,
            'rvcoinsrewardtype_id' => 1,
            'received_rvcoins' => 10,
        ]);
        update_rvcoins($user->id,10);
        Mail::to($user->email)->send(new welcomeEmailByAdmin($user,$request->password));
        $id = $user->id;
        //Start save into roleuser table
        if(isset($request->role_ids) && !empty($request->role_ids))
        {
            $data_role = [];
            $data_sequence_for_role_switch = [];
            $data_for_role_id = [];
            foreach($request->role_ids as $roles)
            {
                $roles_data = explode("_",$roles);
                $role_id = $roles_data[0];                
                $data_for_role_id[] = $role_id;
                $sequence_for_role_switch = $roles_data[1];
                $data_role[] = [
                    'user_id' => $id,
                    'role_id' => $role_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $data_sequence_for_role_switch[$role_id] = $sequence_for_role_switch;
            }            
            $role_of_maximum_sequence = array_keys($data_sequence_for_role_switch, max($data_sequence_for_role_switch))[0];    
        
            // Start check if editor-in-chief already assigned with same major category
            if(in_array("3", $data_for_role_id))
            {
                if($request->editorrole_id == 1)
                {
                    $check_editor = Userprofile::where('editorrole_id',1)
                                        ->where('majorcategory_id',$request->majorcategory_id)
                                        ->first();
                    if($check_editor && $check_editor->user_id != $id)
                    {
                        return response()->json(['success'=>'fail','message'=>'Already assigned this editor with the Scientific Disciplines. The user is created, you may go on user section and update the user.']);
                    }                    
                }
            }
            // End check if editor-in-chief already assigned with same major category
            //Userrole::where('user_id', $id)->delete();
            Userrole::where('user_id', $id)
                        ->where(function ($query) {
                            $query->where('role_id', 3)
                                ->orWhere('role_id', 5);
                        })
                        ->delete();
            Userrole::insert($data_role);
        }
        //End  save into roleuser table

        $user_details = User::find($id);
        $phone_with_code = explode("_",$request->input('phone_with_code'));
        $country_code = $phone_with_code[0].'_'.$phone_with_code[2];
        $phone = $phone_with_code[1];
        $user_details->name = $request->name;
        $user_details->last_name = $request->last_name;
        if(isset($request->role_ids) && !empty($request->role_ids))
        {
            $user_details->role_id = $role_of_maximum_sequence;
        }
        else
        {
            $user_details->role_id = 6;
        }
        $user_details->phone = $phone;
        $user_details->country_code = $country_code;
        $user_details->country_id = $request->country_id;
        $user_details->city = $request->city;
        $user_details->zip_code = $request->zip_code;
        $user_details->address = $request->address;
        $user_details->institute_name = $request->institute_name;
        $user_details->position = $request->position;
        $user_details->degree = $request->degree;
        $profile_pic_path = '';
        if($request->hasFile('profile_pic')){
            $profile_pic_image = $request->file('profile_pic');
            $fileName_profile_pic_image = time().'_'.$profile_pic_image->getClientOriginalName();
            $filePath = $profile_pic_image->storeAs('uploads/profile_image', $fileName_profile_pic_image, 'public');
            $user_details->profile_pic = $fileName_profile_pic_image;
            $profile_pic_path = asset('storage/uploads/profile_image/' . $fileName_profile_pic_image);
        }
        $user_details->save();

        // Start update into profile table
        $profile_details = Userprofile::where('user_id', $id)->first();
        if($profile_details)
        {
            if($request->status == '1')
            {
                $user_profile = Userprofile::where('user_id', $id)->update(array('user_description' => $request->user_description,'account_activated_by' => Auth::id(),'account_activated_date'=> now()));
            }
        }
        else
        {
            if($request->status == '0')
            {
                $user_profile = Userprofile::where('user_id', $id)->insert(array('user_description' => $request->user_description,'user_id'=>$id,'account_deleted_by' => Auth::id(),'account_deletion_date'=> now()));
            }
        }

        // In case if, roles is having editor        
        if(isset($request->role_ids) && !empty($request->role_ids) && in_array("3", $data_for_role_id))
        {
            $editor_update = Userprofile::updateOrCreate([                            
                'user_id' => $id                                
            ],[                                
                'editorrole_id'   => $request->editorrole_id,
                'majorcategory_id'  =>  $request->majorcategory_id,                                
                'subcategory_id'  =>  json_encode($request->subcategory_id),                                
            ]);
        }
        else
        {
            $editor_update = Userprofile::updateOrCreate([                            
                'user_id' => $id                                
            ],[                                
                'editorrole_id'   => null,
                'majorcategory_id'  =>  null,                                
            ]);
        }
        // End update into profile table
        session()->flash('success','User is created successfully!');
        return response()->json(['success'=>'Successfully','message'=>'Created Successfully!']);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {                   
        $user_details = DB::table('users')
                        ->leftJoin('userprofiles', 'userprofiles.user_id', '=', 'users.id')
                        ->leftJoin('users as deleted_by_users', 'userprofiles.account_deleted_by', '=', 'deleted_by_users.id')
                        ->select('users.*', 'userprofiles.account_deletion_request', 'userprofiles.account_deletion_request_date', 'userprofiles.account_deleted_by', 'userprofiles.account_deletion_date', 'deleted_by_users.name as deleted_by_name','userprofiles.wallet_id','userprofiles.user_description','userprofiles.highest_priority','userprofiles.visible_status')
                        ->where('users.id', $id)
                        ->first();
                    
        $country_list = Country::all();
        $progress_count = profile_progress_count($id); // In App/Helper.php
        $roles = role::where('id','!=',1)->get();
        $userrole = Userrole::where('user_id',$id)->get();
        $userroledata = [];
        foreach($userrole as $userrole)
        {
            array_push($userroledata, $userrole->role_id);
        }
        return view('backend.users.user_show_for_delete', compact('country_list','user_details','progress_count','roles','userroledata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_details = DB::table('users')
                        ->leftJoin('userprofiles','userprofiles.user_id','=','users.id')
                        ->select('users.*','userprofiles.editorrole_id','userprofiles.majorcategory_id','userprofiles.subcategory_id','userprofiles.wallet_id','userprofiles.user_description','userprofiles.highest_priority','userprofiles.visible_status')
                        ->where('users.id', $id)
                        ->first();
        $selected_sub_category_id = json_decode($user_details->subcategory_id);
        $country_list = Country::all();
        $progress_count = profile_progress_count($id); // In App/Helper.php
        $roles = role::where('id','!=',1)->whereIn('id',['3','5'])->get();
        $userrole = Userrole::where('user_id',$id)->get();
        $userroledata = [];
        foreach($userrole as $userrole)
        {
            array_push($userroledata, $userrole->role_id);
        }
        $editor_role = Editorrole::where('status',1)->where('id',2)->get();
        $major_category = Majorcategory::where('status',1)->get();
        $subcategory_data = Subcategory::where('majorcategory_id',$user_details->majorcategory_id)->get();
        return view('backend.users.user_update', compact('country_list','user_details','progress_count','roles','userroledata','editor_role','major_category','subcategory_data','selected_sub_category_id'));
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
        $validatedData = $request->validate([
            // 'name' => 'required',  
            // 'last_name' => 'required',  
            // 'country_id' => 'required',  
            // 'city' => 'required',  
            // 'zip_code' => 'required',          
            'profile_pic' => 'sometimes|nullable|image|max:40',   
            // 'institute_name' => 'required',  
            // 'position' => 'required',  
            // 'degree' => 'required', 
        ], [        
            'required' => 'This field is required',
        ]);  

        //Start save into roleuser table
        if(isset($request->role_ids) && !empty($request->role_ids))
        {
            $data_role = [];
            $data_sequence_for_role_switch = [];
            $data_for_role_id = [];
            foreach($request->role_ids as $roles)
            {
                $roles_data = explode("_",$roles);
                $role_id = $roles_data[0];                
                $data_for_role_id[] = $role_id;
                $sequence_for_role_switch = $roles_data[1];
                $data_role[] = [
                    'user_id' => $id,
                    'role_id' => $role_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $data_sequence_for_role_switch[$role_id] = $sequence_for_role_switch;
            }            
            $role_of_maximum_sequence = array_keys($data_sequence_for_role_switch, max($data_sequence_for_role_switch))[0];    
        
            // Start check if editor-in-chief already assigned with same major category
            if(in_array("3", $data_for_role_id))
            {
                if($request->editorrole_id == 1)
                {
                    $check_editor = Userprofile::where('editorrole_id',1)
                                        ->where('majorcategory_id',$request->majorcategory_id)
                                        ->first();
                    if($check_editor && $check_editor->user_id != $id)
                    {
                        return response()->json(['success'=>'fail','message'=>'already assigned this editor with the Scientific Disciplines.']);
                    }                    
                }
                if($request->editorrole_id == 2 && $request->highest_priority == 1)
                {
                    $check_highest_priority = Userprofile::where('highest_priority',1)
                                        ->where('majorcategory_id',$request->majorcategory_id)
                                        ->first();
                    if($check_highest_priority && $check_highest_priority->user_id != $id)
                    {
                        return response()->json(['success'=>'fail','message'=>'already given highest priority to another user for this Scientific Discipline.']);
                    }                    
                }
            }
            // End check if editor-in-chief already assigned with same major category
            //Userrole::where('user_id', $id)->delete();
            Userrole::where('user_id', $id)
                        ->where(function ($query) {
                            $query->where('role_id', 3)
                                ->orWhere('role_id', 5);
                        })
                        ->delete();
            Userrole::insert($data_role);
        }
        //End  save into roleuser table

        $user_details = User::find($id);
        $phone_with_code = explode("_",$request->input('phone_with_code'));
        $country_code = $phone_with_code[0].'_'.$phone_with_code[2];
        $phone = $phone_with_code[1];
        $user_details->name = $request->name;
        $user_details->last_name = $request->last_name;
        if(isset($request->role_ids) && !empty($request->role_ids))
        {
            $user_details->role_id = $role_of_maximum_sequence;
        }
        else
        {
            $user_details->role_id = 6;
        }
        $user_details->phone = $phone;
        $user_details->country_code = $country_code;
        $user_details->country_id = $request->country_id;
        $user_details->city = $request->city;
        $user_details->zip_code = $request->zip_code;
        $user_details->address = $request->address;
        $user_details->institute_name = $request->institute_name;
        $user_details->position = $request->position;
        $user_details->degree = $request->degree;
        $user_details->status = $request->status;
        $user_details->editorial_board_numbering = $request->editorial_board_numbering;
        $profile_pic_path = '';
        if($request->hasFile('profile_pic')){
            $profile_pic_image = $request->file('profile_pic');
            $fileName_profile_pic_image = time().'_'.$profile_pic_image->getClientOriginalName();
            $filePath = $profile_pic_image->storeAs('uploads/profile_image', $fileName_profile_pic_image, 'public');
            $user_details->profile_pic = $fileName_profile_pic_image;
            $profile_pic_path = asset('storage/uploads/profile_image/' . $fileName_profile_pic_image);
        }
        $user_details->save();

        // Start update into profile table
        //$profile_details = Userprofile::where('user_id', $id)->first();
        $profile_details = DB::table('users')
                        ->leftJoin('userprofiles','userprofiles.user_id','=','users.id')
                        ->select('users.*','userprofiles.editorrole_id','userprofiles.majorcategory_id','userprofiles.subcategory_id','userprofiles.wallet_id','userprofiles.user_description','userprofiles.highest_priority','userprofiles.visible_status')
                        ->where('users.id', $id)
                        ->first();
        if($profile_details)
        {
            if($request->status == '1')
            {
                if($profile_details->account_activation_request == 1)
                {
                    $user_profile = User::where('id', $id)->update(array('account_activation_request' => 0));
                    $admin_email = config('constants.emails.admin_email');
                    Mail::to($admin_email)->send(new accountActivationByAdminEmail('foradmin',$profile_details));
                    Mail::to($profile_details->email)->send(new accountActivationByAdminEmail('foruser',$profile_details));
                }
                $user_profile = Userprofile::where('user_id', $id)->update(array('user_description' => $request->user_description,'account_deletion_request' => 0,'account_activated_by' => Auth::id(),'account_activated_date'=> now()));
            }
        }
        else
        {
            if($request->status == '0')
            {
                $user_profile = Userprofile::where('user_id', $id)->insert(array('user_description' => $request->user_description,'user_id'=>$id,'account_deleted_by' => Auth::id(),'account_deletion_date'=> now()));
            }
        }

        // In case if, roles is having editor        
        if(isset($request->role_ids) && !empty($request->role_ids) && in_array("3", $data_for_role_id))
        {
            $editor_update = Userprofile::updateOrCreate([                            
                'user_id' => $id                                
            ],[                                
                'editorrole_id'   => $request->editorrole_id,
                'majorcategory_id'  =>  $request->majorcategory_id,                                
                'subcategory_id'  =>  json_encode($request->subcategory_id),                                
                'highest_priority'  =>  $request->highest_priority,                                
                'visible_status'  =>  $request->visible_status,                                
            ]);
        }
        else
        {
            $editor_update = Userprofile::updateOrCreate([                            
                'user_id' => $id                                
            ],[                                
                'editorrole_id'   => null,
                'majorcategory_id'  =>  null,                                
            ]);
        }
        // End update into profile table
        
        $progress_count = profile_progress_count($id); // In App/Helper.php
        return response()->json(['success'=>'Successfully','message'=>'Updated Successfully!','progress_count'=>$progress_count,'profile_pic_path'=>$profile_pic_path]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_details = User::find($id);
        $user_details->status = 0;
        $user_details->save();

        $user_profile = Userprofile::where('user_id', $id)->update(array('account_deleted_by' => Auth::id(),'account_deletion_date'=> now()));

        Mail::to($user_details->email)->send(new accountDeletionConfirmationToUser($user_details));

        return redirect()->back()->with('success','User Deleted Successfully!');
    }
    public function user_delete_request()
    {
        $user_details = User::leftJoin('userprofiles','userprofiles.user_id','=','users.id')
                            ->select('users.id','users.name','users.phone','users.email','userprofiles.account_deletion_request_date')
                            ->where('userprofiles.account_deletion_request',1)
                            ->where('userprofiles.account_deleted_by',NULL)
                            ->where('users.role_id','!=',1)
                            ->orderBy('users.created_at','desc')->get();
        return view('backend.users.users_deleted_request_list', compact('user_details'));
    }
    public function user_activation_request()
    {
        $user_details = User::leftJoin('userprofiles','userprofiles.user_id','=','users.id')
                            ->select('users.id','users.name','users.phone','users.email','userprofiles.account_deletion_request_date')
                            ->where('users.account_activation_request',1)
                            ->where('users.role_id','!=',1)
                            ->orderBy('users.account_activation_request_date','desc')->get();
        return view('backend.users.user_activation_request_list', compact('user_details'));
    }
    public function users_rvcoins($user_id)
    {
        $user_details = get_user_details($user_id);
        $rvcoinsrewardtype = Rvcoinsrewardtype::where('id','!=',1)->get();
        $rvcoins_history = rvcoins_history($user_id);
        return view('backend.users.rvcoins_assign',compact('rvcoinsrewardtype','user_details','rvcoins_history'));
    }
    public function assign_rvcoins(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'received_rvcoins' => 'required',
            'rvcoinsrewardtype_id' => 'required'
        ], [        
            'required' => 'This field is required',
        ]);  
        $rvCoins = Rvcoin::create([
            'user_id' => $request->user_id,
            'rvcoinsrewardtype_id' => $request->rvcoinsrewardtype_id,
            'received_rvcoins' => $request->received_rvcoins,
            'description' => $request->description
        ]);
        update_rvcoins($request->user_id,$request->received_rvcoins);
        session()->flash('success','RVcoins assigned successfully.');
        return redirect()->back();

    }
    public function generateUniqueNumber() 
    {
        $uniqueNumber = uniqid(); // Generate a random number
        // Check if the number already exists in the table
        $exists = DB::table('users')->where('unique_member_id', $uniqueNumber)->exists();
    
        if ($exists) {
            // If the number already exists, generate a new one
            return $this->generateUniqueNumber();
        } else {
            // If the number is unique, return it
            return $uniqueNumber;
        }
    }
    public function generateUniqueNumberwallet_id() 
    {
        $unique_wallet_id = Str::random(42); // Generate a random number
        // Check if the number already exists in the table
        $exists = DB::table('userprofiles')->where('wallet_id', $unique_wallet_id)->exists();
    
        if ($exists) {
            // If the number already exists, generate a new one
            return $this->generateUniqueNumberwallet_id();
        } else {
            // If the number is unique, return it
            return $unique_wallet_id;
        }
    }
    public function show_profile()
    {
        return view('backend.users.admin_profile');
    }
    public function update_profile(Request $request,$id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/' , 'confirmed'],
        ],
        [
            'required'=> 'This field is required',
            'password.regex'=> 'Password format is invalid',
            'password.confirmed'=> 'Password format is invalid',
        ]);

        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        session()->flash('success','Updated successfully.');
        return redirect()->back();
    }
    public function users_video_assigned($id)
    {                   
        $user_details = DB::table('users')
                        ->leftJoin('userprofiles', 'userprofiles.user_id', '=', 'users.id')
                        ->leftJoin('users as deleted_by_users', 'userprofiles.account_deleted_by', '=', 'deleted_by_users.id')
                        ->select('users.*', 'userprofiles.account_deletion_request', 'userprofiles.account_deletion_request_date', 'userprofiles.account_deleted_by', 'userprofiles.account_deletion_date', 'deleted_by_users.name as deleted_by_name','userprofiles.wallet_id','userprofiles.user_description','userprofiles.highest_priority','userprofiles.visible_status')
                        ->where('users.id', $id)
                        ->first();

        $roles = DB::table('userroles')
                        ->leftJoin('roles','roles.id','=','userroles.role_id')
                        ->select('roles.role','roles.id as role_id','userroles.id as userrole_id')
                        ->where('user_id',$id)->get();

        $user_profile_data = Userprofile::where('user_id', $id)->first();
        $video_list = video_uploads_by_user($id);
        if($user_profile_data)
        {
            $video_list_for_editor = video_assigned_for_editor($user_profile_data->majorcategory_id);
            $video_list_for_reviewer = video_assigned_for_reviewer($user_details->email);
            $video_list_for_publisher = video_assigned_for_publisher($id);
            $video_assigned_for_corr_author = video_assigned_for_corr_author($user_details->email);
        }
        else
        {
            $video_list_for_editor = '';
            $video_list_for_reviewer = '';
            $video_list_for_publisher = '';
            $video_assigned_for_corr_author = '';
        }
        
        $video_list_for_editor_member = video_assigned_for_editor_member($id);
        $assigned_task_count_editor_member = assigned_task_count_editor_member($id);
        $assigned_task_count_reviewer = assigned_task_count_reviewer($user_details->email);
        $editor_role = '';
        if(Session::has('loggedin_role')) 
        {
            $user_role_id = Session::get('loggedin_role');
        } 
        else 
        {
            $user_role_id = $user_details->role_id;
        }
        // Start check for editor role
        if($user_role_id == '3')
        {
            $editor_role = DB::table('userprofiles')
                ->select('editorrole_id')
                ->where('user_id',$id)->first();
        }
        return view('backend.users.users_video_assigned', compact('user_details','roles','user_profile_data','video_list','video_list_for_editor','video_list_for_editor_member','video_list_for_reviewer','video_list_for_publisher','video_assigned_for_corr_author','assigned_task_count_editor_member','assigned_task_count_reviewer','user_role_id','editor_role'));
    }
    public function user_role(Request $request)
    {
        $role_id = $request->role_id;
        switch_role_session($role_id); // in App/Helper.php
        return response()->json(['message' => 'Session stored successfully']);
    }
    public function video_details_history($id,$user_id,$user_email)
    {
        $user_details = DB::table('users')
                        ->leftJoin('userprofiles', 'userprofiles.user_id', '=', 'users.id')
                        ->leftJoin('users as deleted_by_users', 'userprofiles.account_deleted_by', '=', 'deleted_by_users.id')
                        ->select('users.*', 'userprofiles.account_deletion_request', 'userprofiles.account_deletion_request_date', 'userprofiles.account_deleted_by', 'userprofiles.account_deletion_date', 'deleted_by_users.name as deleted_by_name','userprofiles.wallet_id','userprofiles.user_description','userprofiles.highest_priority','userprofiles.visible_status')
                        ->where('users.id', $user_id)
                        ->first();    
        $user_profile_data = Userprofile::where('user_id', $user_id)->first();
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

            $passed_by_name = passed_by_name($id,'4',$user_id);        
            $editorial_member_option = editorial_member_option();
            $editor_chief_option = editorial_member_option();
            $accept_deny_option = accept_deny_option(); // currently not in use
            $reviewer_option = reviewer_option();
            $pass_revise_option = pass_revise_option();
            $check_last_record = check_last_record($id);
            $video_history = video_history($id);
            $publisher_option = publisher_option();
            $send_to_user_id_for_publisher = passed_by_name($id,'6',$user_id);
            $get_condition_to_delete_record_for_author = get_condition_to_delete_record_for_author($id);
            // Start to get last submission for different-different roles
            $pass_to = [];
            $editorial_member = [];
            $reviewer_emails = [];
            $last_message = '';
            $publisher_ids = [];
            // For Editorial chief
            $last_record_for_editor_chief = videohistory::where('videoupload_id',$id)
                                                ->where('send_from_user_id',$user_id)
                                                ->where('send_from_as','editorial-member')
                                                ->where('last_record_for_chief_editor',1)
                                                ->get();
            if ($last_record_for_editor_chief->isEmpty())
            {
                // if pass to another editorial member, the last record
                $last_record_for_editor_chief = videohistory::where('videoupload_id',$id)
                                                ->where('videohistorystatus_id',25)
                                                ->where('send_to_user_id',$user_id)
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
                                                ->where('videohistories.send_from_user_id',$user_id)
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
                                                ->where('videohistories.reviewer_email',$user_email)
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
                                                ->where('videohistories.reviewer_email',$user_email)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first();
            
            // corresponding author
            $last_record_for_corresponding_author = DB::table('videohistories')
                                                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                                                ->select('videohistorystatuses.option as last_selected_option','videohistories.message','videohistories.send_from_as','videohistories.corresponding_author_email','videohistories.videohistorystatus_id','videohistories.message_visibility','videohistories.corresponding_author_status')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('send_from_as','Corresponding-Author')
                                                ->where('videohistories.corresponding_author_email',$user_email)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first();   
            // Publisher
            $last_record_for_publisher = DB::table('videohistories')
                                                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                                                ->select('videohistorystatuses.option as last_selected_option','videohistories.message','videohistories.videohistorystatus_id')
                                                ->where('videohistories.videoupload_id',$id)
                                                ->where('send_from_as','Publisher')
                                                ->where('videohistories.send_from_user_id',$user_id)
                                                ->orderBy('videohistories.created_at', 'desc')
                                                ->first(); 
            // reviewer's list to withdraw   
            $reviewers_list_to_withdraw = DB::table('videohistories')
                                                ->where('videoupload_id',$id)
                                                ->where('videohistorystatus_id',5)
                                                ->where('send_from_as','editorial-member')
                                                ->where('send_from_user_id',$user_id)
                                                ->where('is_latest_record_for_reviewer_from_editor',1)
                                                ->get();         
            // End to get last submission for different-different roles
            
        // End for history
        $editor_role = '';
        if(Session::has('loggedin_role')) 
        {
            $user_role_id = Session::get('loggedin_role');
        } 
        else 
        {
            $user_role_id = $user_details->role_id;
        }
        // Start check for editor role
        if($user_role_id == '3')
        {
            $editor_role = DB::table('userprofiles')
                ->select('editorrole_id')
                ->where('user_id',$id)->first();
        }
         $response = response()->view('backend.users.video_details',compact('last_record_of_editor_member_for_authors','last_record_of_reviewer_for_authors','country_list','video_view_count','subcategory_data','Videotype','Videosubtype','majorcategory','paymentype','coauthor','video_list','likecount','coauthors','editor_chief_option','editorial_member_list','passed_by_name','accept_deny_option','pass_revise_option','check_last_record','video_history','reviewer_list','pass_to','editorial_member','reviewer_emails','last_message','last_record_for_editor_member','last_record_for_reviewer','publisher_list','publisher_ids','publisher_option','send_to_user_id_for_publisher','last_record_for_publisher','last_record_for_corresponding_author','editorial_member_option','reviewer_option','get_condition_to_delete_record_for_author','last_record_for_editor_chief','reviewers_list_to_withdraw','last_record_for_withdraw_reviewer','user_role_id','editor_role'));

        // Set Cache-Control headers
         $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
         $response->header('Pragma', 'no-cache');
         $response->header('Expires', '0');

        // Return the response
         return $response;
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
    public function statictics_report($user_id,$user_email)
    {
        $user_details = get_user_details($user_id);
        $user_roles = DB::table('userroles')
                        ->leftJoin('roles','roles.id','=','userroles.role_id')
                        ->select('roles.role','roles.id as role_id','userroles.id as userrole_id')
                        ->where('user_id',$user_id)->get();
        $user_profile_data = Userprofile::where('user_id', $user_id)->first();
        $video_list = video_uploads_by_user($user_id); // no use
        if($user_profile_data)
        {
            $video_list_for_editor = video_assigned_for_editor($user_profile_data->majorcategory_id);
            $video_list_for_reviewer = video_assigned_for_reviewer($user_email);
            $video_list_for_publisher = video_assigned_for_publisher($user_id);
            $video_assigned_for_corr_author = video_assigned_for_corr_author($user_email);
        }
        else
        {
            $video_list_for_editor = '';
            $video_list_for_reviewer = '';
            $video_list_for_publisher = '';
            $video_assigned_for_corr_author = '';
        }
        
        $video_list_for_editor_member = video_assigned_for_editor_member($user_id);
        $assigned_task_count_editor_member = assigned_task_count_editor_member($user_id); // no use
        $assigned_task_count_reviewer = assigned_task_count_reviewer($user_email); // no use
        
        $statictics_member_only = statictics_member_only($user_id);
        $statictics_for_author = statictics_for_author($user_id);
        $statictics_for_publisher = statictics_for_publisher($user_id);
        $statictics_for_corr_author = statictics_for_corr_author($user_email);
        $statictics_for_editorial_member = statictics_for_editorial_member($user_id);
        $statictics_for_reviewer = statictics_for_reviewer($user_email);
        $rvcoins_history = rvcoins_history($user_id);
        $purchase_history = purchase_history($user_id);
        // echo '<pre>';
        // print_r($statictics_for_author);exit;

        return view('backend.statictics.statictics_report',compact('user_details','user_roles','user_profile_data','statictics_member_only','statictics_for_author','statictics_for_publisher','statictics_for_corr_author','statictics_for_editorial_member','statictics_for_reviewer','video_list','video_list_for_editor','video_list_for_editor_member','video_list_for_reviewer','video_list_for_publisher','video_assigned_for_corr_author','assigned_task_count_editor_member','assigned_task_count_reviewer','rvcoins_history','purchase_history'));
        
    }
    public function send_verifcation_link(Request $request,$id)
    {
        $user = User::find($id);
        if(empty($user->email_verified_at))
        {
            Mail::to($user->email)->send(new userVerificationEmail($user));
            $admin_email = config('constants.emails.admin_email');
            Mail::to($admin_email)->send(new registeredUserNotificationToAdmin($user,'signup'));
            session()->flash('success', 'Verification link is sent!');
        }
        else
        {
            session()->flash('success', 'This user is already verified!');
        }
        return redirect()->back();
    }
}
