<?php

namespace App\Http\Controllers\frontend\members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class MemberController extends Controller
{
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if(Auth::user() && (Auth::user()->role_id == 6 || Auth::user()->role_id == 2))
        // {
        //     return $next($request);
        // }    
        // return redirect()->route('member.login');
        // });  
        // $this->middleware('checkUserStatus');   
        $this->middleware(['auth','userRole','checkUserStatus']);   
    }
    public function watch_list($sortingOption = null)
    {
        $video_lists = watch_list(Auth::user()->id,$sortingOption); // In App/Helper.php
        $video_list_all = $video_lists['video_list'];
        $all_subcategories = $video_lists['all_subcategories'];
        return view('frontend.members.watch_list',compact('video_list_all','all_subcategories'));
    }
}
