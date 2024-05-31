@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid contact-us-details">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title">
                        <h6><b>1- A tutorial demonstrating the use of open-source tools for creating your research video</b></h6>
                    </div>
                </div>
            </div>
            <hr class="customHr">
            <div class="row">

                <div class="col-lg-12">
                    <div>
                        <div>
                            <video class="img-fluid aboutVideo" preload="auto" controls disablepictureinpicture controlsList="nodownload" onContextMenu="return false;">
                                <source src="{{ asset('frontend/img/videos/tutorial.webm') }}" type="video/mp4" class="full-video">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    @endsection
