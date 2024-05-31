@extends('backend.include.backendapp')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Uploaded Video Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('adminusers.index') }}">Users</a></li>
                            <li class="breadcrumb-item active">Uploaded Video Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        {{-- <h3 class="card-title">Send message</h3> --}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="main-title">
                                    <h5>Corresponding Author</h5>
                                </div>
                                @foreach ($coauthors as $correspondingAuthor)
                                    @if ($correspondingAuthor->authortype_id == '3')
                                        <div class="row correspondingAuthorSection">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="correspondingauthorname">Name<b
                                                            class="red">*</b></label><span class="red"></span>
                                                    <input type="text" name="name[3][correspondingauthorname][]"
                                                        id="correspondingauthorname" class="form-control blackText"
                                                        value="{{ $correspondingAuthor->name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="correspondingauthorsurname">Surname<b
                                                            class="red">*</b></label>
                                                    <input type="text" name="name[3][correspondingauthorsurname][]"
                                                        id="correspondingauthorsurname" class="form-control blackText"
                                                        value="{{ $correspondingAuthor->surname }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="correspondingauthoraffiliation">Affiliation<b
                                                            class="red">*</b></label>
                                                    <input type="text" name="name[3][correspondingauthoraffiliation][]"
                                                        id="correspondingauthoraffiliation" class="form-control blackText"
                                                        value="{{ $correspondingAuthor->affiliation }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="correspondingauthoremail">Email<b
                                                            class="red">*</b></label>
                                                    <input type="text" name="name[3][correspondingauthoremail][]"
                                                        id="correspondingauthoremail" class="form-control blackText"
                                                        value="{{ $correspondingAuthor->email }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="correspondingauthorcountry">Country<b
                                                            class="red">*</b></label>
                                                    <select class="form-control blackText"
                                                        name="name[3][correspondingauthorcountry][]"
                                                        id="correspondingauthorcountry">
                                                        <option value="">Select Country</option>
                                                        @foreach ($country_list as $country_list3)
                                                            <option value="{{ $country_list3->id }}"
                                                                {{ $country_list3->id == $correspondingAuthor->country_id ? 'selected' : '' }}>
                                                                {{ $country_list3->name }}</option>
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
                                    @foreach ($coauthors as $author)
                                        @if ($author->authortype_id == '5')
                                            <div class="row authorSection">
                                                
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="authorname">Name</label>
                                                        <input type="text" name="name[5][authorname][]" id="authorname"
                                                            class="form-control blackText" value="{{ $author->name }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="authorsurname">Surname</label>
                                                        <input type="text" name="name[5][authorsurname][]"
                                                            id="authorsurname" class="form-control blackText"
                                                            value="{{ $author->surname }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="authoraffiliation">Affiliation</label>
                                                        <input type="text" name="name[5][authoraffiliation][]"
                                                            id="authoraffiliation" class="form-control blackText"
                                                            value="{{ $author->affiliation }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="coauthoremail">Email</label>
                                                        <input type="text" name="name[5][coauthoremail][]"
                                                            id="coauthoremail" class="form-control blackText"
                                                            value="{{ $author->email }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="authorcountry">Country</label>
                                                        <select class="form-control blackText"
                                                            name="name[5][authorcountry][]" id="authorcountry"
                                                            onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                                            <option value="">Select Country</option>
                                                            @foreach ($country_list as $country_list2)
                                                                <option value="{{ $country_list2->id }}"
                                                                    {{ $country_list2->id == $author->country_id ? 'selected' : '' }}
                                                                    disabled>{{ $country_list2->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr />

                                <div class="main-title addMoreButton">
                                    <h5>Proposed Reviewers</h5>
                                    {{-- <button class="btn btn-primary add_reviewersDiv">Add More</button> --}}
                                    <span class="max_warning_message_reviewer red" style="margin-left: 10px;"></span>
                                </div>

                                <div id="reviewerDiv">
                                    @foreach ($coauthors as $reviewer)
                                        @if ($reviewer->authortype_id == '4' && $reviewer->is_proposed_reviewer == '1')
                                            <div class="row reviewerSection3">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="reviewername">Name<b class="red">*</b></label><span
                                                            class="red"></span>
                                                        <input type="text" name="name[4][reviewername][]"
                                                            class="form-control blackText" value="{{ $reviewer->name }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="reviewersurname">Surname<b
                                                                class="red">*</b></label>
                                                        <input type="text" name="name[4][reviewersurname][]"
                                                            class="form-control blackText"
                                                            value="{{ $reviewer->surname }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="revieweraffiliation">Affiliation<b
                                                                class="red">*</b></label>
                                                        <input type="text" name="name[4][revieweraffiliation][]"
                                                            class="form-control blackText"
                                                            value="{{ $reviewer->affiliation }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="revieweremail">Email<b class="red">*</b></label>
                                                        <input type="text" name="name[4][revieweremail][]"
                                                            class="form-control blackText" value="{{ $reviewer->email }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="reviewercountry">Country<b
                                                                class="red">*</b></label>
                                                        <select class="form-control blackText"
                                                            name="name[4][reviewercountry][]"
                                                            onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                                            <option value="">Select Country</option>
                                                            @foreach ($country_list as $country_list3)
                                                                <option value="{{ $country_list3->id }}"
                                                                    {{ $country_list3->id == $reviewer->country_id ? 'selected' : '' }}
                                                                    disabled>{{ $country_list3->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr>

                                <div id="keywordsDiv">
                                    <div class="keywod_section5 row">
                                        @php $i = 1; @endphp
                                        @foreach ($video_list->keywords as $index => $keyword)
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="keywords">Keyword {{ $i++ }}<b
                                                            class="red">*</b></label>
                                                    <input type="text" name="keywords[]"
                                                        placeholder="Max 25 characters" id="keywords"
                                                        class="form-control blackText char-limit"
                                                        value="{{ $keyword }}" data-maxlength="25">
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
                                                <select id="videotype_id" name="videotype_id" class="custom-select"
                                                    onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                                    <option value="">Select</option>
                                                    @foreach ($Videotype as $Videotype)
                                                        <option value="{{ $Videotype->id }}"
                                                            {{ $Videotype->id == $video_list->videotype_id ? 'selected' : '' }}>
                                                            {{ $Videotype->video_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="videosubtype_id">Video Sub Type<b class="red">*</b></label>
                                                <select id="videosubtype_id" name="videosubtype_id"
                                                    class="custom-select">
                                                    <option value="">Select</option>
                                                    @foreach ($Videosubtype as $Videosubtype)
                                                        <option value="{{ $Videosubtype->id }}"
                                                            {{ $Videosubtype->id == $video_list->videosubtype_id ? 'selected' : '' }}>
                                                            {{ $Videosubtype->video_sub_type }}
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
                                                <select id="majorcategory_id" name="majorcategory_id"
                                                    class="custom-select"
                                                    onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                                    <option value="">Select</option>
                                                    @foreach ($majorcategory as $majorcategory)
                                                        <option value="{{ $majorcategory->id }}"
                                                            {{ $majorcategory->id == $video_list->majorcategory_id ? 'selected' : '' }}>
                                                            {{ $majorcategory->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 input-fix">
                                            <div class="form-group">
                                                <label for="subcategory_id">Subdisciplines<b class="red">*</b></label>
                                                <select id="subcategory_id" name="subcategory_id[]" multiple="multiple"
                                                    class="select2bs4 custom-select subcategory_id">

                                                    @foreach ($subcategory_data as $subcategory_value)
                                                        <option value="{{ $subcategory_value->id }}"
                                                            {{ in_array($subcategory_value->id, $video_list->subcategory_id) ? 'selected' : '' }}>
                                                            {{ $subcategory_value->subcategory_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="membershipplan_id">Online Publishing Licence<b
                                                        class="red">*</b></label>
                                                <select id="membershipplan_id" name="membershipplan_id"
                                                    class="custom-select"
                                                    onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                                    <option value="">Select</option>
                                                    @foreach ($paymentype as $paymentype_edit)
                                                        <option value="{{ $paymentype_edit->id }}"
                                                            {{ $paymentype_edit->id == $video_list->membershipplan_id ? 'selected' : '' }}>
                                                            {{ $paymentype_edit->plan }}</option>
                                                    @endforeach
                                                </select>
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
                                                    value="1"
                                                    {{ $video_list->declaration_of_interests1 == '1' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="custom-control-label common_text_size"
                                                    for="declaration_of_interests1">The authors declare that they have no
                                                    known
                                                    competing financial interests or personal relationships
                                                    that could have appeared to influence the work reported in this
                                                    video.</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input"
                                                    name="declaration_of_interests" id="declaration_of_interests2"
                                                    value="2"
                                                    {{ $video_list->declaration_of_interests1 == '2' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="custom-control-label common_text_size"
                                                    for="declaration_of_interests2">The authors declare the following
                                                    financial
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
                                                <label for="acknowledge">DOI <i class="fa fa-info-circle custom-tooltip"
                                                        aria-hidden="true" data-toggle="tooltip"
                                                        title="If you have a published article that corresponds to your research video contents, please insert the DOI link for this Article (100 characters maximum)"></i></label>
                                                <input type="text" name="doi_link" id="doi_link" readonly
                                                    value="{{ $video_list->doi_link }}" placeholder="Max 100 characters"
                                                    class="form-control blackText char-limit" data-maxlength="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="col-xl-12 col-sm-12 mb-3 watchListDiv"
                                                    id="video_list_div{{ $video_list->id }}">
                                                    <div class="video-card">
                                                        <div class="video-card-image">
                                                            {{-- <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a> --}}
                                                            <video id="my-videosss"
                                                                class="img-fluid myVideo video-js vjs-default-skin"
                                                                controls preload="auto" data-setup='{}'>
                                                                <source
                                                                    src="{{ route('video.player.show', ['filename' => $video_list->unique_number . '.m3u8', 'type' => 'full', 'video_id' => $video_list->unique_number]) }}"
                                                                    type="application/x-mpegURL">
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
                                                                <a>{{ $video_list->video_title }}</a>
                                                            </div>
                                                            <div class="video-page video-title">
                                                                <b class="gray-color">{{ $video_list->category_name }}</b>
                                                                {{-- - <span class="white-clr">Subcategory</span> --}}
                                                            </div>
                                                            {{-- @include('frontend.include.video_options') --}}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-6 video-details">
                                            <div class="form-group">
                                                <div class="custom-control">
                                                    <div id="file-details"></div>
                                                </div>
                                            </div>
                                            <a href="{{ route('download.video.admin', $video_list->id) }}"
                                                class="btn btn-outline-primary">Download this video</a>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox terms_n_conditions_level">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="terms_n_conditions" name="terms_n_conditions"
                                                        {{ $video_list->terms_n_conditions == '1' ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="custom-control-label" for="terms_n_conditions">I agree
                                                        to the <a href="{{ route('terms.condition') }}" target="_BLANK"
                                                            style="color:blue;text-decoration: underline !important;">terms
                                                            and
                                                            conditions</a> on behalf all authors.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.row -->
                @include('backend.include.history')
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
