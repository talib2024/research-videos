<script>
    $(document).ready(function() {
        var maxClones = 5; // Maximum number of clones allowed
        $(document).on('click', '.add_audio_section', function(e) {
            e.preventDefault();
            var examsList = $('#audio-section');
            if (examsList.children('.audio-group').length < maxClones) {
                var clone = examsList.children('.audio-group:first').clone(true);
                // Uncheck the checkbox in the cloned element
                clone.find('input[type=checkbox]').prop('checked', false);

                // Remove the tooltip from the original checkbox
                examsList.find('input[type=checkbox]').removeAttr('data-toggle');

                clone.append(
                    '<div class="col-lg-1 remove_audioDiv"> <div class="removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                );

                // Reset values in cloned inputs and add enumerated IDs to input fields 
                clone.find('input').val('').attr('id', function() {
                    return $(this).attr('id') + '_' + (examsList.children('.audio-group')
                        .length + 1);
                });
                examsList.append(clone);
            } else {
                // Show a warning message besides the button here
                $('.max_warning_message_audio').html('Maximum limit reached!');
            }
        });
    });

    // Remove rows when the remove button on coauthor is clicked
    $(document).on('click', '.remove_audioDiv', function(e) {
        e.preventDefault();
        $('.max_warning_message_audio').html('');
        $(this).parent().remove();
    });

    $(document).ready(function() {
        var maxClones = 5; // Maximum number of clones allowed
        $(document).on('click', '.add_image_section', function(e) {
            e.preventDefault();
            var examsList = $('#image-section');
            if (examsList.children('.image-group').length < maxClones) {
                var clone = examsList.children('.image-group:first').clone(true);
                // Uncheck the checkbox in the cloned element
                clone.find('input[type=checkbox]').prop('checked', false);

                // Remove the tooltip from the original checkbox
                examsList.find('input[type=checkbox]').removeAttr('data-toggle');

                clone.append(
                    '<div class="col-lg-1 remove_imageDiv"> <div class="removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                );

                // Reset values in cloned inputs and add enumerated IDs to input fields 
                clone.find('input').val('').attr('id', function() {
                    return $(this).attr('id') + '_' + (examsList.children('.image-group')
                        .length + 1);
                });
                examsList.append(clone);
            } else {
                // Show a warning message besides the button here
                $('.max_warning_message_image').html('Maximum limit reached!');
            }
        });
    });

    // Remove rows when the remove button on coauthor is clicked
    $(document).on('click', '.remove_imageDiv', function(e) {
        e.preventDefault();
        $('.max_warning_message_image').html('');
        $(this).parent().remove();
    });

    $(document).ready(function() {
        var maxClones = 5; // Maximum number of clones allowed
        $(document).on('click', '.add_text_section', function(e) {
            e.preventDefault();
            var examsList = $('#text-section');
            if (examsList.children('.text-group').length < maxClones) {
                var clone = examsList.children('.text-group:first').clone(true);
                // Uncheck the checkbox in the cloned element
                clone.find('input[type=checkbox]').prop('checked', false);

                // Remove the tooltip from the original checkbox
                examsList.find('input[type=checkbox]').removeAttr('data-toggle');

                clone.append(
                    '<div class="col-lg-1 remove_textDiv"> <div class="removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                );

                // Reset values in cloned inputs and add enumerated IDs to input fields 
                clone.find('input').val('').attr('id', function() {
                    return $(this).attr('id') + '_' + (examsList.children('.text-group')
                        .length + 1);
                });
                examsList.append(clone);
            } else {
                // Show a warning message besides the button here
                $('.max_warning_message_text').html('Maximum limit reached!');
            }
        });
    });

    // Remove rows when the remove button on coauthor is clicked
    $(document).on('click', '.remove_textDiv', function(e) {
        e.preventDefault();
        $('.max_warning_message_text').html('');
        $(this).parent().remove();
    });

    $(document).ready(function() {
        var maxClones = 5; // Maximum number of clones allowed
        $(document).on('click', '.add_video_section', function(e) {
            e.preventDefault();
            var examsList = $('#video-section');
            if (examsList.children('.video-group').length < maxClones) {
                var clone = examsList.children('.video-group:first').clone(true);
                // Uncheck the checkbox in the cloned element
                clone.find('input[type=checkbox]').prop('checked', false);

                // Remove the tooltip from the original checkbox
                examsList.find('input[type=checkbox]').removeAttr('data-toggle');

                clone.append(
                    '<div class="col-lg-1 remove_videoDiv"> <div class="removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>'
                );

                // Reset values in cloned inputs and add enumerated IDs to input fields 
                clone.find('input').val('').attr('id', function() {
                    return $(this).attr('id') + '_' + (examsList.children('.video-group')
                        .length + 1);
                });
                examsList.append(clone);
            } else {
                // Show a warning message besides the button here
                $('.max_warning_message_video').html('Maximum limit reached!');
            }
        });
    });

    // Remove rows when the remove button on coauthor is clicked
    $(document).on('click', '.remove_videoDiv', function(e) {
        e.preventDefault();
        $('.max_warning_message_video').html('');
        $(this).parent().remove();
    });


    $(document).ready(function() {

        // Add custom method for audio file size validation
        $.validator.addMethod("videoFileSize", function(value, element) {
            return this.optional(element) || (element.files[0].size <
                30000000); // Adjusted file size limit to 10 MB
        }, "Video file size must be less than 30MB.");

        // Add custom method for audio file size validation
        $.validator.addMethod("audioFileSize", function(value, element) {
            return this.optional(element) || (element.files[0].size <
                10000000); // Adjusted file size limit to 10 MB
        }, "Audio file size must be less than 10MB.");

        // Add custom method for image file size validation
        $.validator.addMethod("imageFileSize", function(value, element) {
            return this.optional(element) || (element.files[0].size <
                10000000); // Adjusted file size limit to 10 MB
        }, "Image file size must be less than 10MB.");

        // Add custom method for text file size validation
        $.validator.addMethod("textFileSize", function(value, element) {
            return this.optional(element) || (element.files[0].size <
                5000000); // Adjusted file size limit to 5 MB
        }, "Text file size must be less than 5MB.");

        if ($("#SubmitVideoGenerateForm").length > 0) {
            $("#SubmitVideoGenerateForm").validate({
                rules: {
                    // Define validation rules here
                    'video_files[]': {
                        //required: true,
                        //accept: "video/mp4,video/x-m4v,image/gif",
                        accept: "video/mp4,video/x-m4v",
                        videoFileSize: true
                    },
                    'audio_files[]': {
                        //required: true,
                        accept: "audio/mpeg",
                        audioFileSize: true
                    },
                    'image_files[]': {
                        //required: true,
                        accept: "image/jpeg,image/png",
                        imageFileSize: true
                    },
                    'text_files[]': {
                        //required: true,
                        accept: "text/plain",
                        textFileSize: true
                    },
                    'video_order[]': {
                        //required: true,
                        number: true,
                        min: 1
                    },
                    'video_duration[]': {
                        //required: true,
                        number: true,
                        min: 1
                    },
                    'audio_order[]': {
                        //required: true,
                        number: true,
                        min: 1
                    },
                    'audio_duration[]': {
                        //required: true,
                        number: true,
                        min: 1
                    },
                    'image_order[]': {
                        //required: true,
                        number: true,
                        min: 1
                    },
                    'image_duration[]': {
                        //required: true,
                        number: true,
                        min: 1
                    },
                    'text_order[]': {
                        //required: true,
                        number: true,
                        min: 1
                    },
                    'text_duration[]': {
                        //required: true,
                        number: true,
                        min: 1
                    }
                },
                messages: {
                    // Define validation messages here
                    'video_files[]': {
                        //required: "Please select a Video file.",
                        accept: "Please select a valid MP4 file only.",
                        audioFileSize: "File size must be less than 30 MB."
                    },
                    'audio_files[]': {
                        //required: "Please select an audio file.",
                        accept: "Please select a valid MP3 file.",
                        audioFileSize: "File size must be less than 10 MB."
                    },
                    'image_files[]': {
                        //required: "Please select an image file.",
                        accept: "Please select a valid JPG or PNG file.",
                        imageFileSize: "File size must be less than 10 MB."
                    },
                    'text_files[]': {
                        //required: "Please select a text file.",
                        accept: "Please select a valid TXT file.",
                        textFileSize: "File size must be less than 5 MB."
                    },
                    'video_order[]': {
                        //required: "Please enter the order number.",
                        number: "Please enter a valid number.",
                        min: "Order number must be greater than 0."
                    },
                    'video_duration[]': {
                        //required: "Please enter the duration.",
                        number: "Please enter a valid number.",
                        min: "Duration must be greater than 0."
                    },
                    'audio_order[]': {
                        //required: "Please enter the order number.",
                        number: "Please enter a valid number.",
                        min: "Order number must be greater than 0."
                    },
                    'audio_duration[]': {
                        //required: "Please enter the duration.",
                        number: "Please enter a valid number.",
                        min: "Duration must be greater than 0."
                    },
                    'image_order[]': {
                        //required: "Please enter the order number.",
                        number: "Please enter a valid number.",
                        min: "Order number must be greater than 0."
                    },
                    'image_duration[]': {
                        //required: "Please enter the duration.",
                        number: "Please enter a valid number.",
                        min: "Duration must be greater than 0."
                    },
                    'text_order[]': {
                        //required: "Please enter the order number.",
                        number: "Please enter a valid number.",
                        min: "Order number must be greater than 0."
                    },
                    'text_duration[]': {
                        //required: "Please enter the duration.",
                        number: "Please enter a valid number.",
                        min: "Duration must be greater than 0."
                    }
                },

                submitHandler: async function(form, event) {
                    event.preventDefault(); // Prevent default form submission
                    var formData = new FormData(form);
                    // Check the condition
                    var same_section = check_Order_For_Same_Section_Condition();
                    var text_files = await validateTextFiles();
                    //console.log('same_section==> ' + same_section);
                    //console.log('text_files==> ' + text_files);
                    //return;
                    if (same_section == false || same_section == 'false' || text_files == false ||
                        text_files == false) {
                        return;
                    }

                    var custom_message_response = custom_message();
                    if (!custom_message_response) {
                        // If form is invalid, stop submission
                        return;
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#videoGenerate').html('Please Wait... Do not reload page or click on any button.');
                    $("#videoGenerate").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('generate.video.without.video') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        beforeSend: function() {
                            $('.spinnerLoader').show();
                        },
                        success: function(response) {
                            console.log(response);
                            if(response.status == 'ok')
                            {
                                $('#videoGenerate').html('Generate Video');
                                $("#videoGenerate").attr("disabled", false);
                                $('.spinnerLoader').hide();
                                window.location = response.video_path;
                                $('#successDiv').show();
                                $('html, body').animate({
                                    scrollTop: 0
                                }, 0);
                                // Create a video element dynamically
                                var videoElement = document.createElement('video');
                                videoElement.src = response.video_path;

                                // When the video has finished loading
                                videoElement.onloadedmetadata = function() {
                                    // Video has finished loading, now delete the directory
                                 deleteDirectory(response.session_id);
                                };                                
                            }
                            else if(response.status == 'notok')
                            {
                                location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            $('.spinnerLoader').hide();
                            var response = JSON.parse(xhr.responseText);
                            var errors = response.errors;
                            $.each(errors, function(key, value) {
                                $("#" + key).html(value[
                                    0
                                    ]); // Show error messages below respective inputs
                            });
                            $('#videoGenerate').html('Generate Video');
                            $("#videoGenerate").attr("disabled", false);
                        }
                    });

                }
            });


        }

        function check_Order_For_Same_Section_Condition() {
            const sections = ['video', 'audio', 'image', 'text'];
            let isValid = true;

            // Object to store order numbers
            const orders = {
                video: [],
                audio: [],
                image: [],
                text: []
            };

            // Collect order numbers for each section
            sections.forEach(section => {
                $(`#${section}-section [name="${section}_order[]"]`).each(function() {
                    orders[section].push($(this).val().trim());
                });
            });

            // Check for duplicates within each section
            sections.forEach(section => {
                const sectionOrders = orders[section];
                const duplicates = sectionOrders.filter((item, index) => sectionOrders.indexOf(item) !==
                    index && item !== "");
                $(`#${section}-section [name="${section}_order[]"]`).each(function() {
                    const orderValue = $(this).val().trim();
                    if (duplicates.includes(orderValue) && orderValue !== "") {
                        isValid = false;
                        $(this).addClass('is-invalid');
                        if ($(this).next('.invalid-feedback').length === 0) {
                            $(this).after(
                                `<div class="invalid-feedback">Duplicate order number found in ${section} section.</div>`
                            );
                        }
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    }
                });
            });

            // Check the condition for video and other sections' orders
            orders.video.forEach(videoOrder => {
                if (videoOrder) {
                    //const invalidSections = ['audio', 'image'];
                    const invalidSections = ['image'];
                    let videoOrderValid = 'donothing';

                    invalidSections.forEach(section => {
                        if (orders[section].includes(videoOrder)) {
                            videoOrderValid = 'invalid';
                            $(`#video-section [name="video_order[]"]`).each(function() {
                                if ($(this).val().trim() === videoOrder) {
                                    $(this).addClass('is-invalid');
                                    if ($(this).next('.invalid-feedback').length ===
                                        0) {
                                        $(this).after(
                                            `<div class="invalid-feedback">Order number in videos section can only match with text and audio section.</div>`
                                        );
                                        isValid = false;
                                    }


                                }
                            });
                            $(`#${section}-section [name="${section}_order[]"]`).each(
                                function() {
                                    if ($(this).val().trim() === videoOrder) {
                                        $(this).addClass('is-invalid');
                                        if ($(this).next('.invalid-feedback').length ===
                                            0) {
                                            $(this).after(
                                                `<div class="invalid-feedback">Order number in ${section} section cannot match with video section.</div>`
                                            );
                                            isValid = false;
                                        }

                                    }
                                });
                        } else {
                            $(`#${section}-section [name="${section}_order[]"]`).each(
                                function() {
                                    if ($(this).val().trim() === videoOrder) {
                                        videoOrderValid = 'valid';
                                        $(this).removeClass('is-invalid');
                                        $(this).next('.invalid-feedback').remove();
                                    }
                                });
                        }
                    });


                    if (videoOrderValid === 'invalid') {
                        $(`#video-section [name="video_order[]"]`).each(function() {
                            if ($(this).val().trim() === videoOrder) {
                                $(this).removeClass('is-invalid');
                                $(this).next('.invalid-feedback').remove();
                            }
                        });
                    }
                }
            });

            return isValid;
        }

        function attachOrderInputListeners() {
            const sections = ['video', 'audio', 'image', 'text'];

            sections.forEach(section => {
                $(`#${section}-section`).on('input', `[name="${section}_order[]"]`, function() {
                    check_Order_For_Same_Section_Condition();
                });
            });
        }

        // Call the function to attach event listeners
        attachOrderInputListeners();

        // Function to validate text files
        async function validateTextFiles() {
            let isValid_file = true;
            let fileChecks = [];

            $('#text-section input[name="text_files[]"]').each(function() {
                const fileInput = this;
                const file = fileInput.files[0];

                if (file) {
                    let fileCheck = new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const textContent = e.target.result;
                            if (textContent.length > 500) {
                                $(fileInput).addClass('is-invalid');
                                if ($(fileInput).next('.invalid-feedback').length ===
                                    0) {
                                    $(fileInput).after(
                                        `<div class="invalid-feedback">Text content must not exceed 500 characters.</div>`
                                    );
                                }
                                isValid_file = false;
                            } else {
                                $(fileInput).removeClass('is-invalid');
                                $(fileInput).next('.invalid-feedback').remove();
                            }
                            resolve();
                        };
                        reader.readAsText(file);
                    });

                    fileChecks.push(fileCheck);
                }
            });

            await Promise.all(fileChecks);
            return isValid_file;
        }

        function attachFileInputListener() {
            $('#text-section').on('change', 'input[name="text_files[]"]', function() {
                validateTextFiles();
            });
        }

        attachFileInputListener();

        // Define custom message function
        function custom_message() {
    let hasError = false;

    // Define sections and their corresponding error messages
    const sections = [
        { sectionId: 'video-section', errorMessage: 'Video' },
        { sectionId: 'audio-section', errorMessage: 'Audio' },
        { sectionId: 'image-section', errorMessage: 'Image' },
        { sectionId: 'text-section', errorMessage: 'Text' }
    ];

    // Iterate over each section
    sections.forEach(section => {
        const sectionId = `#${section.sectionId}`;

        // Select all input elements within the current section
        $(`${sectionId} input`).each(function() {
            const inputField = $(this);
            const inputValue = inputField.val();
            const inputId = inputField.attr('id');
            const errorMessageSelector = `#${inputId}-error`;
            const inputType = inputField.attr('type');

            $(errorMessageSelector).remove();

            // Check if input value is empty
            /*if (!inputValue) {
                hasError = true;
                // Remove previous error message and add new one
                inputField.after(
                    `<span id="${inputId}-error" class="error-message" style="color: red;">${section.errorMessage} field is required.</span>`
                );
                return false; // Exit the .each() loop
            }*/

            if (inputType == 'number' && inputValue) {
                // Check for numeric value and minimum value constraint
                if (!$.isNumeric(inputValue) || parseInt(inputValue) < 1) {
                    hasError = true;
                    inputField.after(
                        `<span id="${inputId}-error" class="error-message" style="color: red;">Value must be a number and greater than or equal to 1.</span>`
                    );
                    return false; // Exit the .each() loop
                }
            }
        });

        // Select validation for file type
        $(`${sectionId} input[type=file]`).each(function() {
            const inputField1 = $(this);
            const inputValue1 = inputField1.val();
            const inputId1 = inputField1.attr('id');
            const errorMessageSelector = `#${inputId1}-error`;
            const file = inputField1[0].files[0];
            let errorMessage = '';
            $(errorMessageSelector).remove();

            // Check if input value is empty
            /*if (!inputValue1) {
                hasError = true;
                errorMessage = `${section.errorMessage} file is required.`;
                inputField1.after(
                    `<span id="${inputId1}-error" class="error-message" style="color: red;">${errorMessage}</span>`
                );
                return false; // Exit the .each() loop
            }*/

            // Check file type based on input ID
            if (inputId1.includes('video') && file && !file.type.includes('video/mp4')) {
                hasError = true;
                errorMessage = 'Invalid file type. Please select a valid MP4 file.';
            } else if (inputId1.includes('image') && file && !(file.type.includes('image/jpeg') || file.type.includes('image/png'))) {
                hasError = true;
                errorMessage = 'Invalid file type. Please select a valid JPG or PNG file.';
            } else if (inputId1.includes('text') && file && !file.type.includes('text/plain')) {
                hasError = true;
                errorMessage = 'Invalid file type. Please select a valid TXT file.';
            } else if (inputId1.includes('audio') && file && !file.type.includes('audio/mpeg')) {
                hasError = true;
                errorMessage = 'Invalid file type. Please select a valid MP3 file.';
            }

            // Check file size
            if (file) {
                const maxSize = getMaxFileSize(inputId1);
                if (file.size > maxSize) {
                    hasError = true;
                    errorMessage = `File size exceeds the limit. Maximum size allowed is ${maxSize / (1024 * 1024)}MB.`;
                }
            }

            // Display error message if any
            if (errorMessage) {
                $(errorMessageSelector).remove();
                inputField1.after(
                    `<span id="${inputId1}-error" class="error-message" style="color: red;">${errorMessage}</span>`
                );
                return false; // Exit the .each() loop
            }
        });

        // Exit the sections loop early if an error was found
        if (hasError) {
            return false;
        }
    });

    return !hasError;
}
        // Function to get max file size based on input ID
        function getMaxFileSize(inputId) {
            switch (true) {
                case inputId.includes('video'):
                    return 30 * 1024 * 1024; // 30MB
                case inputId.includes('audio'):
                    return 10 * 1024 * 1024; // 10MB
                case inputId.includes('image'):
                    return 10 * 1024 * 1024; // 10MB
                case inputId.includes('text'):
                    return 5 * 1024 * 1024; // 5MB
                default:
                    return Infinity;
            }
        }
        // Add input event listener to dynamically remove error messages
        $('input').on('input', function() {
            const inputField = $(this);
            const inputId = inputField.attr('id');
            const errorMessageSelector = `#${inputId}-error`;

            if (inputField.val()) {
                $(errorMessageSelector).remove();
            }
        });



        function deleteDirectory(session_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route('delete.generated.deletedirectory') }}',
                type: "POST",
                data: {
                    'session_id': session_id
                },
                success: function(response) {
                    console(response);
                },
                error: function(xhr, status, error) {
                    console(error);
                }
            });
        }
    });
</script>
