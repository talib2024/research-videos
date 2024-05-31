<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institutionrequest;
use App\Models\Transcation;
use App\Models\User;

class InstitutionManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','adminRole']);
    }
    public function all_institution_request()
    {
        $institutionrequest = Institutionrequest::all();
        return view('backend.institute.all_institution_request',compact('institutionrequest'));
    }
    public function all_institution_request_view($id)
    {
        $institutionrequest = Institutionrequest::find($id);
        return view('backend.institute.all_institution_request_details',compact('institutionrequest'));
    }
    public function control_institution()
    {
        $institutionpaymentdetails = Transcation::where('transaction_type','assign_to_institute_by_admin')->get();
        return view('backend.institute.control_institution',compact('institutionpaymentdetails'));
    }
    public function control_institution_store(Request $request)
    {
        $validatedData = $request->validate([
            'email_type' => 'required',  
            'subscription_start_date' => 'required',  
            'subscription_end_date' => 'required',  
            'is_active' => 'required',  
        ], [        
            'required' => 'This field is required',  
        ]);
        $transaction_save = new Transcation();
        $transaction_save->amount = '0.00';
        $transaction_save->subscription_start_date = $request->subscription_start_date;
        $transaction_save->subscription_end_date = $request->subscription_end_date;
        $transaction_save->transaction_type = 'assign_to_institute_by_admin';
        $transaction_save->is_payment_done = 1;
        $transaction_save->email_type = $request->email_type;
        $transaction_save->is_active = $request->is_active;
        $transaction_save->save();
        session()->flash('success','Added successfully.');
        return redirect()->back();
    }
    public function control_institution_edit($id)
    {
        $transactiondetails = Transcation::find($id);
        return view('backend.institute.control_institution_edit',compact('transactiondetails'));
    }
    public function control_institution_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email_type' => 'required',  
            'subscription_start_date' => 'required',  
            'subscription_end_date' => 'required',  
            'is_active' => 'required',  
        ], [        
            'required' => 'This field is required',  
        ]);
        $transaction_save = Transcation::find($id);
        $transaction_save->amount = '0.00';
        $transaction_save->subscription_start_date = $request->subscription_start_date;
        $transaction_save->subscription_end_date = $request->subscription_end_date;
        $transaction_save->transaction_type = 'assign_to_institute_by_admin';
        $transaction_save->is_payment_done = 1;
        $transaction_save->email_type = $request->email_type;
        $transaction_save->is_active = $request->is_active;
        $transaction_save->save();
        session()->flash('success','Updated successfully.');
        return redirect()->route('control.institution');
    }
    public function users_institution()
    {
        $user_details = User::where('role_id','!=',1)->where('is_organization','=',1)->orderBy('created_at','desc')->get();
        return view('backend.institute.userlist', compact('user_details'));
    }
    public function all_institution_request_delete($id)
    {
        $institutionrequest = Institutionrequest::findOrFail($id); // Use findOrFail to throw 404 if record not found
        $institutionrequest->delete(); // Delete the record
        session()->flash('success','Deleted successfully.');
        return redirect()->back();
    }
    
}
