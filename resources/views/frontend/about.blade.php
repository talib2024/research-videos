@extends('frontend.include.frontendapp')
@section('content')
    <div id="content-wrapper">
        <div class="container-fluid contact-us-details">
            <div class="row">
                <div class="col-lg-2">
                    <div class="main-title">
                        <h6>About <b>ResearchVideos</b></h6>
                    </div>
                </div>
            </div>
            <hr class="customHr">
            <div class="row">

                <div class="col-lg-12">
                    <div>
                        <div>
                            <video class="img-fluid aboutVideo" preload="auto" controls controlsList="nodownload">
                                <source src="{{ asset('frontend/img/videos/Intro_Video_Aspect_Ratio_16_to_9.mp4') }}" type="video/mp4" class="full-video">
                            </video>
                        </div>
                        <br/>
                        <div class="form-box-about">
                        <p>Welcome to <b class="changeAnchorColor"><a href="https://researchvideos.net/" target="_BLANK">ResearchVideos</a></b>, a new cutting-edge scientific research video platform developed by dedicated researchers and academics to reshape scholarly publishing in the era of the metaverse and digital revolution. </p>
                        @php
                            $count = count($majorCategory_viewComposer);
                        @endphp
                        <p><b>ResearchVideos</b> platform is committed to online publishing of high-quality, peer-reviewed scientific research <b>videos</b>, including <b>videos in 2D, 360°, and virtual reality (VR) formats</b>, spanning {{ $count }} scientific fields: 
                        
                        @foreach($majorCategory_viewComposer as  $index => $majorCategory_data_about)
                                <a href="{{ route('category.wise.video', $majorCategory_data_about->id) }}">
                                    {{ $majorCategory_data_about->category_name }}
                                </a>
                                @if($index < $count - 2)
                                    ,
                                @elseif($index == $count - 2)
                                    and
                                @endif
                        @endforeach                        
                        .</p>
                        <p>Authors can submit different types of Research Videos such as: "News and Updates Video" from 1 to 2 minutes, "Short Video" from 3 to 5 minutes, "Video Clip" from 5 to 10 minutes, "Research Video" from 10 to 15 minutes, "Tutorial Video" from 15 to 20 minutes and "Review Video" from 20 to 25 minutes. For more details on how to prepare the videos, see our <b class="changeAnchorColor"><a href="{{ route('guide.for.authors') }}" target="_BLANK">Guide For Authors</a></b>.</p>
                        <p><b>ResearchVideos</b> aims to be indexed and ranked among the top scholarly publishing platforms, and we believe that your involvement will play a pivotal role in achieving this goal.</p>
                        
                        <p>We are committed to rewarding Editors and Reviewers for their efforts and contribution to the scholarly publishing and review process. For that reason, one of the unique features of our new platform is the introduction of <b></i><a href="https://rvcoins.net/">The RVcoins Project</a></i></b>, a new <b>digital currency</b>.</p>
                        <p>By becoming a member of <b>ResearchVideos</b>, you'll join a scientific community committed to enhancing the communication of scientific research. This will broaden the dissemination of your academic research and development and boost your global scientific profile.</p>
                        <p><a href="{{ route('member.register') }}">Join <b>ResearchVideos</b> now</a>, Join the Future..</p>
                        <p><b>Online ISSN: 2997-724X</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    @endsection
