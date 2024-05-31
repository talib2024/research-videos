 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Report as a publisher:</h6>
                        </div>
                    </div>

                    @if (count(collect($statictics_for_publisher)) > 0)
                    <div class="common-history-form-box table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Total number of received videos</th>
                                        <th>Total number of assigned videos</th>
                                        <th>Total number of published videos</th>
                                        <th>Total number of unpublished videos</th>
                                        <th>Total number of revised videos</th>
                                        <th>Total number of hold videos</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                        <tr>
                                            <td>{{ $statictics_for_publisher['total_videos_received'] }}</td>
                                            <td>{{ $statictics_for_publisher['total_videos_assigned'] }}</td>
                                            <td>{{ $statictics_for_publisher['total_videos_published'] }}</td>
                                            <td>{{ $statictics_for_publisher['total_videos_unpublished'] }}</td>
                                            <td>{{ $statictics_for_publisher['total_videos_pending'] }}</td>
                                            <td>{{ $statictics_for_publisher['total_videos_in_review'] }}</td>
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