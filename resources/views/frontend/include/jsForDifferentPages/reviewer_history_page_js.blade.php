<script>
if ($("#acceptanceReviewer_member_form").length > 0) {
    $("#acceptanceReviewer_member_form").validate({                
        rules: {
            videohistorystatus_id: {
                required: true
            },
            /*message: {
                required: true
            },*/
        },
        messages: {
            videohistorystatus_id: {
                required: "This field is required"
            },
            /*message: {
                required: "This field is required"
            },*/
        },
        submitHandler: function(form) {
            var formData = new FormData(form);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#acceptanceReviewer_form_Submit').html('Please Wait...');
            $("#acceptanceReviewer_form_Submit").attr("disabled", true);

            $.ajax({
                url: '{{ route('store.history.by.reviewer') }}',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
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
if ($("#Submitreviewer_member_form").length > 0) {
    $("#Submitreviewer_member_form").validate({                
        rules: {
            videohistorystatus_id: {
                required: true
            },
            message: {
                required: true
            },
        },
        messages: {
            videohistorystatus_id: {
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

            $('#reviewer_form_Submit').html('Please Wait...');
            $("#reviewer_form_Submit").attr("disabled", true);

            $.ajax({
                url: '{{ route('store.history.by.reviewer.after.login') }}',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
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