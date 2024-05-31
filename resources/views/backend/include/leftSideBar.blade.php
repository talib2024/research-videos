<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('frontend/img/Logo2_RV_b.gif') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: 1">
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @if(!empty(Auth::user()->profile_pic))
              <img alt="Avatar" src="{{ asset('storage/uploads/profile_image/'.Auth::user()->profile_pic) }}" class="img-circle elevation-2">
            @else
              <img alt="Avatar" src="{{ asset('frontend/img/user.png') }}" class="img-circle elevation-2">
            @endif
        </div>
        <div class="info">
          <a href="{{ route('admin.profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{ route('home') }}" class="nav-link  {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          {{-- <li class="nav-item menu-open">
            <a href="{{ route('adminusers.index') }}" class="nav-link  {{ Route::currentRouteName() == 'adminusers.index' ? 'active' : '' }} {{ Route::currentRouteName() == 'adminusers.index' ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Registered Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li> --}}
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Users 
                <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('adminusers.create') }}" class="nav-link  {{ Route::currentRouteName() == 'adminusers.create' ? 'active' : '' }} {{ Route::currentRouteName() == 'adminusers.create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create a new user</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('adminusers.index') }}" class="nav-link  {{ Route::currentRouteName() == 'adminusers.index' ? 'active' : '' }} {{ Route::currentRouteName() == 'adminusers.index' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.delete.request') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delete Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.activation.request') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Activation Request</p>
                </a>
              </li>
            </ul>
          </li>

           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Newsletter 
                <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('backendnewsletter.index') }}" class="nav-link  {{ Route::currentRouteName() == 'backendnewsletter.index' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subscribed users</p>
                </a>
              </li>             
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Payment 
                <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('all.payment.list') }}" class="nav-link  {{ Route::currentRouteName() == 'all.payment.list' ? 'active' : '' }} {{ Route::currentRouteName() == 'adminusers.edit' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All payment</p>
                </a>
              </li>
            </ul>
          </li>

           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> RVcoins category 
                <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('rvcoinsrewartype.create') }}" class="nav-link  {{ Route::currentRouteName() == 'rvcoinsrewartype.create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create reward type</p>
                </a>
              </li>             
            </ul>
          </li>

           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Scientific disciplines 
                <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('scientificdisciplines.create') }}" class="nav-link  {{ Route::currentRouteName() == 'scientificdisciplines.create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Scientific disciplines</p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="{{ route('scientificsubdisciplines.create') }}" class="nav-link  {{ Route::currentRouteName() == 'scientificsubdisciplines.create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sub disciplines</p>
                </a>
              </li>             
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Subscription 
                <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('subscriptionmaster.create') }}" class="nav-link  {{ Route::currentRouteName() == 'subscriptionmaster.create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subscription</p>
                </a>
              </li>           
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('transactionbyadmin.create') }}" class="nav-link  {{ Route::currentRouteName() == 'transactionbyadmin.create' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subscription to user</p>
                </a>
              </li>           
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p> Institute management 
                <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('all.institution.request') }}" class="nav-link  {{ Route::currentRouteName() == 'all.institution.request' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All institution request</p>
                </a>
              </li>           
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.institution') }}" class="nav-link  {{ Route::currentRouteName() == 'users.institution' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All institution users</p>
                </a>
              </li>           
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('control.institution') }}" class="nav-link  {{ Route::currentRouteName() == 'control.institution' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Control Institution</p>
                </a>
              </li>           
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('Showhidesection.index') }}" class="nav-link  {{ Route::currentRouteName() == 'Showhidesection.index' ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Show/hide section
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('video.sort.by.admin.show') }}" class="nav-link  {{ Route::currentRouteName() == 'video.sort.by.admin.show' ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Video sort by
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('video.pagination.by.admin.show') }}" class="nav-link  {{ Route::currentRouteName() == 'video.pagination.by.admin.show' ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Video pagination option
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('sort.editors.page') }}" class="nav-link  {{ Route::currentRouteName() == 'sort.editors.page' ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Sort/paging editors page
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('specialissueadmin.index') }}" class="nav-link  {{ Route::currentRouteName() == 'specialissueadmin.index' ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Special Issues
              </p>
            </a>
          </li>
        
          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Informational</p>
            </a>
          </li> --}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>