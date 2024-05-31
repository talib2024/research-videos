 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Report as an editorial member:</h6>
                        </div>
                    </div>
                    @if (count(collect($statictics_for_reviewer)) > 0)
                    <div class="common-history-form-box table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Total number of invitations accepted</th>
                                        <th>Total videos accepted for publication</th>
                                        <th>Total videos rejected for publication</th>
                                        {{-- <th>Total number of accepted videos for reviews</th>
                                        <th>Total number of pending videos for reviews</th>
                                        <th>Total number of rejected videos for reviews</th>
                                        <th>Total videos under process</th>
                                        <th>Total videos accepted for publication</th>
                                        <th>Total number of videos published by publisher</th>
                                        <th>Total number of videos un published by publisher</th> --}}
                                    </tr>
                                </thead>
                                <tbody>  
                                    <tr>
                                        <td>{{ $statictics_for_reviewer['total_invitation_accepted'] }}</td>
                                        <td>{{ $statictics_for_reviewer['total_videos_Accepted_For_Publication'] }}</td>
                                        <td>{{ $statictics_for_reviewer['total_videos_Rejected_For_Publication'] }}</td>
                                        {{-- <td>{{ $statictics_for_reviewer['total_videos_assigned'] }}</td>
                                        <td>{{ $statictics_for_reviewer['totalVideosPendingForReviews'] }}</td>
                                        <td>{{ $statictics_for_reviewer['totalVideosRejectedForReviews'] }}</td>
                                        <td>{{ $statictics_for_reviewer['totalVideosunderProcess'] }}</td>
                                        <td>{{ $statictics_for_reviewer['totalVideosforAcceptedForPublication'] }}</td>

                                        <td>{{ $statictics_for_reviewer['totalVideosforPublishedByPublisher'] }}</td>
                                        <td>{{ $statictics_for_reviewer['totalVideosforUnPublishedByPublisher'] }}</td> --}}
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