<script>
$.validator.addMethod("fileType", function(value, element) {
    return this.optional(element) || /\.(jpe?g|png)$/i.test(value);
}, "Please upload a valid image file (JPG, JPEG, PNG).");

$.validator.addMethod("fileSize", function(value, element) { 
    return this.optional(element) || (element.files[0].size < 40960); // Adjusted file size limit to 20 KB
}, "File size must be less than 40KB.");

 if ($("#CreateProfileForm").length > 0) {
            $("#CreateProfileForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength:8
                    },
                    profile_pic: {
                        fileSize: true, // Adding the fileSize validation rule
                        fileType: true
                    },
                    editorrole_id: {
                        required: true
                    },
                    majorcategory_id: {
                        required: true
                    },
                    'subcategory_id[]': {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "This field is required"
                    },
                    email: {
                        required: "This field is required",
                        email: "Invalid email type"
                    },
                    password: {
                        required: "This field is required",
                        min: "Minimum 8 in length"
                    },
                    profile_pic: {
                       fileSize: "File size must be less than 40KB", // Adjust the message according to your file size limit
                       fileType: "Please upload only jpg or png file"
                    },
                    editorrole_id: {
                        required: "This field is required"
                    },
                    majorcategory_id: {
                        required: "This field is required"
                    },
                    'subcategory_id[]': {
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

                    $('#profileCreate').html('Please Wait...');
                    $("#profileCreate").attr("disabled", true);
                    var url = "{{ route('adminusers.store') }}";
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
                                $('#editor_role_error').html(response.message);
                                $('#editor_role_error').show();
                                $('#profileCreate').html('Create profile');
                                $("#profileCreate"). attr("disabled", false);
                                $('.successDiv').show();
                            }
                            else
                            {
                                $('#profileCreate').html('Create profile');
                                $("#profileCreate"). attr("disabled", false);
                                $('.successDiv').show();
                                
                                //successMessage(response.message);
                                window.location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                $("#" + key + "_user-error").html(value[0]);
                            });
                            $('#profileCreate').html('Create profile');
                            $("#profileCreate"). attr("disabled", false);
                        }
                    });
                }
            });
        } 

const input = document.querySelector("#phone");
const iti = window.intlTelInput(input, {
  utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
});

// Set the initial value for the country code input
const countryCodeFromDatabase = ""; // Replace this with the actual value retrieved from the database

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