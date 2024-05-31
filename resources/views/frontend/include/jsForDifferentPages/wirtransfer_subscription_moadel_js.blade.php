<script>
$.validator.addMethod("fileType", function(value, element) {
    return this.optional(element) || /\.(jpe?g|png|pdf)$/i.test(value);
}, "Please upload a valid image file (JPG, JPEG, PNG, PDF).");

$.validator.addMethod("fileSize", function(value, element) { 
    return this.optional(element) || (element.files[0].size < 5000000); // Adjusted file size limit to 5MB
}, "File size must be less than 5MB.");

 if ($("#wireTransferForm_subscription").length > 0) {
            $("#wireTransferForm_subscription").validate({
                rules: {
                   /* transaction_id: {
                        required: true
                    },*/
                    transaction_receipt: {
                        required: true,
                        fileType: true,
                        fileSize: true // Adding the fileSize validation rule
                    },
                    captcha: {
                        required: true
                    },
                },
                messages: {
                    /*transaction_id: {
                        required: "This field is required"
                    },*/
                    transaction_receipt: {
                       required: "This field is required",
                       fileType: "Please upload only jpg, png or pdf file",
                       fileSize: "File size must be less than 5MB" // Adjust the message according to your file size limit
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

                    $('#wireTransferFormUpdate_subscription').html('Please Wait...');
                    $("#wireTransferFormUpdate_subscription").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('update.wiretransfer.payment.subscription') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            $("#captcha_wiretransfer-error").html('');
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                $("#" + key + "_wiretransfer-error").html(value[0]);
                            });
                            reloadCaptcha_video();
                            $('#wireTransferFormUpdate_subscription').html('Upload Details');
                            $("#wireTransferFormUpdate_subscription"). attr("disabled", false);
                        }
                    });
                }
            })
        } 

if ($("#rvCoinsForm_subscription").length > 0) {
            $("#rvCoinsForm_subscription").validate({
                rules: {
                    subscription_plan_id: {
                        required: true
                    },
                    captcha: {
                        required: true
                    },
                },
                messages: {
                    subscription_plan_id: {
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

                    $('#rvCoinsForm_subscription_submit').html('Please Wait...');
                    $("#rvCoinsForm_subscription_submit").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('update.rvcoins.payment.subscription') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            $("#captcha_wiretransfer-error").html('');
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                $("#" + key + "_wiretransfer-error").html(value[0]);
                            });
                            reloadCaptcha_video();
                            $('#rvCoinsForm_subscription_submit').html('Upload Details');
                            $("#rvCoinsForm_subscription_submit"). attr("disabled", false);
                        }
                    });
                }
            })
        } 
</script>

@if (session('wiretransfer_success'))
<script>
$(document).ready(function(){
   $('#wireTransferSuccessModal').modal('toggle');
});
</script>
@endif