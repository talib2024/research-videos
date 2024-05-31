@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Online Publishing License Options</h6>
                        </div>
                    </div>
                    <div class="col-md-12">
                            <div class="single-video-info-content box mb-3" id="introduction">
                                    {{-- <h5 align="center">ResearchVideos: Online Publishing License Options</h5> --}}
                                <div class="member-section">
                                    <div class="member-content">
                                        <p>Authors submitting a new video to ResearchVideos must select one of the following online publishing license options:</p>
                                        <h6 class="mt-2">1. Regular Video - License Option:</h6>                                        
                                        <p class="ml-3">Authors can submit a video under the "Regular Video" license option free of charge. This license grants ResearchVideos the copyright for the published video. All videos published under the "Regular Video" license option will allow ResearchVideos to host and stream them, either free or non-free of charge for the public.</p>
                                        
                                        <h6 class="mt-2">2. Open-Access - License Option:</h6>                                        
                                        <p class="ml-3">Authors can submit a video under the "Open-Access" license option for a fee of 500 USD&dagger;, applicable only if the submitted video is accepted for publication. All videos published under the "Open-Access" license option will be accessible to all registered members free of charge. This provides authors with greater visibility in the scientific community with an increasing number of citations.</p>
                                        <p class="mt-2 ml-3">All videos published under the "Open-Access" license option will be released under the Creative Commons Attribution License (CC). </p>
                                        
                                        {{-- <p class="mt-2 ml-3"><i>*Discounts will be applicable to authors affiliated to a developing country.  To verify if a discount applies to your case, please <a href="{{ route('contact.us') }}">contact us</a> confirming your name, surname and affiliation address. List of developing countries: <a href="https://www.dfat.gov.au/sites/default/files/list-developing-countries.pdf" target="_BLANK">click here</a>.</i></p> --}}
                                        <p class="mt-2 ml-3"><i>&dagger;We are currently welcoming submissions for open-access videos at no cost.</p>
                                        
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
