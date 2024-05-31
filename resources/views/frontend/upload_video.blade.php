@extends('frontend.include.frontendapp')
@section('content')
        
         <div id="content-wrapper">
            <div class="container-fluid pt-5 pb-5">
               <div class="row">
                  <div class="col-md-8 mx-auto text-center upload-video pt-5 pb-5">
                     <h1><i class="fas fa-file-upload text-primary"></i></h1>
                     <h4 class="mt-5">Select Video files to upload</h4>
                     <p class="land">or drag and drop video files</p>
                     <div class="mt-4">
                        <a class="btn btn-outline-primary" href="#">Submit Your Video</a>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.container-fluid -->      
@endsection