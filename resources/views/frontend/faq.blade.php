@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid pb-0">
            <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-title">
                            <h6>Frequently Asked Questions</h6>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="single-video-info-content box mb-3" id="introduction">
                            <div class="member-section">
                                <div class="member-content">
                                    <div id="main">
                                        <div class="container">
                                            <div class="accordion" id="faq">
                                                <div class="card">
                                                    <div class="card-header" id="faqhead1">
                                                        {{-- <a href="#" class="btn btn-header-link" data-toggle="collapse"
                                                            data-target="#faq1" aria-expanded="true"
                                                            aria-controls="faq1">FAQ1: What is the status of my submitted videos?</a> --}}
                                                            <a href="{{ asset('frontend/img/faq/Reply_to_FAQ1.pdf') }}" target="_BLANK" class="btn btn-header-link">FAQ1: What is the status of my submitted videos?</a>
                                                    </div>

                                                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1"
                                                        data-parent="#faq">
                                                        <div class="card-body">
                                                            To inquire about the status of your submitted videos, log in to your "Author" account. Navigate to the "My Videos" section and click on the eye symbol in the row corresponding to the video you wish to check. This action will prompt a new table to appear under "Video Status," providing detailed information about the video's status.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="faqhead2">
                                                        <a href="{{ asset('frontend/img/faq/Reply_to_FAQ2.pdf') }}" target="_BLANK" class="btn btn-header-link">FAQ2: Choose a subscription plan?</a>
                                                    </div>

                                                    <div id="faq2" class="collapse show" aria-labelledby="faqhead2"
                                                        data-parent="#faq">
                                                        <div class="card-body">
                                                            <p>Once you've signed in as a member, locate your profile photo in the top right corner. Click on it to reveal a drop-down list. From there, select "Subscriptions" to access the page displaying the various subscription plans.</p>
                                                            <p>A reduced rate will be granted to individuals who are members of countries classified as developing, as outlined in the provided list.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="faqhead3">
                                                        <a href="{{ asset('frontend/img/faq/Reply_to_FAQ3.pdf') }}" target="_BLANK" class="btn btn-header-link">FAQ3: Update my profile and upload a photo? </a>
                                                    </div>

                                                    <div id="faq3" class="collapse show" aria-labelledby="faqhead3"
                                                        data-parent="#faq">
                                                        <div class="card-body">
                                                            Once you've signed in as a member, locate your profile photo in the top right corner. Click on it to reveal a drop-down list. From there, select "Profile" to access the page displaying the member profile information. Under “Profile photo” select “Browse” to upload a file. Add if there are restrictions to the photo size…
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="faqhead4">
                                                        <a href="{{ asset('frontend/img/faq/Reply_to_FAQ4.pdf') }}" target="_BLANK" class="btn btn-header-link collapsed">FAQ4: Verify received RVcoins and total balance? </a>
                                                    </div>

                                                    <div id="faq4" class="collapse show" aria-labelledby="faqhead4"
                                                        data-parent="#faq">
                                                        <div class="card-body">
                                                            <p>Once you've signed in as a member, locate your profile photo in the top right corner. Click on it to reveal a drop-down list. From there, select "Profile" to access the page displaying the member profile information. Under “Wallet ID” select the wallet ID address which will prompt a new page displaying the “Total Balance RVcoins” and the “Received RVcoins” along with other information.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="faqhead5">
                                                        <a href="#" class="btn btn-header-link collapsed">FAQ5: How to prepare my video before online submission?  </a>
                                                    </div>

                                                    <div id="faq5" class="collapse show" aria-labelledby="faqhead5"
                                                        data-parent="#faq">
                                                        <div class="card-body">
                                                            <p>Read our <a href="{{ route('guide.for.authors') }}">Guide for Authors</a>.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="faqhead6">
                                                        <a href="#" class="btn btn-header-link collapsed">FAQ6: What are the license publishing options?  </a>
                                                    </div>

                                                    <div id="faq6" class="collapse show" aria-labelledby="faqhead6"
                                                        data-parent="#faq">
                                                        <div class="card-body">
                                                            <p>Navigate to the "For Authors" section in the left main menu. Click on "Publishing License Options," and this will direct you to a new page providing detailed information about the various publishing options available.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="faqhead7">
                                                        <a href="#" class="btn btn-header-link collapsed">FAQ7: Find a published video by its RVOI ID?  </a>
                                                    </div>

                                                    <div id="faq7" class="collapse show" aria-labelledby="faqhead7"
                                                        data-parent="#faq">
                                                        <div class="card-body">
                                                            <p>Refer to the <a href="{{ route('search.by.rvoi.link') }}">“Search by RVOI link”</a>.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

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
