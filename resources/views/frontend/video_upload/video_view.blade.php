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

        .video-details {
            padding-top: 2.5rem;
        }

        #file-drag {
            border: 2px dashed #555;
            border-radius: 7px;
            color: #555;
            cursor: pointer;
            display: block;
            font-weight: bold;
            margin: 1em 0;
            padding: 1.5em;
            text-align: center;
            transition: background 0.3s, color 0.3s;
        }

        #file-drag:hover {
            background: #161616;
        }

        #file-drag:hover,
        #file-drag.hover {
            color: #ffffff;
        }


        #vide_Upload-btn {
            margin: auto;
        }

        #vide_Upload-btn:hover {
            background: #f44336ff;
        }

        #vide_Upload-form {
            margin: auto;
            width: 40%;
        }

        progress {
            appearance: none;
            background: #eee;
            border: none;
            border-radius: 3px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25) inset;
            height: 30px;
        }

        progress[value]::-webkit-progress-value {
            background:
                -webkit-linear-gradient(-45deg,
                    transparent 33%,
                    rgba(0, 0, 0, .2) 33%,
                    rgba(0, 0, 0, .2) 66%,
                    transparent 66%),
                -webkit-linear-gradient(right,
                    #005f95,
                    #07294d);
            background:
                linear-gradient(-45deg,
                    transparent 33%,
                    rgba(0, 0, 0, .2) 33%,
                    rgba(0, 0, 0, .2) 66%,
                    transparent 66%),
                linear-gradient(right,
                    #005f95,
                    #07294d);
            background-size: 60px 30px, 100% 100%, 100% 100%;
            border-radius: 3px;
        }

        progress[value]::-moz-progress-bar {
            background:
                -moz-linear-gradient(-45deg,
                    transparent 33%,
                    rgba(0, 0, 0, .2) 33%,
                    rgba(0, 0, 0, .2) 66%,
                    transparent 66%),
                -moz-linear-gradient(right,
                    #005f95,
                    #07294d);
            background:
                linear-gradient(-45deg,
                    transparent 33%,
                    rgba(0, 0, 0, .2) 33%,
                    rgba(0, 0, 0, .2) 66%,
                    transparent 66%),
                linear-gradient(right,
                    #005f95,
                    #07294d);
            background-size: 60px 30px, 100% 100%, 100% 100%;
            border-radius: 3px;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

    </style>
    <div id="content-wrapper">
        <div class="container-fluid upload-details">
            <div class="row">
                <div class="col-lg-8">
                    <div class="main-title">
                        <h6>Update Video Details</h6>
                    </div>
                </div>
                {{-- <div class="col-lg-4" style="float:right">
                    <div class="main-title">
                        <h6>Current Video Status: <b class="required">{{ $video_list->historycurrentstatus_name }}</b> </h6>
                    </div>
                </div> --}}
                @if (session('success'))
                <div class="col-lg-10 successDiv">
                    <div class="alert alert-success" role="alert">
                       {{ Session::get('success') }}
                    </div>
                </div>
                @endif
                <div class="col-lg-10 successDiv" style="display:none">
                    <div class="alert alert-danger errorDisplayDiv" role="alert">
                       
                    </div>
                </div>
            </div>
            <hr>
            <form id="updateVideoForm" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h5>Corresponding Author</h5>
                        </div>
                         @foreach($coauthors as $correspondingAuthor)
                            @if($correspondingAuthor->authortype_id == '3')
                            <div class="row correspondingAuthorSection">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="correspondingauthorname">Name<b class="red">*</b></label><span
                                            class="red"></span>
                                        <input type="text" name="name[3][correspondingauthorname][]"
                                            id="correspondingauthorname" class="form-control blackText" value="{{ $correspondingAuthor->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="correspondingauthorsurname">Surname<b class="red">*</b></label>
                                        <input type="text" name="name[3][correspondingauthorsurname][]"
                                            id="correspondingauthorsurname" class="form-control blackText" value="{{ $correspondingAuthor->surname }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="correspondingauthoraffiliation">Affiliation<b class="red">*</b></label>
                                        <input type="text" name="name[3][correspondingauthoraffiliation][]"
                                            id="correspondingauthoraffiliation" class="form-control blackText" value="{{ $correspondingAuthor->affiliation }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="correspondingauthoremail">Email<b class="red">*</b></label>
                                        <input type="text" name="name[3][correspondingauthoremail][]"
                                            id="correspondingauthoremail" class="form-control blackText" value="{{ $correspondingAuthor->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="correspondingauthorcountry">Country<b class="red">*</b></label>
                                        <select class="form-control blackText" name="name[3][correspondingauthorcountry][]"
                                            id="correspondingauthorcountry">
                                            <option value="">Select Country</option>
                                            @foreach ($country_list as $country_list3)
                                                <option value="{{ $country_list3->id }}" {{ $country_list3->id == $correspondingAuthor->country_id ? 'selected' : '' }}>{{ $country_list3->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        <hr>
                        <div class="main-title addMoreButton">
                            <h5>Author</h5>
                            {{-- <button class="btn btn-primary add_authorDiv">Add More</button>
                            <span class="max_warning_message red" style="margin-left: 10px;"></span> --}}
                        </div>
                        <div id="authorDiv">
                        @foreach($coauthors as $author)
                            @if($author->authortype_id == '5')
                            <div class="row authorSection">
                                {{-- <div class="col-lg-1">
                                    <div class="form-group">
                                        <label for="correspondingauthorcheck">Corr. Author</label>
                                        <input type="checkbox" name="name[5][correspondingauthorcheck][]" id="correspondingauthorcheck"
                                            class="form-control correspondingAuthorcheckBox" {{ $author->authortype_id == '3' ? 'checked' : '' }} >
                                    </div>
                                </div> --}}
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="authorname">Name</label>
                                        <input type="text" name="name[5][authorname][]" id="authorname"
                                            class="form-control blackText" value="{{ $author->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authorsurname">Surname</label>
                                        <input type="text" name="name[5][authorsurname][]" id="authorsurname"
                                            class="form-control blackText" value="{{ $author->surname }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authoraffiliation">Affiliation</label>
                                        <input type="text" name="name[5][authoraffiliation][]" id="authoraffiliation"
                                            class="form-control blackText" value="{{ $author->affiliation }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authoremail">Email</label>
                                        <input type="text" name="name[5][authoremail][]" id="authoremail"
                                            class="form-control blackText" value="{{ $author->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authorcountry">Country</label>
                                        <select class="form-control blackText" name="name[5][authorcountry][]"
                                            id="authorcountry">
                                            <option value="">Select Country</option>
                                            @foreach ($country_list as $country_list2)
                                                <option value="{{ $country_list2->id }}" {{ $country_list2->id == $author->country_id ? 'selected' : '' }} >{{ $country_list2->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            @endif
                        @endforeach
                        </div>
                        <hr/>

                        <div class="main-title addMoreButton">
                            <h5>Proposed Reviewers</h5>
                            {{-- <button class="btn btn-primary add_reviewersDiv">Add More</button>
                            <span class="max_warning_message_reviewer red" style="margin-left: 10px;"></span> --}}
                        </div>

                        <div id="reviewerDiv">
                        @foreach($coauthors as $reviewer)
                            @if($reviewer->authortype_id == '4' && $reviewer->is_proposed_reviewer == '1')
                            <div class="row reviewerSection3">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="reviewername">Name<b class="red">*</b></label><span
                                            class="red"></span>
                                        <input type="text" name="name[4][reviewername][]" class="form-control blackText" value="{{ $reviewer->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="reviewersurname">Surname<b class="red">*</b></label>
                                        <input type="text" name="name[4][reviewersurname][]"
                                            class="form-control blackText" value="{{ $reviewer->surname }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="revieweraffiliation">Affiliation<b class="red">*</b></label>
                                        <input type="text" name="name[4][revieweraffiliation][]"
                                            class="form-control blackText" value="{{ $reviewer->affiliation }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="revieweremail">Email<b class="red">*</b></label>
                                        <input type="text" name="name[4][revieweremail][]"
                                            class="form-control blackText" value="{{ $reviewer->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="reviewercountry">Country<b class="red">*</b></label>
                                         <select  class="form-control blackText" name="name[4][reviewercountry][]">
                                            <option value="">Select Country</option>
                                            @foreach ($country_list as $country_list3)
                                                <option value="{{ $country_list3->id }}" {{ $country_list3->id == $reviewer->country_id ? 'selected' : '' }} >{{ $country_list3->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                            </div>
                        <hr>
                        <div class="main-title addMoreButton">
                            <h5>Keywords</h5>
                            {{-- <button class="btn btn-primary add_keywordsDiv_update">Add More</button>
                            <span class="max_warning_message_keywords red" style="margin-left: 10px;"></span> --}}
                        </div>

                            <div id="keywordsDiv_update" class="row">
                                @php $i = 1; @endphp
                                @foreach ($video_list->keywords as $index => $keyword)
                                    <div class="col-lg-2 keyword-section keywod_section{{ $index + 1 }}">
                                        <div class="form-group">
                                            <label for="keywords">Keyword {{ $i++ }}<b class="red">*</b></label>
                                            <input type="text" name="keywords[]" placeholder="Max 25 characters" class="form-control blackText char-limit" value="{{ $keyword }}" data-maxlength="25">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        <hr>


                        <div class="osahan-form">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="video_title">Video Title<b class="red">*</b></label><span
                                            class="red"></span>
                                        <input type="text" name="video_title" placeholder="Max 120 characters"
                                            id="video_title" class="form-control blackText char-limit"
                                            data-maxlength="120" value="{{ $video_list->video_title }}">
                                    </div>
                                </div>
                                 <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="videotype_id">Video Type<b class="red">*</b></label>
                                        <select id="videotype_id" name="videotype_id" class="custom-select" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                            <option value="">Select</option>
                                            @foreach ($Videotype as $Videotype)
                                                <option value="{{ $Videotype->id }}" {{ $Videotype->id == $video_list->videotype_id ? 'selected' : '' }}>{{ $Videotype->video_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                                                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="videosubtype_id">Video Sub Type<b class="red">*</b></label>
                                        <select id="videosubtype_id" name="videosubtype_id" class="custom-select" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                            <option value="">Select</option>
                                            @foreach ($Videosubtype as $Videosubtype)
                                                <option value="{{ $Videosubtype->id }}" {{ $Videosubtype->id == $video_list->videosubtype_id ? 'selected' : '' }}>{{ $Videosubtype->video_sub_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="references">References<b class="red">*</b></label>
                                        <textarea rows="3" id="references" name="references" class="form-control blackText word-limit"
                                            placeholder="Max 1500 words" data-maxwords="1500">{{ $video_list->references }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="abstract">Abstract<b class="red">*</b></label>
                                        <textarea rows="3" id="abstract" name="abstract" class="form-control blackText text-limit"
                                            placeholder="Max 300 words or 1200 characters"data-maxwords="300" data-maxlength="1200"
                                            data-show-word=".word-count" data-show-char=".char-count">{{ $video_list->abstract }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="majorcategory_id">Scientific Disciplines<b
                                                class="red">*</b></label>
                                        <select id="majorcategory_id" name="majorcategory_id" class="custom-select" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                            <option value="">Select</option>
                                            @foreach ($majorcategory as $majorcategory)
                                                <option value="{{ $majorcategory->id }}" {{ $majorcategory->id == $video_list->majorcategory_id ? 'selected' : '' }}>
                                                    {{ $majorcategory->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 input-fix" id="subcategory_div_for_slide">
                                    <div class="form-group">
                                        <label for="subcategory_id">Subdisciplines<b class="red">*</b></label><span class="red">(Select upto 3 subdisciplines)</span>
                                        <select id="subcategory_id" name="subcategory_id[]" multiple="multiple" class="custom-select subcategory_id">
                                            
                                            @foreach($subcategory_data as $subcategory_value)
                                                <option value="{{ $subcategory_value->id }}" {{ in_array($subcategory_value->id, $video_list->subcategory_id) ? 'selected' : '' }}>{{ $subcategory_value->subcategory_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="custom_error red" id="subcategory_id_video_updates-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="membershipplan_id">Online Publishing Licence<b
                                                class="red">*</b></label>
                                        <select id="membershipplan_id" name="membershipplan_id" class="custom-select">
                                            <option value="">Select</option>
                                            @foreach ($paymentype as $paymentype)
                                                <option value="{{ $paymentype->id }}" {{ $paymentype->id == $video_list->membershipplan_id ? 'selected' : '' }}>
                                                    {{ $paymentype->plan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 videoAmountDiv" style="display:none;">
                                    <div class="form-group">
                                        <label for="video_price">Video Amount<b class="red">*</b></label>
                                        <input type="text" id="video_price" name="video_price"
                                            class="form-control blackText" value="{{ $video_list->video_price }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-xs-12 col-12">
                                    <label for="declaration_of_interests"
                                        class="declaration_of_interests_level">Declaration
                                        of interests<b class="red">*</b></label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input"
                                            name="declaration_of_interests" id="declaration_of_interests1"
                                            value="1" {{ $video_list->declaration_of_interests1 == '1' ? 'checked' : '' }} >
                                        <label class="custom-control-label common_text_size"
                                            for="declaration_of_interests1">The authors declare that they have no known
                                            competing financial interests or personal relationships
                                            that could have appeared to influence the work reported in this video.</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input"
                                            name="declaration_of_interests" id="declaration_of_interests2"
                                            value="2" {{ $video_list->declaration_of_interests1 == '2' ? 'checked' : '' }} >
                                        <label class="custom-control-label common_text_size"
                                            for="declaration_of_interests2">The authors declare the following financial
                                            interests/personal relationships which may be considered
                                            as potential competing interests</label>
                                    </div>
                                </div>

                                <div class="col-lg-6 declaration_remark_div" style="display:none;">
                                    <div class="form-group">
                                        <label for="declaration_remark">Remark (Declaration of interests)<b
                                                class="red">*</b></label>
                                        <textarea rows="3" id="declaration_remark" name="declaration_remark" class="form-control blackText word-limit"
                                            placeholder="Max 150 words" data-maxwords="150">{{ $video_list->declaration_remark }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="acknowledge">Acknowledge</label>
                                        <textarea rows="3" id="acknowledge" name="acknowledge" class="form-control blackText word-limit"
                                            placeholder="Max 150 words" data-maxwords="150">{{ $video_list->acknowledge }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="acknowledge">DOI <i class="fa fa-info-circle custom-tooltip" aria-hidden="true" data-toggle="tooltip" title="If you have a published article that corresponds to your research video contents, please insert the DOI link for this Article (100 characters maximum)"></i></label>
                                        <input type="text" name="doi_link" id="doi_link" value="{{ $video_list->doi_link }}" placeholder="Max 100 characters" class="form-control blackText char-limit" data-maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">                               
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="declaration_remark">Uploaded video</label>
                                        <div class="col-xl-12 col-sm-12 mb-3 watchListDiv" id="video_list_div{{ $video_list->id }}">
                                            <div class="video-card">
                                                <div class="video-card-image">
                                                    {{-- <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a> --}}
                                                    <video id="my-video" class="img-fluid myVideo video-js" controls preload="auto" data-setup='{}'>
                                                        <source src="{{ route('video.player.show', ['filename' => $video_list->unique_number.'.m3u8','type' => 'full','video_id' => $video_list->unique_number]) }}" type="application/x-mpegURL">
                                                    </video>
                                                    <div class="overlay"
                                                        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
                                                        <p>You need to login to continue watching.</p>
                                                    </div>
                                                    <div id="overlay_counter{{ $video_list->id }}"
                                                        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
                                                        <p id="overlay_counter_msg{{ $video_list->id }}"></p>
                                                    </div>
                                                </div>
                                                <div class="video-card-body">
                                                    <div class="video-title">
                                                        <a
                                                            href="{{ route('video.edit', $video_list->id) }}">{{ $video_list->video_title }}</a>
                                                    </div>
                                                    <div class="video-page text-success">
                                                        <b class="gray-color">{{ $video_list->category_name }}</b> {{-- - <span class="white-clr">Subcategory</span> --}}
                                                    </div>
                                                    {{-- @include('frontend.include.video_options') --}}
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="video_price">Select Video</label>
                                        <input id="vide_Upload" type="file" name="vide_Upload"
                                            style="opacity: 0; position: absolute; z-index: -1;" accept="video/*" />
                                        <label for="vide_Upload" id="file-drag">
                                            Select a file to upload (Maximum allowed mp4 file size is 100 MB)
                                            <br />OR
                                            <br />Drag a file into this box

                                            <br /><br /><span id="vide_Upload-btn" class="button">Add a video</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6 video-details">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <div id="file-details"></div>
                                        </div>
                                        <div class="mt-2 spinnerLoader">
                                               <img class="img-fluid spinnerLoaderImg" src="{{ asset('frontend/img/spinner.gif') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox terms_n_conditions_level">
                                            <input type="checkbox" class="custom-control-input" id="terms_n_conditions"
                                                name="terms_n_conditions" value="1" {{ $video_list->terms_n_conditions == '1' ? 'checked' : '' }} >
                                            <label class="custom-control-label" for="terms_n_conditions">I agree to the <a
                                                    href="{{ route('terms.condition') }}" target="_BLANK"
                                                    style="color:blue;text-decoration: underline !important;">terms and
                                                    conditions</a> on behalf all authors.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Captcha</label>
                                            <div class="captcha_video">
                                                <span>{!! captcha_img() !!}</span>
                                                <button type="button" class="btn btn-danger captchaButton_video" class="reload_video" id="reload_video">
                                                        &#x21bb;
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Enter Captcha<b class="required">*</b></label><span class="required">{{ $errors->first('captcha') }}</span>
                                            <input id="captcha_video" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                            <span class="custom_error required" id="captcha_video_updates-error"></span>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    if(Session::has('loggedin_role')) {
                                    $user_role_id = Session::get('loggedin_role');
                                    } else {
                                    $user_role_id = Auth::user()->role_id;
                                    }
                                @endphp
                                @if($user_role_id == '5')
                                <div class="col-lg-6" style="display:none;">
                                    <div class="form-group">
                                        <label for="message">Message<b class="required">*</b></label>
                                        <textarea rows="3" id="message" name="message" class="form-control blackText">no need this for publisher</textarea>
                                    </div>
                                </div>
                                @else
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="message">Message<b class="required">*</b></label>
                                        <textarea rows="3" id="message" name="message" class="form-control blackText text-limit" placeholder="Max 6000 characters" data-maxlength="6000" data-show-char=".char-count"></textarea>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if($user_role_id == '5' || $user_role_id == '7')
                        <div class="osahan-area text-center mt-3">
                            <button type="submit" class="btn btn-outline-primary" id="videoUpdate">Update Your
                                Video</button>
                        </div>
                        @endif
                    </div>
                </div>
            </form>            
        </div>
        <!-- /.container-fluid -->
    @endsection

    @push('pushjs')
<script>
$(document).ready(function () {
    // Initialize Bootstrap Multiselect
    $('.subcategory_id').multiselect({ buttonWidth: '160px' });

    // Add event listener to limit selection to 3
    $('.subcategory_id').on('change', function () {
        var selectedOptions = $('.subcategory_id option:selected:not([value=""])');

        if (selectedOptions.length > 3) {
            // Deselect the last option if more than 3 are selected
            selectedOptions.last().prop('selected', false);
        }

        // Disable remaining options excluding the "Select" option
        $('.subcategory_id option:not(:selected)').not('[value=""]').prop('disabled', selectedOptions.length >= 3);

        // Rebuild the multiselect to reflect the change
        $('.subcategory_id').multiselect('rebuild');
    });

    // Set the initial selected options if you have them (replace [1, 2, 3] with your actual values)
    var initialSelectedOptions = {!! json_encode($video_list->subcategory_id) !!};
    $('.subcategory_id').val(initialSelectedOptions).change();
});

</script>
    @endpush
