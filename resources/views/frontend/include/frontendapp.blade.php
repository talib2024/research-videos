<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <title>ResearchVideos</title>
      @include('frontend.include.cssurls')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
   </head>
   <body id="page-top">
      <nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top navbar_Modal">
         &nbsp;&nbsp; 
         <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
         <i class="fas fa-bars"></i>
         </button> &nbsp;&nbsp;
        <a class="navbar-brand mr-0 logo-custom-anchor" href="{{ route('welcome') }}">
            @if(session('switchtheme') == 'light')
                {{-- <img src="placeholder_light.jpg" data-src="{{ asset('frontend/img/Logo_RV_red_on_white.gif') }}" class="img-fluid logo-custom logo-change lazy" alt=""> --}}
                <video class="img-fluid logo-custom logo-change autoplay-video" loop muted disablepictureinpicture controlsList="nodownload" data-src="{{ asset('frontend/img/Logo_RV_red_on_white.webm') }}" onContextMenu="return false;">
                    <!-- Placeholder image -->
                    <source class="img-fluid" src="" type="video/webm">
                    <!-- Actual video source will be loaded via JavaScript -->
                </video>
            @else
                {{-- <img src="placeholder_dark.jpg" data-src="{{ asset('frontend/img/Logo2_RV_b.gif') }}" class="img-fluid logo-custom logo-change lazy" alt=""> --}}
                <video class="img-fluid logo-custom logo-change autoplay-video" loop muted disablepictureinpicture controlsList="nodownload" data-src="{{ asset('frontend/img/Logo_RV_red.webm') }}" onContextMenu="return false;">
                    <!-- Placeholder image -->
                    <source class="img-fluid" src="" type="video/webm">
                    <!-- Actual video source will be loaded via JavaScript -->
                </video>
            @endif
        </a>
         <div class="drk-lig-theme">
                  <input type="checkbox" style="width:auto;" class="checkbox_switch_theme" id="checkbox_switch_theme" value="{{ session()->has('switchtheme') && session('switchtheme') == 'light' ? 'light' : 'dark' }}" {{ session()->has('switchtheme') && session('switchtheme') == 'dark' ? 'checked' : 'checked' }}>
               <label for="checkbox_switch_theme" class="checkbox_switch_theme-label">
                  @if(session('switchtheme') == 'light')
                     <i class="fas fa-sun"></i>
                  @else
                     <i class="fas fa-moon"></i>
                  @endif
                  <span class="ball"></span>
               </label>
               </div>
         <!-- Navbar Search -->
         @auth
         <form action="{{ route('post.all.search') }}" method="get" class="loged-in d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search">
         @csrf
            <div class="input-group">
               <input type="text" name="search_value" value="{{ session('advance_search_request')['search_value'] ?? '' }}" class="form-control search_value_all" placeholder="Search for...">
               <div class="input-group-append">
                  <button class="btn btn-light" type="submit">
                  <i class="fas fa-search"></i> 
                  </button>
               </div>
               
               <a href="{{ route('show.advance.search') }}" class="btn btn-light ellip" title="Advanced Search" >
                    <i class="fa fa-ellipsis-h"></i>
                </a>
            </div>
         </form>
         @else
            <form action="{{ route('post.all.search') }}" method="get" class="loged-out d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search">
            @csrf
                <div class="input-group">
                <input type="text" name="search_value" value="{{ session('advance_search_request')['search_value'] ?? '' }}" class="form-control search_value_all" placeholder="Search for...">
                <div class="input-group-append">
                    <button class="btn btn-light" type="submit">
                    <i class="fas fa-search"></i> 
                    </button>
                </div>
                
                <a href="{{ route('show.advance.search') }}" class="btn btn-light ellip" title="Advanced Search" >
                        <i class="fa fa-ellipsis-h"></i>
                    </a>
                </div>
            </form>
         @endif
         <!-- Navbar -->
         <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar">
            @auth
            <li class="nav-item dropdown no-arrow mx-1 changeDropdown">
                @php
                
                    if(Session::has('loggedin_role')) {
                        $user_role_id = Session::get('loggedin_role');
                    } else {
                        $user_role_id = Auth::user()->role_id;
                    }
                    $loggedin_role = loggedin_as($user_role_id);
                @endphp
                {{-- <p class="current_role">Role: {{ $loggedin_role }}</p> --}}
               <a class="nav-link dropdown-toggle roleDropDown" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               
               {{ $loggedin_role }}
               <i class="fa fa-caret-down"></i>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
               @php 
                $roles = DB::table('userroles')
                        ->leftJoin('roles','roles.id','=','userroles.role_id')
                        ->select('roles.role','roles.id as role_id','userroles.id as userrole_id')
                        ->where('user_id',Auth::id())->get();
                foreach($roles as $roles)
                {
               @endphp
                  <a class="dropdown-item changeUserRole" href="#" data-role-id="{{ $roles->role_id }}">{{ $roles->role }}</a>
                @php
                }
                @endphp
               </div>
            </li>
               <li class="nav-item dropdown no-arrow osahan-right-navbar-user" style="display:flex;">
                  <a class="nav-link dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  @if(!empty(Auth::user()->profile_pic))
                  <img alt="Avatar" src="{{ asset('storage/uploads/profile_image/'.Auth::user()->profile_pic) }}" class="profile_image">
                  @else
                  <img alt="Avatar" src="{{ asset('frontend/img/user.png') }}" class="profile_image">
                  @endif
                  {{-- {{ Auth::user()->name }}  --}}
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                     <a class="dropdown-item" href="{{ route('my.account') }}"><i class="fas fa-fw fa-user-circle"></i> &nbsp; My Account</a>
                     <a class="dropdown-item" href="{{ route('subscription') }}"><i class="fas fa-fw fa-video"></i> &nbsp; Subscriptions</a>
                     <a class="dropdown-item" href="{{ route('user.payment.history') }}"><i class="fas fa-credit-card"></i> &nbsp; Payment History</a>
                     <a class="dropdown-item" href="{{ route('my.settings') }}"><i class="fas fa-fw fa-cog"></i> &nbsp; Profile</a>
                     <a class="dropdown-item" href="{{ route('watch.list') }}"><i class="fas fa-fw fa-video"></i> &nbsp; Watch list</a>
                     @if(Auth::user()->is_organization == '1')
                        <a class="dropdown-item" href="{{ route('institute.user') }}"><i class="fas fa-fw fa-user-circle"></i> &nbsp; Institute User</a>
                     @endif
                     {{-- <a class="dropdown-item" href="{{ route('coauthors.index') }}"><i class="fas fa-fw fa-user-circle"></i> &nbsp; Co-Authors</a> --}}
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
                  </div>
               </li>
            @else
                <li class="nav-item mx-1">
                  <a class="nav-link mobile_size" href="{{ route('organization.login') }}">
                  {{-- <i class="fas fa-plus-circle fa-fw"></i> --}}
                  <img src="{{ asset('frontend/img/institution_login_icon.png') }}" class="img-fluid icon_logins zoom" alt="Access through your institution" title="Access through your institution">
                  {{-- Access through your Institution --}}
                  </a>
               </li>
               <li class="nav-item mx-1">
                  <a class="nav-link mobile_size" href="{{ route('member.login') }}">
                  {{-- <i class="fas fa-plus-circle fa-fw"></i> --}}
                  <img src="{{ asset('frontend/img/login_icon.png') }}" class="img-fluid icon_logins zoom" alt="Login to your account" title="Login to your account">
                  {{-- Login --}}
                  </a>
               </li>
               <li class="nav-item mx-1">
                  <a class="nav-link mobile_size" href="{{ route('member.register') }}">
                  {{-- <i class="fas fa-plus-circle fa-fw"></i> --}}
                  <img src="{{ asset('frontend/img/signup_icon.png') }}" class="img-fluid icon_logins zoom" alt="Join us for free" title="Join us for free">
                  {{-- Join for free --}}
                  </a>
               </li>
            @endif
         </ul>
      </nav>
       <div class="col-sm-12 mobile-search_sec bg-white">
        <form action="{{ route('post.all.search') }}" method="get" class=" osahan-search-mobile">
        @csrf
            <div class="input-group">
                <input type="text" name="search_value" value="{{ session('advance_search_request')['search_value'] ?? '' }}" class="form-control search_value_all" placeholder="Search for...">
                <div class="input-group-append">
                    <button class="btn btn-light" type="submit">
                    <i class="fas fa-search"></i> 
                    </button>
                </div>
                <a href="{{ route('show.advance.search') }}" class="btn btn-light ellip" title="Advanced Search" >
                    <i class="fa fa-ellipsis-h"></i>
                </a>
            </div>
        </form>
      </div>
      <div id="wrapper">
         <!-- Sidebar -->
        @include('frontend.include.leftSideBar')
@yield('content')

<!-- Sticky Footer -->
           <footer class="sticky-footer">
    <div class="container ">
        <div class="row increaseTheImpact">
             <div class="col-12 submit-video">
                <h6><strong>Increase the impact of your research!</strong></h6>
               <a href="{{ route('video.index') }}"><button type="button" class="btn butn">Submit your video</button></a>
            </div>
        </div>
        <hr/>
        @if($show_hide_section_record[0]->status == '1')
        <div class="row ">
            <div class="container partner-section">
                <a href="#"><h6><strong>AI Video and Data Sharing Tools</strong></h6></a>
                <section class="customer-logos slider">
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo1.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo13.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo2.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo14.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo3.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo15.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo4.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo16.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo5.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo17.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo6.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo18.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo7.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo19.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo8.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo20.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo9.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/Data_Sharing_Tools/logo21.webp') }}" class="lazy"></div>
                    <div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo12.webp') }}" class="lazy"></div>
                    
                </section>
            </div>
                <div class="col-lg-3 col-md-3 col-sm-3 button-sec">
                </div>
                <div class="col-md-12 col-lg-3 button-sec">
                <a href="{{ route('video.generation') }}"><button type="button" class="btn butn">Video Generation</button></a>
                </div>
                <div class="col-md-12 col-lg-3 button-sec">

                <a href="{{ route('data.sharing') }}"><button type="button" class="btn butn">Data Sharing</button></a>
                </div>
        </div>
        <hr/>
        @endif
        @if($show_hide_section_record[1]->status == '1')
        <div class="row ">
            <div class="container partner-section">
                <a href="{{ route('contact.us') }}"><h6><strong>Trusted By</strong></h6></a>
                <section class="customer-logos slider">
                    <a href="https://www.openshot.org/" target="_BLANK"><div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo1.webp') }}" class="lazy"></div></a>
                    <a href="https://www.make-real.com/" target="_BLANK"><div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo22.webp') }}" class="lazy"></div></a>
                    <a href="https://www.synapse.org/" target="_BLANK"><div class="slide"><img data-src="{{ asset('frontend/img/ai_audio_video_data/AI_Video_and_Audio_Generation_Tools/logo13.webp') }}" class="lazy"></div></a>
                </section>
            </div>
                <div class="col-lg-3 col-md-3 col-sm-3 button-sec">
                </div>
                <div class="col-md-12 col-lg-3 button-sec">
                <button type="button" class="btn butn">Universities and Institutions</button>
                </div>
                <div class="col-md-12 col-lg-3 button-sec">

                <a href="{{ route('societies.and.publishers') }}"><button type="button" class="btn butn">Societies and Publishers</button></a>
                </div>
        </div>
        <hr/>
        @endif
        <div class="row stayup-soc_icon">
            <div class="col-lg-6 col-md-6 col-sm-12 up-todate">
                <h6><strong>Stay Up To Date With Us!</strong></h6>
                <p class="auth_P">Subscribe to receive our latest newsletters</p>
                <p id="newsletter_success_msg" class="required"></p>
           <form id="newsLetterForm" autoComplete="off">
                <input type="text" name="email" id="" placeholder="your email" class="newsletterInput form-control">
                <span class="custom_error required" id="email-error"></span>
                <div class="form-group">
               
            </div>
            <div class="form-group cap-cha col-lg-12">
                <div class="cap col-lg-6 col-md-12 col-sm-12">
                    <label>Captcha <b class="required">*</b></label><span class="required">{{ $errors->first('captcha') }}</span>
                    <div class="captcha">
                        <span>{!! captcha_img() !!}</span>
                        <button type="button" class="btn btn-danger captchaButton" class="reload" id="reload">
                                &#x21bb;
                        </button>
                    </div>
                </div>
                <div class="enter-cap col-lg-6 col-md-12 col-sm-12">
                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                    <span class="custom_error required" id="captcha-error"></span>
                </div>
            </div>
                <button type="submit" id="newsLetterFormSubmit" class="btn butn sub-but">Subscribe</button>
            </form>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 up-todate">
                <h6 class="follow-up">Follow us on</h6>
                <div class="rounded-social-buttons">
                    <a class="social-button twitter" href="https://twitter.com/VideosResearch" target="_blank"><img class="img-fluid logo-custom" alt="" src="{{ asset('frontend/img/twitter_icon.png') }}"></a>
                    <a class="social-button linkedin" href="https://www.linkedin.com/company/researchvideos" target="_blank"><img class="img-fluid logo-custom" alt="" src="{{ asset('frontend/img/linkedin_icon.png') }}"></a>
                    <a class="social-button instagram" href="https://www.instagram.com/researchvideosllc" target="_blank"><img class="img-fluid logo-custom" alt="" src="{{ asset('frontend/img/instagram_icon.png') }}"></a>
                </div>
                
            </div>
        </div>
        <hr/>
    </div>
    <div class="container option-section">
        <div class="row raw-link">
            <div class="col-lg-4  col-md-4 col-sm-12 sec-1">
                <p><strong><a href="{{ route('member.register') }}">Join For Free</a></strong></p>
                <p><strong><a href="{{ route('all.editorial.board.member') }}">Editorial Board</a></strong></p>
                <p><strong><a href="{{ route('video.index') }}">Submit Your Video</a></strong></p>
                <p><strong><a href="{{ route('search.by.rvoi.link') }}">Search by RVOI link</a></strong></p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 sec-2">
                <p><strong><a href="#">Scientific Disciplines</a></strong></p>
                <ul>
                    @foreach($majorCategory_viewComposer as $majorCategory_data)
                        <li>
                            <a href="{{ route('category.wise.video',$majorCategory_data->id) }}">{{ $majorCategory_data->category_name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 sec-3">
                <p><strong><a href="{{ route('contact.us') }}">Contact Us</a></strong></p>
                <p><strong><a href="{{ route('faq') }}">Frequently Asked Questions</a></strong></p>
                <p><strong><a href="{{ route('terms.condition') }}">Terms and Conditions</a></strong></p>                
                <p><strong><a href="{{ route('site.map') }}">Site Map</a></strong></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 copy-right copyrightFontSize">
                <p class="auth_P"><strong>© 2023-2024 ResearchVideos. All rights reserved</strong></p>
            </div>
        </div>
    </div>
  </footer>
         </div>
         <!-- /.content-wrapper -->
      </div>
      <!-- /#wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
         <form action="{{ route('members.logout') }}" method="post">
         @csrf
            <div class="modal-content background_color">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <button class="btn btn-primary" type="submit">Logout</button>
               </div>
            </div>
         </form>
         </div>
      </div>
       @include('frontend.include.jsurls')
       @include('frontend.include.custom-cookie-consent')
       @include('frontend.include.custom_js')
       
       @if(Route::currentRouteName() == 'coauthors.index')
            @include('frontend.include.jsForDifferentPages.co_authors_js')
       @elseif(Route::currentRouteName() == 'my.settings')
            @include('frontend.include.jsForDifferentPages.jsForProfilePage')
        @elseif(Route::currentRouteName() == 'my.account')
            @include('frontend.include.jsForDifferentPages.js_for_my_account_page')
       @endif
       @stack('pushjs')
       
  <script type="text/javascript">
    $(document).ready(function(){
        $('.customer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1000,
            arrows: false,
            dots: false,
                pauseOnHover: false,
                responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 3
                }
            }]
        });
    });

    function successMessage(message)
    { 
        $('.successDivText').html(message);
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('.successDiv').slideDown('slow', function() {
            setTimeout(function() {
                $('.successDiv').slideUp('slow');
            }, 5000);
        });
    }
</script>
<script>
    $('.changeUserRole').on('click', function(e) {
        e.preventDefault();
        var roleId = $(this).data('role-id');
        $.ajax({
            method: 'POST',
            url: '{{ route('change.userrole') }}',
            data: {
                role_id: roleId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                
                window.location.href = "{{ route('my.account')}}";
            },
            error: function(xhr, status, error) {
                
            }
        });
    });
</script>
<script>
$(document).ready(function(){
  $("p").click(function() {
    var targetDivId = $(this).attr('data-target');
    var offset = $("#" + targetDivId).offset().top;
    var scrollPosition = offset - 80; 
    $('html, body').animate({
        scrollTop: scrollPosition
    }, 1000);
  });
});
</script>
@if(isset($user_role_id))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var userRoleId = "{{ $user_role_id }}";
        if (!userRoleId) {
            userRoleId = 'default_role_id'; 
        }
        
        var anchorElements = document.querySelectorAll(".changeUserRole");
        
        anchorElements.forEach(function(anchor) {
            if(anchor.getAttribute("data-role-id") === userRoleId) {
                anchor.style.backgroundColor = '#f44336ff';
            }
        });
    });
</script>
@endif

@if(Route::currentRouteName() == 'video.index' || Route::currentRouteName() == 'video.edit')
<script>
    $('.increaseTheImpact').hide();
</script>
@endif

{{-- Start for newsletters subscription --}}
<script type="text/javascript">
$('#reload').click(function () {
    reloadCaptcha();
});

function reloadCaptcha() 
{
    $.ajax({
        type: 'GET',
        url: '{{ route("reload.captcha") }}',
        success: function (data) {
            $(".captcha span").html(data.captcha);
        }
    });
}

if ($("#newsLetterForm").length > 0) {
    $("#newsLetterForm").validate({
        
       
        submitHandler: function(form) {
            $(".custom_error").html("");
            var formData = new FormData(form);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#newsLetterFormSubmit').html('Please Wait...');
            $("#newsLetterFormSubmit").attr("disabled", true);

            $.ajax({
                url: "{{ route('post.newsletter') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#newsLetterForm')[0].reset();
                    reloadCaptcha();
                    $('#newsletter_success_msg').html(response.success);
                    $('#newsLetterFormSubmit').html('Subscribe');
                    $("#newsLetterFormSubmit").attr("disabled", false);
                    $('#newsletter_success_msg').slideDown('slow', function() {
                        setTimeout(function() {
                            $('#newsletter_success_msg').slideUp('slow');
                        }, 5000);
                    });
                },
                error: function(xhr, status, error) {
                    var errors = JSON.parse(xhr.responseText).errors;

                    
                    $.each(errors, function(key, value) {
                        $("#" + key + "-error").html(value[0]);
                    });

                   
                        reloadCaptcha();
                    

                    $('#newsLetterFormSubmit').html('Subscribe');
                    $("#newsLetterFormSubmit").attr("disabled", false);
                }
            });
        }
    })
} 

$('#reload_video').click(function () {
    reloadCaptcha_video();
});

$('.captchaButton_video').click(function () {
    reloadCaptcha_video();
});

function reloadCaptcha_video() 
{
    $.ajax({
        type: 'GET',
        url: '{{ route("reload.captcha") }}',
        success: function (data) {
            $(".captcha_video span").html(data.captcha);
        }
    });
}
new DataTable('#example');
$(document).ready( function () {
    $('#example_history').DataTable({
        "order": [[3, "desc"]]
    });
} );

document.addEventListener("contextmenu", (e) => e.preventDefault(), false);

</script>


<script>
    $(document).ready(function() {
        var downloadInProgress = false;
        var currentVideoId = null;

       
        $('.popover-trigger').on('click', function(e) {
            e.preventDefault();
            var videoId = $(this).data('video-id');
            currentVideoId = videoId;
            $('#downloadModal').modal('show');
        });

      
        $('#confirmDownload').on('click', function() {
            if (downloadInProgress || currentVideoId === null) {
                return;
            }

            downloadInProgress = true;
            $(this).prop('disabled', true); 

            var videoId = currentVideoId;
            var url = "{{ route('export.bibtex', ':videoId') }}".replace(':videoId', videoId);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var filename = response.filename;
                    var content = response.content;

                    var blob = new Blob([content], { type: 'text/plain' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename + '.bib';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(error) {
                    console.error('Error:', error);
                },
                complete: function() {
                    downloadInProgress = false;
                    $('#confirmDownload').prop('disabled', false);
                    $('#downloadModal').modal('hide');
                }
            });
        });

        
        $('#downloadModal').on('hidden.bs.modal', function() {
            downloadInProgress = false;
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.checkbox_switch_theme').change(function () {
            
            const checkbox_switch_value = $('#checkbox_switch_theme').val();
            const themeMode = checkbox_switch_value == 'dark' ? 'light' : 'dark';
           
            $.ajax({
                type: 'GET',
                url: "{{ route('change.theme') }}",
                data: { themeMode: themeMode },
                success: function () {
                    $('#checkbox_switch_theme').val(themeMode);
                    updateCssLink(themeMode);
                   
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });

    function updateCssLink(themeMode) {
        const linkElement = document.querySelector('.theme-stylesheet');
        const  logoElement = document.querySelector('.logo-change');
        const  uploadVideoSideBar = document.querySelector('.uploadVideoSideBar');
        const  sciDiscSideBar = document.querySelector('.sciDiscSideBar');
        var videoElement_logo = document.querySelector('.autoplay-video');
        // Get the current playback state of the video
        var isVideoPlaying_logo = !videoElement_logo.paused;
        if(themeMode == 'light')
        {
            linkElement.href = `{{ asset("frontend/css/osahan-light.css") }}`;
            logoElement.src = `{{ asset('frontend/img/Logo_RV_red_on_white.webm') }}`;
            uploadVideoSideBar.src = `{{ asset('frontend/img/left_menu_icons/submit_video_icon1_dark.png') }}`;
            sciDiscSideBar.src = `{{ asset('frontend/img/left_menu_icons/sci_disci_icon2_dark.png') }}`;
        }
        else
        {
            linkElement.href = `{{ asset("frontend/css/osahan.css") }}`;
            logoElement.src = `{{ asset('frontend/img/Logo_RV_red.webm') }}`;
            uploadVideoSideBar.src = `{{ asset('frontend/img/left_menu_icons/submit_video_icon1_light.png') }}`;
            sciDiscSideBar.src = `{{ asset('frontend/img/left_menu_icons/sci_disci_icon2_light.png') }}`;
        }
        if (isVideoPlaying_logo) {
            videoElement_logo.play();
        }
    }
    $(function () {        
        $('#richTextArea_message').summernote();
    })
</script>
<script>
    window.addEventListener('load', function() {
        var lazyImages = document.querySelectorAll('.lazy');
        lazyImages.forEach(function(img) {
            img.setAttribute('src', img.getAttribute('data-src'));
            img.classList.remove('lazy');
        });

    // Get all videos with the class "autoplay-video"
      var cat_videos = document.querySelectorAll('.autoplay-video');

      // Loop through each video
      cat_videos.forEach(function(cat_video) {
         // Get the data-src attribute value which holds the actual video source
         var videoSrc = cat_video.dataset.src;
         // Set the src attribute with the actual video source
         cat_video.querySelector('source').src = videoSrc;
         // Load and autoplay the video
         cat_video.load();
         cat_video.play();
      });
    });
</script>

   </body>

</html>