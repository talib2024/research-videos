@extends('frontend.include.frontendapp')
@section('content')
@include('frontend.payment.payment_modal_css')
         <div id="content-wrapper">
            <div class="container-fluid pb-0">
               <div class="top-category section-padding mb-4">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <h6>Scientific Disciplines</h6>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="owl-carousel owl-carousel-category">
                       @foreach ($majorCategory as $majorCategory)
                           <div class="item">
                              <div class="category-item">
                                 <a href="{{ route('category.wise.video',$majorCategory->id) }}">
                                    <video class="autoplay-video" loop muted disablepictureinpicture controlsList="nodownload" data-src="{{ asset('frontend/img/gif_images/'.$majorCategory->category_image) }}" onContextMenu="return false;">
                                       <!-- Placeholder image -->
                                       <source class="img-fluid" src="" type="video/webm">
                                       <!-- Actual video source will be loaded via JavaScript -->
                                    </video>
                                 </a>
                              </div>
                           </div>
                        @endforeach
                        </div>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                        <div class="sort_filter_by_div">
                           <div class="btn-group float-right right-action">
                              <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Filter by <i class="fa fa-caret-down" aria-hidden="true"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-list-ol"></i> &nbsp; Disciplines</a>
                                 <form id="disciplines_form" action="{{ route('welcome') }}" method="GET">
                                    @csrf
                                    <select name="disciplines_filter_by" id="disciplines_filter_by" class="disciplines_filter_by">
                                          <option value="">Select</option>
                                          @foreach ($subcategoryVideos as $majorCategoryId_filter => $categoryData_filter)
                                             <option value="{{ $majorCategoryId_filter }}" {{ request('disciplines_filter_by') == $majorCategoryId_filter ? ' selected' : '' }}>{{ $categoryData_filter['major_category_name'] }}</option>
                                          @endforeach
                                    </select>
                                 </form>
                                 <hr style="background: white; margin: 8px 15px 0 15px; width: 87%;" />
                                 <a class="dropdown-item" href="#"><i class="fas fa-video"></i> &nbsp; Video types</a>
                                 <form id="video_types_form" action="{{ route('welcome') }}" method="GET">
                                    @csrf
                                    <select name="video_type_filter_by" id="video_type_filter_by" class="video_type_filter_by">
                                          <option value="">Select</option>
                                          @foreach ($video_type_records as $video_type_record)
                                             <option value="{{ $video_type_record->id }}" {{ request('video_type_filter_by') == $video_type_record->id ? ' selected' : '' }}>{{ $video_type_record->video_type }}</option>
                                          @endforeach
                                    </select>
                                 </form>
                              </div>
                           </div>

                           <div class="btn-group float-right right-action mt-1 mb-1">
                              <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Sort by <i class="fa fa-caret-down" aria-hidden="true" style="margin-left:8px;"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item{{ request('sortingOption') == 'last_published' ? ' background_red' : '' }}" href="{{ route('welcome.sorting', ['sortingOption' => 'last_published']) }}"><i class="fas fa-fw fa-star"></i> &nbsp; Last published</a>
                                 <a class="dropdown-item{{ request('sortingOption') == 'most_liked' ? ' background_red' : '' }}" href="{{ route('welcome.sorting', ['sortingOption' => 'most_liked']) }}"><i class="fas fa-thumbs-up"></i> &nbsp; Most liked</a>
                                 <a class="dropdown-item{{ request('sortingOption') == 'most_viewed' ? ' background_red' : '' }}" href="{{ route('welcome.sorting', ['sortingOption' => 'most_viewed']) }}"><i class="fa fa-eye"></i> &nbsp; Most viewed</a>
                                 <a class="dropdown-item{{ request('sortingOption') == 'disciplines' ? ' background_red' : '' }}" href="{{ route('welcome.sorting', ['sortingOption' => 'disciplines']) }}"><i class="fas fa-fw fa-list-alt"></i> &nbsp; Disciplines</a>
                                 {{-- <a class="dropdown-item" href="{{ route('welcome.sorting', ['sortingOption' => 'sub_disciplines']) }}"><i class="fas fa-fw fa-list-alt"></i> &nbsp; Sub disciplines</a>                                  --}}
                              </div>
                           </div>
                        </div>
                           <h6>Featured Videos</h6>
                        </div>
                     </div>
                @if ($video_list_all->isNotEmpty())
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
                                <h5>Be the first to publish your research in this scientific discipline.</h5>
                            </div>
                        </div>
                    @endif
                  </div>
                  @include('frontend.include.videos.video_paginate')
               </div>
            </div>
            <!-- /.container-fluid -->    


            <!-- Modal-->
        @include('frontend.payment.payment_modal')      
@endsection

@push('pushjs')
    @include('frontend.payment.payment_modal_js')
<!-- Start custom pagination for filter  -->
<script>
    // JavaScript to prevent dropdown from closing and to submit the form when options are changed
    document.querySelectorAll("#disciplines_form select, #video_types_form select").forEach(function(select) {
        select.addEventListener("click", function(event) {
            event.stopPropagation();
        });

        select.addEventListener("change", function() {
            console.log('Form submitted'); // Log to track form submission

            var form = this.closest("form");
            var formData = new FormData(form);

            // Construct the URL with existing query parameters
            var url = new URL(window.location.href);

            // Set the new filter parameter
            url.searchParams.set(select.name, select.value);

            console.log('Updated URL:', url.href); // Log the updated URL

            // Navigate to the updated URL
            window.location.href = url.href;
        });
    });

    // JavaScript to handle pagination
    document.querySelectorAll('.pagination a').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior

            var url = new URL(link.href); // Construct URL from pagination link

            // Construct the URL with existing query parameters
            var existingParams = window.location.search.substring(1); // Get existing query parameters
            if (existingParams) {
                var params = new URLSearchParams(existingParams);
                params.delete('page'); // Remove existing page parameter
                url.search = params.toString(); // Set updated query parameters
            }

            // Set the page parameter for pagination
            var pageNumber = link.getAttribute('href').match(/page=(\d+)/)[1];
            url.searchParams.set('page', pageNumber);

            console.log('Updated Pagination URL:', url.href); // Log updated pagination URL

            // Navigate to the updated pagination URL
            window.location.href = url.href;
        });
    });

    // Check if current page has no data after filtering
   var currentPage = parseInt(new URLSearchParams(window.location.search).get('page') || 1);

var activePageItem = document.querySelector('.pagination .page-item.active');
var hasNoData = activePageItem && activePageItem.classList.contains('disabled');

if (hasNoData == null && currentPage !== 1) {
    // Reset page to first page if current page has no data and is not already the first page
    var url = new URL(window.location.href);
    url.searchParams.set('page', 1);
    window.location.href = url.href;
}
</script>
<!-- End custom pagination for filter  -->
<script>
    window.addEventListener('load', function() {
        var lazyImages = document.querySelectorAll('.lazy');

        lazyImages.forEach(function(img) {
            img.src = img.getAttribute('data-src');
        });
    });
</script>
@endpush