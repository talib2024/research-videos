<script>
 if ($("#institutionRregisterForm").length > 0) {
            $("#institutionRregisterForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    affiliation: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    subject: {
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
                    affiliation: {
                        required: "This field is required"
                    },
                    country: {
                        required: "This field is required"
                    },
                    email: {
                       required: "This field is required",
                       email: "Not a valid email"
                    },
                    subject: {
                        required: "This field is required"
                    },
                    captcha: {
                        required: "This field is required"
                    },
                },
                submitHandler: function(form,event) {
                    event.preventDefault();
                    var formData = new FormData(form);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#institutionRregisterFormSendButton').html('Please Wait...');
                    $("#institutionRregisterFormSendButton").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('submit.institution.register') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            $('#institutionRregisterFormSendButton').html('Submit');
                            $("#institutionRregisterFormSendButton"). attr("disabled", false);
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            $("#captcha_contact-error").html('');
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                $("#" + key + "_contact-error").html(value[0]);
                            });
                            reloadCaptcha_contact();
                            $('#institutionRregisterFormSendButton').html('Submit');
                            $("#institutionRregisterFormSendButton"). attr("disabled", false);
                        }
                    });
                }
            })
        } 
// Function to scroll to the top after page reload
window.onload = function() {
    // Scroll to the top of the page
    $('html, body').animate({ scrollTop: 0 }, 'slow');
};

// Start captcha for other than newsletter and login page
$('#reload_contact').click(function () {
    reloadCaptcha_contact();
});

function reloadCaptcha_contact() 
{
    $.ajax({
        type: 'GET',
        url: '{{ route("reload.captcha") }}',
        success: function (data) {
            $(".captcha_contact span").html(data.captcha);
        }
    });
}
</script>