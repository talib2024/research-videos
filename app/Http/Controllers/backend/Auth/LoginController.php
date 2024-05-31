<?php

namespace App\Http\Controllers\backend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;

class LoginController extends Controller
{  
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login()
    {
        return view('backend.auth.login');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ],[
            'required' => 'This field is required',
            'captcha.captcha' => 'Invalid captcha',
        ]);

        $credentials = $request->except(['_token','captcha']);

        // Check if the user trying to log in through the admin form is not an admin
        if (isset($credentials['email']) && $credentials['email']) {
            $user = User::where('email', $credentials['email'])->first();
            if ($user && $user->role_id != '1') {
                // You can return an error message or redirect to an appropriate page
                return redirect()->back()->with('message','Invalid credentials');
            }
        }

        if (auth()->attempt($credentials)) {
            return redirect()->route('home');
        }

        return redirect()->back()->with('message','Invalid credentials');
    }

    public function registration()
    {
        return view('register');
    }

    public function processRegistration(Request $request)
    {   
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
 
        $user = User::create([
            'name' => trim($request->name),
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password)
        ]);
       
        return redirect()->route('login')->with('message','Your account is created');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}