<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Country;
use App\Models\User;
use App\Models\Userprofile;
use App\Models\Majorcategory;
use App\Models\Subcategory;

class StaticticsController extends Controller
{  
    public function __construct()
    {   
        $this->middleware(['auth','userRole','checkUserStatus']); 
    }

    public function statictics_report()
    {
        $user_roles = DB::table('userroles')
                        ->leftJoin('roles','roles.id','=','userroles.role_id')
                        ->select('roles.role','roles.id as role_id','userroles.id as userrole_id')
                        ->where('user_id',Auth::id())->get();
        $user_profile_data = Userprofile::where('user_id', Auth::user()->id)->first();
        $video_list = video_uploads_by_user(Auth::user()->id); // no use
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
        $assigned_task_count_editor_member = assigned_task_count_editor_member(Auth::user()->id); // no use
        $assigned_task_count_reviewer = assigned_task_count_reviewer(Auth::user()->email); // no use
        
        $statictics_member_only = statictics_member_only(Auth::user()->id);
        $statictics_for_author = statictics_for_author(Auth::user()->id);
        $statictics_for_publisher = statictics_for_publisher(Auth::user()->id);
        $statictics_for_corr_author = statictics_for_corr_author(Auth::user()->email);
        $statictics_for_editorial_member = statictics_for_editorial_member(Auth::user()->id);
        $statictics_for_reviewer = statictics_for_reviewer(Auth::user()->email);
        $rvcoins_history = rvcoins_history(Auth::user()->id);
        $purchase_history = purchase_history(Auth::user()->id);
        // echo '<pre>';
        // print_r($statictics_for_author);exit;

        return view('frontend.statictics.statictics_report',compact('user_roles','user_profile_data','statictics_member_only','statictics_for_author','statictics_for_publisher','statictics_for_corr_author','statictics_for_editorial_member','statictics_for_reviewer','video_list','video_list_for_editor','video_list_for_editor_member','video_list_for_reviewer','video_list_for_publisher','video_assigned_for_corr_author','assigned_task_count_editor_member','assigned_task_count_reviewer','rvcoins_history','purchase_history'));
        
    }
}
