 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Report as a corresponding author:</h6>
                        </div>
                    </div>

                    @if (count(collect($statictics_for_corr_author)) > 0)
                    <div class="common-history-form-box table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Total videos accepted by you</th>
                                        {{-- <th>Total videos accepted for publication</th>
                                        <th>Total videos rejected for publication</th>
                                        <th>Total videos under review process</th> --}}
                                    </tr>
                                </thead>
                                <tbody>  
                                        <tr>
                                            <td>{{ $statictics_for_corr_author['total_videos_accepted_by_you'] }}</td>
                                            {{-- <td>{{ $statictics_for_corr_author['total_videos_accepted'] }}</td>
                                            <td>{{ $statictics_for_corr_author['total_videos_rejected'] }}</td>
                                            <td>{{ $statictics_for_corr_author['total_videos_in_review'] }}</td> --}}
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No videos assigned for you!</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>