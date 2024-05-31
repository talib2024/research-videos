 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Report as a member:</h6>
                        </div>
                    </div>

                    @if (count(collect($statictics_member_only)) > 0)
                    <div class="common-history-form-box table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Total video views by you</th>
                                        <th>Total Likes by you</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                        <tr>
                                            <td>{{ $statictics_member_only['video_views_count'] }}</td>
                                            <td>{{ $statictics_member_only['statictics_like_unlike'] }}</td>
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