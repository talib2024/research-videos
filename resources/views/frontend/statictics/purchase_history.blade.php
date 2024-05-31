 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Purchase History:</h6>
                        </div>
                    </div>

                    @if ($purchase_history->isNotEmpty())
                    <div class="common-history-form-box table-responsive">
                            <table id="purchase_table_history" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product type</th>
                                        <th>Amount</th>
                                        <th>Video ID</th>
                                        <th>Transaction type</th>
                                        <th>Subscription start date</th>
                                        <th>Subscription end date</th>
                                        <th>Payment status</th>
                                        <th>Payment date</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                        @foreach($purchase_history as $purchase_history_value)
                                            <tr>
                                                <td>{{ $purchase_history_value->item_type }}</td>
                                                <td>{!! $purchase_history_value->transaction_type == 'rv_coins' ? $purchase_history_value->amount.' coins' : '$'.$purchase_history_value->amount !!}</td>
                                                <td>
                                                @if ($purchase_history_value->item_type == 'video')

                                                    <a href="{{ route('video.details', $purchase_history_value->videouploads_id) }}" target="_blank">{{ $purchase_history_value->unique_number }}</a>
                                                @else
                                                    -
                                                @endif
                                                
                                                </td>
                                                <td>{{ $purchase_history_value->transaction_type }}</td>
                                                <td> {{ !empty($purchase_history_value->subscription_start_date) ? \Carbon\Carbon::parse($purchase_history_value->subscription_start_date)->format('Y/m/d h:i:s A') : '-' }}</td>
                                                <td> {{ !empty($purchase_history_value->subscription_end_date) ? \Carbon\Carbon::parse($purchase_history_value->subscription_end_date)->format('Y/m/d h:i:s A') : '-' }}</td>
                                                <td>{{ $purchase_history_value->is_payment_done == '1' ? 'Paid' : 'Pending' }}</td>
                                                <td> {{ \Carbon\Carbon::parse($purchase_history_value->created_at)->format('Y/m/d h:i:s A') }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No purchase history yet!</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>