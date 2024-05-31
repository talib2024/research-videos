@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Authors Services</h6>
                        </div>
                    </div>
                    <div class="col-md-12">
                            <div class="single-video-info-content box mb-3" id="introduction">
                                <div class="member-section">
                                    <div class="member-content">
                                        <h6 class="mt-2">Enhanced Video and Audio File Generation Services</h6>                                        
                                        <p class="mt-2 ml-3">If you are an author seeking technical support to enhance the quality of your video and/or audio files, we have curated a list of valuable <a href="{{ route('guide.for.authors') }}?id=prepare_Your_Video">online tools</a> to aid you in meticulously preparing your content before submission to <a href="https://www.{{ $live_url }}">researchvideos.net</a>. These specialized tools are dedicated to refining your research findings into high-quality video and/or audio formats, offering competitive pricing for their services.</p>
                                                                               
                                        <p class="mt-2 ml-3">If you are utilizing an AI tool for video and audio assistance, it is essential to note that the responsibility for scientific analysis and results assessment should rest solely with the author. AI tools are best suited for tasks related to format and video/audio quality enhancement, ensuring that the core scientific content and interpretation remain the author's prerogative.</p>
                                        <p class="mt-2 ml-3">For further guidance on video preparation, you can refer to the comprehensive information available in the <a href="{{ route('guide.for.authors') }}">Guide for Authors</a> and the <a href="{{ route('tutorials') }}">Tutorial Video</a>.</p>
                                        
                                        {{-- <p class="mt-2 ml-3">Moreover, if you prefer our team to create a video based on your research findings or a published paper, feel free to <a href="{{ route('contact.us') }}">contact us</a> for additional details and guidance on the process.</p> --}}
                                        <p class="mt-2 ml-3">Furthermore, if you would like our team to produce a video based on your research findings or a published paper, please feel free to <a href="{{ route('contact.us') }}">contact us</a> for additional details and guidance on the process.</p>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
        </div>
        <!-- /.container-fluid -->
    @endsection
