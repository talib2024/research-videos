 <style>
div.dropdown-menu{
   background-color:#232323;
}
.scrollable-menu {
        max-height: 100px; /* Adjust the maximum height as needed */
        overflow-y: auto;
    }


.checkbox_switch_theme {
  opacity: 0;
  position: absolute;
}

.checkbox_switch_theme-label {
  background-color: #111;
  width: 50px;
  height: 26px;
  border-radius: 50px;
  position: relative;
  padding: 5px;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.fa-moon {color: #f1c40f;}

.fa-sun {color: #f39c12;}

.checkbox_switch_theme-label .ball {
  background-color: #fff;
  width: 22px;
  height: 22px;
  position: absolute;
  left: 2px;
  top: 2px;
  border-radius: 50%;
  transition: transform 0.2s linear;
}

.checkbox_switch_theme:checked + .checkbox_switch_theme-label .ball {
  transform: translateX(24px);
}
.dropdown-item i:hover {
    color: #f44336ff;
    font-size:13px;
}

/* Set the color for the down arrow icon */
.toggle-dropdown i.fa-caret-down {
    color: #f44336ff;
    font-size:13px;
}
.custom-anchor {
        color: inherit; /* or specify the desired color */
        text-decoration: inherit; /* or specify the desired text decoration */
    }
.custom-anchor:hover {
        color: inherit; /* or specify the desired color */
    }
div.subCategoryMenu {
    position: absolute !important;
    top: 0%;
    left: 100% !important;
}
 </style>
 <ul class="sidebar navbar-nav">
            <li class="nav-item  {{ Route::currentRouteName() == 'about' ? 'active' : '' }}">
               <a class="nav-link" href="{{ route('about') }}">
               {{-- <i class="fas fa-fw fa-home"></i> --}}
               <img src="{{ asset('frontend/img/about.png') }}" class="img-fluid aboutSideBar" alt="About">
               <span>About</span>
               </a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'video.index' ? 'active' : '' }}">
               <a class="nav-link" href="{{ route('video.index') }}">
               {{-- <i class="fas fa-fw fa-upload"></i> --}}
               <img src="{{ session('switchtheme') == 'light' ? asset('frontend/img/left_menu_icons/submit_video_icon1_dark.png') : asset('frontend/img/left_menu_icons/submit_video_icon1_light.png') }}" class="img-fluid aboutSideBar uploadVideoSideBar" alt="About">
               <span>Submit Your Video</span>
               </a>
            </li>
   
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               {{-- <i class="fas fa-fw fa-list-ol"></i> --}}
               <img src="{{ session('switchtheme') == 'light' ? asset('frontend/img/left_menu_icons/sci_disci_icon2_dark.png') : asset('frontend/img/left_menu_icons/sci_disci_icon2_light.png') }}" class="img-fluid aboutSideBar sciDiscSideBar" alt="About">
               <span>Scientific Disciplines</span>
            </a>
            <div class="dropdown-menu">
               @foreach ($subcategoryVideos as $majorCategoryId => $categoryData)
               <div class="dropdown-item toggle-dropdown" data-target="nested-dropdown-{{ $majorCategoryId }}">
                     <a class="custom-anchor" href="{{ route('category.wise.video',$majorCategoryId) }}">{{ $categoryData['major_category_name'] }}</a>
                     &nbsp;<i class="fas fa-caret-right" style="cursor:pointer;font-size:17px;margin-left: 3px;"></i> 
               </div>
               <div class="dropdown-menu scrollable-menu subCategoryMenu" style="position: absolute !important; top: auto; left: 100% !important;" id="nested-dropdown-{{ $majorCategoryId }}">
                     @foreach ($categoryData['subcategories'] as $subcategoryId=>$subcategory)
                     <a class="dropdown-item" href="{{ route('sub.category.wise.video',$subcategoryId) }}">{{ $subcategory }}</a>
                     @endforeach
               </div>
               @endforeach
            </div>
         </li>
            <li class="nav-item {{ Route::currentRouteName() == 'all.editorial.board.member' ? 'active' : '' }}">
               <a class="nav-link" href="{{ route('all.editorial.board.member') }}">
               <i class="fas fa-fw fa-tasks"></i>
               <span>Editorial Board</span>
               </a>
            </li>
             {{-- <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-fw fa-tasks"></i>
               <span>Editorial Board</span>
               </a>
               <div class="dropdown-menu">
                  @foreach($majorCategory_viewComposer as $editorial_data)
                     <a class="dropdown-item" href="{{ route('editorial.board.wise.video',$editorial_data->id) }}">{{ $editorial_data->category_name }}</a>
                  @endforeach
               </div>
            </li> --}}

             <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-fw fa-pen"></i>
               <span>For Authors</span>
               </a>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('guide.for.authors') }}">Guide for Authors</a>
                  <a class="dropdown-item" href="{{ route('tutorials') }}">Tutorials</a>
                  <a class="dropdown-item" href="{{ route('open.science') }}">Publishing Licence Options</a>
                  <a class="dropdown-item" href="{{ route('authors.services') }}">Authors Services</a>
               </div>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'institution.register' ? 'active' : '' }}">
               <a class="nav-link" href="{{ route('institution.register') }}">
               <i class="fas fa-building"></i>
               <span>Institution Registration</span>
               </a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'special.issue' ? 'active' : '' }}">
               <a class="nav-link" href="{{ route('special.issue') }}">
               <i class="fas fa-star"></i>
               <span>Special Issues</span>
               </a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'contact.us' ? 'active' : '' }}">
               <a class="nav-link" href="{{ route('contact.us') }}">
               <i class="fa fa-address-book"></i>
               <span>Contact Us</span>
               </a>
            </li>
            @auth
            <li class="nav-item {{ Route::currentRouteName() == 'subscription' ? 'active' : '' }}">
               <a class="nav-link" href="{{ route('subscription') }}">
               <i class="fas fa-fw fa-video"></i>
               <span>Subscribe</span>
               </a>
            </li>
            @endif
            <li class="nav-item {{ Route::currentRouteName() == 'generate.video' ? 'active' : '' }}">
               <a class="nav-link" href="{{ route('generate.video') }}">
               <i class="fas fa-film"></i>
               <span>Generate My Video</span>
               </a>
            </li>
         </ul>
@push('pushjs')
 <script>
    $(document).ready(function () {
        // Use event delegation to handle icon click
        $('.dropdown-menu').on('click', '.toggle-dropdown i', function (event) {
            event.stopPropagation(); // Prevent anchor click from propagating

            var id = $(this).closest('.toggle-dropdown').data('target');
            var dropdown = $('#' + id);

            // Toggle the dropdown
            dropdown.toggle();

            // Toggle the arrow icon based on the dropdown state
            $(this).toggleClass('fa-caret-right fa-caret-down');

            // Hide other nested dropdowns
            $('[id^="nested-dropdown-"]').not(dropdown).hide();

            // Reset the icons in other dropdowns
            $('.toggle-dropdown i').not($(this)).removeClass('fa-caret-down').addClass('fa-caret-right');
        });

        // Handle anchor click
        $('.toggle-dropdown a').click(function (event) {
            // Redirect to the route
            window.location.href = $(this).attr('href');
        });
    });
</script>
@endpush