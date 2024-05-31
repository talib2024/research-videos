<!-- Favicon Icon -->
      <link rel="icon" type="image/png" href="img/favicon.png">
      <!-- Bootstrap core CSS-->
      <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <!-- Custom fonts for this template-->
      <link href="{{ asset('frontend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
      <!-- Custom styles for this template-->
      @if(session('switchtheme') == 'light')
      <link href="{{ asset('frontend/css/osahan-light.css') }}" rel="stylesheet" class="theme-stylesheet">
      @else
      <link href="{{ asset('frontend/css/osahan.css') }}" rel="stylesheet" class="theme-stylesheet">
      @endif
      <!-- Owl Carousel -->
      <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.carousel.css') }}">
      <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.theme.css') }}">

      
      <link rel="stylesheet" href="{{ asset('frontend/footer/carousel.css') }}">
       <!-- Select2 -->
 @if (Route::currentRouteName() != 'welcome')      
  <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <link href="{{ asset('frontend/css/intlTelInput.css') }}" rel="stylesheet" class="theme-stylesheet">
  <link href="{{ asset('frontend/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/css/bootstrap-multiselect.css') }}" rel="stylesheet" class="theme-stylesheet">
 <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">
@endif

<link href="{{ asset('frontend/css/video-js.min.css') }}" rel="stylesheet" class="theme-stylesheet">
<link href="{{ asset('frontend/css/videojs.ads.css') }}" rel="stylesheet" class="theme-stylesheet">
<link href="{{ asset('frontend/css/videojs.ima.css') }}" rel="stylesheet" class="theme-stylesheet">