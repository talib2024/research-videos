<script>
$.validator.addMethod("fileType", function(value, element) {
    return this.optional(element) || /\.(jpe?g|png)$/i.test(value);
}, "Please upload a valid image file (JPG, JPEG, PNG).");

$.validator.addMethod("fileSize", function(value, element) { 
    return this.optional(element) || (element.files[0].size < 40960); // Adjusted file size limit to 20 KB
}, "File size must be less than 40KB.");

 if ($("#SubmitProfileForm").length > 0) {
            $("#SubmitProfileForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },                    
                    country_id: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    zip_code: {
                        required: true
                    },
                    profile_pic: {
                        fileType: true,
                        fileSize: true // Adding the fileSize validation rule
                    },
                    institute_name: {
                        required: true
                    },
                    position: {
                        required: true
                    },
                    degree: {
                        required: true
                    },
                    majorcategory_id: {
                        required: true
                    },
                    captcha: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "This field is required"
                    },
                    last_name: {
                        required: "This field is required"
                    },
                    country_id: {
                        required: "This field is required"
                    },
                    city: {
                        required: "This field is required"
                    },
                    zip_code: {
                        required: "This field is required"
                    },
                    profile_pic: {
                       fileType: "Please upload only jpg or png file",
                       fileSize: "File size must be less than 40KB" // Adjust the message according to your file size limit
                    },
                    institute_name: {
                        required: "This field is required"
                    },
                    position: {
                        required: "This field is required"
                    },
                    degree: {
                        required: "This field is required"
                    },
                    majorcategory_id: {
                        required: "This field is required"
                    },
                    captcha: {
                        required: "This field is required"
                    },
                },
                submitHandler: function(form,event) {
                    event.preventDefault();
                    var formData = new FormData(form);
                    var phoneNumber = $("#phone").val();
                    var countryCode = $("#country_code").val();
                    var country_code_iso = $("#country_code_iso").val();
                    formData.append("phone_with_code", countryCode +'_'+ phoneNumber +'_'+ country_code_iso);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#profileUpdate').html('Please Wait...');
                    $("#profileUpdate").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('update.profile') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            const profile_pic_path = response.profile_pic_path;
                            if(profile_pic_path != '')
                            {
                                $(".profile_image").attr("src", profile_pic_path);
                            }
                            $('#profileUpdate').html('Update profile');
                            $("#profileUpdate"). attr("disabled", false);
                            $('.profile_progress_bar').css('width', response.progress_count+'%');
                            $('.profile_progress_bar').html(response.progress_count+'%');
                            $('.profile_progress_bar').attr('aria-valuenow', response.progress_count);                            
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('.customProgressBar').show('slow');
                            $("#captcha_profile-error").html('');
                            $("#captcha_video").val('');
                            reloadCaptcha_video();
                            //successMessage(response.message);
                        },
                        error: function(xhr, status, error) {
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                $("#" + key + "_profile-error").html(value[0]);
                            });
                            reloadCaptcha_video();
                            $('#profileUpdate').html('Update your profile');
                            $("#profileUpdate"). attr("disabled", false);
                        }
                    });
                }
            })
        } 

$(document).ready(function() {
    const progress_count = "{{ $progress_count }}";
    $('.profile_progress_bar').css('width', progress_count+'%');
    $('.profile_progress_bar').html(progress_count+'%');
    $('.profile_progress_bar').attr('aria-valuenow', progress_count);
});

const input = document.querySelector("#phone");
const iti = window.intlTelInput(input, {
  utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
});

// Set the initial value for the country code input
const countryCodeFromDatabase = "{{ $user_details->country_code }}"; // Replace this with the actual value retrieved from the database

var codes = countryCodeFromDatabase.split('_');
iti.setCountry(codes[1]);

// Set the initial value for the country code input
$('#country_code').val(iti.getSelectedCountryData().dialCode);

// Update the country code input when the country is changed
input.addEventListener("countrychange", function() {
  $('#country_code').val(iti.getSelectedCountryData().dialCode);
  $('#country_code_iso').val(iti.getSelectedCountryData().iso2);
});

// Set the initial value for the country code input
$('#country_code_iso').val(iti.getSelectedCountryData().iso2);

</script>