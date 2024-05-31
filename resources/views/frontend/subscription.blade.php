@extends('frontend.include.frontendapp')

@section('content')
<div id="content-wrapper">
            <div class="container-fluid">
               <div class="video-block section-padding">
                  <div class="row">
                   <div class="col-md-12">
                        <div class="main-title">
                           <h6>Select a single member subscription plan and get an unlimited access to all videos.</h6>
                        </div>
                     </div>
                     @foreach ($subscriptionPlans as $plan)
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="channels-card">
                                <div class="channels-card-image custom-channels-card-image">
                                    <h6>{{ $plan->plan_name }}</h6>
                                    <button type="button" class="btn btn-warning btn-sm border-none" style="font-size:15px;font-weight:500">USD ${{ $plan->amount }}</button>
                                    <p></p>
                                    <h6 class="text-primary"><a href="#" class="wireTransferClickSubscription" data-wiretransfer_subscription_plan_id="{{ Crypt::encrypt($plan->id) }}" data-wiretransfer_subscription_plan_price="{{ $plan->amount }}"><img class="" alt="" src="{{ asset('frontend/img/wire_transfer.png') }}"></a><h6>
                                    <h6 class="text-primary"><a href="#" class="rvcoinsClickSubscription" data-wiretransfer_subscription_plan_id="{{ Crypt::encrypt($plan->id) }}" data-subscription_amount_RVcoins="{{ $plan->rv_coins_price }}"><img class="" alt="" src="{{ asset('frontend/img/rv_coins.png') }}"></a><h6>
                                    {{-- <h6 class="text-primary pb-2"><a href="#" class="wireTransferClickSubscription" data-wiretransfer_subscription_plan_id="{{ Crypt::encrypt($plan->id) }}" data-wiretransfer_subscription_plan_price="{{ $plan->amount }}">Wire Transfer</a></h6> --}}
                                    {{-- <h6 class="text-primary pb-2"><a href="#" class="rvcoinsClickSubscription" data-wiretransfer_subscription_plan_id="{{ Crypt::encrypt($plan->id) }}" data-subscription_amount_RVcoins="{{ $plan->rv_coins_price }}">Pay by RVcoins</a></h6> --}}
                                    <div id="paypal-button-container-{{ $plan->paypal_plan_id }}" data-plan-id="{{ $plan->id }}"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                  </div>
                 <div class="col-md-12">
                        <div class="main-title">
                           <h6><i>For group entities, universities and institutions subscriptions, please <a href="{{ route('contact.us') }}">contact us</a>.</i></h6>
                        </div>
                     </div>
               </div>
            </div>
<!-- /.container-fluid -->

<div id="modalWireTransfer_subscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content background_color">
            <div class="modal-header row d-flex justify-content-between mx-1 mx-sm-3 mb-0 pb-0 border-0">
                <div class="tabs active" id="tab01">
                    <h6>Upload wire transfer details</h6>
                </div>
            </div>
            <div class="line"></div>
            <div class="modal-body p-0">
                <fieldset class="show" id="tab011">
                    <div class=" background_color">
                        <h5 class="text-center mb-4 mt-0 pt-4">Price: <span class="required price_section_subscription"></span>
                        </h5>
                        <h6 class="px-3">Account detail:</h6>
                        <p class="ml-3"><a href="{{ asset('frontend/img/researchvideos_wiretransfer_account_details.pdf') }}" target="_BLANK">Please click here to download the account details.</a></p>
                    </div>
                    <div class="px-3">
                        <h6 class="pt-3 pb-3 mb-4 border-bottom"><span class="fa fa-android"></span> Upload payment details:</h6>
                        <form id="wireTransferForm_subscription" autoComplete="off">
                            @csrf
                            <input type="hidden" value="" id="subscription_plan_price" />
                            <input type="hidden" value="" name="subscription_plan_id" id="subscription_plan_id" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="abstract">Transaction Receipt<b class="red">*</b></label>
                                        <input type="file" id="transaction_receipt" name="transaction_receipt" class="form-control border-form-control" />
                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Captcha</label>
                                            <div class="captcha_video">
                                                <span>{!! captcha_img() !!}</span>
                                                <button type="button" class="btn btn-danger captchaButton_video" class="reload_video" id="reload_video">
                                                        &#x21bb;
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Enter Captcha<b class="required">*</b></label><span class="required">{{ $errors->first('captcha') }}</span>
                                            <input id="captcha_video" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                            <span class="custom_error required" id="captcha_wiretransfer-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin:10px 0 0 165px">
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-outline-primary" id="wireTransferFormUpdate_subscription">Upload Details</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </fieldset>

            </div>
            <div class="line"></div>
        </div>
    </div>
</div>

<div id="modalRvCoins_subscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content background_color">
            <div class="modal-header row d-flex justify-content-between mx-1 mx-sm-3 mb-0 pb-0 border-0">
                <div class="tabs active" id="tab01">
                    <h6>Pay by RVcoins</h6>
                </div>
            </div>
            <div class="line"></div>
            <div class="modal-body p-0">
                <fieldset class="show" id="tab011">
                    <div class=" background_color">
                        <h5 class="text-center mb-0 mt-0 pt-4">You have total RVcoins: <span class="required RVCoinsValue_subscription"></span>
                        </h5>
                        <h5 class="text-center mb-4 mt-0 pt-1">RVcoins for this plan: <span class="required RVCoins_price_sectionsubscription"></span>
                        </h5>
                    </div>
                    <div class="px-3 rvcoinsDiv_subscription">
                        <form id="rvCoinsForm_subscription" autoComplete="off">
                            @csrf
                            <input type="hidden" value="" id="subscription_plan_price_rvcoins" />
                            <input type="hidden" value="" name="subscription_plan_id" id="subscription_plan_id_rvcoins" />
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Captcha</label>
                                            <div class="captcha_video">
                                                <span>{!! captcha_img() !!}</span>
                                                <button type="button" class="btn btn-danger captchaButton_video" class="reload_video" id="reload_video">
                                                        &#x21bb;
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Enter Captcha<b class="required">*</b></label><span class="required">{{ $errors->first('captcha') }}</span>
                                            <input id="captcha_video" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                            <span class="custom_error required" id="captcha_wiretransfer-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin:10px 0 0 165px">
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-outline-primary" id="rvCoinsForm_subscription_submit">Upload Details</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="px-3 rvcoinsDivForNoPayment">
                        <h5 class="text-center mb-2 mt-2 required">You cannot purchase this plan by RVcoins. Because you have less RVcoins.</h5>

                    </diV>
                </fieldset>

            </div>
            <div class="line"></div>
        </div>
    </div>
</div>


<div class="modal fade" id="wireTransferSuccessModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content background_color">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
                </div>
            
            <div class="modal-body">
                
                <div class="thank-you-pop">
                    <img src="{{ asset('frontend/img/Green-Round-Tick.png') }}" alt="">
                    <h1>Thank You!</h1>
                    <p>Your payment is submitted successfully and admin will verify it soon.</p>							
                </div>
                    
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('pushjs')
<script>
$(document).on("click", ".wireTransferClickSubscription", function () {
     const subscription_plan_id = $(this).data('wiretransfer_subscription_plan_id');
     const subscription_plan_price = $(this).data('wiretransfer_subscription_plan_price');
     $('#subscription_plan_price').val(subscription_plan_price);
     $('#subscription_plan_id').val(subscription_plan_id);
     $('.price_section_subscription').html(subscription_plan_price+' '+'USD');
     $('#modalWireTransfer_subscription').modal('show');
});
$(document).on("click", ".rvcoinsClickSubscription", function () {
     const user_total_coins = "{{ $loggedIn_user_details->total_rv_coins }}";
     const subscription_plan_id = $(this).data('wiretransfer_subscription_plan_id');
     const subscription_plan_price_RVcoins = $(this).data('subscription_amount_rvcoins');
     $('#subscription_plan_price_rvcoins').val(subscription_plan_price_RVcoins);
     $('#subscription_plan_id_rvcoins').val(subscription_plan_id);
     $('.RVCoins_price_sectionsubscription').html(subscription_plan_price_RVcoins);
     $('.RVCoinsValue_subscription').html(user_total_coins);
     if(subscription_plan_price_RVcoins != '')
     {
        $('.RVCoinsValue').html(user_total_coins);
        if(user_total_coins < subscription_plan_price_RVcoins)
        {
            $('.rvcoinsDivForNoPayment').show();
            $('.rvcoinsDiv_subscription').hide();
        }
        else
        {
            $('.rvcoinsDivForNoPayment').hide();
            $('.rvcoinsDiv_subscription').show();
        }
     }

     $('#modalRvCoins_subscription').modal('show');
});
</script>
@include('frontend.include.jsForDifferentPages.wirtransfer_subscription_moadel_js')
<script src="https://www.paypal.com/sdk/js?client-id=AYmQ3p4m_LUfHob58WCLGV5XgHPs3kPBtGJRw1cqNUkysjh88kTTS3dsaYufPvEYIOZ0nKiJ_FNSDILA&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<script>

    const subscriptionPlans = @json($subscriptionPlans);

    subscriptionPlans.forEach(plan => {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'subscribe'
            },
            createSubscription: function(data, actions) {
                return actions.subscription.create({
                    plan_id: plan.paypal_plan_id
                });
            },
            onApprove: function(data, actions) {
                var transactionId = data.orderID;
                var subscriptionData = {
                    transaction_id: transactionId,
                    plan_record_id: plan.id // Get the plan record ID
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('update.paypal.subscription') }}",
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(subscriptionData),
                    success: function(response) {
                        window.location.href = response.redirect;
                    },
                    error: function(error) {
                        console.error('Error sending subscription data to server:', error);
                    }
                });
            }
        }).render('#paypal-button-container-' + plan.paypal_plan_id);
    });
</script>
@endpush
