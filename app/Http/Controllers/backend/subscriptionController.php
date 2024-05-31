<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriptionplan;

class subscriptionController extends Controller
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
        $subscriptionplan = Subscriptionplan::get();
        return view('backend.subscription.create_subscription',compact('subscriptionplan'));
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
            'plan_name' => 'required',
            'paypal_plan_id' => 'required',
            'duration' => 'required',
            'amount' => 'required',
            'rv_coins_price' => 'required',
            'status' => 'required',
        ], [        
            'required' => 'This field is required',
        ]);  

        $subscriptionplan = new Subscriptionplan();
        $subscriptionplan->plan_name = $request->plan_name;
        $subscriptionplan->paypal_plan_id = $request->paypal_plan_id;
        $subscriptionplan->duration = $request->duration;
        $subscriptionplan->amount = $request->amount;
        $subscriptionplan->rv_coins_price = $request->rv_coins_price;
        $subscriptionplan->status = $request->status;
        $subscriptionplan->description = $request->description;
        $subscriptionplan->save();
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
        $subscriptionplan_detail = Subscriptionplan::find($id);
        return view('backend.subscription.update_subscription',compact('subscriptionplan_detail'));
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
            'plan_name' => 'required',
            'paypal_plan_id' => 'required',
            'duration' => 'required',
            'amount' => 'required',
            'rv_coins_price' => 'required',
            'status' => 'required',
        ], [        
            'required' => 'This field is required',
        ]);  

        $subscriptionplan = Subscriptionplan::find($id);
        $subscriptionplan->plan_name = $request->plan_name;
        $subscriptionplan->paypal_plan_id = $request->paypal_plan_id;
        $subscriptionplan->duration = $request->duration;
        $subscriptionplan->amount = $request->amount;
        $subscriptionplan->rv_coins_price = $request->rv_coins_price;
        $subscriptionplan->status = $request->status;
        $subscriptionplan->description = $request->description;
        $subscriptionplan->save();
        session()->flash('success','Updated successfully.');
        return redirect()->back();
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
