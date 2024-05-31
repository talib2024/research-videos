<script>
if ($("#SubmitPublisher_form").length > 0) {
            $("#SubmitPublisher_form").validate({                
                rules: {
                    videohistorystatus_id: {
                        required: true
                    },
                    message: {
                        required: true
                    },
                    membershipplan_id: {
                        required: true
                    },
                    video_price: {
                        required: true,
                        number: true
                    },
                    rv_coins_price: {
                        required: true,
                        number: true
                    },
                },
                messages: {
                    videohistorystatus_id: {
                        required: "This field is required"
                    },
                    message: {
                        required: "This field is required"
                    },
                    membershipplan_id: {
                        required: "This field is required"
                    },
                    video_price: {
                        required: "This field is required",
                        number: "The amount must be a number"
                    },
                    rv_coins_price: {
                        required: "This field is required",
                        number: "The coins must be a number"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#publisher_form_Submit').html('Please Wait...');
                    $("#publisher_form_Submit").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('store.history.by.publisher') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            //$('#publisher_form_Submit').html('Please Wait...');
                   // $("#publisher_form_Submit").attr("disabled", false);
                            if(response.success == 'Successfully')
                            {
                                window.location.reload();
                            } 
                            else if(response.success == 'failed')
                            {
                                window.location.reload();
                            }                            
                        }
                    });
                }
            })
        } 
</script>