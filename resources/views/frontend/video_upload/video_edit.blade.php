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

/* Start show control bar on hover */
.vjs-default-skin.vjs-has-started .vjs-control-bar {
  display: none !important;
}

.video-js:hover .vjs-control-bar {
  display: block !important;
}
.vjs-default-skin.vjs-has-started .vjs-control-bar {
  visibility: visible !important;
  opacity: 1 !important;
  height: auto !important;
  background-color: rgba(7, 20, 30, 1) !important;
}
.video-js .vjs-control {
    position: relative !important;
    text-align: center !important;
    padding: 0 !important;
    height: auto !important;
    width: auto !important;
    flex: none !important;
}
.video-js .vjs-mute-control {
    margin-left : 30px !important;
}
.video-js .vjs-volume-level {
    left: 20px !important;
}
button.vjs-play-control.vjs-control.vjs-button.vjs-paused
{
    margin-left: 6px !important;
    z-index: 999 !important;
}
button.vjs-play-control.vjs-control.vjs-button.vjs-playing
{
    margin-left: 6px !important;
    z-index: 999 !important;
}

button.vjs-play-control.vjs-control.vjs-button.vjs-paused.vjs-ended
{
    margin-left: 6px !important;
    z-index: 999 !important;
}
/* End show control bar on hover */
    </style>
    <div id="content-wrapper">
        <div class="container-fluid upload-details">
            <div class="row">
                <div class="col-lg-8">
                    <div class="main-title">
                        <h6>Uploaded Video Details</h6>
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
            </div>
            <hr>
            <form id="SubmitVideoForm" enctype="multipart/form-data">
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
                                            id="correspondingauthorname" class="form-control blackText" value="{{ $correspondingAuthor->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="correspondingauthorsurname">Surname<b class="red">*</b></label>
                                        <input type="text" name="name[3][correspondingauthorsurname][]"
                                            id="correspondingauthorsurname" class="form-control blackText" value="{{ $correspondingAuthor->surname }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="correspondingauthoraffiliation">Affiliation<b class="red">*</b></label>
                                        <input type="text" name="name[3][correspondingauthoraffiliation][]"
                                            id="correspondingauthoraffiliation" class="form-control blackText" value="{{ $correspondingAuthor->affiliation }}" readonly>
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
                            {{-- <button class="btn btn-primary add_authorDiv">Add More</button> --}}
                            <span class="max_warning_message red" style="margin-left: 10px;"></span>
                        </div>
                        <div id="authorDiv">
                        @foreach($coauthors as $author)
                            @if($author->authortype_id == '5')
                            <div class="row authorSection">
                                {{-- <div class="col-lg-1">
                                    <div class="form-group">
                                        <label for="correspondingauthorcheck">Corr. Author</label>
                                        <input type="checkbox" name="name[5][correspondingauthorcheck][]" id="correspondingauthorcheck"
                                            class="form-control correspondingAuthorcheckBox" {{ $author->authortype_id == '3' ? 'checked' : '' }} disabled>
                                    </div>
                                </div> --}}
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="authorname">Name</label>
                                        <input type="text" name="name[5][authorname][]" id="authorname"
                                            class="form-control blackText" value="{{ $author->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authorsurname">Surname</label>
                                        <input type="text" name="name[5][authorsurname][]" id="authorsurname"
                                            class="form-control blackText" value="{{ $author->surname }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authoraffiliation">Affiliation</label>
                                        <input type="text" name="name[5][authoraffiliation][]" id="authoraffiliation"
                                            class="form-control blackText" value="{{ $author->affiliation }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="coauthoremail">Email</label>
                                        <input type="text" name="name[5][coauthoremail][]" id="coauthoremail"
                                            class="form-control blackText" value="{{ $author->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authorcountry">Country</label>
                                        <select class="form-control blackText" name="name[5][authorcountry][]"
                                            id="authorcountry" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                            <option value="">Select Country</option>
                                            @foreach ($country_list as $country_list2)
                                                <option value="{{ $country_list2->id }}" {{ $country_list2->id == $author->country_id ? 'selected' : '' }} disabled>{{ $country_list2->name }}</option>
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
                            {{-- <button class="btn btn-primary add_reviewersDiv">Add More</button> --}}
                            <span class="max_warning_message_reviewer red" style="margin-left: 10px;"></span>
                        </div>

                        <div id="reviewerDiv">
                        @foreach($coauthors as $reviewer)
                            @if($reviewer->authortype_id == '4' && $reviewer->is_proposed_reviewer == '1')
                            <div class="row reviewerSection3">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="reviewername">Name<b class="red">*</b></label><span
                                            class="red"></span>
                                        <input type="text" name="name[4][reviewername][]" class="form-control blackText" value="{{ $reviewer->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="reviewersurname">Surname<b class="red">*</b></label>
                                        <input type="text" name="name[4][reviewersurname][]"
                                            class="form-control blackText" value="{{ $reviewer->surname }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="revieweraffiliation">Affiliation<b class="red">*</b></label>
                                        <input type="text" name="name[4][revieweraffiliation][]"
                                            class="form-control blackText" value="{{ $reviewer->affiliation }}" readonly>
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
                                         <select  class="form-control blackText" name="name[4][reviewercountry][]" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                            <option value="">Select Country</option>
                                            @foreach ($country_list as $country_list3)
                                                <option value="{{ $country_list3->id }}" {{ $country_list3->id == $reviewer->country_id ? 'selected' : '' }} disabled>{{ $country_list3->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                            </div>
                        <hr>

                        {{-- <div class="main-title addMoreButton">
                            <h5>Keywords</h5>
                            <button class="btn btn-primary add_keywordsDiv">Add More</button>
                            <span class="max_warning_message_keywords red" style="margin-left: 10px;"></span>
                        </div> --}}

                            <div id="keywordsDiv">
                                    <div class="keywod_section5 row">
                                @php $i = 1; @endphp
                                @foreach ($video_list->keywords as $index => $keyword)
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="keywords">Keyword {{ $i++ }}<b class="red">*</b></label>
                                                <input type="text" name="keywords[]" placeholder="Max 25 characters" id="keywords"
                                                    class="form-control blackText char-limit" value="{{ $keyword }}" data-maxlength="25">
                                            </div>
                                        </div>
                                @endforeach
                                    </div>
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
                                            data-maxlength="120" value="{{ $video_list->video_title }}" readonly>
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
                                        <select id="videosubtype_id" name="videosubtype_id" class="custom-select">
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
                                            placeholder="Max 1500 words" data-maxwords="1500" readonly>{{ $video_list->references }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="abstract">Abstract<b class="red">*</b></label>
                                        <textarea rows="3" id="abstract" name="abstract" class="form-control blackText text-limit"
                                            placeholder="Max 300 words or 1200 characters"data-maxwords="300" data-maxlength="1200"
                                            data-show-word=".word-count" data-show-char=".char-count" readonly>{{ $video_list->abstract }}</textarea>
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

                                <div class="col-lg-3 input-fix">
                                    <div class="form-group">
                                        <label for="subcategory_id">Subdisciplines<b class="red">*</b></label>
                                        <select id="subcategory_id" name="subcategory_id[]" multiple="multiple" class="custom-select subcategory_id">
                                            
                                            @foreach($subcategory_data as $subcategory_value)
                                                <option value="{{ $subcategory_value->id }}" {{ in_array($subcategory_value->id, $video_list->subcategory_id) ? 'selected' : '' }}>{{ $subcategory_value->subcategory_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="membershipplan_id">Online Publishing Licence<b
                                                class="red">*</b></label>
                                        <select id="membershipplan_id" name="membershipplan_id" class="custom-select" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                            <option value="">Select</option>
                                            @foreach ($paymentype as $paymentype_edit)
                                                <option value="{{ $paymentype_edit->id }}" {{ $paymentype_edit->id == $video_list->membershipplan_id ? 'selected' : '' }}>
                                                    {{ $paymentype_edit->plan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3 videoAmountDiv" style="display:none;">
                                    <div class="form-group">
                                        <label for="video_price">Video Amount<b class="red">*</b></label>
                                        <input type="text" id="video_price" name="video_price"
                                            class="form-control blackText" value="{{ $video_list->video_price }}">
                                    </div>
                                </div> --}}

                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-xs-12 col-12">
                                    <label for="declaration_of_interests"
                                        class="declaration_of_interests_level">Declaration
                                        of interests<b class="red">*</b></label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input"
                                            name="declaration_of_interests" id="declaration_of_interests1"
                                            value="1" {{ $video_list->declaration_of_interests1 == '1' ? 'checked' : '' }} disabled>
                                        <label class="custom-control-label common_text_size"
                                            for="declaration_of_interests1">The authors declare that they have no known
                                            competing financial interests or personal relationships
                                            that could have appeared to influence the work reported in this video.</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input"
                                            name="declaration_of_interests" id="declaration_of_interests2"
                                            value="2" {{ $video_list->declaration_of_interests1 == '2' ? 'checked' : '' }} disabled>
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
                                            placeholder="Max 150 words" data-maxwords="150" readonly>{{ $video_list->declaration_remark }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="acknowledge">Acknowledge</label>
                                        <textarea rows="3" id="acknowledge" name="acknowledge" class="form-control blackText word-limit"
                                            placeholder="Max 150 words" data-maxwords="150" readonly>{{ $video_list->acknowledge }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="acknowledge">DOI <i class="fa fa-info-circle custom-tooltip" aria-hidden="true" data-toggle="tooltip" title="If you have a published article that corresponds to your research video contents, please insert the DOI link for this Article (100 characters maximum)"></i></label>
                                        <input type="text" name="doi_link" id="doi_link" readonly value="{{ $video_list->doi_link }}" placeholder="Max 100 characters" class="form-control blackText char-limit" data-maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="video_price">Select Video<b class="red">*</b></label>
                                        <input id="vide_Upload" type="file" name="vide_Upload"
                                            style="opacity: 0; position: absolute; z-index: -1;" />
                                        <label for="vide_Upload" id="file-drag">
                                            Select a file to upload
                                            <br />OR
                                            <br />Drag a file into this box

                                            <br /><br /><span id="vide_Upload-btn" class="button">Add a video</span>
                                        </label>
                                    </div>
                                </div> --}}
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="col-xl-12 col-sm-12 mb-3 watchListDiv" id="video_list_div{{ $video_list->id }}">
                                            <div class="video-card">
                                                <div class="video-card-image">
                                                    {{-- <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a> --}}
                                                    <video id="my-videosss" class="img-fluid myVideo video-js vjs-default-skin" controls preload="auto" data-setup='{}'>
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
                                                       <b class="gray-color">{{ $video_list->category_name }}</b>  {{-- - <span class="white-clr">Subcategory</span> --}}
                                                    </div>
                                                    {{-- @include('frontend.include.video_options') --}}
                                                </div>
                                            </div>
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

                                <div class="col-lg-6 video-details">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <div id="file-details"></div>
                                        </div>
                                    </div>
                                    @if($user_role_id == '5')
                                    <a href="{{ route('download.video',$video_list->id) }}" class="btn btn-outline-primary">Download this video</a>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox terms_n_conditions_level">
                                            <input type="checkbox" class="custom-control-input" id="terms_n_conditions"
                                                name="terms_n_conditions" {{ $video_list->terms_n_conditions == '1' ? 'checked' : '' }} disabled>
                                            <label class="custom-control-label" for="terms_n_conditions">I agree to the <a
                                                    href="{{ route('terms.condition') }}" target="_BLANK"
                                                    style="color:blue;text-decoration: underline !important;">terms and
                                                    conditions</a> on behalf all authors.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        @if (
        (($check_last_record->videohistorystatus_id == '6' && $check_last_record->send_to_user_id == Auth::id()) ||
            ($check_last_record->videohistorystatus_id == '18' && $check_last_record->send_from_user_id == Auth::id()) ||
            ($check_last_record->videohistorystatus_id == '19' && $check_last_record->send_from_user_id == Auth::id()) ||
            ($check_last_record->videohistorystatus_id == '24' && $check_last_record->send_from_user_id == Auth::id())) &&
            ($user_role_id == '5')
            )
                        <div class="osahan-area text-center mt-3">
                            <a href="{{ route('video.show',$video_list->id) }}" class="btn btn-outline-primary" id="Author_form_Submit">Update this video</a>
                        </div>
                @endif
                    </div>
                </div>
            </form>
            
            <hr>
            <div class="row">
                <div class="col-lg-2">
                    <div class="main-title">
                        <h6>Video Status</h6>
                    </div>
                </div>                
            </div>
            @php               
                // Start check for editor role
                if($user_role_id == '3')
                {
                    $editor_role = DB::table('userprofiles')
                        ->select('editorrole_id')
                        ->where('user_id',Auth::id())->first();
                }
            @endphp
            @if($user_role_id == '3' && isset($editor_role) && $editor_role->editorrole_id == '1')
               @include('frontend.editor.editor_in_chief_history_page')
            @elseif($user_role_id == '3' && isset($editor_role) && $editor_role->editorrole_id == '2')
               @include('frontend.editor.editor_member_history_page')
            @elseif($user_role_id == '2')
               @include('frontend.author.author_history_page')
            @elseif($user_role_id == '4')
               @include('frontend.reviewer.reviewer_history_page')
            @elseif($user_role_id == '5')
               @include('frontend.publisher.publisher_history_page')
            @elseif($user_role_id == '7')
               @include('frontend.correspondingauthor.correspondingauthor_history_page')
            @endif
            
        </div>
        <!-- /.container-fluid -->
    @endsection
@push('pushjs')
    @if($user_role_id == '3' && isset($editor_role) && $editor_role->editorrole_id == '1')
        @include('frontend.include.jsForDifferentPages.editor_in_chief_history_page_js')
    @elseif($user_role_id == '3' && isset($editor_role) && $editor_role->editorrole_id == '2')
        {{-- @include('frontend.include.jsForDifferentPages.editor_member_history_page_js') --}}
        @include('frontend.include.jsForDifferentPages.editor_in_chief_history_page_js')
    @elseif($user_role_id == '4')
        @include('frontend.include.jsForDifferentPages.reviewer_history_page_js')
    @elseif($user_role_id == '5')
        @include('frontend.include.jsForDifferentPages.publisher_history_page_js')
    @endif

    
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