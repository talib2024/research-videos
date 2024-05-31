 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Videos assigned for you:</h6>
                        </div>
                    </div>

                    @if ($video_assigned_for_corr_author->isNotEmpty())
                    <div class="common-history-form-box table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                @include('frontend.include.account_table.thead')
                                <tbody>                        
                                    @foreach ($video_assigned_for_corr_author as $video_list)
                                        @include('frontend.include.account_table.tbody')
                                    @endforeach
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