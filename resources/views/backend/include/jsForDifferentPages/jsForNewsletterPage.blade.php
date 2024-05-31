<script>
 if ($("#newsletterForm").length > 0) {
            $("#newsletterForm").validate({
                rules: {
                    subject: {
                        required: true
                    },
                    'email[]': {
                        required: true
                    },
                    message: {
                        required: true
                    },
                },
                messages: {
                    subject: {
                        required: "This field is required"
                    },
                    'email[]': {
                        required: "This field is required"
                    },
                    message: {
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

                    $('#newsletterSend').html('Please Wait...');
                    $("#newsletterSend").attr("disabled", true);
                    $.ajax({
                        url: "{{ route('backendnewsletter.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            window.location.reload();
                            /*$('#newsletterSend').html('Send');
                            $("#newsletterSend"). attr("disabled", false);
                            $('.successDiv').show();*/
                        }
                    });
                }
            });
        } 
</script>