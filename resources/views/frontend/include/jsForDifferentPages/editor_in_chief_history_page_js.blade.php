<script>
$(document).ready(function(){
    $('#pass_to').on('change', function() {
        const pass_to_id = $('#pass_to').val();
        toggleDiv_based_on_passTO(pass_to_id);
    });
});
function toggleDiv_based_on_passTO(pass_to_id)
{
    if (pass_to_id == '3') 
    {
        $("#editorial_member_div").hide();
        $("#reviewer_div").hide();
        $("#publisher_div").hide();
        $("#message_div").show();
        $("#status_for_authors_div").show();
        $("#reviewer_div_form").hide();
        $("#withdraw_reviewer_div").hide();
        $(".editorRevieweremail").val();
    } 
    else if(pass_to_id == '4') 
    {
        $("#editorial_member_div").show();
        $("#reviewer_div").hide();
        $("#publisher_div").hide();
        $("#message_div").show();
        $("#status_for_authors_div").hide();
        $("#reviewer_div_form").hide();
        $("#withdraw_reviewer_div").hide();
        $(".editorRevieweremail").val('');
    }
    else if(pass_to_id == '5') 
    {
        $("#editorial_member_div").hide();
        $("#reviewer_div").show();
        $("#publisher_div").hide();
        $("#message_div").show();
        $("#status_for_authors_div").hide();
        $("#reviewer_div_form").show();
        $("#withdraw_reviewer_div").show();
    }
    else if(pass_to_id == '6') 
    {
        $("#editorial_member_div").hide();
        $("#reviewer_div").hide();
        $("#publisher_div").show();
        $("#message_div").show();
        $("#status_for_authors_div").hide();
        $("#reviewer_div_form").hide();
        $("#withdraw_reviewer_div").hide();
        $(".editorRevieweremail").val('');
    }
    else if(pass_to_id == '25') 
    {
        $("#editorial_member_div").hide();
        $("#reviewer_div").hide();
        $("#publisher_div").hide();
        $("#message_div").show();
        $("#status_for_authors_div").hide();
        $("#reviewer_div_form").hide();
        $("#withdraw_reviewer_div").hide();
        $(".editorRevieweremail").val('');
    }
}
if ($("#Submiteditor_chief_form").length > 0) {
            $("#Submiteditor_chief_form").validate({                
                rules: {
                    pass_to: {
                        required: true
                    },
                    'editorial_member_id[]': {
                        required: true
                    },
                    'reviewer_email[]': {
                        required: true
                    },
                    reviewer_id: {
                        required: true
                    },
                    publisher_id: {
                        required: true
                    },
                    status_for_authors: {
                        required: true
                    },
                    message: {
                        required: true
                    },
                },
                messages: {
                    pass_to: {
                        required: "This field is required"
                    },
                    'editorial_member_id[]': {
                        required: "This field is required"
                    },
                    'reviewer_email[]': {
                        required: "This field is required"
                    },
                    reviewer_id: {
                        required: "This field is required"
                    },
                    publisher_id: {
                        required: "This field is required"
                    },
                    status_for_authors: {
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

                    $('#editor_chief_form_Submit').html('Please Wait...');
                    $("#editor_chief_form_Submit").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('editor.in.chief.store.history') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response.success == 'Successfully')
                            {
                                window.location.reload();
                            }  
                            else
                            {
                                $('#pass_to_error').html(response.msg);
                                $('#editor_chief_form_Submit').html('Submit');
                                $("#editor_chief_form_Submit"). attr("disabled", false);
                            }                          
                        }
                    });
                }
            })
        } 

/*$("#editorial_member_id").select2({
    placeholder: "Editorial Members",
    allowClear: true
});
$("#reviewer_email").select2({
    placeholder: "Reviewers List",
    allowClear: true
});*/

if ($("#Submiteditor_reviewer_form").length > 0) {
            $("#Submiteditor_reviewer_form").validate({  
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#Submiteditor_reviewer_form_Submit').html('Please Wait...');
                    $("#Submiteditor_reviewer_form_Submit").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('editor.store.reviewer') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response.success == 'Successfully')
                            {
                                window.location.reload();
                            }  
                            else
                            {
                                $('#Submiteditor_reviewer_form_Submit').html('Add Reviewer');
                                $("#Submiteditor_reviewer_form_Submit"). attr("disabled", false);
                            }                          
                        }
                    });
                }
            })
        } 


$(document).ready(function () {
    // Initialize Bootstrap Multiselect
     $('.withdraw_reviewer_email').multiselect({
        buttonWidth: '100%',
        enableFiltering: true,  // Enable filtering
        enableCaseInsensitiveFiltering: true,  // Make filtering case-insensitive
        maxHeight: 200,  // Set a maximum height for the dropdown
    });

   $('.reviewer_email').multiselect({
        buttonWidth: '100%',
        enableFiltering: true,  // Enable filtering
        enableCaseInsensitiveFiltering: true,  // Make filtering case-insensitive
        maxHeight: 200,  // Set a maximum height for the dropdown
    });

    // Add event listener to limit selection to 4
    $('.reviewer_email').on('change', function () {
        var selectedOptions = $('.reviewer_email option:selected:not([value=""])');

        if (selectedOptions.length > 4) {
            // Deselect the last option if more than 3 are selected
            selectedOptions.last().prop('selected', false);
        }

        // Disable remaining options excluding the "Select" option
        $('.reviewer_email option:not(:selected)').not('[value=""]').prop('disabled', selectedOptions.length >= 4);

        // Rebuild the multiselect to reflect the change
        $('.reviewer_email').multiselect('rebuild');
    });

    
});
</script>

@if(in_array('3', $pass_to))
<script>toggleDiv_based_on_passTO(3);</script>

@elseif(in_array('4', $pass_to))
<script>toggleDiv_based_on_passTO(4);</script>

@elseif(in_array('5', $pass_to))
<script>toggleDiv_based_on_passTO(5);</script>

@elseif(in_array('6', $pass_to))
<script>toggleDiv_based_on_passTO(6);</script>

@elseif(in_array('25', $pass_to))
<script>toggleDiv_based_on_passTO(25);</script>
@endif