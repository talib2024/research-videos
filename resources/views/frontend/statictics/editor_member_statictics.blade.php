 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Report as an editorial member:</h6>
                        </div>
                    </div>

                    @if (count(collect($statictics_for_editorial_member)) > 0)
                    <div class="common-history-form-box table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Total number of assigned videos</th>
                                        <th>Total number of rejected videos</th>
                                        <th>Total videos accepted for publication</th>
                                        <th>Total videos under review process</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                        <tr>
                                            <td>{{ $statictics_for_editorial_member['total_videos_assigned'] }}</td>
                                            <td>{{ $statictics_for_editorial_member['total_videos_pending'] }}</td>
                                            <td>{{ $statictics_for_editorial_member['total_videos_accepted_for_publication'] }}</td>
                                            <td>{{ $statictics_for_editorial_member['total_videos_review_process'] }}</td>
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