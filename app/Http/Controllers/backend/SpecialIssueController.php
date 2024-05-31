<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Specialissue;

class SpecialIssueController extends Controller
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
        $specialissue = Specialissue::all();
        $editor_board_list = DB::table('userprofiles')
                                ->leftJoin('users', 'users.id', '=', 'userprofiles.user_id')
                                ->select(
                                    'users.id',
                                    'users.name',
                                    'users.last_name',
                                    'users.email'
                                )
                                ->where('userprofiles.editorrole_id', '=', 2)
                                ->get();
        return view('backend.specialissue.index',compact('specialissue','editor_board_list'));
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
            'issue_title' => 'required',
            'issue_discipline' => 'required',
            'user_id' => 'required'
        ], [        
            'required' => 'This field is required',
        ]);  
        $user_ids = json_encode($request->user_id);
        $specialissue = new Specialissue();
        $specialissue->issue_title = $request->issue_title;
        $specialissue->issue_discipline = $request->issue_discipline;
        $specialissue->user_id = $user_ids;
        $specialissue->issue_description = $request->issue_description;
        $specialissue->save();
        session()->flash('success','Created successfully.');
        return redirect()->back();
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
        $specialissue = Specialissue::find($id);
        $specialissue->user_id = json_decode($specialissue->user_id, true);
        $editor_board_list = DB::table('userprofiles')
                                ->leftJoin('users', 'users.id', '=', 'userprofiles.user_id')
                                ->select(
                                    'users.id',
                                    'users.name',
                                    'users.last_name',
                                    'users.email'
                                )
                                ->where('userprofiles.editorrole_id', '=', 2)
                                ->get();
        return view('backend.specialissue.edit',compact('specialissue','editor_board_list'));
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
            'issue_title' => 'required',
            'issue_discipline' => 'required',
            'user_id' => 'required'
        ], [        
            'required' => 'This field is required',
        ]);  
        $user_ids = json_encode($request->user_id);
        $specialissue = Specialissue::find($id);
        $specialissue->issue_title = $request->issue_title;
        $specialissue->issue_discipline = $request->issue_discipline;
        $specialissue->user_id = $user_ids;
        $specialissue->issue_description = $request->issue_description;
        $specialissue->save();
        session()->flash('success','updated successfully.');
        return redirect()->route('specialissueadmin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Specialissue::destroy($id);
        session()->flash('success','Deleted successfully.');
        return redirect()->route('specialissueadmin.index');
    }
}
