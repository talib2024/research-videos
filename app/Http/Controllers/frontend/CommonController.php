<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cookieconsent;

class CommonController extends Controller
{  
    public function __construct()
    { 
        $this->middleware('checkUserStatus');       
    }
    public function cookie_consent_save(Request $request)
    {
        $cookie_status = $request->cookie_status;

        $confirmMyChoices_input = $request->confirmMyChoices_input;
        $rejectAllModal_input = $request->rejectAllModal_input;
        $your_privacy_cookie = $request->your_privacy_cookie;
        $strictly_necessary_cookies = $request->strictly_necessary_cookies;
        $performance_cookies = $request->performance_cookies;
        $functional_cookies = $request->functional_cookies;
        $targeting_cookies = $request->targeting_cookies;
        $social_media_cookies = $request->social_media_cookies;

        $ip = $request->ip();

        $cookie_consent_save = new Cookieconsent();        
        $cookie_consent_save->ip_address = $ip;
        $cookie_consent_save->cookie_status = $cookie_status;
        if(!empty($confirmMyChoices_input) || !empty($rejectAllModal_input))
        {
            $cookie_consent_save->your_privacy_cookie = $your_privacy_cookie;
            $cookie_consent_save->strictly_necessary_cookies = $strictly_necessary_cookies;
            $cookie_consent_save->performance_cookies = $performance_cookies;
            $cookie_consent_save->functional_cookies = $functional_cookies;
            $cookie_consent_save->targeting_cookies = $targeting_cookies;
            $cookie_consent_save->social_media_cookies = $social_media_cookies;
        }
        $cookie_consent_save->save();        
    }
    public function change_theme(Request $request)
    {
        $switch_role = Session::put('switchtheme', $request->input('themeMode'));
        return response()->json(['success' => true]);
    }
}
