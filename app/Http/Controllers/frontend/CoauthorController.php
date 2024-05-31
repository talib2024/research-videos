<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\Coauthor;

class CoauthorController extends Controller
{  
    public function __construct()
    {  
        $this->middleware(['auth','userRole','checkUserStatus']); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country_list = Country::all();
        return view('frontend.coauthors.index',compact('country_list'));
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
            'name' => 'required',  
            'email' => 'email|required',  
            'country_id' => 'required',  
            'city' => 'required',  
            'zip_code' => 'required',  
            'role' => 'required',
            'address' => 'required'
        ], [        
            'required' => 'This field is required',
        ]);  
        $coauthor_details = new Coauthor();
        $coauthor_details->user_id = Auth::user()->id;
        $coauthor_details->name = $request->name;
        $coauthor_details->surname = $request->surname;
        $coauthor_details->email = $request->email;
        $coauthor_details->phone = $request->phone;
        $coauthor_details->institute_name = $request->institute_name;
        $coauthor_details->role = $request->role;
        $coauthor_details->country_id = $request->country_id;
        $coauthor_details->city = $request->city;
        $coauthor_details->zip_code = $request->zip_code;
        $coauthor_details->address = $request->address;
        $coauthor_details->save();
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
