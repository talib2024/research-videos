<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Sortingoptionforpublishedvideo;
use App\Models\Paginationoptionforpublishedvideo;
use App\Models\Sorteditorspage;

class CommonController extends Controller
{
    public function video_sort_by_admin_show()
    {
        $sorting_options = Sortingoptionforpublishedvideo::all();
        return view('backend.others.video_sort_by_admin_show',compact('sorting_options'));
    }
    public function video_sort_by_admin_update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'sorting_option' => 'required',
        ],
        [
            'required' => 'Please select atleast single option.'
        ]);

        $selectedSortingOptionId = $request->input('sorting_option');
        Sortingoptionforpublishedvideo::where('id', '<>', $selectedSortingOptionId)->update(['status' => 0]);
        $sortingOption = Sortingoptionforpublishedvideo::find($selectedSortingOptionId);
        if ($sortingOption) {
            $sortingOption->status = 1;
            $sortingOption->save();
            return redirect()->back()->with('success', 'Sorting option updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Invalid sorting option selected.');
        }
    }
    public function video_pagination_by_admin_show()
    {
        $pagination_options = Paginationoptionforpublishedvideo::first();
        return view('backend.others.video_pagination_by_admin_show',compact('pagination_options'));
    }
    public function video_pagination_by_admin_update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required',
            'pagination_options' => 'required|numeric|min:1',
        ],
        [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute must be a number.',
            'min' => 'The :attribute must be at least :min.',
        ]);

        $pagination_id = $request->input('id');
        $pagination_options = $request->input('pagination_options');
        
        $paginationOption = Paginationoptionforpublishedvideo::find($pagination_id);
        if ($paginationOption) {
            $paginationOption->video_items_per_page = $pagination_options;
            $paginationOption->save();
            return redirect()->back()->with('success', 'updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
    public function sort_editors_page()
    {
        $sorting_editors_options = Sorteditorspage::first();
        return view('backend.others.sort_editors_page',compact('sorting_editors_options'));
    }
    public function sort_editors_page_update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required',
            'sorting_option' => 'required',
            'order_by' => 'required',
            'editorial_member_per_page' => 'required|numeric|min:1',
        ],
        [
            'required' => 'The :attribute field is required.',
            'min' => 'Must be at least :min.',
        ]);
        
        $data = Sorteditorspage::find($request->id);
        if ($data) {
            $data->sorting_option = $request->sorting_option;
            $data->order_by = $request->order_by;
            $data->editorial_member_per_page = $request->editorial_member_per_page;
            $data->save();
            return redirect()->back()->with('success', 'updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
