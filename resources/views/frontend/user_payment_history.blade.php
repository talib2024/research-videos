@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="row">
               
                <div class="col-lg-10">
                    <div class="main-title">
                        <h6>Payment History</h6>
                    </div>
                </div>
               
            </div>
            <hr class="customHr">

            <div class="video-block section-padding">
                <div class="row">

                    {{-- @if ($payment_details->isNotEmpty())                     --}}
                        <div class="common-history-form-box table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product type</th>
                                        <th>Product name</th>
                                        <th>Amount</th>
                                        <th>Subscription start date</th>
                                        <th>Subscription end date</th>
                                        <th>Payment status</th>
                                        {{-- <th>Product status</th> --}}
                                    </tr>
                                </thead>
                                <tbody>                        
                                    @foreach ($payment_details as $payment_details_history)
                                        <tr>
                                            <td>{{ $payment_details_history->item_type }}</td>
                                            <td>
                                                 @if($payment_details_history->item_type == 'video')
                                                    <a href="{{ route('video.details', $payment_details_history->video_id) }}">{{ $payment_details_history->unique_number }}</a>
                                                 @else
                                                    {{ $payment_details_history->plan_name }}
                                                 @endif
                                            </td>
                                            <td>{!! $payment_details_history->transaction_type == 'rv_coins' ? $payment_details_history->amount.' RVcoins' : '$'.$payment_details_history->amount.' USD' !!}</td>
                                            <td>{{ $payment_details_history->item_type == 'subscription' ? \Carbon\Carbon::parse($payment_details_history->subscription_start_date)->format('Y/m/d  H:i:s') : '-' }}</td>
                                            <td>{{ $payment_details_history->item_type == 'subscription' ? \Carbon\Carbon::parse($payment_details_history->subscription_end_date)->format('Y/m/d  H:i:s') : '-' }}</td>
                                            <td>{{ $payment_details_history->is_payment_done == '1' ? 'Payment done' : 'Payment pending' }}</td>                                        
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                       
                    {{-- @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No videos uploaded by you!</h5>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
             
        </div>
        <!-- /.container-fluid -->

   
    @endsection
