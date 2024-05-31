<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Mail\transactionByAdminEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Subscriptionplan;
use App\Models\User;
use App\Models\Transcation;
use App\Models\Transactionsbyadmin;

class TransactionByAdminController extends Controller
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
        $subscriptionplan = Subscriptionplan::where('status',1)->orderBy('plan_name','ASC')->get();
        $users = User::where('role_id','!=',1)->where('status',1)->orderBy('email','ASC')->get();
        $assign_transcation = DB::table('transcations')
                                ->select('transcations.*','users.email as user_email','subscriptionplans.plan_name')
                                ->leftJoin('users','users.id','=','transcations.user_id')
                                ->leftJoin('subscriptionplans','subscriptionplans.id','=','transcations.item_id')
                                ->where('transaction_type','=','assign_by_admin')
                                ->get();
        return view('backend.transactionsbyadmin.create_transactionsbyadmin',compact('subscriptionplan','users','assign_transcation'));
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
            'user_id' => 'required',
            'subscription_plan_id' => 'required',
        ], [        
            'required' => 'This field is required',
        ]);  
        $user_id = $request->user_id;
        $item_id = $request->subscription_plan_id;
        $subscription_details = get_subscription_plan($item_id);

        $save_transaction = new Transcation();
        $save_transaction->user_id = $user_id;
        $save_transaction->item_type = 'subscription';
        $save_transaction->item_id = $item_id;
        $save_transaction->amount = $subscription_details->amount;
        $save_transaction->subscription_start_date = Carbon::now();
        $save_transaction->subscription_end_date = Carbon::now()->addDay($subscription_details->duration);
        $save_transaction->transaction_type = 'assign_by_admin';
        $save_transaction->is_payment_done = 1;
        $save_transaction->ip_address = $request->getClientIp();
        $save_transaction->save();

        $save_transaction_admins = new Transactionsbyadmin();
        $save_transaction_admins->transaction_table_id = $save_transaction->id;
        $save_transaction_admins->user_id = $user_id;
        $save_transaction_admins->item_type = 'subscription';
        $save_transaction_admins->item_id = $item_id;
        $save_transaction_admins->amount = $subscription_details->amount;
        $save_transaction_admins->subscription_start_date = Carbon::now();
        $save_transaction_admins->subscription_end_date = Carbon::now()->addDay($subscription_details->duration);
        $save_transaction_admins->transaction_type = 'assign_by_admin';
        $save_transaction_admins->is_payment_done = 1;
        $save_transaction_admins->ip_address = $request->getClientIp();
        $save_transaction_admins->save();
        
        $user_details = get_user_details($user_id);
        $finance_email = config('constants.emails.finance_email');
        Mail::to($finance_email)->send(new transactionByAdminEmail('foradmin',$user_details,$save_transaction,$item_id));
        Mail::to($user_details->email)->send(new transactionByAdminEmail('foruser',$user_details,$save_transaction,$item_id));
        session()->flash('success','Assigned successfully.');
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
        Transcation::destroy($id);
        session()->flash('success','Deleted successfully.');
        return redirect()->back();
    }
}
