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
                    /*name: {
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
                    },*/
                    profile_pic: {
                        fileSize: true, // Adding the fileSize validation rule
                        fileType: true
                    },
                    /*institute_name: {
                        required: true
                    },
                    position: {
                        required: true
                    },
                    degree: {
                        required: true
                    },*/
                    /*'role_ids[]': {
                        required: true
                    },*/
                    editorrole_id: {
                        required: true
                    },
                    majorcategory_id: {
                        required: true
                    },
                    'subcategory_id[]': {
                        required: true
                    },
                    highest_priority: {
                        required: true
                    },
                    visible_status: {
                        required: true
                    },
                },
                messages: {
                    /*name: {
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
                    },*/
                    profile_pic: {
                       fileSize: "File size must be less than 40KB", // Adjust the message according to your file size limit
                       fileType: "Please upload only jpg or png file"
                    },
                    /*institute_name: {
                        required: "This field is required"
                    },
                    position: {
                        required: "This field is required"
                    },
                    degree: {
                        required: "This field is required"
                    },*/
                    /*'role_ids[]': {
                        required: "This field is required"
                    },*/
                    editorrole_id: {
                        required: "This field is required"
                    },
                    majorcategory_id: {
                        required: "This field is required"
                    },
                    'subcategory_id[]': {
                        required: "This field is required"
                    },
                    highest_priority: {
                        required: "This field is required"
                    },
                    visible_status: {
                        required: "This field is required"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    const user_id = $('#user_id').val();
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
                    var url = "{{ route('adminusers.update', ':user_id22') }}";
                    url = url.replace(':user_id22', user_id);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            if(response.success == 'fail')
                            {
                                $('#highest_priority_span').html(response.message);
                                $('#highest_priority_span').show();
                                $('#profileUpdate').html('Update profile');
                                $("#profileUpdate"). attr("disabled", false);
                                $('.successDiv').show();
                            }
                            else
                            {
                                const profile_pic_path = response.profile_pic_path;
                                if(profile_pic_path != '')
                                {
                                    $(".profile_image").attr("src", profile_pic_path);
                                }
                                $('#profileUpdate').html('Update profile');
                                $("#profileUpdate"). attr("disabled", false);
                                $('.successDiv').show();
                                $('.profile_progress_bar').css('width', response.progress_count+'%');
                                $('.profile_progress_bar').html(response.progress_count+'%');
                                $('.profile_progress_bar').attr('aria-valuenow', response.progress_count);                            
                                $('html, body').animate({ scrollTop: 0 }, 0);
                                $('.customProgressBar').show('slow');
                                //successMessage(response.message);
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        } 

/*$(document).ready(function() {
    const progress_count = "{{ $progress_count }}";
    $('.profile_progress_bar').css('width', progress_count+'%');
    $('.profile_progress_bar').html(progress_count+'%');
    $('.profile_progress_bar').attr('aria-valuenow', progress_count);
});*/

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

// Start show hide based on editor
    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.querySelector('select[name="role_ids[]"]');
        const editorrole_div_toggle = document.querySelector('.editorrole_div');
        const majorcategory_div_toggle = document.querySelector('.majorcategory_div');
        const subcategory_div_toggle = document.querySelector('.subcategory_div');
        const highest_priority_div_toggle = document.querySelector('.highest_priority_div');

        function toggleDivs() {
            const selectedValues = Array.from(selectElement.selectedOptions, option => option.value.split('_')[0]);
            if (selectedValues.includes('3')) {
                editorrole_div_toggle.style.display = 'block';
                majorcategory_div_toggle.style.display = 'block';
                subcategory_div_toggle.style.display = 'block';
                highest_priority_div_toggle.style.display = 'block';
            } else {
                editorrole_div_toggle.style.display = 'none';
                majorcategory_div_toggle.style.display = 'none';
                subcategory_div_toggle.style.display = 'none';
                highest_priority_div_toggle.style.display = 'none';
            }
        }
        toggleDivs(); // Initial check
        $('#role_ids').change(function(){
            toggleDivs(); // Call the function to handle the input event
        });
    });
// End show hide based on editor
</script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(document).ready(function(){
        $(document).on('change','#majorcategory_id', function() {
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
                        $('#subcategory_id').empty();
                        let all_options = "<option value=''>Select</option>";
                        let all_subcategories = res.subcategories;
                        $.each(all_subcategories, function(index, value) {
                            all_options += "<option value='" + value.id +
                                "'>" + value.subcategory_name + "</option>";
                        });
                        $("#subcategory_id").html(all_options);
                    }
                }
            })
        });
    });
</script>