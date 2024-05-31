<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Transcation;

class PaymentController extends Controller
{ 
    public function __construct()
    {
        $this->middleware(['auth','adminRole']);
    }
    public function index()
    {
        $payment_details = DB::table('transcations')
                                ->leftJoin('users','users.id','=','transcations.user_id')
                                ->select('transcations.*','users.name as users_name','users.last_name as users_lastname','users.email as users_email')
                                ->get();
        return view('backend.payment.index',compact('payment_details'));
    }
    public function check_payment_details($payment_id)
    {
        $payment_details = DB::table('transcations')
                                ->leftJoin('users','users.id','=','transcations.user_id')
                                ->select('transcations.*','users.name as users_name','users.last_name as users_lastname','users.email as users_email')
                                ->where('transcations.id',$payment_id)
                                ->first();
        return view('backend.payment.view',compact('payment_details'));
    }
    public function update_payment(Request $request)
    {
        $save_transaction = Transcation::find($request->payment_id);
        $save_transaction->is_payment_done = 1;
        $save_transaction->save();
        $request->session()->flash('success', 'Updated successfully.');
        return redirect()->back();
    }
}
