@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6><b>Special Issues</b></h6>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="single-video-left">
                            <div class="single-video-info-content box mb-3 table-responsive">
                                <table class="table table-striped table-bordered">
                                    @if (isset($special_issue))
                                        @foreach ($special_issue as $special_issue_value)
                                            <tr>
                                                <td>
                                                <div>
                                                    <div class="member-section">
                                                        {{-- <div class="profile-wrapper" style="width:100px;">&nbsp;</div> --}}
                                                        <div class="member-content1" style="margin: 0 0 0 10px;">
                                                            <h6 class="editorialBoardDetails">
                                                                {{ $special_issue_value->issue_title }}</h6>
                                                            <p>{{ $special_issue_value->issue_discipline }}</p>
                                                            <a href="{{ route('video.index') }}"><button type="button" class="btn butn">Submit your video</button></a>
                                                        </div>
                                                    </div>
                                                    <div class="member-section" style="flex-wrap: wrap;">
                                                        @foreach($special_issue_value->users as $users_values)
                                                            <div class="inner-div" style="display: flex; flex-direction: column; align-items: center; margin: 10px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; width: 200px; box-sizing: border-box;">
                                                                <div class="profile-wrapper">
                                                                    @if (!empty($users_values->profile_pic))
                                                                        <img alt="Avatar"
                                                                            src="{{ asset('storage/uploads/profile_image/' . $users_values->profile_pic) }}"
                                                                            class="profile_image" height="100" width="100">
                                                                    @else
                                                                        <img alt="Avatar"
                                                                            src="{{ asset('frontend/img/user.png') }}"
                                                                            class="profile_image" height="100" width="100">
                                                                    @endif
                                                                </div>
                                                                <div class="member-content1">
                                                                    <h6 class="editorialBoardDetails"
                                                                        data-user-id="{{ $users_values->id }}"><a
                                                                            href="#">{!! $users_values->name . ' ' . $users_values->last_name !!}</a></h6>
                                                                    <p>{{ $users_values->institute_name }}</p>
                                                                    <p>{{ $users_values->city . ', ' . $users_values->country_name }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                     <div class="member-content" style="margin: 0 0 0 10px;">
                                                        {{-- <div class="profile-wrapper" style="width:100px;">&nbsp;</div>
                                                        
                                                        <div> --}}

                                                            <div class="issueDescription" style="text-align: justify;">
                                                                <span class="less-text">
                                                                    {!! Illuminate\Support\Str::limit(strip_tags($special_issue_value->issue_description), 200, '...') !!}
                                                                </span>
                                                                <span class="full-text" style="display: none;">
                                                                    {!! $special_issue_value->issue_description !!}
                                                                </span>
                                                            </div>
                                                            @if (strlen($special_issue_value->issue_description) > 200)
                                                                <button class="showMoreBtn">Show more</button>
                                                                <button class="showLessBtn" style="display: none;">Show
                                                                    less</button>
                                                                    
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                @if (empty($special_issue) && $special_issue->count() <= 0)
                                    <div class="col-lg-12 mb-4">
                                        <div class="form-box">
                                            <h5>No members yet!</h5>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        <!-- /.container-fluid -->


        <div id="modaleditorialBoardDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" class="modal fade text-left">
            <div class="modal-dialog modal-lg">
                <div class="modal-content background_color">
                    <div class="modal-header">
                        <h5 class="modal-title editorialBoardModalTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body editorialBoardModalDetails">
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('pushjs')
        <script>
            $(document).ready(function() {

                $(".editorialBoardDetails").on("click", function() {
                    var userId = $(this).data("user-id");
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = "{{ route('user.details', ':userId') }}";
                    url = url.replace(':userId', userId);
                    var postData = {
                        userId: userId
                    };
                    $.ajax({
                        url: url,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(postData),
                        success: function(response) {
                            const user_full_name = response.user_details.first_name + ' ' + response
                                .user_details.last_name;
                            $('.editorialBoardModalTitle').html(user_full_name);
                            $('.editorialBoardModalDetails').html(response.user_details
                                .user_description);
                            $('#modaleditorialBoardDetails').modal('show');
                        },
                        error: function(error) {
                            console.error('Error sending data to server:', error);
                        }
                    });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var showMoreBtns = document.querySelectorAll('.showMoreBtn');
                var showLessBtns = document.querySelectorAll('.showLessBtn');

                showMoreBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var memberContent = btn.closest('.member-content');
                        var issueDescription = memberContent.querySelector('.issueDescription');
                        var fullText = issueDescription.querySelector('.full-text');
                        var lessText = issueDescription.querySelector('.less-text');

                        lessText.style.display = 'none';
                        fullText.style.display = 'inline';
                        btn.style.display = 'none';
                        btn.nextElementSibling.style.display = 'inline';
                    });
                });

                showLessBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var memberContent = btn.closest('.member-content');
                        var issueDescription = memberContent.querySelector('.issueDescription');
                        var fullText = issueDescription.querySelector('.full-text');
                        var lessText = issueDescription.querySelector('.less-text');

                        fullText.style.display = 'none';
                        lessText.style.display = 'inline';
                        btn.style.display = 'none';
                        btn.previousElementSibling.style.display = 'inline';
                    });
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var issueDescriptions = document.querySelectorAll('.issueDescription');

                issueDescriptions.forEach(function(issueDescription) {
                    var content = issueDescription.innerHTML;

                    // Regular expression to find URLs in text
                    var urlRegex = /(https?:\/\/[^\s]+)/g;

                    // Replace plain text URLs with clickable links
                    var formattedContent = content.replace(urlRegex, function(url) {
                        return '<a href="' + url + '" target="_blank">' + url + '</a>';
                    });

                    // Update the content with clickable links
                    issueDescription.innerHTML = formattedContent;
                });
            });
        </script>
    @endpush
