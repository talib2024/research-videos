<div class="text-center mb-5 login-main-left-header pt-4 authLogo">
   <a href="{{ route('welcome') }}">
   @if(session('switchtheme') == 'light')
      <img src="{{ asset('frontend/img/rv_rotating_logo.gif') }}" class="img-fluid" alt="LOGO">
   @else
      <img src="{{ asset('frontend/img/Rotating_Logo_Dark_Gray_Background.gif') }}" class="img-fluid" alt="LOGO">
   @endif
   </a>
   <h5 class="mt-3 mb-3">Welcome to ResearchVideos</h5>
   <p class="authParaFontSize auth_P">Welcome to the Future.</p>
   @if (Route::currentRouteName() == 'organization.login')
      {{-- <h5 class="required">Institution Login</h5> --}}
   @elseif (Route::currentRouteName() == 'organization.register')
      <h5 class="required">Institution Register</h5>
   @elseif (Route::currentRouteName() == 'statictics.login')
      <h5 class="required">Statistics Login</h5>
   @elseif (Route::currentRouteName() == 'reviewer.register')
      @if(isset($decrypted_roles) && $decrypted_roles == 'Reviewer')
      <h5 class="required">Reviewer Register</h5>
      @elseif(isset($decrypted_roles) && $decrypted_roles == 'Corresponding-Author')
      <h5 class="required">Corresponding Author Register</h5>
      @elseif(isset($decrypted_roles) && $decrypted_roles == 'author')
      <h5 class="required">Author Register</h5>
      @endif
   @endif
</div>