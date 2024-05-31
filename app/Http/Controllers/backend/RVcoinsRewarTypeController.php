<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rvcoinsrewardtype;

class RVcoinsRewarTypeController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rvcoinsrewardtype = Rvcoinsrewardtype::get();
        return view('backend.rvcoins.create_rvcoins',compact('rvcoinsrewardtype'));
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
            'reward_type' => 'required'
        ], [        
            'required' => 'This field is required',
        ]);  
        $reward_type = new Rvcoinsrewardtype();
        $reward_type->reward_type = $request->reward_type;
        $reward_type->save();
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
        $rvcoinsrewardtype = Rvcoinsrewardtype::find($id);
        return view('backend.rvcoins.update_rvcoins',compact('rvcoinsrewardtype'));
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
            'reward_type' => 'required'
        ], [        
            'required' => 'This field is required',
        ]);  
        $reward_type = Rvcoinsrewardtype::find($id);
        $reward_type->reward_type = $request->reward_type;
        $reward_type->save();
        session()->flash('success','Updated successfully.');
        return redirect()->route('rvcoinsrewartype.create');
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
