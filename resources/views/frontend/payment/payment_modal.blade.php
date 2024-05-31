<div id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content background_color">
            <div class="modal-header row d-flex justify-content-between mx-1 mx-sm-3 mb-0 pb-0 border-0">
                <div class="tabs active" id="tab01">
                    <h6>Pay for this single video</h6>
                </div>
                <div class="tabs" id="tab02">
                    <h6 class="font-weight-bold">or subscribe</h6>
                </div>
            </div>
            <div class="line"></div>
            <div class="modal-body p-0">
                <fieldset class="show" id="tab011">
                    <div class="background_color">
                        <h5 class="text-center mb-4 mt-0 pt-4">Price: <span class="required price_section"></span>
                        </h5>
                    </div>
                    <div class="px-3">
                        <h6 class="pt-3 pb-3 mb-4 border-bottom"><span class="fa fa-android"></span> Please select any
                            payment option:</h6>
                        <h6 class="text-primary pb-2 wireTransferClick wireTransferClick_custom"><a href="#"><img class="" alt="" src="{{ asset('frontend/img/wire_transfer.png') }}"></a></a></h6>

                        <h6 class="text-primary pb-2 payByRVcoinsClick wireTransferClick_custom"><a href="#"><img class="" alt="" src="{{ asset('frontend/img/rv_coins.png') }}"></a></h6>
                        {{-- <h6 class="text-primary pb-2"><a href="{{ route('make.paypal.payment') }}"
                                onclick="event.preventDefault(); document.getElementById('paypal-form').submit();">Paypal</a>
                        </h6> --}}
                        <div style="width:260px;" id="paypal-button-container-video"></div>
                        <input type="hidden" id="paypal_video_id_smart" value="">
                        <input type="hidden" id="paypal_video_amount" value="">
                        <input type="hidden" id="video_amount_RVcoins" value="">
                        {{-- <h6 class="text-primary pb-4"><a href="#">Credit-Card</a></h6> --}}

                        {{-- forms for different-different type --}}
                        {{-- <form id="paypal-form" action="{{ route('make.paypal.payment') }}" method="POST"
                            class="d-none">
                            @csrf
                            <input type="hidden" value="" name="paypal_video_id" id="paypal_video_idggg" />
                        </form> --}}
                        {{-- end forms for different-different type --}}
                    </div>
                </fieldset>
                <fieldset id="tab021">
                    <div class="px-3">
                        <h6 class="pt-3 pb-3 mb-4 border-bottom"><span class="fa fa-android"></span> Please select
                            Subscription:</h6>
                        <h6 class="text-primary pb-2"><a href="{{ route('subscription') }}">Subscription</a></h6>
                    </div>
                </fieldset>

            </div>
            <div class="line"></div>
        </div>
    </div>
</div>

<div id="modalWireTransfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
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
                    <div class="background_color">
                        <h5 class="text-center mb-4 mt-0 pt-4">Price: <span class="required price_section"></span>
                        </h5>
                        <h6 class="px-3">Account detail:</h6>
                        <p class="ml-3"><a href="{{ asset('frontend/img/researchvideos_wiretransfer_account_details.pdf') }}" target="_BLANK">Please click here to download the account details.</a></p>
                    </div>
                    <div class="px-3">
                        <h6 class="pt-3 pb-3 mb-4 border-bottom"><span class="fa fa-android"></span> Upload payment details:</h6>
                        <form id="wireTransferForm" autoComplete="off">
                            @csrf
                            <input type="hidden" value="" id="video_price_wire_transfer" />
                            <input type="hidden" value="" name="paypal_video_id" id="video_id_wire_transfer" />
                            <div class="row">
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="references">Transaction ID:<b class="required">*</b></label>
                                        <input type="text" name="transaction_id" placeholder="Transaction ID" id="transaction_id"
                                            class="form-control blackText">
                                    </div>
                                </div> --}}
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
                                        <button type="submit" class="btn btn-outline-primary" id="wireTransferFormUpdate">Upload Details</button>
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

<div id="modalRVcoins" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content background_color">
            <div class="modal-header row d-flex justify-content-between mx-1 mx-sm-3 mb-0 pb-0 border-0">
                <div class="tabs active" id="tab011">
                    <h6>Pay by RVcoins</h6>
                </div>
            </div>
            <div class="line"></div>
            <div class="modal-body p-0">
                <fieldset class="show" id="tab011">
                    <div class="background_color">
                        <h5 class="text-center mb-0 mt-0 pt-4">You have total RVcoins: <span class="required RVCoinsValue"></span></h5>
                        <h5 class="text-center mb-4 mt-0 pt-1">RVcoins for this video: <span class="required RVCoins_price_section"></span></h5>
                    </div>
                    <div class="px-3 rvcoinsDiv">
                        <form id="rvCoinsForm" autoComplete="off">
                            @csrf
                            <input type="hidden" value="" id="video_price_RVcoins" />
                            <input type="hidden" value="" name="paypal_video_id" id="video_id_RVcoins" />
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Captcha</label>
                                            <div class="captcha_video">
                                                <span>{!! captcha_img() !!}</span>
                                                <button type="button" class="btn btn-danger captchaButton_video" class="reload_video">
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
                                            <span class="custom_error required" id="captcha_RVcoins-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin:10px 0 0 165px">
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-outline-primary" id="rvCoinsFormUpdate">Pay by RVcoins</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="px-3 rvcoinsDivForNoPayment">
                        <h5 class="text-center mb-2 mt-2 required">You cannot purchase this video by RVcoins. Because you have less RVcoins.</h5>

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
@push('pushjs')
@include('frontend.include.jsForDifferentPages.wirtransfer_moadl_js')
@endpush
