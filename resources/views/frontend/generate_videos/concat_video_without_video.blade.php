@extends('frontend.include.frontendapp')
@section('content')
    <style>
        .button {
            background: #1c1c1c;
            border: none;
            border-radius: 3px;
            color: white;
            display: inline-block;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.02em;
            padding: 10px 10px;
            text-align: center;
            text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.75);
            text-decoration: none;
            text-transform: uppercase;
            transition: all 0.2s;
        }
    </style>
    <div id="content-wrapper">
        <div class="container-fluid upload-details">
            <div class="row">
                <div class="col-lg-2">
                    <div class="main-title">
                        <h6>Generate My Video.</h6>
                    </div>
                </div>
                @if (session('error'))
                <div class="col-lg-10 errorDiv">
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('error') }}
                    </div>
                </div>
                @endif
                <div class="col-lg-10" id="successDiv" style="display:none;">
                    <div class="alert alert-success" role="alert">
                        Video generated successfully!
                    </div>
                </div>
                <div class="col-lg-10 successDiv" style="display:none">
                    <div class="alert alert-danger errorDisplayDiv" role="alert">

                    </div>
                </div>
            </div>
            <hr>
            <form id="SubmitVideoGenerateForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Audio Section -->
                                <div class="main-title addMoreButton">
                                    <h5>Video Files</h5>
                                    <button class="btn btn-primary add_video_section">Add More</button>
                                    <span class="max_warning_message_video red" style="margin-left: 10px;"></span>
                                </div>
                                <div id="video-section">
                                    <div class="row video-group mb-3">
                                        <div class="col-lg-3">
                                            <input type="file" name="video_files[]" class="form-control error" id="video_file_id_1">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" name="video_order[]" class="form-control error" placeholder="Order Number" id="video_order_id_1">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" name="video_duration[]" class="form-control error" placeholder="Duration (seconds)" id="video_duration_id_1">
                                        </div>
                                    </div>
                                </div>
                            <hr />

                        <!-- Image Section -->
                                <div class="main-title addMoreButton">
                                    <h5>Image Files</h5>
                                    <button class="btn btn-primary add_image_section">Add More</button>
                                    <span class="max_warning_message_image red" style="margin-left: 10px;"></span>
                                </div>
                                <div id="image-section">
                                    <div class="row image-group mb-3">
                                        <div class="col-lg-3">
                                            <input type="file" name="image_files[]" class="form-control" id="image_file_id_1">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" name="image_order[]" class="form-control" placeholder="Order Number" id="image_order_id_1">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" name="image_duration[]" class="form-control" placeholder="Duration (seconds)" id="image_duration_id_1">
                                        </div>
                                    </div>
                                </div>
                            <hr />

                        <!-- Text Section -->
                                <div class="main-title addMoreButton">
                                    <h5>Text Files</h5>
                                    <button class="btn btn-primary add_text_section">Add More</button>
                                    <span class="max_warning_message_text red" style="margin-left: 10px;"></span>
                                </div>
                                <div id="text-section">
                                    <div class="row text-group mb-3">
                                        <div class="col-lg-3">
                                            <input type="file" name="text_files[]" class="form-control text_filess" id="text_file_id_1">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" name="text_order[]" class="form-control" placeholder="Order Number" id="text_order_id_1">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" name="text_duration[]" class="form-control" placeholder="Duration (seconds)" id="text_duration_id_1">
                                        </div>
                                    </div>
                                </div>
                            <hr />

                        <!-- Audio Section -->
                                <div class="main-title addMoreButton">
                                    <h5>Audio Files</h5>
                                    <button class="btn btn-primary add_audio_section">Add More</button>
                                    <span class="max_warning_message_audio red" style="margin-left: 10px;"></span>
                                </div>
                                <div id="audio-section">
                                    <div class="row audio-group mb-3">
                                        <div class="col-lg-3">
                                            <input type="file" name="audio_files[]" class="form-control" id="audio_file_id_1">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" name="audio_order[]" class="form-control" placeholder="Order Number" id="audio_order_id_1">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" name="audio_duration[]" class="form-control" placeholder="Duration (seconds)" id="audio_duration_id_1">
                                        </div>
                                    </div>
                                </div>
                            <hr />
                     

                        <div class="osahan-area text-center mt-3">
                            <button type="submit" class="btn btn-outline-primary" id="videoGenerate">Generate
                                Video</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.container-fluid -->
    @endsection
@push('pushjs')
    @include('frontend.include.jsForDifferentPages.concat_video_without_video_page_js')  

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
@endpush
