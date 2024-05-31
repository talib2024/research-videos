@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid contact-us-details">
            <div class="row">
                <div class="col-lg-2">
                    <div class="main-title">
                        <h6>Site Map</h6>
                    </div>
                </div>
            </div>
            <hr class="customHr">
            <div class="row">

                <div class="col-lg-12 ">
                    <div class="form-box-about">
                        <section id="sec1">

                            <div class="row">
                                <div class="col-md-3">
                                    <ul>
                                        <li><a href="{{ route('welcome') }}">Home</a></li>
                                        <li><a href="{{ route('about') }}">About</a></li>
                                        <li><a href="{{ route('video.index') }}">Submit Your Video</a></li>
                                        <li><a href="{{ route('institution.register') }}">Institution Registration</a></li>
                                        <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                                        <li><a href="{{ route('subscription') }}">Subscribe</a></li>
                                        <li><a href="{{ route('faq') }}">Frequently Asked Questions</a></li>
                                        <li><a href="{{ route('terms.condition') }}">Terms and Conditions</a></li>
                                        <li><a href="{{ route('member.login') }}">Login</a></li>
                                        <li><a href="{{ route('member.register') }}">Join for free</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <ul>
                                        <li><a href="#">Scientific Disciplines</a>
                                        <ul>
                                            @foreach($majorCategory_viewComposer as $majorCategory_data_sitemap)                                                
                                                <li><a href="{{ route('category.wise.video',$majorCategory_data_sitemap->id) }}">{{ $majorCategory_data_sitemap->category_name }}</a></li>
                                            @endforeach
                                        </ul>                                        
                                        </li>
                                        
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <ul>
                                        <li><a href="#">Editorial Board</a>
                                        <ul>
                                            @foreach($majorCategory_viewComposer as $editorial_data_sitemap)                                                
                                                <li><a href="{{ route('editorial.board.wise.video',$editorial_data_sitemap->id) }}">{{ $editorial_data_sitemap->category_name }}</a></li>
                                            @endforeach
                                        </ul>                                        
                                        </li>
                                        
                                    </ul>
                                </div>
                                
                                <div class="col-md-3">
                                    <ul>
                                        <li><a href="#">For Authors</a>
                                        <ul>
                                            <li><a href="{{ route('guide.for.authors') }}">Guide for Authors</a></li>
                                            <li><a href="{{ route('tutorials') }}">Tutorials</a></li>                                            
                                            <li><a href="{{ route('open.science') }}">Publishing Licence Options</a></li>
                                            <li><a href="{{ route('authors.services') }}">Authors Services</a></li>                                            
                                        </ul>                                        
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    @endsection
