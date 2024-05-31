<script>
 if ($("#contactFormSend").length > 0) {
            $("#contactFormSend").validate({
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
                    message: {
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
                    message: {
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

                    $('#contactFOrmSendButton').html('Please Wait...');
                    $("#contactFOrmSendButton").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('submit.contact.form') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            $('#contactFOrmSendButton').html('Submit');
                            $("#contactFOrmSendButton"). attr("disabled", false);
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            $("#captcha_contact-error").html('');
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                $("#" + key + "_contact-error").html(value[0]);
                            });
                            reloadCaptcha_contact();
                            $('#contactFOrmSendButton').html('Submit');
                            $("#contactFOrmSendButton"). attr("disabled", false);
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