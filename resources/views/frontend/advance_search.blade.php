@extends('frontend.include.frontendapp')
@section('content')
@include('frontend.payment.payment_modal_css')
    <div id="content-wrapper">
        <div class="container-fluid upload-details">
        @if(Route::currentRouteName() == 'show.advance.search' || (Route::currentRouteName() == 'post.advance.search'))
            <div class="row">
                <div class="col-lg-2">
                    <div class="main-title">
                        <h6>Advanced Search</h6>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-2">
                    <div class="main-title">
                        <h6>Search Result</h6>
                    </div>
                </div>
            </div>
        @endif
        @if(Route::currentRouteName() == 'show.advance.search' || (Route::currentRouteName() == 'post.advance.search'))
            <hr>
            <form action="{{ route('post.advance.search') }}" method="get" id="advancedSearchForm" autoComplete="off">
            @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="osahan-form">
                        <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="unique_number">Video ID</label>
                                        <input type="text" name="unique_number" placeholder="Video ID"
                                            id="unique_number" value="{{ session('advance_search_request')['unique_number'] ?? '' }}" class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="author_name">Author Name</label>
                                        <input type="text" name="author_name" placeholder="Author Name"
                                            id="author_name" value="{{ session('advance_search_request')['author_name'] ?? '' }}" class="form-control blackText">
                                        <input type="hidden" name="search_value" class="search_value_advanced" value="{{ session('advance_search_request')['search_value'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="video_title">Video Title</label>
                                        <input type="text" name="video_title" placeholder="Video Title"
                                            id="video_title" value="{{ session('advance_search_request')['video_title'] ?? '' }}" class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="online_publishing_licence">Online Publishing Licence</label>
                                        <select id="online_publishing_licence" name="online_publishing_licence" class="custom-select">
                                            <option value="">Select</option>
                                           @foreach ($paymentype as $paymentype)
                                                <option value="{{ $paymentype->id }}" {{ isset(session('advance_search_request')['online_publishing_licence']) ? session('advance_search_request')['online_publishing_licence'] == $paymentype->id ? 'selected' : '' : '' }}>
                                                    {{ $paymentype->plan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6 ">
                                    <div class="form-group">
                                        <label for="reviewer_name">Reviewer Name</label>
                                        <input type="text" name="reviewer_name" placeholder="Reviewer Name" id="reviewer_name" value="{{ session('advance_search_request')['reviewer_name'] ?? '' }}"
                                            class="form-control blackText">
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="references">References</label>
                                        <input type="text" name="references" placeholder="References"
                                            id="references" value="{{ session('advance_search_request')['references'] ?? '' }}" class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="abstract">Abstract</label>
                                        <input type="text" name="abstract" placeholder="Abstract"
                                            id="abstract" value="{{ session('advance_search_request')['abstract'] ?? '' }}" class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="form-group">
                                        <label for="keywords">Keywords</label>
                                        <input type="text" name="keywords" placeholder="Keywords" id="keywords" value="{{ session('advance_search_request')['keywords'] ?? '' }}"
                                            class="form-control blackText">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="majorcategory_id">Scientific Disciplines</label>
                                        <select id="majorcategory_id" name="majorcategory_id" class="custom-select">
                                            <option value="">Select</option>
                                            @foreach ($majorcategory as $majorcategory)
                                                <option value="{{ $majorcategory->id }}" {{ isset(session('advance_search_request')['majorcategory_id']) ? session('advance_search_request')['majorcategory_id'] == $majorcategory->id ? 'selected' : '' : '' }}>
                                                    {{ $majorcategory->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="subcategory_id_search">Subdisciplines</label>
                                        <select id="subcategory_id_search" name="subcategory_id_search" class="custom-select subcategory_id_search">
                                            <option value="">Select</option>
                                            @if(isset($subcategory_data))
                                                @foreach($subcategory_data as $subcategory_value)
                                                    <option value="{{ $subcategory_value->id }}" {{ isset(session('advance_search_request')['subcategory_id_search']) ? session('advance_search_request')['subcategory_id_search'] == $subcategory_value->id ? 'selected' : '' : '' }}>{{ $subcategory_value->subcategory_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="videotype_id">Video Type</label>
                                        <select id="videotype_id" name="videotype_id" class="custom-select">
                                            <option value="">Select</option>
                                            @foreach ($Videotype as $Videotype)
                                                <option value="{{ $Videotype->id }}" {{ isset(session('advance_search_request')['videotype_id']) ? session('advance_search_request')['videotype_id'] == $Videotype->id ? 'selected' : '' : '' }}>{{ $Videotype->video_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="videosubtype_id">Video Sub Type</label>
                                        <select id="videosubtype_id" name="videosubtype_id" class="custom-select">
                                            <option value="">Select</option>
                                           @foreach ($Videosubtype as $Videosubtype)
                                                <option value="{{ $Videosubtype->id }}" {{ isset(session('advance_search_request')['videosubtype_id']) ? session('advance_search_request')['videosubtype_id'] == $Videosubtype->id ? 'selected' : '' : '' }}>
                                                    {{ $Videosubtype->video_sub_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>                          
                        </div>
                        <div class="osahan-area text-center mt-3">
                            <button type="submit" class="btn btn-outline-primary" id="advancedSearchSubmit">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
<hr>
           <div class="video-block section-padding">
                  <div class="row">
                     
                @if (isset($video_list_all) && !empty($video_list_all))
                  @foreach ($video_list_all as $video_list)
                     <div class="col-xl-4 col-sm-6 mb-3">
                        <div class="video-card">
                           @include('frontend.include.videos.common_video_view')
                        </div>
                     </div>                      
                     @endforeach
                  @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No record found!</h5>
                            </div>
                        </div>
                    @endif
                  </div>
                  @if (isset($video_list_all) && !empty($video_list_all))
                  <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center pagination-sm mb-0">
                        {{ $video_list_all->appends(request()->except('page'))->links() }}
                    </ul>
                </nav>

                    {{-- @include('frontend.include.videos.video_paginate') --}}
                  @endif
               </div>
        </div>
        <!-- /.container-fluid -->  


            <!-- Modal-->
        @include('frontend.payment.payment_modal')    
    @endsection
    @push('pushjs')

    <script>
    $('.search_value_all').on('input', function() {
        const search_text_all = $(this).val();
        $('.search_value_advanced').val(search_text_all);
    });

    $(document).ready(function(){
        $(document).on('change','#majorcategory_id', function() {
            let majorcategory_id = $(this).val();
            $.ajax({
                method: 'post',
                url: "{{ route('sub.category') }}",
                data: {
                    majorcategory_id: majorcategory_id,                    
                    token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status == 'success') {
                        $('.subcategory_id_search').empty();
                        let all_options = "<option value='' selected>Select Sub Discipline</option>"; // Added select option
                        let all_subcategories = res.subcategories;
                        $.each(all_subcategories, function(index, value) {
                            all_options += "<option value='" + value.id +
                                "'>" + value.subcategory_name + "</option>";
                        });
                        $(".subcategory_id_search").html(all_options);
                    }
                }
            })
        });
    });
    </script>
    @include('frontend.payment.payment_modal_js')
    @endpush
