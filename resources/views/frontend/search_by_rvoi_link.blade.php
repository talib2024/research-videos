@extends('frontend.include.auth_includes.frontendauthapp')

@section('content')
   <div class="col-md-12">
      <div class="login-main-right bg-white p-5 mt-5 mb-5">
         <div class="owl-carousel owl-carousel-login">
	    <div class="item">
               <center>
               <video class="img-fluid" autoplay loop muted>
                   <source class="img-fluid" src="{{ asset('frontend/img/gif_images/rvoi_rotating_logo.webm') }}" type="video/webm">
	       </video>
	       <br>
               <br>
               <br>
	       <h3 style="color: grey;">Welcome to rvoi.org</h2>
               <br>
	       <h4 style="color: grey;">Research Video Object Identifier</h3>        
	       <br>
               <br>
               </center>
               <form id="searchForm" autoComplete="off">
                  <div class="form-group">
                     <input type="text" id="search" name="search" placeholder="RVOI link" class="form-control" />
                     <input type="hidden" id="video_id" name="video_id" class="form-control" />
                  <div id="search_list" class="dropdown"></div>   
                  </div>   
                  <div class="mt-4">
                     <div class="row">
                        <div class="col-12">
                           <button type="submit" class="btn btn-outline-primary btn-block btn-lg">RVOI Search</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
@endsection

@push('pushjs')

   <script type="text/javascript">
var route = "{{ route('search.by.rvoi.link.get.data') }}";

$(document).ready(function(){
        $('#search').on('keyup',function(){
            var query= $(this).val(); 
            $.ajax({
                url:route,
                type:"GET",
                data:{'search':query},
                success:function(data){ 
                    $('#search_list').html(data);
                }
            });
             //end of ajax call
        });
    });

        $(document).ready(function () {
            // Handle row click event
            $(document).on('click', '.rvoi_search_table th', function () {
                // Get the data-id attribute from the clicked cell
                var selectedId = $(this).data('id');
                // Get the text content of the clicked cell
                var selectedText = $(this).text();

                // Update the search box and hidden field with the selected values
                $('#search').val(selectedText);
                $('#video_id').val(selectedId);
                $('#search_list').empty();
                // Hide the dropdown
                $('.rvoi_search_table th').closest('.dropdown').removeClass('open');
            });
        });

        // Handle form submission
        $('#searchForm').submit(function (event) {
            // Prevent the form from submitting via traditional means
            event.preventDefault();

            // Get the selected video ID from the hidden input field or variable
            var selectedVideoId = $('#video_id').val();

            // Redirect to the details page with the selected video ID
            if (selectedVideoId) {
                var url = "{{ route('video.details', ':selectedVideoId') }}";
                url = url.replace(':selectedVideoId', selectedVideoId);
                location.href = url;
            }
        });
    </script>
@endpush

