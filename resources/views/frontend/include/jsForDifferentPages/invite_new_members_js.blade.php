<script>

$(document).ready(function(){
    var maxClones = 10; // Maximum number of clones allowed
    var initialCount = 0; // Initial number of email sections

    function updateLabelsAndIDs() {
        $('#emailsDiv').children('.email-section').each(function(index) {
            var currentCount = initialCount + index + 1;
            $(this).find('.email_label').html('Email ' + currentCount + '<b class="red">*</b>');
            $(this).find('input').attr('id', 'emails_' + currentCount);
        });
    }

    $(document).on('click', '.add_emailsDiv', function(e) {
        e.preventDefault();
        var examsList = $('#emailsDiv');

        if (examsList.children('.email-section').length < maxClones) {
            var clone = examsList.children('.email-section:last').clone(true);

            // Reset values in cloned inputs and update label and add enumerated IDs to input fields
            clone.find('input').val('').attr('id', function(index, oldId) {
                var currentCount = examsList.children('.email-section').length + initialCount + 1;
                return 'emails_' + currentCount;
            });

            // Find the count of the last input label and increment it for the new label
            var lastLabel = clone.find('.email_label');
            var lastCount = parseInt(lastLabel.text().match(/\d+/)[0], 10);
            lastLabel.html('Email ' + (lastCount + 1) + '<b class="red">*</b>');

            // Remove the existing remove button before appending the new one
            clone.find('.remove_emailsDiv').remove();

            // Append the new remove button
            clone.append('<div class="col-lg-1 remove_emailsDiv"> <div class="form-group removeClassDiv"> <button class="btn btn-danger removeDivClass">Remove</button> </div> </div>');

            examsList.append(clone);

            // Update labels and IDs after adding a new section
            updateLabelsAndIDs();
        } else {
            // Show a warning message besides the button here
            $('.max_warning_message_emails').html('Maximum limit is 10 only!');
        }
    });

    $(document).on('click', '.removeDivClass', function(e) {
        e.preventDefault();
        $(this).closest('.email-section').remove();
        // Update labels and IDs after removing a section
        updateLabelsAndIDs();
    });
});

 if ($("#invite_new_member").length > 0) {
            $("#invite_new_member").validate({
                rules: {
                    'emails[]': {
                        required: true,
                        email: true
                    },
                    captcha: {
                        required: true
                    },
                },
                messages: {
                    'emails[]': {
                        required: "This field is required",
                        email: 'Please insert valid email format'
                    },
                    captcha: {
                        required: "This field is required"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#invite_new_member_Submit').html('Please Wait...');
                    $("#invite_new_member_Submit").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('invite.member.send') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            //$('#invite_new_member_Submit').html('Invite');
                            //$("#invite_new_member_Submit"). attr("disabled", false);
                            if(response.success == 'error')
                            {
                                $('#invite_new_member_Submit').html('Invite');
                                $("#invite_new_member_Submit"). attr("disabled", false);
                                $('.errorDisplayDiv').html(response.message);
                                $('html, body').animate({ scrollTop: 0 }, 0);
                                $('.successDiv').slideDown('slow', function() {
                                /*setTimeout(function() {
                                    $('.successDiv').slideUp('slow');
                                }, 5000);*/
                                });
                            }
                            else
                            {
                                window.location.href = response.redirect;
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                $("#" + key + "_videos-error").html(value[0]);
                            });
                            reloadCaptcha_video();
                            $('#invite_new_member_Submit').html('Invite');
                            $("#invite_new_member_Submit"). attr("disabled", false);
                        }
                    });
                }
            })
        }
</script>