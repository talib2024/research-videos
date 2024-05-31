<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Mail\sendMailAfterWireTransfer;
use App\Mail\sendMailAfterWireTransferToAdmin;
use App\Mail\sendMailAfterWireTransferSubscription;
use App\Mail\sendMailAfterWireTransferSubscriptionToAdmin;
use App\Mail\sendMailAfterPaypalSubscriptionToBuyer;
use App\Mail\sendMailAfterPaypalSubscriptionToAdmin;
use App\Mail\sendMailAfterPaypalVideoPurchaseToBuyer;
use App\Mail\sendMailAfterPaypalVideoPurchaseToAdmin;
use App\Mail\sendMailAfterRVcoinsPurchaseForVideos;
use App\Mail\sendMailAfterRVcoinsPurchaseForSubscription;
use Illuminate\Support\Facades\Mail;
use App\Models\Transcation;
use App\Models\Userprofile;

class PaymentController extends Controller
{  
    public function __construct()
    {   
        $this->middleware(['auth','userRole','checkUserStatus']); 
    }
    public function handlePaypalPayment(Request $request)
    {
        $video_id = Crypt::decrypt($request->paypal_video_id);
        $video_price = get_video_price($video_id);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.paypal.payment',$request->paypal_video_id),
                "cancel_url" => route('cancel.paypal.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $video_price->video_price
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return view('frontend.payment.error_payment');
        } else {
            
            return view('frontend.payment.error_payment');
        }
    }
    public function handleCreditCardPayment(Request $request)
    {
        // Your logic for handling debit/credit card payments goes here
        // Make sure to set up the necessary data and call the PayPalClient methods accordingly

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        $response = $provider->createOrder([
            // Add necessary data for debit/credit card payments
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
        }

        return view('frontend.payment.error_payment');
    }

    public function paymentPaypalCancel(Request $request)
    {         
        return view('frontend.payment.error_payment');
    }
    public function paymentPaypalSuccess(Request $request, $encrypted_video_id)
    {
        $video_id = Crypt::decrypt($encrypted_video_id);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        $transaction_id = '';
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            if(isset($video_id) && !empty($video_id))
            {
                $transaction_id = $response['purchase_units'][0]['payments']['captures'][0]['id'];
                $save_transaction = new Transcation();
                $save_transaction->user_id = Auth::user()->id;
                $save_transaction->item_type = 'video';
                $save_transaction->item_id = $video_id;
                $save_transaction->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
                $save_transaction->transaction_id = $transaction_id;
                $save_transaction->transaction_type = 'paypal';
                $save_transaction->is_payment_done = 1;
                $save_transaction->save();
            }
            // $message = 'Your transaction is completed successfully!';
            // return view('frontend.payment.success_payment',compact('message','transaction_id'));
            $request->session()->flash('success', 'Your transaction is completed successfully.');
            $request->session()->flash('transaction_id', $transaction_id);
            return redirect()->route('success.page');
        } else {
            return view('frontend.payment.error_payment');
        }
    }
    public function update_wiretransfer_payment(Request $request)
    { 
        $validatedData = $request->validate([
            'paypal_video_id' => 'required',  
            //'transaction_id' => 'required',  
            'transaction_receipt' => 'sometimes|nullable|mimes:png,jpeg,JPEG,pdf|max:5120',  
            'captcha' => 'required|captcha'
        ], [        
            'required' => 'This field is required',  
            'captcha.captcha' => 'Invalid captcha'  
        ]);
        $video_id = Crypt::decrypt($request->paypal_video_id);
        $video_price = get_video_price($video_id);
        if(isset($video_id) && !empty($video_id))
        {
            $save_transaction = new Transcation();
            $save_transaction->user_id = Auth::user()->id;
            $save_transaction->item_type = 'video';
            $save_transaction->item_id = $video_id;
            $save_transaction->amount = $video_price->video_price;
            //$save_transaction->transaction_id = $request->transaction_id;
            $save_transaction->transaction_type = 'wire_transfer';
            if($request->hasFile('transaction_receipt')){
                $transaction_receipt_image = $request->file('transaction_receipt');
                $fileName_transaction_receipt_image = time().'_'.$transaction_receipt_image->getClientOriginalName();
                $filePath = $transaction_receipt_image->storeAs('uploads/wire_transfer_receipt', $fileName_transaction_receipt_image, 'public');
                $save_transaction->transaction_receipt = $fileName_transaction_receipt_image;
            }
            $save_transaction->save();
            $finance_email = config('constants.emails.finance_email');
            Mail::to(Auth::user()->email)->send(new sendMailAfterWireTransfer($fileName_transaction_receipt_image,$video_id)); // to the buyer
            Mail::to($finance_email)->send(new sendMailAfterWireTransferToAdmin($fileName_transaction_receipt_image,$video_id)); // to the admin
                
            $request->session()->flash('wiretransfer_success', 'Updated successfully.');
            return response()->json(['success'=>'Successfully','message'=>'Updated Successfully!']);
        }
    }
    public function update_wiretransfer_payment_subscription(Request $request)
    { 
        $validatedData = $request->validate([
            'subscription_plan_id' => 'required', 
            'transaction_receipt' => 'sometimes|nullable|mimes:png,jpeg,JPEG,pdf|max:5120',  
            'captcha' => 'required|captcha'
        ], [        
            'required' => 'This field is required',  
            'captcha.captcha' => 'Invalid captcha'  
        ]);
        $subscription_plan_id = Crypt::decrypt($request->subscription_plan_id);
        $subscription_details = get_subscription_plan($subscription_plan_id);
        if(isset($subscription_plan_id) && !empty($subscription_plan_id))
        {
            $save_transaction = new Transcation();
            $save_transaction->user_id = Auth::user()->id;
            $save_transaction->item_type = 'subscription';
            $save_transaction->item_id = $subscription_plan_id;
            $save_transaction->amount = $subscription_details->amount;
            $save_transaction->transaction_type = 'wire_transfer';
            $save_transaction->subscription_start_date = Carbon::now();
            $save_transaction->subscription_end_date = Carbon::now()->addDay($subscription_details->duration);
            if($request->hasFile('transaction_receipt')){
                $transaction_receipt_image = $request->file('transaction_receipt');
                $fileName_transaction_receipt_image = time().'_'.$transaction_receipt_image->getClientOriginalName();
                $filePath = $transaction_receipt_image->storeAs('uploads/wire_transfer_receipt', $fileName_transaction_receipt_image, 'public');
                $save_transaction->transaction_receipt = $fileName_transaction_receipt_image;
            }
            $save_transaction->save();
            $finance_email = config('constants.emails.finance_email');
            Mail::to(Auth::user()->email)->send(new sendMailAfterWireTransferSubscription($fileName_transaction_receipt_image,$subscription_details->plan_name,$subscription_details->amount)); // to the buyer
            Mail::to($finance_email)->send(new sendMailAfterWireTransferSubscriptionToAdmin($fileName_transaction_receipt_image,$subscription_details->plan_name,$subscription_details->amount)); // to the admin
                
            $request->session()->flash('wiretransfer_success', 'Updated successfully.');
            return response()->json(['success'=>'Successfully','message'=>'Updated Successfully!']);
        }
    }
    public function update_paypal_subscription(Request $request)
    {
        $subscriptionData = $request->all();
        $transaction_id = $subscriptionData['transaction_id'];
        $item_id = $subscriptionData['plan_record_id'];
        $subscription_details = get_subscription_plan($item_id);

        $save_transaction = new Transcation();
        $save_transaction->user_id = Auth::user()->id;
        $save_transaction->item_type = 'subscription';
        $save_transaction->item_id = $item_id;
        $save_transaction->amount = $subscription_details->amount;
        $save_transaction->transaction_id = $transaction_id;
        $save_transaction->subscription_start_date = Carbon::now();
        $save_transaction->subscription_end_date = Carbon::now()->addDay($subscription_details->duration);
        $save_transaction->transaction_type = 'paypal';
        $save_transaction->is_payment_done = 1;
        $save_transaction->ip_address = $request->getClientIp();
        $save_transaction->save();
        
        $finance_email = config('constants.emails.finance_email');
        Mail::to(Auth::user()->email)->send(new sendMailAfterPaypalSubscriptionToBuyer($save_transaction,$item_id)); // to the buyer
        Mail::to($finance_email)->send(new sendMailAfterPaypalSubscriptionToAdmin($save_transaction,$item_id)); // to the admin
            
        $request->session()->flash('success', 'Your transaction is completed successfully.');
        $request->session()->flash('transaction_id', $transaction_id);
        return response()->json(['success'=>'Successfully','redirect' => route('success.page')]);
    }
    public function update_paypal_payment_for_single_video(Request $request)
    {
        $video_id = Crypt::decrypt($request->video_id);        
        $transaction_id = $request->transaction_id;
        $video_amount = $request->video_amount;

        $save_transaction = new Transcation();
        $save_transaction->user_id = Auth::user()->id;
        $save_transaction->item_type = 'video';
        $save_transaction->item_id = $video_id;
        $save_transaction->amount = $video_amount;
        $save_transaction->transaction_id = $transaction_id;
        $save_transaction->transaction_type = 'paypal';
        $save_transaction->is_payment_done = 1;
        $save_transaction->ip_address = $request->getClientIp();
        $save_transaction->save();
    
        $finance_email = config('constants.emails.finance_email');
        Mail::to(Auth::user()->email)->send(new sendMailAfterPaypalVideoPurchaseToBuyer($save_transaction,$video_id)); // to the buyer
        Mail::to($finance_email)->send(new sendMailAfterPaypalVideoPurchaseToAdmin($save_transaction,$video_id)); // to the admin
        
        $request->session()->flash('success', 'Your transaction is completed successfully.');
        $request->session()->flash('transaction_id', $transaction_id);
        return response()->json(['success'=>'Successfully','redirect' => route('success.page')]);
       
    }
    public function update_rvcoins_payment(Request $request)
    { 
        $validatedData = $request->validate([
            'paypal_video_id' => 'required', 
            'captcha' => 'required|captcha'
        ], [        
            'required' => 'This field is required',  
            'captcha.captcha' => 'Invalid captcha'  
        ]);
        $video_id = Crypt::decrypt($request->paypal_video_id);
        $video_price = get_video_price($video_id);
        $get_user_details = get_user_details(Auth::user()->id);
        if($get_user_details->total_rv_coins < $video_price->rv_coins_price)
        {
            return response()->json(['success'=>'fail','message'=>'Yoy dont have enough RVcoins!']);
            exit;
        }
        if(isset($video_id) && !empty($video_id))
        {
            $save_transaction = new Transcation();
            $save_transaction->user_id = Auth::user()->id;
            $save_transaction->item_type = 'video';
            $save_transaction->item_id = $video_id;
            $save_transaction->amount = $video_price->rv_coins_price;
            $save_transaction->transaction_type = 'rv_coins';
            $save_transaction->is_payment_done = 1;
            $save_transaction->ip_address = $request->getClientIp();
            $save_transaction->save();

            //Start Update remaing RVcoins of user
            // Cast the values to integers before subtraction
            $totalRvCoins = (int)$get_user_details->total_rv_coins;
            $videoCoinsPrice = (int)$video_price->rv_coins_price;
            // Perform subtraction
            $updated_rvcoins = $totalRvCoins - $videoCoinsPrice;

            $rvcoins_update = Userprofile::where('user_id', Auth::user()->id)->update(['total_rv_coins' => $updated_rvcoins]);
            //End Update remaing RVcoins of user
            
            $finance_email = config('constants.emails.finance_email');
            Mail::to(Auth::user()->email)->send(new sendMailAfterRVcoinsPurchaseForVideos('user',$video_id,$save_transaction)); // to the buyer
            Mail::to($finance_email)->send(new sendMailAfterRVcoinsPurchaseForVideos('admin',$video_id,$save_transaction)); // to the buyer
                
            $request->session()->flash('wiretransfer_success', 'Updated successfully.');
            return response()->json(['success'=>'Successfully','message'=>'Updated Successfully!']);
        }
    }
    public function update_rvcoins_payment_subscription(Request $request)
    { 
        $validatedData = $request->validate([
            'subscription_plan_id' => 'required', 
            'captcha' => 'required|captcha'
        ], [        
            'required' => 'This field is required',  
            'captcha.captcha' => 'Invalid captcha'  
        ]);
        $item_id = Crypt::decrypt($request->subscription_plan_id);
        $subscription_details = get_subscription_plan($item_id);
        $get_user_details = get_user_details(Auth::user()->id);
        if($get_user_details->total_rv_coins < $subscription_details->rv_coins_price)
        {
            return response()->json(['success'=>'fail','message'=>'Yoy dont have enough RVcoins!']);
            exit;
        }
        if(isset($item_id) && !empty($item_id))
        {
            $save_transaction = new Transcation();
            $save_transaction->user_id = Auth::user()->id;
            $save_transaction->item_type = 'subscription';
            $save_transaction->item_id = $item_id;
            $save_transaction->amount = $subscription_details->rv_coins_price;
            $save_transaction->subscription_start_date = Carbon::now();
            $save_transaction->subscription_end_date = Carbon::now()->addDay($subscription_details->duration);
            $save_transaction->transaction_type = 'rv_coins';
            $save_transaction->is_payment_done = 1;
            $save_transaction->ip_address = $request->getClientIp();
            $save_transaction->save();

            //Start Update remaing RVcoins of user
            // Cast the values to integers before subtraction
            $totalRvCoins = (int)$get_user_details->total_rv_coins;
            $videoCoinsPrice = (int)$subscription_details->rv_coins_price;
            // Perform subtraction
            $updated_rvcoins = $totalRvCoins - $videoCoinsPrice;

            $rvcoins_update = Userprofile::where('user_id', Auth::user()->id)->update(['total_rv_coins' => $updated_rvcoins]);
            //End Update remaing RVcoins of user
            
            $finance_email = config('constants.emails.finance_email');
            Mail::to(Auth::user()->email)->send(new sendMailAfterRVcoinsPurchaseForSubscription('user',$item_id,$save_transaction)); // to the buyer
            Mail::to($finance_email)->send(new sendMailAfterRVcoinsPurchaseForSubscription('admin',$item_id,$save_transaction)); // to the buyer
                
            $request->session()->flash('wiretransfer_success', 'Updated successfully.');
            return response()->json(['success'=>'Successfully','message'=>'Updated Successfully!']);
        }
    }
    public function success_page()
    {
        return view('frontend.payment.success_payment');
    }
}
