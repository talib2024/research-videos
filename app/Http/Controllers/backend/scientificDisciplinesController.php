<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Http\Request;
use App\Models\Majorcategory;

class scientificDisciplinesController extends Controller
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
        $majorCategory = Majorcategory::get();
        return view('backend.disciplines.create_scientific_disciplines',compact('majorCategory'));
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
            'category_name' => 'required',
            'short_name' => 'required',
            'scientific_disciplines_image' => 'required|mimes:webm,gif,svg|max:300',
        ], [        
            'required' => 'This field is required',
        ]);  
        $last_sequence_count = Majorcategory::select(DB::raw('MAX(sequence) AS sequence'))->first();
        $incremented_sequence = $last_sequence_count->sequence;
        $incremented_sequence = (int) $incremented_sequence + 1;
        $major_category = new Majorcategory();
        $major_category->category_name = $request->category_name;
        $major_category->short_name = $request->short_name;
        $major_category->sequence = $incremented_sequence;
        if($request->hasFile('scientific_disciplines_image'))
        {
            $scientific_disciplines_image_image = $request->file('scientific_disciplines_image');
            $fileName_scientific_disciplines_image_image = time().'_'.$scientific_disciplines_image_image->getClientOriginalName();
            $scientific_disciplines_image_image->move(public_path('frontend/img/gif_images/'), $fileName_scientific_disciplines_image_image);
            $major_category->category_image = $fileName_scientific_disciplines_image_image;            
        }
        $major_category->save();
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
        $record_check = DB::table('subcategories')->select('id')->where('majorcategory_id',$id)->first();
        $check_for_delete = $record_check ? 'no' : 'yes';
        $majorCategory = Majorcategory::find($id);
        return view('backend.disciplines.update_scientific_disciplines',compact('majorCategory','check_for_delete'));
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
            'category_name' => 'required',
            'short_name' => 'required',
            'scientific_disciplines_image' => 'sometimes|nullable|mimes:webm,gif,svg|max:300',
        ], [        
            'required' => 'This field is required',
        ]);  
        $major_category = Majorcategory::find($id);
        $major_category->category_name = $request->category_name;
        $major_category->short_name = $request->short_name;
        if($request->hasFile('scientific_disciplines_image'))
        {
            // first delete the file
            File::delete(public_path('frontend/img/gif_images/'.$major_category->category_image));
            // end delete the file
            $scientific_disciplines_image_image = $request->file('scientific_disciplines_image');
            $fileName_scientific_disciplines_image_image = time().'_'.$scientific_disciplines_image_image->getClientOriginalName();
            $scientific_disciplines_image_image->move(public_path('frontend/img/gif_images/'), $fileName_scientific_disciplines_image_image);
            $major_category->category_image = $fileName_scientific_disciplines_image_image;            
        }
        $major_category->save();
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
        $data = Majorcategory::find($id);
        File::delete(public_path('frontend/img/gif_images/'.$data->category_image));
        Majorcategory::destroy($id);
        session()->flash('success','Deleted successfully.');
        return redirect()->route('scientificdisciplines.create');
    }
}
