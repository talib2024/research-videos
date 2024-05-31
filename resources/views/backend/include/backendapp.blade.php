<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="{{ asset('backend/dist/css/google-fonts.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
 
  <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <link href="{{ asset('frontend/css/intlTelInput.css') }}" rel="stylesheet" class="theme-stylesheet">
  <link href="{{ asset('frontend/css/bootstrap-multiselect.css') }}" rel="stylesheet" class="theme-stylesheet">  


<link href="{{ asset('frontend/css/video-js.min.css') }}" rel="stylesheet" class="theme-stylesheet">
<link href="{{ asset('frontend/css/videojs.ads.css') }}" rel="stylesheet" class="theme-stylesheet">
<link href="{{ asset('frontend/css/videojs.ima.css') }}" rel="stylesheet" class="theme-stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('backend.include.headerNavBar')
 
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('backend.include.leftSideBar')

  <!-- Content Wrapper. Contains page content -->
    @yield('content')

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>2023 - 2024 &copy; ResearchVideos</strong>
    All rights reserved.
    {{-- <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div> --}}
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> --}}
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('backend/dist/js/pages/dashboard.js') }}"></script>


<!-- DataTables  & Plugins -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>        
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-multiselect.js') }}"></script>


<script src="{{ asset('frontend/js/video.min.js') }}"></script>
<script src="{{ asset('frontend/js/ima3.js') }}"></script>
<script src="{{ asset('frontend/js/videojs.ads.min.js') }}"></script>
<script src="{{ asset('frontend/js/videojs.ima.js') }}"></script>      

@if(Route::currentRouteName() == 'adminusers.edit')
    @include('backend.include.jsForDifferentPages.jsForProfilePage')
@endif
@stack('pushjs')

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $("#example3").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

// select2

 $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  // For user create profile page and show hide based on editor
    const selectElement = document.querySelector('select[name="role_ids[]"]');
    const editorrole_div_toggle = document.querySelector('.editorrole_div');
    const majorcategory_div_toggle = document.querySelector('.majorcategory_div');
    const subcategory_div_toggle = document.querySelector('.subcategory_div');
    const highest_priority_div_toggle = document.querySelector('.highest_priority_div');
    const visible_status_div_toggle = document.querySelector('.visible_status_div');
    const editorial_board_numbering_div_toggle = document.querySelector('.editorial_board_numbering_div');

    // Define function to toggle divs based on selection
    function toggleDivs() {
        const selectedValues = Array.from(selectElement.selectedOptions, option => option.value.split('_')[0]);
        if (selectedValues.includes('3')) {
            editorrole_div_toggle.style.display = 'block';
            majorcategory_div_toggle.style.display = 'block';
            subcategory_div_toggle.style.display = 'block';
            highest_priority_div_toggle.style.display = 'block';
            visible_status_div_toggle.style.display = 'block';
            editorial_board_numbering_div_toggle.style.display = 'block';
        } else {
            editorrole_div_toggle.style.display = 'none';
            majorcategory_div_toggle.style.display = 'none';
            subcategory_div_toggle.style.display = 'none';
            highest_priority_div_toggle.style.display = 'none';
            visible_status_div_toggle.style.display = 'none';
            editorial_board_numbering_div_toggle.style.display = 'none';
        }
    }

    // Initial check
    toggleDivs();

    // Event listener for changes using select2
    $('.select2bs4').on('change', function(event) {
        toggleDivs();
    });
  //End For user create profile page and show hide based on editor


   

  })
</script>
<script>
  $(function () {
    // Summernote for rich text area
    $('#message').summernote();
  })

  $(document).ready(function() {
  $('#multiselect').multiselect({
    includeSelectAllOption : true,
  });
});
</script>
</body>
</html>
