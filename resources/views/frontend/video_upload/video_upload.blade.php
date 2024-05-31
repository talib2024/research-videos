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
                <div class="col-lg-2">
                    <div class="main-title">
                        <h6>Upload Video Details</h6>
                    </div>
                </div>
                @if (session('success'))
                <div class="col-lg-10 successDiv">
                    <div class="alert alert-success" role="alert">
                        Video uploded successfully!
                    </div>
                </div>
                @endif
                <div class="col-lg-10 successDiv" style="display:none">
                    <div class="alert alert-danger errorDisplayDiv" role="alert">
                       
                    </div>
                </div>
            </div>
            <hr>
            <form id="SubmitVideoForm" enctype="multipart/form-data">
                <div class="row">


                    <div class="col-lg-12">
                        {{-- <div class="main-title">
                            <h5>First Author</h5>
                        </div>
                        <div class="row firstAuthorSection">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="firstauthorname">Name</label><span class="red"></span>
                                    <input type="text" name="name[1][firstauthorname][]" id="firstauthorname"
                                        class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="firstauthorsurname">Surname</label>
                                    <input type="text" name="name[1][firstauthorsurname][]" id="firstauthorsurname"
                                        class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="firstauthoraffiliation">Affiliation</label>
                                    <input type="text" name="name[1][firstauthoraffiliation][]"
                                        id="firstauthoraffiliation" class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="firstauthoremail">Email</label>
                                    <input type="text" name="name[1][firstauthoremail][]" id="firstauthoremail"
                                        class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select class="form-control blackText" name="name[1][firstauthorcountry][]"
                                        id="firstauthorcountry">
                                        <option value="">Select Country</option>
                                        @foreach ($country_list as $country_list1)
                                            <option value="{{ $country_list1->id }}">{{ $country_list1->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr> --}}


                        {{-- <div class="main-title addMoreButton">
                            <h5>Co-Author</h5>
                            <button class="btn btn-primary add_coAuthorDiv">Add More</button>
                        </div>
                        <div id="coAuthorDiv">
                            <div class="row coAuthorSection">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="coauthorname">Name</label><span class="red"></span>
                                        <input type="text" name="name[2][coauthorname][]" id="coauthorname"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="coauthorsurname">Surname</label>
                                        <input type="text" name="name[2][coauthorsurname][]" id="coauthorsurname"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="coauthoraffiliation">Affiliation</label>
                                        <input type="text" name="name[2][coauthoraffiliation][]" id="coauthoraffiliation"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="coauthoremail">Email</label>
                                        <input type="text" name="name[2][coauthoremail][]" id="coauthoremail"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="coauthorcountry">Country</label>
                                        <select class="form-control blackText" name="name[2][coauthorcountry][]"
                                            id="coauthorcountry">
                                            <option value="">Select Country</option>
                                            @foreach ($country_list as $country_list2)
                                                <option value="{{ $country_list2->id }}">{{ $country_list2->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr> --}}


                        <div class="main-title">
                            <h5>Corresponding Author</h5>
                        </div>
                        <div class="row correspondingAuthorSection">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="correspondingauthorname">Name<b class="red">*</b></label><span
                                        class="red"></span>
                                    <input type="text" name="name[3][correspondingauthorname][]"
                                        id="correspondingauthorname" class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="correspondingauthorsurname">Surname<b class="red">*</b></label>
                                    <input type="text" name="name[3][correspondingauthorsurname][]"
                                        id="correspondingauthorsurname" class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="correspondingauthoraffiliation">Affiliation<b class="red">*</b></label>
                                    <input type="text" name="name[3][correspondingauthoraffiliation][]"
                                        id="correspondingauthoraffiliation" class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="correspondingauthoremail">Email<b class="red">*</b></label>
                                    <input type="text" name="name[3][correspondingauthoremail][]"
                                        id="correspondingauthoremail" class="form-control blackText" value="{{ Auth::user()->email }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="correspondingauthorcountry">Country<b class="red">*</b></label>
                                    <select class="form-control blackText" name="name[3][correspondingauthorcountry][]"
                                        id="correspondingauthorcountry">
                                        <option value="">Select Country</option>
                                        @foreach ($country_list as $country_list3)
                                            <option value="{{ $country_list3->id }}">{{ $country_list3->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="main-title addMoreButton">
                            <h5>Author</h5>
                            <button class="btn btn-primary add_authorDiv">Add More</button>
                            <span class="max_warning_message red" style="margin-left: 10px;"></span>
                        </div>
                        <div id="authorDiv">
                            <div class="row authorSection">
                                {{-- <div class="col-lg-1">
                                    <div class="form-group">
                                        <label for="correspondingauthorcheck">Corr. Author <i class="fa fa-info-circle custom-tooltip" aria-hidden="true" data-toggle="tooltip" title="At least one checkbox must be selected."></i></label>
                                        <input type="checkbox" name="name[5][correspondingauthorcheck][]" id="correspondingauthorcheck"
                                            class="form-control correspondingAuthorcheckBox" checked="checked">
                                    </div>
                                </div> --}}
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="authorname">Name</label>
                                        <input type="text" name="name[5][authorname][]" id="authorname"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authorsurname">Surname</label>
                                        <input type="text" name="name[5][authorsurname][]" id="authorsurname"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authoraffiliation">Affiliation</label>
                                        <input type="text" name="name[5][authoraffiliation][]" id="authoraffiliation"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authoremail">Email</label>
                                        <input type="text" name="name[5][authoremail][]" id="authoremail"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="authorcountry">Country</label>
                                        <select class="form-control blackText" name="name[5][authorcountry][]"
                                            id="authorcountry">
                                            <option value="">Select Country</option>
                                            @foreach ($country_list as $country_list2)
                                                <option value="{{ $country_list2->id }}">{{ $country_list2->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <hr/>

                        <div class="main-title addMoreButton">
                            <h5>Proposed Reviewers</h5>
                            <button class="btn btn-primary add_reviewersDiv">Add More</button>
                            <span class="max_warning_message_reviewer red" style="margin-left: 10px;"></span>
                        </div>
                        <div class="row reviewerSection2">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="reviewername">Name<b class="red">*</b></label><span
                                        class="red"></span>
                                    <input type="text" name="name[4][reviewername][]" class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="reviewersurname">Surname<b class="red">*</b></label>
                                    <input type="text" name="name[4][reviewersurname][]"
                                        class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="revieweraffiliation">Affiliation<b class="red">*</b></label>
                                    <input type="text" name="name[4][revieweraffiliation][]"
                                        class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="revieweremail">Email<b class="red">*</b></label>
                                    <input type="text" name="name[4][revieweremail][]" class="form-control blackText">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="reviewercountry">Country<b class="red">*</b></label>
                                    <select class="form-control blackText" name="name[4][reviewercountry][]">
                                        <option value="">Select Country</option>
                                        @foreach ($country_list as $country_list3)
                                            <option value="{{ $country_list3->id }}">{{ $country_list3->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div id="reviewerDiv">
                            <div class="row reviewerSection3">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="reviewername">Name<b class="red">*</b></label><span
                                            class="red"></span>
                                        <input type="text" name="name[4][reviewername][]" class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="reviewersurname">Surname<b class="red">*</b></label>
                                        <input type="text" name="name[4][reviewersurname][]"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="revieweraffiliation">Affiliation<b class="red">*</b></label>
                                        <input type="text" name="name[4][revieweraffiliation][]"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="revieweremail">Email<b class="red">*</b></label>
                                        <input type="text" name="name[4][revieweremail][]"
                                            class="form-control blackText">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="reviewercountry">Country<b class="red">*</b></label>
                                         <select  class="form-control blackText" name="name[4][reviewercountry][]">
                                            <option value="">Select Country</option>
                                            @foreach ($country_list as $country_list3)
                                                <option value="{{ $country_list3->id }}">{{ $country_list3->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <hr>

                        <div class="main-title addMoreButton">
                            <h5>Keywords</h5>
                            <button class="btn btn-primary add_keywordsDiv">Add More</button>
                            <span class="max_warning_message_keywords red" style="margin-left: 10px;"></span>
                        </div>

                        <div id="keywordsDiv" class="row">
                            <!-- Original Section -->
                            <div class="col-lg-2 keyword-section keywod_section1">
                                <div class="form-group">
                                    <label for="keywords">Keywords 1<b class="red">*</b></label>
                                    <input type="text" name="keywords[]" placeholder="Max 25 characters" class="form-control blackText char-limit" data-maxlength="25">
                                </div>
                            </div>

                            <!-- Additional Sections (Clones) -->
                            <div class="col-lg-2 keyword-section keywod_section2">
                                <div class="form-group">
                                    <label for="keywords">Keywords 2<b class="red">*</b></label>
                                    <input type="text" name="keywords[]" placeholder="Max 25 characters" class="form-control blackText char-limit" data-maxlength="25">
                                </div>
                            </div>

                            <div class="col-lg-2 keyword-section keywod_section3">
                                <div class="form-group">
                                    <label for="keywords">Keywords 3<b class="red">*</b></label>
                                    <input type="text" name="keywords[]" placeholder="Max 25 characters" class="form-control blackText char-limit" data-maxlength="25">
                                </div>
                            </div>

                            <div class="col-lg-2 keyword-section keywod_section4">
                                <div class="form-group">
                                    <label for="keywords">Keywords 4<b class="red">*</b></label>
                                    <input type="text" name="keywords[]" placeholder="Max 25 characters" class="form-control blackText char-limit" data-maxlength="25">
                                </div>
                            </div>

                            <div class="col-lg-2 keyword-section keywod_section5">
                                <div class="form-group">
                                    <label for="keywords">Keywords 5<b class="red">*</b></label>
                                    <input type="text" name="keywords[]" placeholder="Max 25 characters" class="form-control blackText char-limit" data-maxlength="25">
                                </div>
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
                                            data-maxlength="120">
                                    </div>
                                </div>
                                 <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="videotype_id">Video Type<b class="red">*</b></label>
                                        <select id="videotype_id" name="videotype_id" class="custom-select">
                                            <option value="">Select</option>
                                            @foreach ($Videotype as $Videotype)
                                                <option value="{{ $Videotype->id }}">{{ $Videotype->video_type }}
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
                                                <option value="{{ $Videosubtype->id }}">{{ $Videosubtype->video_sub_type }}
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
                                            placeholder="Max 1500 words" data-maxwords="1500"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="abstract">Abstract<b class="red">*</b></label>
                                        <textarea rows="3" id="abstract" name="abstract" class="form-control blackText text-limit"
                                            placeholder="Max 300 words or 1200 characters" data-maxwords="300" data-maxlength="1200"
                                            data-show-word=".word-count" data-show-char=".char-count"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="majorcategory_id">Scientific Disciplines<b
                                                class="red">*</b></label>
                                        <select id="majorcategory_id" name="majorcategory_id" class="custom-select">
                                            <option value="">Select</option>
                                            @foreach ($majorcategory as $majorcategory_value)
                                                <option value="{{ $majorcategory_value->id }}">
                                                    {{ $majorcategory_value->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 subcategory_div input-fix">
                                    <div class="form-group">
                                        <label for="subcategory_id">Subdisciplines<b class="red">*</b></label><span class="red">(Select upto 3 subdisciplines)</span>
                                        <select id="subcategory_id" name="subcategory_id[]" multiple="multiple" class="custom-select subcategory_id">
                                            <option value="">Select</option>                                            
                                        </select>
                                        <span class="custom_error red" id="subcategory_id__videos-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="membershipplan_id">Online Publishing Licence<b
                                                class="red">*</b></label>
                                        <select id="membershipplan_id" name="membershipplan_id" class="custom-select">
                                            <option value="">Select</option>
                                            @foreach ($paymentype as $paymentype)
                                                <option value="{{ $paymentype->id }}">
                                                    {{ $paymentype->plan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3 videoAmountDiv" style="display:none;">
                                    <div class="form-group">
                                        <label for="video_price">Video Amount<b class="red">*</b></label>
                                        <input type="text" id="video_price" name="video_price"
                                            class="form-control blackText">
                                    </div>
                                </div> --}}

                            </div>

                            {{-- <div class="row">
<div class="col-lg-6">
<div class="form-group">
<label for="video_price">Select Co-Authors</label>
<br/>
<select multiple="multiple" name="coauthor_checkboxes[]" id="coauthor_checkboxes">
@foreach ($coauthor as $coauthor)
<option value="{{ $coauthor->id }}">{{ $coauthor->name }}</option>                                                
@endforeach
</select>
</div>
</div>
<div class="col-lg-6 video-details">
<div class="form-group">
<div class="custom-control">
<input type="hidden" name="coauthor_sequence" id="coauthor_sequence">
</div>
</div>
</div>
</div> --}}

                            <div class="row">
                                <div class="col-lg-6 col-xs-12 col-12">
                                    <label for="declaration_of_interests"
                                        class="declaration_of_interests_level">Declaration
                                        of interests<b class="red">*</b></label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input"
                                            name="declaration_of_interests" id="declaration_of_interests1"
                                            value="1">
                                        <label class="custom-control-label common_text_size"
                                            for="declaration_of_interests1">The authors declare that they have no known
                                            competing financial interests or personal relationships
                                            that could have appeared to influence the work reported in this video.</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input"
                                            name="declaration_of_interests" id="declaration_of_interests2"
                                            value="2">
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
                                            placeholder="Max 150 words" data-maxwords="150"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="acknowledge">Acknowledge</label>
                                        <textarea rows="3" id="acknowledge" name="acknowledge" class="form-control blackText word-limit"
                                            placeholder="Max 150 words" data-maxwords="150"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="acknowledge">DOI <i class="fa fa-info-circle custom-tooltip" aria-hidden="true" data-toggle="tooltip" title="If you have a published article that corresponds to your research video contents, please insert the DOI link for this Article (100 characters maximum)"></i></label>
                                        <input type="text" name="doi_link" id="doi_link" placeholder="Max 100 characters" class="form-control blackText char-limit" data-maxlength="100">
                                </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="video_price">Select Video<b class="red">*</b></label>
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
                                                name="terms_n_conditions" value="1">
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
                                            <span class="custom_error required" id="captcha_videos-error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="osahan-area text-center mt-3">
                            <button type="submit" class="btn btn-outline-primary" id="videoSubmit">Submit Your
                                Video</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.container-fluid -->
    @endsection