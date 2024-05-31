@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Editorial Board: <span class="red">{{ $category_name->category_name }}</span></h6>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="single-video-left">
                            {{-- <div class="single-video-info-content box mb-3">
                                <p>1- <a href="#sub_disciplines_tab">Sub Disciplines</a></p>
                                <p>2- <a href="#editorial_members_tab">Editorial Members</a></p>
                                
                            </div> --}}
                            {{-- <div class="single-video-info-content box mb-3" id="sub_disciplines_tab">
                                <h5 align="center">Sub Disciplines:</h5>
                                @if (isset($subcategory_list))
                                    @foreach ($subcategory_list as $subcategory_list_value)
                                        <div class="member-section">
                                            <div class="member-content">
                                                <b><i>{{ $subcategory_list_value->subcategory_name }}:</i></b>
                                                <span>{{ $subcategory_list_value->description }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if (empty($subcategory_list) && $subcategory_list->count() <= 0)
                                    <div class="col-lg-12 mb-4">
                                        <div class="form-box">
                                            <h5>No sub disciplines yet!</h5>
                                        </div>
                                    </div>
                                @endif
                            </div> --}}
                            <div class="single-video-info-content box mb-3" id="editorial_members_tab">
                                @if (isset($editor_board_list) && $editor_board_list->count() > 0)
                                    @foreach ($editor_board_list as $editor_board_list_value)
                                        <div class="member-section">
                                            @if (!empty($editor_board_list_value->profile_pic))
                                                <img alt="Avatar"
                                                    src="{{ asset('storage/uploads/profile_image/' . $editor_board_list_value->profile_pic) }}"
                                                    class="profile_image" height="100" width="100">
                                            @else
                                                <img alt="Avatar" src="{{ asset('frontend/img/user.png') }}"
                                                    class="profile_image" height="100" width="100">
                                            @endif
                                            <div class="member-content">
                                                <h6 class="editorialBoardDetails"
                                                    data-user-id="{{ $editor_board_list_value->id }}"><a
                                                        href="#">{!! $editor_board_list_value->name . ' ' . $editor_board_list_value->last_name !!}</a></h6>
                                                <p>{{ $editor_board_list_value->institute_name }}</p>
                                                <p>{{ $editor_board_list_value->city . ', ' . $editor_board_list_value->country_name }}
                                                </p>
                                                {{-- <p>{!! $editor_board_list_value->user_description !!}</p> --}}
                                                {{-- <p>{{ $editor_board_list_value->subcategory_names }}</p> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if (empty($editor_board_list) || $editor_board_list->count() <= 0)
                                    <div class="col-lg-12 mb-4">
                                        <div class="form-box">
                                            <h5>No members yet!</h5>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if (isset($editor_board_list))
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center pagination-sm mb-0">
                                        {{ $editor_board_list->links() }}
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->


       <div id="modaleditorialBoardDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
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
                            const user_full_name = response.user_details.first_name+' '+response.user_details.last_name;
                            $('.editorialBoardModalTitle').html(user_full_name);
                            $('.editorialBoardModalDetails').html(response.user_details.user_description);
                            $('#modaleditorialBoardDetails').modal('show');
                        },
                        error: function(error) {
                            console.error('Error sending data to server:', error);
                        }
                    });
                });

                // Smooth scroll for anchor links
                /* $('a[href^="#"]').on('click', function (e) {
                     e.preventDefault();

                     var target = $(this.hash);
                     if (target.length) {
                         var offset = target.offset().top;

                         var fixedHeight = 80;
                         var adjustedOffset = offset - fixedHeight;

                         $('html, body').animate({
                             scrollTop: adjustedOffset
                         }, 1000);
                     }
                 });*/
            });
        </script>
    @endpush
