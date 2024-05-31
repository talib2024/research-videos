@extends('frontend.include.frontendapp')
@section('content')
   
         <div id="content-wrapper">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-8 mx-auto text-center  pt-4 pb-5">
                     <h1><img alt="404" src="{{ asset('frontend/img/404.png') }}" class="img-fluid"></h1>
                     <h1>Sorry! Page not found.</h1>
                     <p class="land">Unfortunately the page you are looking for has been moved or deleted.</p>
                     <div class="mt-5">
                        <a class="btn btn-outline-primary" href="{{ route('welcome') }}"><i class="mdi mdi-home"></i> GO TO HOME PAGE</a>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.container-fluid -->

@endsection