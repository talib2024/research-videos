<script>
 if ($("#SubmitCoAuthorForm").length > 0) {
            $("#SubmitCoAuthorForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        email:true,
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
                    role: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "This field is required"
                    },
                    email: {
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
                    role: {
                        required: "This field is required"
                    },
                    address: {
                        required: "This field is required"
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#authorSubmit').html('Please Wait...');
                    $("#authorSubmit").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('coauthors.store') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            $('#authorSubmit').html('Submit');
                            $("#authorSubmit"). attr("disabled", false);
                            document.getElementById("SubmitCoAuthorForm").reset();
                            successMessage(response.message);
                        }
                    });
                }
            })
        } 
</script>