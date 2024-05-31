 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Received RVcoins:</h6>
                        </div>
                    </div>

                    @if ($rvcoins_history->isNotEmpty())
                    <div class="common-history-form-box table-responsive">
                            <table id="rvcoins_table_history" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Received RVcoins</th>
                                        <th>Reward Type</th>
                                        <th>Receiving date</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                        @foreach($rvcoins_history as $rvcoins_history_value)
                                            <tr>
                                                <td>{{ number_format($rvcoins_history_value->received_rvcoins, 3) }}</td>
                                                <td>{{ $rvcoins_history_value->reward_type }}</td>
                                                <td> {{ \Carbon\Carbon::parse($rvcoins_history_value->created_at)->format('Y/m/d h:i:s A') }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No RVcoins yet!</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>