<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\accountDeletionRequestToAdmin;
use App\Mail\accountDeletionRequestToUser;
use App\Mail\instituteEmployeeStatusToEmployee;
use App\Mail\instituteEmployeeStatusToInstitute;
use DB;
use App\Models\Country;
use App\Models\User;
use App\Models\Userprofile;
use App\Models\Majorcategory;
use App\Models\Subcategory;

class ProfileController extends Controller
{   
    public function __construct()
    {
        $this->middleware(['auth','userRole','checkUserStatus']);      
    }   
    public function my_settings()
    {
        $user_details = DB::table('users')
                        ->leftJoin('userprofiles','userprofiles.user_id','=','users.id')
                        ->leftJoin('roles','roles.id','=','users.role_id')
                        ->select('users.*','roles.role as role_name','userprofiles.majorcategory_id','userprofiles.subcategory_id','userprofiles.wallet_id','userprofiles.user_description')
                        ->where('users.id', Auth::user()->id)
                        ->first();
        $user_details->subcategory_id = json_decode($user_details->subcategory_id, true);
        $country_list = Country::all();
        $majorcategory = Majorcategory::where('status',1)->get();
        $subcategory_data = Subcategory::where('majorcategory_id',$user_details->majorcategory_id)->get();
        $progress_count = profile_progress_count(Auth::user()->id); // In App/Helper.php
        return view('frontend.profile',compact('country_list','user_details','majorcategory','subcategory_data','progress_count'));
    }   
    public function update_profile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',  
            'last_name' => 'required',
            'country_id' => 'required',  
            'city' => 'required',  
            'zip_code' => 'required',          
            'profile_pic' => 'sometimes|nullable|mimes:png,jpeg,JPEG|max:40',  
            'institute_name' => 'required',  
            'position' => 'required',  
            'degree' => 'required', 
            'majorcategory_id' => 'required',           
            'subcategory_id' => 'required',           
            'user_description' => 'sometimes|nullable|max:2500',   
            'captcha' => 'required|captcha'
        ], [        
            'required' => 'This field is required',  
            'captcha.captcha' => 'Invalid captcha'  
        ]);  
        $user_details = User::find(Auth::id());
        $phone_with_code = explode("_",$request->input('phone_with_code'));
        $country_code = $phone_with_code[0].'_'.$phone_with_code[2];
        $phone = $phone_with_code[1];
        $user_details->name = $request->name;
        $user_details->last_name = $request->last_name;
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
        $userprofile = Userprofile::updateOrCreate([
            'user_id' => Auth::id()
          ],[
            'majorcategory_id' => $request->majorcategory_id,
            'subcategory_id' => json_encode($request->subcategory_id),
            'user_description' => $request->user_description,
            //'wallet_id' => $request->wallet_id
          ]);
        $progress_count = profile_progress_count(Auth::user()->id); // In App/Helper.php
        return response()->json(['success'=>'Successfully','message'=>'Updated Successfully!','progress_count'=>$progress_count,'profile_pic_path'=>$profile_pic_path]);
    }
    public function user_role(Request $request)
    {
        $role_id = $request->role_id;
        switch_role_session($role_id); // in App/Helper.php
        return response()->json(['message' => 'Session stored successfully']);
    }
    public function my_account()
    {
        $user_profile_data = Userprofile::where('user_id', Auth::user()->id)->first();
        $video_list = video_uploads_by_user(Auth::user()->id);
        if($user_profile_data)
        {
            $video_list_for_editor = video_assigned_for_editor($user_profile_data->majorcategory_id);
            $video_list_for_reviewer = video_assigned_for_reviewer(Auth::user()->email);
            $video_list_for_publisher = video_assigned_for_publisher(Auth::user()->id);
            $video_assigned_for_corr_author = video_assigned_for_corr_author(Auth::user()->email);
        }
        else
        {
            $video_list_for_editor = '';
            $video_list_for_reviewer = '';
            $video_list_for_publisher = '';
            $video_assigned_for_corr_author = '';
        }
        
        $video_list_for_editor_member = video_assigned_for_editor_member(Auth::user()->id);
        $assigned_task_count_editor_member = assigned_task_count_editor_member(Auth::user()->id);
        $assigned_task_count_reviewer = assigned_task_count_reviewer(Auth::user()->email);
        return view('frontend.my_account',compact('user_profile_data','video_list','video_list_for_editor','video_list_for_editor_member','video_list_for_reviewer','video_list_for_publisher','video_assigned_for_corr_author','assigned_task_count_editor_member','assigned_task_count_reviewer'));
    }
    public function account_delete_request(Request $request)
    {
        $userprofile = Userprofile::updateOrCreate([                            
            'user_id' =>  Auth::id()                              
        ],
        [                                
            'account_deletion_request' => 1,                        
            'account_deletion_request_date' => now(),                        
            'account_deleted_by' => null                        
        ]);
        
        $admin_email = config('constants.emails.admin_email');
        Mail::to($admin_email)->send(new accountDeletionRequestToAdmin());
        Mail::to(Auth::user()->email)->send(new accountDeletionRequestToUser());
        return redirect()->back();
        //End update status into user table
    }
    public function institute_user()
    {
        $institute_user = DB::table('users')
        ->where('users.is_organization', 2)
        ->where('users.related_main_organisation_id', Auth::user()->id)
        ->get();
        return view('frontend.institute.institute_user',compact('institute_user'));
    }
    public function institute_user_details($id)
    {
        $user_details = DB::table('users')
                        ->leftJoin('userprofiles','userprofiles.user_id','=','users.id')
                        ->leftJoin('roles','roles.id','=','users.role_id')
                        ->select('users.*','roles.role as role_name','userprofiles.majorcategory_id','userprofiles.subcategory_id')
                        ->where('users.id', $id)
                        ->first();
        $user_details->subcategory_id = json_decode($user_details->subcategory_id, true);
        $country_list = Country::all();
        $majorcategory = Majorcategory::where('status',1)->get();
        $subcategory_data = Subcategory::where('majorcategory_id',$user_details->majorcategory_id)->get();
        return view('frontend.institute.institute_user_details',compact('country_list','user_details','majorcategory','subcategory_data'));

    }
    public function institute_user_status_update(Request $request,$id)
    {
        $user_details = get_user_details($id);
        $user_institute = User::where('id',$user_details->related_main_organisation_id)->first();
        if($user_details->status == 1)
        {
            $user_update = User::where('id', $id)->update(['status' => 0]);
            Mail::to($user_details->email)->send(new instituteEmployeeStatusToEmployee($user_institute,'0'));
            Mail::to($user_institute->email)->send(new instituteEmployeeStatusToInstitute($user_details,'0'));
        }
        else
        {
            // if status is 0
            $user_update = User::where('id', $id)->update(['status' => 1]);
            Mail::to($user_details->email)->send(new instituteEmployeeStatusToEmployee($user_institute,'1'));
            Mail::to($user_institute->email)->send(new instituteEmployeeStatusToInstitute($user_details,'1'));
        }
        return redirect()->back()->with('success','User updated Successfully!');
    }
    public function user_payment_history()
    {
        $payment_details = DB::table('transcations')
                                ->leftJoin('subscriptionplans','subscriptionplans.id','=','transcations.item_id')
                                ->leftJoin('videouploads','videouploads.id','=','transcations.item_id')
                                ->select('transcations.*','subscriptionplans.plan_name','videouploads.id AS video_id','videouploads.unique_number')
                                ->where('transcations.user_id',Auth::user()->id)
                                ->get();
        return view('frontend.user_payment_history',compact('payment_details'));
    }
}
