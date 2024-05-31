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
      <style>
      #wrapper #content-wrapper .container-fluid {
         padding: 30px 30px 30px 30px;
      }
      footer.sticky-footer {
         margin-left: 0px;
      }
      </style>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
   </head>
   <body id="page-top">
      <nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top navbar_Modal">
         &nbsp;&nbsp; 
         {{-- <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
         <i class="fas fa-bars"></i>
         </button> &nbsp;&nbsp; --}}
         
         @if(session('switchtheme') == 'light')
         <a class="navbar-brand mr-0 logo-custom-anchor" href="{{ route('welcome') }}"><img class="img-fluid logo-custom logo-change" alt="" src="{{ asset('frontend/img/Logo_RV_red_on_white.gif') }}"></a>
         @else
         <a class="navbar-brand mr-0 logo-custom-anchor" href="{{ route('welcome') }}"><img class="img-fluid logo-custom logo-change" alt="" src="{{ asset('frontend/img/Logo2_RV_b.gif') }}"></a>
         @endif
         <!-- Navbar Search -->
         <form action="{{ route('post.all.search') }}" method="get" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search">
         @csrf
            <div class="input-group" style="visibility:hidden;">
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
         <!-- Navbar -->
         <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar">
            @auth
            <li class="nav-item dropdown no-arrow mx-1 changeDropdown" style="visibility:hidden;">
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
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
                  </div>
               </li>
            @else
                <li class="nav-item mx-1">
                  <a class="nav-link" href="{{ route('organization.login') }}">
                  <i class="fas fa-plus-circle fa-fw"></i>
                  Access through your Institution
                  </a>
               </li>
               <li class="nav-item mx-1">
                  <a class="nav-link" href="{{ route('member.login') }}">
                  <i class="fas fa-plus-circle fa-fw"></i>
                  Login
                  </a>
               </li>
               <li class="nav-item mx-1">
                  <a class="nav-link" href="{{ route('member.register') }}">
                  <i class="fas fa-plus-circle fa-fw"></i>
                  Join for free
                  </a>
               </li>
            @endif
         </ul>
      </nav>
      <div id="wrapper">
         <!-- Sidebar -->
        {{-- @include('frontend.include.leftSideBar') --}}
@yield('content')

<!-- Sticky Footer -->
           <footer class="sticky-footer" style="margin-top: 120px;">
   
    <div class="container option-section">
        <div class="row">
            <div class="col-12 copy-right copyrightFontSize">
                <p><strong>© 2023-2024 ResearchVideos. All rights reserved</strong></p>
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

<script type="text/javascript">
document.addEventListener("contextmenu", (e) => e.preventDefault(), false);
new DataTable('#example');
$(document).ready( function () {
    $('#rvcoins_table_history').DataTable({
        "order": [[1, "desc"]] // Replace 'your_column_index' with the index of the 'created_at' column
    });

     $('#purchase_table_history').DataTable({
        //"order": [[1, "desc"]] // Replace 'your_column_index' with the index of the 'created_at' column
    });
} );
</script>
   </body>

</html>