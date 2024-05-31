<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\sendMessageToSubscribedNewsLetterUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Models\Newslettersubscription;

class NewsletterController extends Controller
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
        $newsletter_user = Newslettersubscription::all();
        return view('backend.newsletter.index', compact('newsletter_user'));
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
        $validatedData = $request->validate([
            'subject' => 'required',  
            'email' => 'required',  
            'message' => 'required',
        ], 
        [        
            'required' => 'This field is required',
        ]); 

        foreach($request->email as $email)
        {
            $encrypted_email = Crypt::encrypt($email);
            Mail::to($email)->send(new sendMessageToSubscribedNewsLetterUsers($email,$encrypted_email,$request->subject,$request->message));
        }
        $request->session()->flash('success', 'Sent successfully.');
        return response()->json(['success' => 'Sent Successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
