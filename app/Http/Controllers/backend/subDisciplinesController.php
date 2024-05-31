<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Majorcategory;
use App\Models\Subcategory;

class subDisciplinesController extends Controller
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
        $major_category = Majorcategory::where('status',1)->get();  
        $categories = DB::table('majorcategories')
                            ->select('majorcategories.id as majorcategory_id','majorcategories.category_name','subcategories.*')
                            ->rightJoin('subcategories','subcategories.majorcategory_id','=','majorcategories.id')
                            ->get();
        return view('backend.disciplines.create_sub_disciplines',compact('major_category','categories'));
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
            'majorcategory_id' => 'required',
            'subcategory_id' => 'required',
            'sub_discipline_description' => 'required',
        ], [        
            'required' => 'This field is required',
        ]);  
        $categories = new Subcategory();
        $categories->majorcategory_id = $request->majorcategory_id;
        $categories->subcategory_name = $request->subcategory_id;
        $categories->description = $request->sub_discipline_description;
        $categories->save();
        session()->flash('success','Created successfully.');
        return response()->json(['success'=>'Successfully','message'=>'Updated Successfully!']);
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
        $record_check = DB::table('videouploads')
            ->whereRaw('JSON_CONTAINS(subcategory_id, \'["' . $id . '"]\')')
            ->first();
        $check_for_delete = $record_check ? 'no' : 'yes';
        $major_category = Majorcategory::where('status',1)->get(); 
        $sub_category = Subcategory::where('id',$id)->first(); 
        return view('backend.disciplines.update_sub_disciplines',compact('major_category','sub_category','check_for_delete'));
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
            'majorcategory_id' => 'required',
            'subcategory_id' => 'required',
            'sub_discipline_description' => 'required',
        ], [        
            'required' => 'This field is required',
        ]);  
        $categories = Subcategory::find($id);
        $categories->majorcategory_id = $request->majorcategory_id;
        $categories->subcategory_name = $request->subcategory_id;
        $categories->description = $request->sub_discipline_description;
        $categories->save();
        session()->flash('success','Updated successfully.');
        return response()->json(['success'=>'Successfully','message'=>'Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subcategory::destroy($id);
        session()->flash('success','Deleted successfully.');
        return redirect()->route('scientificsubdisciplines.create');
    }
}
