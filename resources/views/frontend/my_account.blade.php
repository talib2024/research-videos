@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="row">
                @if (isset($user_profile_data->account_deletion_request) && $user_profile_data->account_deletion_request == 1)
                    <div class="col-lg-12">
                        <div class="alert alert-warning" role="alert">
                            Your account will be deleted soon, please check your email !
                        </div>
                    </div>
                @endif
                <div class="col-lg-10">
                    <div class="main-title">
                        <h6>My account</h6>
                    </div>
                </div>
                @if (
                    !isset($user_profile_data) ||
                        (empty($user_profile_data->account_deletion_request) || $user_profile_data->account_deletion_request != 1))
                    <div class="col-lg-2">
                        <button type="button" class="btn butn" data-toggle="modal" data-target="#deleteAccountModal">Delete
                            my account</button>
                    </div>
                @endif
            </div>
            <hr class="customHr">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input class="form-control border-form-control" value="{{ Auth::user()->name }}"
                            placeholder="First Name" name="name" id="name" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Surname</label>
                        <input class="form-control border-form-control" value="{{ Auth::user()->last_name }}"
                            placeholder="Surname" name="last_name" id="last_name" disabled="true" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Registration Email</label>
                        <input class="form-control border-form-control" value="{{ Auth::user()->email }}"
                            placeholder="Registration Email" disabled="true" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label">Registration Date</label>
                    <input class="form-control border-form-control"
                        value="{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('Y/m/d') }}"
                        placeholder="Registration Date" disabled="" disabled="true" readonly>
                </div>
            </div>
            <hr>

            @php
                if(Session::has('loggedin_role')) {
                $user_role_id = Session::get('loggedin_role');
                } else {
                $user_role_id = Auth::user()->role_id;
                }
                // Start check for editor role
                if($user_role_id == '3')
                {
                    $editor_role = DB::table('userprofiles')
                        ->select('editorrole_id')
                        ->where('user_id',Auth::id())->first();
                }
                // End check for editor role
                if($user_role_id == '2') {
            @endphp
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">                           
                            <h6>My Videos</h6>
                        </div>
                    </div>

                    @if ($video_list->isNotEmpty())                    
                        <div class="common-history-form-box table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                @include('frontend.include.account_table.thead')
                                <tbody>                        
                                    @foreach ($video_list as $video_list)
                                        @include('frontend.include.account_table.tbody')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- @foreach ($video_list as $video_list)
                            <div class="col-xl-4 col-sm-6 mb-3 watchListDiv" id="video_list_div{{ $video_list->id }}">
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
                            </div>
                        @endforeach --}}
                    @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No videos uploaded by you!</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
               @php } @endphp
            @if($user_role_id == '3' && isset($editor_role) && $editor_role->editorrole_id == '1')
               @include('frontend.editor.editor_account')
            @elseif($user_role_id == '3' && isset($editor_role) && $editor_role->editorrole_id == '2')
               @include('frontend.editor.editor_member_account')
            @elseif($user_role_id == '4')
               @include('frontend.reviewer.reviewer_account')
            @elseif($user_role_id == '5')
               @include('frontend.publisher.publisher_account')
            @elseif($user_role_id == '7')
               @include('frontend.correspondingauthor.correspondingauthor_account')            
            @endif
        </div>
        <!-- /.container-fluid -->

        <!-- Logout Modal-->
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <form action="{{ route('account.delete.request') }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title red" id="exampleModalLabel">Do you want to delete your account?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Delete Request", if you want to delete your account.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Delete Request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<div class="modal fade" id="successVideo" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
                </div>
            
            <div class="modal-body">
                
                <div class="thank-you-pop">
                    <img src="{{ asset('frontend/img/Green-Round-Tick.png') }}" alt="">
                    <h4 class="auth_P" style="color:#5C5C5C !important">Your submission was successful !</h4>					
                    <p class="auth_P" style="font-size:17px !important;">Your video unique-ID is: {{ session('videoid') }}</p>							
                    <p class="auth_P" style="font-size:17px !important;">You can login to your account at any time to check the status of your submitted video.</p>							
                </div>
                    
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="commonmodal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
                </div>
            
            <div class="modal-body">
                
                <div class="thank-you-pop">
                    <img src="{{ asset('frontend/img/Green-Round-Tick.png') }}" alt="">
                    <h1>Thank You!</h1>
                    <p>{{ session('deletesuccess') }}</p>							
                </div>
                    
            </div>
            
        </div>
    </div>
</div>
    @endsection
@push('pushjs')
    @if (session('success'))
        <script>
        $(document).ready(function(){
        $('#successVideo').modal('toggle');
        });
        </script>
    @endif

     @if (session('deletesuccess'))
        <script>
        $(document).ready(function(){
        $('#commonmodal').modal('toggle');
        });
        </script>
    @endif
@endpush
