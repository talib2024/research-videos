<?php

namespace App\Http\Controllers\frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\userVerificationEmail;
use App\Mail\resetPasswordEmail;
use App\Mail\welcomeEmail;
use App\Mail\institutionRegistrationNotificationToEmployee;
use App\Mail\institutionRegistrationNotificationToInstitute;
use App\Mail\accountActivationEmail;
use App\Mail\registeredUserNotificationToAdmin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB; 
use App\Models\User;
use App\Models\Userrole;
use App\Models\Userprofile;
use App\Models\Rvcoin;
use App\Models\videohistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{   
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
        if(Auth::user())
        {
            return redirect()->route('welcome');
        }    
        return $next($request);
        })->except(['logout','reloadCaptcha']);        
    }
    public function member_login()
    {
        return view('frontend.auth.member_login');
    } 
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ],[
            'required'=> 'This field is required',
            'captcha.captcha' => 'Invalid captcha'
        ]);
   
        $credentials = $request->only('email', 'password');
        $user_details = User::select('email_verified_at','role_id','status','is_organization')->where('email',$request->email)->first();
        if(empty($user_details->email_verified_at))
        {
            return redirect()->back()->with('error','Invalid credentials');
        }
        elseif($user_details->role_id == '1')
        {
            // Admin cannot login from here.
            return redirect()->back()->with('error','Invalid credentials');
        } 
        elseif($user_details->status == 0)
        {
            // User can login from here, if status is 1.
            return redirect()->back()->with('error','Invalid credentials');
        }
        elseif($user_details->status == 2)
        {
            // User can login from here, if status is 1.
            return redirect()->back()->with('error','This email is blocked. Please contact administrator');
        }  
        // elseif($user_details->is_organization == 1 || $user_details->is_organization == 2)
        // {
        //     // Only normal member can login from here.
        //     return redirect()->back()->with('error','Invalid credentials');
        // }       
        elseif(Auth::attempt($credentials))
        {
            $role_id = Auth::user()->role_id;
            switch_role_session($role_id); // in App/Helper.php
            return redirect()->route('welcome');
            //$userRole = Session::get('loggedin_role');
            // if($userRole == '6')
            // {
            //     // Member
            //     return redirect()->route('members.home', ['role_id' => $userRole]);
            // }
            // elseif($userRole == '2')
            // {
            //     // Author
            //     return redirect()->route('author.home', ['role_id' => $userRole]);
            // }
            // elseif($userRole == '3')
            // {
            //     // Editor
            //     return redirect()->route('editor.home', ['role_id' => $userRole]);
            // }
            // elseif($userRole == '4')
            // {
            //     // Reviewer
            //     return redirect()->route('reviewer.home', ['role_id' => $userRole]);
            // }
            // elseif($userRole == '5')
            // {
            //     // Publisher
            //     return redirect()->route('publisher.home', ['role_id' => $userRole]);
            // }
            //return redirect()->route('welcome');
        }
        return redirect()->back()->with('error','Invalid credentials');
    }   
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    } 
    public function member_register()
    {
        return view('frontend.auth.member_register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/' , 'confirmed'],
            'captcha' => 'required|captcha'
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
            'email_verification_token' => Str::random(32),
            'unique_member_id' => $this->generateUniqueNumber(),
            'user_registered_ip_address' => $request->ip(),
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

        // Start check if this user has accepted the Invitation to review a video and then register from here. Then assign him as a reviewer also.
        $check_user = videohistory::where('videohistorystatus_id',7)->where('reviewer_email',strtolower($request->email))->first();
        if($check_user)
        {
            $role_update = Userrole::updateOrCreate([                            
                'user_id' => $user->id,
                'role_id' => 4,                              
            ],[
                'role_id' => 4,                              
            ]);
        }
        // End check if this user has accepted the Invitation to review a video and then register from here. Then assign him as a reviewer also.

        Mail::to($user->email)->send(new userVerificationEmail($user));
        $admin_email = config('constants.emails.admin_email');
        Mail::to($admin_email)->send(new registeredUserNotificationToAdmin($user,'signup'));
        return redirect()->route('member.login')->with('message','You need to confirm your account. We have sent you an activation link, please check your email.');
    }
    public function reviewer_register($reviewer_email,$encrypted_majorcategory_id,$encrypted_role)
    {
        $encrypted_roles = $encrypted_role;
        $decrypted_roles = Crypt::decrypt($encrypted_role);
        $reviewer_email = Crypt::decrypt($reviewer_email);
        $check_email = User::where('email', $reviewer_email)->first();
        if($check_email) 
        {
            return redirect()->route('member.login');
        }
        else
        {
            return view('frontend.auth.reviewer_register',compact('reviewer_email','encrypted_majorcategory_id','encrypted_roles','decrypted_roles'));
        }        
    }
    public function reviewer_register_post(Request $request)
    {
        // for both reviewer and corresponding author
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/' , 'confirmed'],
            'captcha' => 'required|captcha'
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
        $decrypted_roles = Crypt::decrypt($request->encrypted_roles);
        if($decrypted_roles == 'Reviewer')
        {
            $user = User::create([
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'email_verification_token' => Str::random(32),
                'unique_member_id' => $this->generateUniqueNumber(),
                'role_id' => 4,
                'user_registered_ip_address' => $request->ip(),
            ]);
            $userRole = Userrole::create([
                'user_id' => $user->id,
                'role_id' => 4,
            ]); 
        }
        elseif($decrypted_roles == 'Corresponding-Author')
        {
            $user = User::create([
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'email_verification_token' => Str::random(32),
                'unique_member_id' => $this->generateUniqueNumber(),
                'role_id' => 7,
                'user_registered_ip_address' => $request->ip(),
            ]);
            $userRole = Userrole::create([
                'user_id' => $user->id,
                'role_id' => 7,
            ]); 
        }
        elseif($decrypted_roles == 'author')
        {
            $user = User::create([
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'email_verification_token' => Str::random(32),
                'unique_member_id' => $this->generateUniqueNumber(),
                'role_id' => 2,
                'user_registered_ip_address' => $request->ip(),
            ]);
            $userRole = Userrole::create([
                'user_id' => $user->id,
                'role_id' => 2,
            ]); 
        }
        $userRole_member = Userrole::create([
            'user_id' => $user->id,
            'role_id' => 6,
        ]);        
        $majorcategory_id = Crypt::decrypt($request->encrypted_majorcategory_id);
        if($decrypted_roles == 'Reviewer')
        {
            $user_profile = Userprofile::updateOrCreate([                            
                'user_id' => $user->id                                
            ],[
                'majorcategory_id'  =>  $majorcategory_id,
                'wallet_id'  =>  $this->generateUniqueNumberwallet_id(),                                 
            ]);
        }
        elseif($decrypted_roles == 'Corresponding-Author')
        {
            // for corresponding author
            $user_profile = Userprofile::updateOrCreate([                            
                'user_id' => $user->id                                
            ],[                                
                'authortypes_id'   => 3,
                'wallet_id'  =>  $this->generateUniqueNumberwallet_id(),                            
            ]);
        }
        elseif($decrypted_roles == 'author')
        {
            // for corresponding author
            $user_profile = Userprofile::updateOrCreate([                            
                'user_id' => $user->id                                
            ],[                                
                'authortypes_id'   => 5,
                'wallet_id'  =>  $this->generateUniqueNumberwallet_id(),                            
            ]);
        }
        $rvCoins = Rvcoin::create([
            'user_id' => $user->id,
            'rvcoinsrewardtype_id' => 1,
            'received_rvcoins' => 10,
        ]);
        update_rvcoins($user->id,10);
        
        Mail::to($user->email)->send(new userVerificationEmail($user));
        $admin_email = config('constants.emails.admin_email');
        Mail::to($admin_email)->send(new registeredUserNotificationToAdmin($user,'signup'));
        return redirect()->route('member.login')->with('message','You need to confirm your account. We have sent you an activation link, please check your email.');
    }
    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('welcome');
    }    
    public function user_verify($token = null)
    {
    	if($token == null) 
        {
    		session()->flash('message', 'Invalid Login attempt');
    		return redirect()->route('member.login');
    	}

       $user = User::where('email_verification_token',$token)->first();
       if($user == null )
       {
       	  session()->flash('message', 'Invalid Login attempt');
          return redirect()->route('member.login');
       }

       $user->update([
          'email_verified_at' => Carbon::now(),
          'email_verification_token' => ''
       ]);
       if($user->is_organization == 0 || $user->is_organization == 1)
       {
        $progress_count = profile_progress_count($user->id); //in App/Helper.php
        Mail::to($user->email)->send(new welcomeEmail($user,$progress_count));
        session()->flash('message', 'Your account is activated, you can log in now.');
       }
       elseif($user->is_organization == 2)
       {
         $user_update = User::where('id', $user->id)->update(['status' => 0]);
        $user_institute = User::where('id',$user->related_main_organisation_id)->first();
        Mail::to($user->email)->send(new institutionRegistrationNotificationToEmployee($user_institute));
        Mail::to($user_institute->email)->send(new institutionRegistrationNotificationToInstitute($user));
        session()->flash('message', 'You have successfully verified your account. Now your institution will verify you and then you will receive an email for the further process.');
       }
       else
       {
        // no code
       }
        $admin_email = config('constants.emails.admin_email');
        Mail::to($admin_email)->send(new registeredUserNotificationToAdmin($user,'emailverification'));
       if($user->is_organization == 0)
       {
        return redirect()->route('member.login');
       }
       elseif($user->is_organization == 1 || $user->is_organization == 2)
       {
        return redirect()->route('organization.login');
       }
       else
       {
        // no code
       }
    }
    public function forgot_password()
    {
        return view('frontend.auth.forgot_password');
    } 
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->upsert([
            ['email' => $request->email,'token' => $token,  'created_at' => Carbon::now()],
        ], 'email');

        Mail::to($request->email)->send(new resetPasswordEmail($token));
        return back()->with('message', 'We have e-mailed your password reset link!');
    }
    public function restore_account()
    {
        return view('frontend.auth.restore_account');
    }
    public function restore_account_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ],
        [
            'required' => 'This field is required',
            'email.email'=> 'Invalid email format',
            'exists' => 'This email does not exist'
        ]
        );

        $user_details = DB::table('users')
                        ->leftJoin('userprofiles','userprofiles.user_id','=','users.id')
                        ->where('users.email',$request->email)
                        ->first();
        //if(!empty($user_details->account_deletion_request) && $user_details->account_deletion_request == 1 && $user_details->status == 0)
        if($user_details->status == 0)
        {
            if($user_details->account_activation_request == 1)
            {
                return back()->with('message', 'You have already requested for the activation. We will notify you after the activation!');
            }
            else
            {
                $user_update = User::where('id', $user_details->user_id)->update(array('account_activation_request' => 1,'account_activation_request_date'=> now()));
            }
        }
        elseif($user_details->status == 2)
        {
            // User can login from here, if status is 1.
            return back()->with('message', 'This email is blocked. Please contact administrator');
        }  
        else
        {
            return back()->with('message', 'Your account is already active!');
        }
        $admin_email = config('constants.emails.admin_email');
        Mail::to($admin_email)->send(new accountActivationEmail('foradmin',$request->email));
        return back()->with('message', 'The request to activate your account has been sent to the admin. We will notify you after the activation!');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token) 
    { 
        $user_email = DB::table('password_resets')->select('email')->where('token',$token)->first();
        if(empty($user_email->email))
        {
            return redirect()->route('member.login');
        }
        return view('frontend.auth.forgetPasswordLink', ['token' => $token,'user_email' => $user_email->email]);
    }
    /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
        $request->validate([
        'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
        'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/' , 'confirmed'],
        ],[
            'required'=> 'This field is required',
            'email.email'=> 'Invalid email format',
            'email.exists'=> 'This email address is not registered',
            'password.regex' => 'Invalid password format',
            'password.min' => 'Password must be at least 8 characters long',
            'password.confirmed' => 'Password does not match'
        ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();

          $user_details = User::where('email',$request->email)->first();

        if($user_details->is_organization == 0)
        {
            return redirect()->route('member.login')->with('message', 'Your password has been changed!');
        }
        elseif($user_details->is_organization == 1 || $user_details->is_organization == 2)
        {
            return redirect()->route('organization.login')->with('message', 'Your password has been changed!');
        }
  
          
      }

      // Start organization authentication
    public function organization_register()
    {
        return view('frontend.auth.organization.organization_register');
    }
    public function organization_register_post(Request $request)
    {
        $request->validate([
            //'organization_type' => ['required'], 
            //'main_institute_name' => 'required_if:organization_type,1',
            //'employee_institute_name' => 'required_if:organization_type,2',
            //'institute_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/' , 'confirmed'],
            'captcha' => 'required|captcha'
        ],
        [
            'required'=> 'This field is required',
            'main_institute_name.required_if'=> 'This field is required',
            'employee_institute_name.required_if'=> 'This field is required',
            'email.unique'=> 'This email address is already registered',
            'email.email'=> 'Invalid email format',
            'password.regex' => 'Invalid password format',
            'password.min' => 'Password must be at least 8 characters long',
            'password.confirmed' => 'Password does not match',
            'captcha.captcha' => 'Invalid captcha'
        ]);
        
        // if($request->organization_type == 1)
        // {
        //     $user = User::create([
        //         'is_organization' => 1,
        //         'institute_name' => $request->main_institute_name,
        //         'email' => strtolower($request->email),
        //         'password' => Hash::make($request->password),
        //         'email_verification_token' => Str::random(32),
        //         'unique_member_id' => $this->generateUniqueNumber(),
        //         'role_id' => 6,
        //         'user_registered_ip_address' => $request->ip(),
        //     ]);
        // }
        // elseif($request->organization_type == 2)
        // {
        //     $institute_id = Crypt::decrypt($request->institute_id);
        //     $user = User::create([
        //         'is_organization' => 2,
        //         'related_main_organisation_id' => $institute_id,
        //         'institute_name' => $request->employee_institute_name,
        //         'email' => strtolower($request->email),
        //         'password' => Hash::make($request->password),
        //         'email_verification_token' => Str::random(32),
        //         'unique_member_id' => $this->generateUniqueNumber(),
        //         'role_id' => 6,
        //         'user_registered_ip_address' => $request->ip(),
        //     ]);
        // }

        $user = User::create([
            'is_organization' => 1,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'email_verification_token' => Str::random(32),
            'unique_member_id' => $this->generateUniqueNumber(),
            'role_id' => 6,
            'user_registered_ip_address' => $request->ip(),
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
        Mail::to($user->email)->send(new userVerificationEmail($user));
        $admin_email = config('constants.emails.admin_email');
        Mail::to($admin_email)->send(new registeredUserNotificationToAdmin($user,'signup'));
        return redirect()->route('organization.login')->with('message','You need to confirm your account. We have sent you an activation link, please check your email.');
       
    }    
    public function organization_name_search(Request $request)
    {
        $query = $request->get('search');
        if(!empty($query))
        {
        $data = User::where('institute_name', 'LIKE', "%$query%")
                                  ->where('is_organization', 1)
                                  ->where('related_main_organisation_id','=', null)
                                  ->select('institute_name','id')
                                  ->get();

        }
        else
        {
            $data = [];
        }
        $output='';
        if(count($data)>0){
            $output ='
                <table class="employee_institute_name_list_table table">
                <thead>';
                    foreach($data as $row){
                        $output .='
                        <tr>
                        <th id="'.$row->id.'" data-id="' . Crypt::encrypt($row->id) . '">'.$row->institute_name.'</th>
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
    public function organization_login()
    {
        return view('frontend.auth.organization.organization_login');
    } 
    public function organization_login_post(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ],[
            'required'=> 'This field is required',
            'captcha.captcha' => 'Invalid captcha'
        ]);
   
        $credentials = $request->only('email', 'password');
        $user_details = User::select('email_verified_at','role_id','status','is_organization')->where('email',$request->email)->first();
        if(empty($user_details->email_verified_at))
        {
            return redirect()->back()->with('error','Invalid credentials');
        }
        elseif($user_details->role_id == '1')
        {
            // Admin cannot login from here.
            return redirect()->back()->with('error','Invalid credentials');
        } 
        elseif($user_details->status == 0)
        {
            // User can login from here, if status is 1.
            return redirect()->back()->with('error','Invalid credentials');
        } 
        elseif($user_details->status == 2)
        {
            // User can login from here, if status is 1.
            return redirect()->back()->with('error','This email is blocked. Please contact administrator');
        } 
        // elseif($user_details->is_organization == 0)
        // {
        //     // Only organization can login from here.
        //     return redirect()->back()->with('error','Invalid credentials');
        // }        
        elseif(Auth::attempt($credentials))
        {
            $role_id = Auth::user()->role_id;
            switch_role_session($role_id); // in App/Helper.php
            return redirect()->route('welcome');
        }
        return redirect()->back()->with('error','Invalid credentials');
    } 
      // End organization authentication

    public function generateUniqueNumber() {
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
    public function generateUniqueNumberwallet_id() {
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
    
    public function statictics_login()
    {
        return view('frontend.auth.statictics.statictics_login');
    } 
    public function statictics_login_post(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ],[
            'required'=> 'This field is required',
            'captcha.captcha' => 'Invalid captcha'
        ]);
   
        $credentials = $request->only('email', 'password');
        $user_details = User::select('email_verified_at','role_id','status','is_organization')->where('email',$request->email)->first();
        if(empty($user_details->email_verified_at))
        {
            return redirect()->back()->with('error','Invalid credentials');
        }
        elseif($user_details->role_id == '1')
        {
            // Admin cannot login from here.
            return redirect()->back()->with('error','Invalid credentials');
        } 
        elseif($user_details->status == 0)
        {
            // User can login from here, if status is 1.
            return redirect()->back()->with('error','Invalid credentials');
        } 
        elseif($user_details->status == 2)
        {
            // User can login from here, if status is 1.
            return redirect()->back()->with('error','This email is blocked. Please contact administrator');
        }  
        // elseif($user_details->is_organization == 1)
        // {
        //     // Only normal member can login from here.
        //     return redirect()->back()->with('error','Invalid credentials');
        // }       
        elseif(Auth::attempt($credentials))
        {
            $role_id = Auth::user()->role_id;
            switch_role_session($role_id); // in App/Helper.php
            return redirect()->route('statictics.report');
        }
        return redirect()->back()->with('error','Invalid credentials');
    }
}
