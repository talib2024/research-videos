 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            {{-- <div class="btn-group float-right right-action">
                                <a href="#" class="right-action-link text-gray" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Last
                                        published</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Most
                                        liked</a>
                                </div>
                            </div> --}}
                            <h6>Videos assigned for you:</h6>
                        </div>
                    </div>

                    @if ($video_list_for_editor->isNotEmpty())
                        <div class="common-history-form-box table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                @include('frontend.include.account_table.thead')
                                <tbody>                        
                                    @foreach ($video_list_for_editor as $video_list)
                                        @include('frontend.include.account_table.tbody')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            {{-- <div class="col-xl-4 col-sm-6 mb-3 watchListDiv" id="video_list_div{{ $video_list->id }}">
                                <div class="video-card">
                                    <div class="video-card-image">
                                        <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                                        <video class="img-fluid myVideo" controls controlsList="nodownload">
                                            <source
                                                src="{{ asset('storage/uploads/vide_Upload2_image/' . $video_list->uploaded_video) }}"
                                                type="video/mp4">
                                        </video>
                                        <div class="overlay"
                                            style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
                                            <p>You need to login to continue watching.</p>
                                        </div>
                                        <div id="overlay_counter{{ $video_list->id }}"
                                            style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
                                            <p id="overlay_counter_msg{{ $video_list->id }}"></p>
                                        </div>
                                    </div>
                                    <div class="video-card-body">
                                        <div class="video-title">
                                            <a
                                                href="{{ route('video.edit', $video_list->id) }}">{{ $video_list->video_title }}</a>
                                        </div>
                                        <div class="video-page text-success">
                                            {{ $video_list->category_name }} - <span class="white-clr">Subcategory</span>
                                        </div>
                                        @include('frontend.include.video_options')
                                    </div>
                                </div>
                            </div> --}}
                    @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No videos assigned for you!</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>