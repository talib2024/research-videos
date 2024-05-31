<script>
    var isUserLoggedIn = "{{ auth()->check() ? true : false }}";
</script>
@if (Route::currentRouteName() == 'welcome' ||
        Route::currentRouteName() == 'video.details' ||
        Route::currentRouteName() == 'watch.list' ||
        Route::currentRouteName() == 'category.wise.video' ||
        Route::currentRouteName() == 'sub.category.wise.video' ||
        Route::currentRouteName() == 'editorial.board.wise.video' ||
        Route::currentRouteName() == 'post.advance.search' ||
        Route::currentRouteName() == 'post.all.search' ||
        Route::currentRouteName() == 'watch.list.sorting' ||
        Route::currentRouteName() == 'category.wise.video.sorting' ||
        Route::currentRouteName() == 'sub.category.wise.video.sorting' ||
        Route::currentRouteName() == 'welcome.sorting')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videos = document.querySelectorAll('.myVideo');
            let playing = [];

            videos.forEach((video, index) => {
                const overlay = document.querySelectorAll('.overlay')[index];
                const freeoverlay = document.querySelectorAll('.freeoverlay')[index];
                const paymentoverlay = document.querySelectorAll('.paymentoverlay')[index];

                // Create a single player instance for each video
                const player = videojs(video.id);

                /*var options = {
                    id: 'content_video', // Use the correct ID for each video element
                    adTagUrl: 'http://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/ad_rule_samples&ciu_szs=300x250&ad_rule=1&impl=s&gdfp_req=1&env=vp&output=xml_vmap1&unviewed_position_start=1&cust_params=sample_ar%3Dpremidpostpod%26deployment%3Dgmf-js&cmsid=496&vid=short_onecue&correlator='
                };*/

                //player.ima(options);

                video.addEventListener('ended', function() {
                    // Handle video conditions after it finishes
                    handleVideoConditions(video, overlay, freeoverlay, paymentoverlay);
                });

                video.onplay = function() {
                    playing.push(video);
                    if (!video.paused) {
                        video.controls = true;
                        // Trigger an AJAX request to register the view
                        registerView(video);
                    }
                };
            });

            function handleVideoConditions(video, overlay, freeoverlay, paymentoverlay) {
                const isShortVideo = video.querySelector('.short-video');
                const isFullVideo = video.querySelector('.full-video');
                const membershipplan_value = video.getAttribute('data-membershipplan-id');
                if (!isUserLoggedIn && isShortVideo && membershipplan_value == 1) {
                    overlay.style.display = 'block';
                } else if (!isUserLoggedIn && isShortVideo && membershipplan_value == 2) {
                    freeoverlay.style.display = 'block';
                } else if (isUserLoggedIn && isShortVideo) {
                    paymentoverlay.style.display = 'block';
                }
            }

            async function registerView(video) {
                const videoId = video.getAttribute('data-video-id');
                const response = await fetch(`{{ route('video.registerView', ['videoId' => ':videoId']) }}`
                    .replace(':videoId', videoId));
                const data = await response.json();
                $('#videoview' + data.id).html(data.view_count);
            }

        });
    </script>

    {{-- Start upload video js --}}
@elseif(Route::currentRouteName() == 'my.settings' ||
        Route::currentRouteName() == 'video.index' ||
        Route::currentRouteName() == 'video.edit' ||
        Route::currentRouteName() == 'video.show')
    <script>
        // Start at the view or update the uploaded video
        /*const membershipplan_id_value = "{{ isset($video_list->membershipplan_id) ? $video_list->membershipplan_id : '' }}";
        if(membershipplan_id_value == 1)
        {
        $(".videoAmountDiv").show();
        }
        else 
        {
        $(".videoAmountDiv").hide();
        }*/
        const declaration_of_interests1_value =
            "{{ isset($video_list->declaration_of_interests1) ? $video_list->declaration_of_interests1 : '' }}";
        declaration_of_interests1_value == 1 ? $(".declaration_remark_div").hide() : $(".declaration_remark_div")
            .show();
        // End at the view or update the uploaded video

        $("input[name=declaration_of_interests]").change(function() {
            const declaration_of_interests = $(this).val();
            declaration_of_interests == 1 ? $(".declaration_remark_div").hide() : $(".declaration_remark_div")
                .show();
        });
        /*$('#membershipplan_id').on('change', function() {
        if (this.value == '1') {
        $(".videoAmountDiv").show();
        } else {
        $(".videoAmountDiv").hide();
        }
        });*/

        // charector count
        $('.char-limit').on('input', function() {
            var max_length = $(this).data('maxlength');
            var text = $(this).val().replace(/\s/g, ''); // Remove all spaces from the input text
            var text_length = text.length;
            if (text_length > max_length) {
                var trimmed_text = text.substr(0, max_length); // Trim the text to the maximum length
                $(this).val(trimmed_text);
                text_length = max_length;
            }
            var remaining_length = max_length - text_length;
            if (max_length === 120) {
                $(this).next('.remaining-count1').text(remaining_length >= 0 ? remaining_length : 0);
            } else if (max_length === 1200) {
                $(this).next('.remaining-count2').text(remaining_length >= 0 ? remaining_length : 0);
            } else {
                // Handle for other cases if needed
            }
        });
        // End charector count

        // Start word count
        $('.word-limit').on('input', function() {
            var max_words = $(this).data('maxwords');
            var text = $(this).val();
            var wordArray = text.match(/\S+/g); // Match non-space characters
            var word_count = wordArray ? wordArray.length : 0;
            if (word_count > max_words) {
                var trimmed_text = text.split(/\s+/, max_words).join(
                    " "); // Trim the text to the maximum word count
                $(this).val(trimmed_text);
                word_count = max_words;
            }
            var remaining_words = max_words - word_count;
            var showElement = $(this).data('show');
            $(showElement).text(remaining_words >= 0 ? remaining_words : 0);
        });
        // End word count

        // Start word or charector count
        $('.text-limit').on('input', function() {
            var max_words = $(this).data('maxwords');
            var max_chars = $(this).data('maxlength');
            var text = $(this).val();
            var wordArray = text.match(/\S+/g); // Match non-space characters
            var word_count = wordArray ? wordArray.length : 0;
            var char_count = text.length;
            if (word_count > max_words) {
                var trimmed_text = text.split(/\s+/, max_words).join(
                    " "); // Trim the text to the maximum word count
                $(this).val(trimmed_text);
                word_count = max_words;
            }
            if (char_count > max_chars) {
                var trimmed_text = text.substr(0, max_chars); // Trim the text to the maximum character count
                $(this).val(trimmed_text);
                char_count = max_chars;
            }
            var remaining_words = Math.max(0, max_words - word_count);
            var remaining_chars = Math.max(0, max_chars - char_count);
            var showWordElement = $(this).data('show-word');
            var showCharElement = $(this).data('show-char');
            if (remaining_words > 0) {
                $(showWordElement).text(remaining_words);
            } else {
                $(showWordElement).text("");
            }
            if (remaining_chars > 0) {
                $(showCharElement).text(remaining_chars);
            } else {
                $(showCharElement).text("");
            }
        });
        // End word or charector count

        // Start drag and drop
        (function() {
            function Init() {
                var fileSelect = document.getElementById('vide_Upload');
                var fileDrag = document.getElementById('file-drag');
                fileSelect.addEventListener('change', fileSelectHandler, false);
                fileDrag.addEventListener('dragover', fileDragHover, false);
                fileDrag.addEventListener('dragleave', fileDragHover, false);
                fileDrag.addEventListener('drop', fileSelectHandler, false);
            }

            function fileDragHover(e) {
                var fileDrag = document.getElementById('file-drag');
                e.stopPropagation();
                e.preventDefault();
                fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body vide_Upload');
            }

            function fileSelectHandler(e) {
                e.preventDefault(); // Prevent the default action from occurring
                var fileDrag = document.getElementById('file-drag');
                fileDrag.className = 'modal-body vide_Upload';
                var files = e.target.files || e.dataTransfer.files;
                var fileSelect = document.getElementById('vide_Upload');
                fileSelect.files = files;
                updateFileList(files); // Update the file list display
                for (var i = 0; i < files.length; i++) {
                    parseFile(files[i]); // Call parseFile for each file
                }
            }

            function updateFileList(files) {
                var fileListContainer = document.getElementById('file-list-container');
                if (fileListContainer) {
                    var fileList = document.createElement('ul');
                    for (var i = 0; i < files.length; i++) {
                        var listItem = document.createElement('li');
                        listItem.appendChild(document.createTextNode(files[i].name));
                        fileList.appendChild(listItem);
                    }
                    fileListContainer.innerHTML = '';
                    fileListContainer.appendChild(fileList);
                    if (files.length > 0) {
                        showFileName(files[0].name); // Displaying the file name
                    }
                }
            }


            function showFileName(name) {
                var fileNameContainer = document.getElementById('file-name-container');
                fileNameContainer.innerText = name;
            }

            function output(msg) {
                var fileDetails = document.getElementById('file-details');
                if (fileDetails) {
                    var details = document.createElement('div');
                    details.innerHTML = msg;
                    fileDetails.appendChild(details);
                }
            }

            function parseFile(file) {
                var fileDetailsElement = document.getElementById('file-details');
                if (fileDetailsElement) {
                    fileDetailsElement.innerHTML = '<ul>' +
                        '<li><strong>Name:</strong> ' + encodeURI(file.name) + '</li>' +
                        '<li><strong>Type:</strong> ' + file.type + '</li>' +
                        '<li><strong>Size:</strong> ' + (file.size / (1024 * 1024)).toFixed(2) + ' MB</li>' +
                        '</ul>';
                }
            }
            // Check for the various File API support.
            if (window.File && window.FileList && window.FileReader) {
                Init();
            } else {
                document.getElementById('file-drag').style.display = 'none';
            }
        })();


        // End drag and drop

        // Ajax save

        // Add a custom method for file type validation
        $.validator.addMethod("fileType", function(value, element) {
            return this.optional(element) || /\.(mp4)$/i.test(value);
        }, "Please upload a valid video file (MP4 only).");

        $.validator.addMethod("fileSize", function(value, element) {
            return this.optional(element) || (element.files[0].size <
            100000000); // Adjusted file size limit to 10 MB
        }, "File size must be less than 100MB.");

        /*$.validator.addMethod("firstFiveKeywordsRequired", function(value, element) {
        // Check if it's one of the first five keyword inputs
        var index = $(element).closest('.keywod_section5').index();
        // Check if all five keyword inputs are filled
        var allFilled = true;
        $('.keywod_section5:eq('+index+')').find('input[name^="keywords"]').each(function() {
        if ($(this).val().trim() === '') {
        allFilled = false;
        return false;  // Exit the loop if any input is empty
        }
        });
        return allFilled;
        }, "All five keyword inputs are required.");*/



        if ($("#SubmitVideoForm").length > 0) {
            $("#SubmitVideoForm").validate({
                errorPlacement: function(error, element) {
                   /* if (element.attr("name") == "name[5][correspondingauthorcheck][]") {
                        $(error).insertAfter('#authorDiv');
                    } else */
                    if (element.attr("name") == "terms_n_conditions") {
                        $(error).insertAfter('.terms_n_conditions_level');
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    /*'name[5][correspondingauthorcheck][]': {
                        required: function(element) {
                            return !$('input[name="name[5][correspondingauthorcheck][]"]').is(':checked');
                        }
                    },*/
                    'name[3][correspondingauthorname][]': {
                        required: true
                    },
                    'name[3][correspondingauthorsurname][]': {
                        required: true
                    },
                    'name[3][correspondingauthoraffiliation][]': {
                        required: true
                    },
                    'name[3][correspondingauthoremail][]': {
                        required: true,
                        email: true
                    },
                    'name[3][correspondingauthorcountry][]': {
                        required: true
                    },
                    /*'name[5][authorname][]': {
                        required: true
                    },
                    'name[5][authorsurname][]': {
                        required: true
                    },
                    'name[5][authoraffiliation][]': {
                        required: true
                    },
                    'name[5][authoremail][]': {
                        required: true,
                        email: true
                    },
                    'name[5][authorcountry][]': {
                        required: true
                    },*/
                    'name[4][reviewername][]': {
                        required: true
                    },
                    'name[4][reviewersurname][]': {
                        required: true
                    },
                    'name[4][revieweraffiliation][]': {
                        required: true
                    },
                    'name[4][revieweremail][]': {
                        required: true,
                        email: true
                    },
                    'name[4][reviewercountry][]': {
                        required: true
                    },
                    video_title: {
                        required: true
                    },
                    'keywords[]': {
                        required: true,
                        // firstFiveKeywordsRequired: true
                    },
                    references: {
                        required: true
                    },
                    abstract: {
                        required: true
                    },
                    declaration_of_interests: {
                        required: true
                    },
                    declaration_remark: {
                        required: true
                    },
                    videotype_id: {
                        required: true
                    },
                    videosubtype_id: {
                        required: true
                    },
                    majorcategory_id: {
                        required: true
                    },
                    'subcategory_id[]': {
                        required: true
                    },
                    membershipplan_id: {
                        required: true
                    },
                    video_price: {
                        required: true
                    },
                    vide_Upload: {
                        required: true,
                        fileType: "video/*", // Adjust the file types based on your needs
                        fileSize: true // Adding the fileSize validation rule
                    },
                    terms_n_conditions: {
                        required: true
                    },
                    captcha: {
                        required: true
                    },
                },
                messages: {
                    /*'name[5][correspondingauthorcheck][]': {
                        required: "At least one checkbox must be selected."
                    },*/
                    'name[3][correspondingauthorname][]': {
                        required: "This field is required"
                    },
                    'name[3][correspondingauthorsurname][]': {
                        required: "This field is required"
                    },
                    'name[3][correspondingauthoraffiliation][]': {
                        required: "This field is required"
                    },
                    'name[3][correspondingauthoremail][]': {
                        required: "This field is required",
                        email: "Invalid email type"
                    },
                    'name[3][correspondingauthorcountry][]': {
                        required: "This field is required"
                    },
                    /*'name[5][authorname][]': {
                        required: "This field is required"
                    },
                    'name[5][authorsurname][]': {
                        required: "This field is required"
                    },
                    'name[5][authoraffiliation][]': {
                        required: "This field is required"
                    },
                    'name[5][authoremail][]': {
                        required: "This field is required",
                        email: "Invalid email type"
                    },
                    'name[5][authorcountry][]': {
                        required: "This field is required"
                    },*/
                    'name[4][reviewername][]': {
                        required: "This field is required"
                    },
                    'name[4][reviewersurname][]': {
                        required: "This field is required"
                    },
                    'name[4][revieweraffiliation][]': {
                        required: "This field is required"
                    },
                    'name[4][revieweremail][]': {
                        required: "This field is required",
                        email: "Invalid email type"
                    },
                    'name[4][reviewercountry][]': {
                        required: "This field is required"
                    },
                    video_title: {
                        required: "This field is required"
                    },
                    'keywords[]': {
                        required: "This field is required",
                        // firstFiveKeywordsRequired: 'Atleast five keyword inputs are required'
                    },
                    references: {
                        required: "This field is required"
                    },
                    abstract: {
                        required: "This field is required"
                    },
                    declaration_of_interests: {
                        required: "This field is required"
                    },
                    declaration_remark: {
                        required: "This field is required"
                    },
                    videotype_id: {
                        required: "This field is required"
                    },
                    videosubtype_id: {
                        required: "This field is required"
                    },
                    majorcategory_id: {
                        required: "This field is required"
                    },
                    'subcategory_id[]': {
                        required: "This field is required"
                    },
                    membershipplan_id: {
                        required: "This field is required"
                    },
                    video_price: {
                        required: "This field is required"
                    },
                    vide_Upload: {
                        required: "Please select a file",
                        fileType: "Please upload a valid video file (MP4 only)", // Adjust the message accordingly
                        fileSize: "File size must be less than 100MB" // Adjust the message according to your file size limit
                    },
                    terms_n_conditions: {
                        required: "This field is required"
                    },
                    captcha: {
                        required: "This field is required"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    // Remove existing checkbox array
                    $(form).find('input[type="checkbox"]').each(function() {
                        formData.delete($(this).attr('name'));
                    });

                    // Add new checkbox values to the formData
                    $(form).find('.authorSection').each(function(index) {
                        var checkedValue = $(this).find('input[type="checkbox"]').prop('checked') ?
                            '1' : '0';
                        formData.append($(this).find('input[type="checkbox"]').attr('name'),
                            checkedValue);
                    });

                    // Handling the termscheckbox
                    var termsCheckedValue = $('#terms_n_conditions').prop('checked') ? '1' : '0';
                    formData.append('terms_n_conditions', termsCheckedValue);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#videoSubmit').html('Please Wait...Do not reload page or click on any button.');
                    $("#videoSubmit").attr("disabled", true);
                    var progressBarInterval;
                    $.ajax({
                        url: '{{ route('video.store') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('.spinnerLoader').show();
                        },                        
                        success: function(response) {
                            $('#videoSubmit').html('Submit Your Video');
                            $("#videoSubmit"). attr("disabled", false);
                            if (response.success == 'error') {
                                $('#videoSubmit').html('Submit Your Video');
                                $("#videoSubmit").attr("disabled", false);
                                $('.errorDisplayDiv').html(response.message);
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 0);
                                $('.successDiv').slideDown('slow', function() {
                                    /*setTimeout(function() {
                                    $('.successDiv').slideUp('slow');
                                    }, 5000);*/
                                });
                            } else if (response.success == 'Successfully') {
                                    $('.spinnerLoader').hide();
                                    window.location.href = response.redirect;
                            } else {
                                $('.spinnerLoader').hide();
                                $('.errorDisplayDiv').html(response.error);
                                $('.successDiv').show();
                                $('#videoSubmit').html('Submit Your Video');
                                $("#videoSubmit").attr("disabled", false);
                                $('.errorDisplayDiv').html(response.message);
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 0);
                            }
                        },
                        error: function(xhr, status, error) {
                            $('.spinnerLoader').hide();
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                if(key == 'captcha')
                                {
                                    $("#" + key + "_videos-error").html(value[0]);
                                }
                                else
                                {
                                    $('.errorDisplayDiv').html('Something went wrong. Please try again');
                                    $('.successDiv').show();
                                    $('html, body').animate({
                                        scrollTop: 0
                                    }, 0);
                                }
                            });
                            reloadCaptcha_video();
                            setTimeout(function() {
                                // Clear the interval when the error occurs
                                clearInterval(progressBarInterval);
                            }, 1000); // Stop the interval after 10 seconds (adjust as needed)
                            $('#videoSubmit').html('Submit Your Video');
                            $("#videoSubmit").attr("disabled", false);
                        }
                    });
                }
            })
        }

        //Start update video
        if ($("#updateVideoForm").length > 0) {
            $("#updateVideoForm").validate({
                errorPlacement: function(error, element) {
                    /*if (element.attr("name") == "name[5][correspondingauthorcheck][]") {
                        $(error).insertAfter('#authorDiv');
                    } else */
                    if (element.attr("name") == "terms_n_conditions") {
                        $(error).insertAfter('.terms_n_conditions_level');
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    /*'name[5][correspondingauthorcheck][]': {
                        required: function(element) {
                            return !$('input[name="name[5][correspondingauthorcheck][]"]').is(':checked');
                        }
                    },*/
                    /*'name[5][authorname][]': {
                        required: true
                    },
                    'name[5][authorsurname][]': {
                        required: true
                    },
                    'name[5][authoraffiliation][]': {
                        required: true
                    },
                    'name[5][authoremail][]': {
                        required: true,
                        email: true
                    },
                    'name[5][authorcountry][]': {
                        required: true
                    },*/
                    'name[4][reviewername][]': {
                        required: true
                    },
                    'name[4][reviewersurname][]': {
                        required: true
                    },
                    'name[4][revieweraffiliation][]': {
                        required: true
                    },
                    'name[4][revieweremail][]': {
                        required: true,
                        email: true
                    },
                    'name[4][reviewercountry][]': {
                        required: true
                    },
                    video_title: {
                        required: true
                    },
                    'keywords[]': {
                        required: true
                    },
                    references: {
                        required: true
                    },
                    abstract: {
                        required: true
                    },
                    declaration_of_interests: {
                        required: true
                    },
                    declaration_remark: {
                        required: true
                    },
                    videotype_id: {
                        required: true
                    },
                    videosubtype_id: {
                        required: true
                    },
                    majorcategory_id: {
                        required: true
                    },
                    membershipplan_id: {
                        required: true
                    },
                    video_price: {
                        required: true
                    },
                    vide_Upload: {
                        fileType: "video/*", // Adjust the file types based on your needs
                        fileSize: true // Adding the fileSize validation rule
                    },
                    terms_n_conditions: {
                        required: true
                    },
                    message: {
                        required: true
                    },
                    captcha: {
                        required: true
                    },
                },
                messages: {
                    /*'name[5][correspondingauthorcheck][]': {
                        required: "At least one checkbox must be selected."
                    },*/
                    /*'name[5][authorsurname][]': {
                        required: "This field is required"
                    },
                    'name[5][authoraffiliation][]': {
                        required: "This field is required"
                    },
                    'name[5][authoremail][]': {
                        required: "This field is required",
                        email: "Invalid email type"
                    },
                    'name[5][authorcountry][]': {
                        required: "This field is required"
                    },*/
                    'name[4][reviewername][]': {
                        required: "This field is required"
                    },
                    'name[4][reviewername][]': {
                        required: "This field is required"
                    },
                    'name[4][reviewersurname][]': {
                        required: "This field is required"
                    },
                    'name[4][revieweraffiliation][]': {
                        required: "This field is required"
                    },
                    'name[4][revieweremail][]': {
                        required: "This field is required",
                        email: "Invalid email type"
                    },
                    'name[4][reviewercountry][]': {
                        required: "This field is required"
                    },
                    video_title: {
                        required: "This field is required"
                    },
                    'keywords[]': {
                        required: "This field is required"
                    },
                    references: {
                        required: "This field is required"
                    },
                    abstract: {
                        required: "This field is required"
                    },
                    declaration_of_interests: {
                        required: "This field is required"
                    },
                    declaration_remark: {
                        required: "This field is required"
                    },
                    videotype_id: {
                        required: "This field is required"
                    },
                    videosubtype_id: {
                        required: "This field is required"
                    },
                    majorcategory_id: {
                        required: "This field is required"
                    },
                    membershipplan_id: {
                        required: "This field is required"
                    },
                    video_price: {
                        required: "This field is required"
                    },
                    vide_Upload: {
                        fileType: "Please upload a valid video file (MP4 only)", // Adjust the message accordingly
                        fileSize: "File size must be less than 100MB" // Adjust the message according to your file size limit
                    },
                    terms_n_conditions: {
                        required: "This field is required"
                    },
                    message: {
                        required: "This field is required"
                    },
                    captcha: {
                        required: "This field is required"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    // Remove existing checkbox array
                    $(form).find('input[type="checkbox"]').each(function() {
                        formData.delete($(this).attr('name'));
                    });

                    // Add new checkbox values to the formData
                    $(form).find('.authorSection').each(function(index) {
                        var checkedValue = $(this).find('input[type="checkbox"]').prop('checked') ?
                            '1' : '0';
                        formData.append($(this).find('input[type="checkbox"]').attr('name'),
                            checkedValue);
                    });

                    // Handling the termscheckbox
                    var termsCheckedValue = $('#terms_n_conditions').prop('checked') ? '1' : '0';
                    formData.append('terms_n_conditions', termsCheckedValue);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#videoUpdate').html('Please Wait...Do not reload page or click on any button.');
                    $("#videoUpdate").attr("disabled", true);

                    @if (isset($video_list->id))
                        const video_id = "{{ $video_list->id }}";
                    @else
                        const video_id = null;
                    @endif
                    var url = "{{ route('video.update', ':video_id') }}";
                    url = url.replace(':video_id', video_id);

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function () {
                            $('.spinnerLoader').show();
                        },
                        success: function(response) {
                            if (response.success == 'error') {
                                $('#videoUpdate').html('Update Your Video');
                                $("#videoUpdate").attr("disabled", false);
                                $('.errorDisplayDiv').html(response.message);
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 0);
                                $('.successDiv').slideDown('slow', function() {
                                    /*setTimeout(function() {
                                    $('.successDiv').slideUp('slow');
                                    }, 5000);*/
                                });
                            } else if (response.success == 'Successfully') {
                                var randomString = Math.random().toString(36).substring(7);
                                window.location.href = response.redirect + '?random=' + randomString;
                            } else {
                                $('.spinnerLoader').hide();
                                $('.errorDisplayDiv').html(response.error);
                                $('.successDiv').show();
                                $('#videoSubmit').html('Update Your Video');
                                $("#videoSubmit").attr("disabled", false);
                                $('.errorDisplayDiv').html(response.message);
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 0);
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                if(key == 'captcha')
                                {
                                    $("#" + key + "_video_updates-error").html(value[0]);
                                }
                                else
                                {
                                    $('.errorDisplayDiv').html('Something went wrong. Please try again');
                                    $('.successDiv').show();
                                    $('html, body').animate({
                                        scrollTop: 0
                                    }, 0);
                                }
                            });
                            reloadCaptcha_video();
                            setTimeout(function() {
                                // Clear the interval when the error occurs
                                clearInterval(progressBarInterval);
                            }, 1000); // Stop the interval after 10 seconds (adjust as needed)
                            var currentWidth = '';
                            var increment = ''; // Assuming 100 intervals for 100%
                            $('.progress .progress-bar').css('width', currentWidth + increment);
                            $('#videoUpdate').html('Update Your Video');
                            $("#videoUpdate").attr("disabled", false);
                        }
                    });
                }
            })
        }
        //End update video

        //add rows when add button on author
        $(document).ready(function() {
            var maxClones = 20; // Maximum number of clones allowed
            $(document).on('click', '.add_authorDiv', function(e) {
                e.preventDefault();
                var examsList = $('#authorDiv');
                if (examsList.children('.authorSection').length < maxClones) {
                    var clone = examsList.children('.authorSection:first').clone(true);
                    // Uncheck the checkbox in the cloned element
                    clone.find('input[type=checkbox]').prop('checked', false);

                    // Remove the tooltip from the original checkbox
                    examsList.find('input[type=checkbox]').removeAttr('data-toggle');

                    clone.append(
                        '<div class="col-lg-1 remove_authorDiv"> <div class="form-group removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                        );

                    // Reset values in cloned inputs and add enumerated IDs to input fields 
                    clone.find('input').val('').attr('id', function() {
                        return $(this).attr('id') + '_' + (examsList.children('.authorSection')
                            .length + 1);
                    });
                    examsList.append(clone);
                } else {
                    // Show a warning message besides the button here
                    $('.max_warning_message').html('Maximum limit reached!');
                }
            });
        });

        // Remove rows when the remove button on coauthor is clicked
        $(document).on('click', '.remove_authorDiv', function(e) {
            e.preventDefault();
            $('.max_warning_message').html('');
            $(this).parent().remove();
        });

        $(document).ready(function() {
            var maxClones = 9; // Maximum number of clones allowed
            $(document).on('click', '.add_reviewersDiv', function(e) {
                e.preventDefault();
                var examsList = $('#reviewerDiv');
                if (examsList.children('.reviewerSection3').length < maxClones) {
                    var clone = examsList.children('.reviewerSection3:first').clone(true);
                    clone.append(
                        '<div class="col-lg-1 remove_reviewerDiv"> <div class="form-group removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                        );

                    // Reset values in cloned inputs and add enumerated IDs to input fields
                    clone.find('input').val('').attr('id', function() {
                        return $(this).attr('id') + '_' + (examsList.children('.reviewerSection3')
                            .length + 1);
                    });
                    examsList.append(clone);
                } else {
                    // Show a warning message besides the button here
                    $('.max_warning_message_reviewer').html('Maximum limit reached!');
                }
            });
        });

        // Remove rows when the remove button on reviewer is clicked
        $(document).on('click', '.remove_reviewerDiv', function(e) {
            e.preventDefault();
            $('.max_warning_message_reviewer').html('');
            $(this).parent().remove();
        });

        $(document).ready(function() {
            var maxClones = 10; // Maximum number of clones allowed
            var initialCount = 0; // Initial number of keyword sections

            function updateLabelsAndIDs() {
                $('#keywordsDiv').children('.keyword-section').each(function(index) {
                    var currentCount = initialCount + index + 1;
                    $(this).find('label').html('Keywords ' + currentCount + '<b class="red">*</b>');
                    $(this).find('input').attr('id', 'keywords_' + currentCount);
                });
            }

            $(document).on('click', '.add_keywordsDiv', function(e) {
                e.preventDefault();
                var examsList = $('#keywordsDiv');

                if (examsList.children('.keyword-section').length < maxClones) {
                    var clone = examsList.children('.keyword-section:last').clone(true);

                    // Reset values in cloned inputs and update label and add enumerated IDs to input fields
                    clone.find('input').val('').attr('id', function(index, oldId) {
                        var currentCount = examsList.children('.keyword-section').length +
                            initialCount + 1;
                        return 'keywords_' + currentCount;
                    });

                    // Find the count of the last input label and increment it for the new label
                    var lastLabel = clone.find('label');
                    var lastCount = parseInt(lastLabel.text().match(/\d+/)[0], 10);
                    lastLabel.html('Keywords ' + (lastCount + 1) + '<b class="red">*</b>');

                    // Remove the existing remove button before appending the new one
                    clone.find('.remove_keywordsDiv').remove();

                    // Append the new remove button
                    clone.append(
                        '<div class="col-lg-1 remove_keywordsDiv"> <div class="form-group removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                        );

                    examsList.append(clone);

                    // Update labels and IDs after adding a new section
                    updateLabelsAndIDs();
                } else {
                    // Show a warning message besides the button here
                    $('.max_warning_message_keywords').html('Maximum limit is 10 only!');
                }
            });

            $(document).on('click', '.removeDivClass', function(e) {
                e.preventDefault();
                $(this).closest('.keyword-section').remove();
                // Update labels and IDs after removing a section
                updateLabelsAndIDs();
            });
        });


        // For keywords update
        $(document).ready(function() {
            var maxClones = 10; // Maximum number of clones allowed
            var initialCount = 0; // Initial number of keyword sections

            function updateLabelsAndIDs_update() {
                $('#keywordsDiv_update').children('.keyword-section').each(function(index) {
                    var currentCount = initialCount + index + 1;
                    $(this).find('label').html('Keywords ' + currentCount + '<b class="red">*</b>');
                    $(this).find('input').attr('id', 'keywords_' + currentCount);
                });
            }

            $(document).on('click', '.add_keywordsDiv_update', function(e) {
                e.preventDefault();
                var examsList = $('#keywordsDiv_update');

                if (examsList.children('.keyword-section').length < maxClones) {
                    var clone = examsList.children('.keyword-section:last').clone(true);

                    // Reset values in cloned inputs and update label and add enumerated IDs to input fields
                    clone.find('input').val('').attr('id', function(index, oldId) {
                        var currentCount = examsList.children('.keyword-section').length +
                            initialCount + 1;
                        return 'keywords_' + currentCount;
                    });

                    // Find the count of the last input label and increment it for the new label
                    var lastLabel = clone.find('label');
                    var lastCount = parseInt(lastLabel.text().match(/\d+/)[0], 10);
                    lastLabel.html('Keywords ' + (lastCount + 1) + '<b class="red">*</b>');

                    // Remove the existing remove button before appending the new one
                    clone.find('.remove_keywordsDiv_update').remove();

                    // Append the new remove button
                    clone.append(
                        '<div class="col-lg-1 remove_keywordsDiv_update"> <div class="form-group removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                        );

                    examsList.append(clone);

                    // Update labels and IDs after adding a new section
                    updateLabelsAndIDs_update();
                } else {
                    // Show a warning message besides the button here
                    $('.max_warning_message_keywords').html('Maximum limit is 10 only!');
                }
            });

            $(document).on('click', '.removeDivClass', function(e) {
                e.preventDefault();
                $(this).closest('.keyword-section').remove();
                // Update labels and IDs after removing a section
                updateLabelsAndIDs_update();
            });
        });
    </script>
@endif
{{-- End upload video js --}}
<script>

//add rows for reviewers at the editor page
$(document).ready(function() {
    var maxClones = 4; // Maximum number of clones allowed
    $(document).on('click', '.add_editorReviewerDiv', function(e) {
        e.preventDefault();
        var examsList = $('#editorReviewerDiv');
        if (examsList.children('.editorReviewerSection').length < maxClones) {
            var clone = examsList.children('.editorReviewerSection:first').clone(true);
            // Uncheck the checkbox in the cloned element
            clone.find('input[type=checkbox]').prop('checked', false);

            // Remove the tooltip from the original checkbox
            examsList.find('input[type=checkbox]').removeAttr('data-toggle');

            clone.append(
                '<div class="col-lg-1 remove_editorReviewerDiv"> <div class="form-group removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                );

            // Reset values in cloned inputs and add enumerated IDs to input fields 
            clone.find('input').val('').attr('id', function() {
                return $(this).attr('id') + '_' + (examsList.children('.editorReviewerSection')
                    .length + 1);
            });
            examsList.append(clone);
        } else {
            // Show a warning message besides the button here
            $('.max_warning_message').html('Maximum limit reached!');
        }
    });
});

// Remove rows for reviewers at the editor page
$(document).on('click', '.remove_editorReviewerDiv', function(e) {
    e.preventDefault();
    $('.max_warning_message').html('');
    $(this).parent().remove();
});

    // for like unlike videos
    function likeCounter(element) {
        var videoId = element.getAttribute('data-videoId');
        var like = element.getAttribute('data-like');
        const is_loggedIn = "{{ auth()->check() }}";
        if (is_loggedIn != 1) {
            $('#overlay_counter_msg' + videoId).html('You need to login first.');
            $('#overlay_counter' + videoId).css('display', 'block');
            $('#overlay_counter' + videoId).delay(3200).fadeOut(300);
        } else {
            $.ajax({
                url: '{{ route('update.video.likes') }}',
                type: "POST",
                data: {
                    videoId: videoId,
                    like: like,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#likecountCustom' + videoId).html(response.like_unlike_count);
                        var $likeIcon = $('#likecountCustom' + videoId);
                        $likeIcon.css('color', '#f44336ff').animate({
                            fontSize: '30px'
                        }, "fast").animate({
                            fontSize: '10px'
                        }, "fast", function() {
                            @if (session('switchtheme') == 'light')
                                $likeIcon.css('color', '#000000');
                            @else
                                $likeIcon.css('color', '#acacac');
                            @endif
                        });
                    } else if (response.status == 'fail') {
                        const message = response.message;
                        $('#overlay_counter_msg' + videoId).html(message);
                        $('#overlay_counter' + videoId).css('display', 'block');
                        $('#overlay_counter' + videoId).delay(3200).fadeOut(300);
                    }

                },
                error: function(error) {
                    console.error("An error occurred:", error);
                }
            });
        }

        // AJAX request  
    }

    function watchlater(element) {
        const route_name = "{{ Route::currentRouteName() }}";
        var videoId = element.getAttribute('data-videoId');
        var isadded = element.getAttribute('data-isadded');
        const is_loggedIn = "{{ auth()->check() }}";
        if (is_loggedIn != 1) {
            $('#overlay_counter_msg' + videoId).html('You need to login first.');
            $('#overlay_counter' + videoId).css('display', 'block');
            $('#overlay_counter' + videoId).delay(3200).fadeOut(300);
        } else {
            $.ajax({
                url: '{{ route('watch.later.video') }}',
                type: "POST",
                data: {
                    videoId: videoId,
                    isadded: isadded,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == 'success') {
                        const type = response.type;
                        if (route_name == 'watch.list') {
                            $('#video_list_div' + videoId).remove();
                            if ($("div").hasClass("watchListDiv") == false || $("div").hasClass(
                                    "watchListDiv") == 'false') {
                                $('.emptyWatchListDiv').show();
                            }
                        }
                        if (type == 1) {
                            $('#alreadyAddedWatchLater' + videoId).show();
                            $('#addWatchLater' + videoId).hide();
                        } else if (type == 0) {
                            $('#addWatchLater' + videoId).show();
                            $('#alreadyAddedWatchLater' + videoId).hide();
                        }
                    } else if (response.status == 'fail') {
                        const message = response.message;
                        $('#overlay_counter_msg' + videoId).html(message);
                        $('#overlay_counter' + videoId).css('display', 'block');
                        $('#overlay_counter' + videoId).delay(3200).fadeOut(300);
                    }

                },
                error: function(error) {
                    console.error("An error occurred:", error);
                }
            });
        }

        // AJAX request  
    }
</script>

<script>
    $(document).ready(function() {
        $(document).on('change', '#majorcategory_id', function() {
            let majorcategory_id = $(this).val();
            $.ajax({
                method: 'post',
                url: "{{ route('sub.category') }}",
                data: {
                    majorcategory_id: majorcategory_id,
                    token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status == 'success') {
                        $('.subcategory_id').empty();
                        let all_options = "";
                        let all_subcategories = res.subcategories;
                        $.each(all_subcategories, function(index, value) {
                            all_options += "<option value='" + value.id +
                                "'>" + value.subcategory_name + "</option>";
                        });
                        $(".subcategory_id").html(all_options);
                        $('.subcategory_id').multiselect('rebuild');

                        // Add event listener to limit selection to 3
                        $('.subcategory_id').on('change', function() {
                            var selectedOptions = $(
                                '.subcategory_id option:selected:not([value=""])'
                                );
                            if (selectedOptions.length > 3) {
                                // Deselect the last option if more than 3 are selected
                                selectedOptions.last().prop('selected', false);
                            }
                            // Disable remaining options excluding the "Select" option
                            $('.subcategory_id option:not(:selected)').not(
                                '[value=""]').prop('disabled', selectedOptions
                                .length >= 3);

                            // Rebuild the multiselect to reflect the change
                            $('.subcategory_id').multiselect('rebuild');
                        });
                    }
                }
            })
        });
    });

    $(document).ready(function() {
        $('.subcategory_id').multiselect({
            buttonWidth: '100%',
            enableFiltering: true, // Enable filtering
            enableCaseInsensitiveFiltering: true, // Make filtering case-insensitive
            maxHeight: 200, // Set a maximum height for the dropdown
        });
    });

</script>

<script>
    document.getElementById('delete_Author_form_Submit').addEventListener('click', function(e) {
        e.preventDefault();
        var result = confirm("Are you sure you want to delete this video?");
        if (result) {
            document.getElementById('deleteVideo').submit();
        }
    });
</script>


@if (Route::currentRouteName() == 'video.edit')
    <script>
        $('.red').hide();
    </script>
@endif

