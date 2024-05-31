<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use App\Models\Majorcategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','adminRole'])->only('index');
        // $this->middleware('auth');
        // $this->middleware('adminRole')->only('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_rvcoins_available_in_user_account = DB::table('userprofiles')->sum('total_rv_coins');
        $total_rvcoins_spend_in_user_account = DB::table('transcations')->where('transaction_type','=','rv_coins')->sum('amount');
        $total_rvcoins_given_by_admin_to_the_users = DB::table('rvcoins')->where('rvcoinsrewardtype_id','!=','1')->sum('received_rvcoins'); // except Registration Reward
        $total_users = DB::table('users')->where('role_id','!=','1')->count('id'); // except admin

        return view('backend.adminDashboard',compact('total_rvcoins_available_in_user_account','total_rvcoins_spend_in_user_account','total_rvcoins_given_by_admin_to_the_users','total_users'));
    }
    public function users_home(Request $request,$sortingOption = null)
    {
        $video_lists = video_uploads($request,$sortingOption); // in App/Helper.php
        $video_list_all = $video_lists['video_list'];
        $all_subcategories = $video_lists['all_subcategories'];
        $majorCategory = major_category(); // in App/Helper.php
        $userRole = Session::get('loggedin_role');
        if($userRole == '6')
        {
            // Member
            return view('frontend.home',compact('majorCategory','video_list_all','all_subcategories'));
        }
        elseif($userRole == '2')
        {
            // Author
            return view('frontend.home',compact('majorCategory','video_list_all','all_subcategories'));
        }
        elseif($userRole == '3')
        {
            // Editor
            return view('frontend.home',compact('majorCategory','video_list_all','all_subcategories'));
        }
        elseif($userRole == '4')
        {
            // Reviewer
            return view('frontend.home',compact('majorCategory','video_list_all','all_subcategories'));
        }
        elseif($userRole == '5')
        {
            // Publisher
            return view('frontend.home',compact('majorCategory','video_list_all','all_subcategories'));
        }
        else
        {
            return view('frontend.home',compact('majorCategory','video_list_all','all_subcategories'));
        }
    }
}
