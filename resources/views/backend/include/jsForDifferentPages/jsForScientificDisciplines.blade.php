<script>
$.validator.addMethod("fileType", function(value, element) {
    return this.optional(element) || /\.(webm|gif|svg)$/i.test(value);
}, "Please upload a valid image file (WEBM, GIF, SVG).");

$.validator.addMethod("fileSize", function(value, element) { 
    return this.optional(element) || (element.files[0].size / 1024 < 300); // in KB
}, "File size must be less than 300KB.");

 if ($("#scientific_disciplines_form").length > 0) {
            $("#scientific_disciplines_form").validate({
                rules: {
                    category_name: {
                        required: true
                    },
                    short_name: {
                        required: true
                    },
                    scientific_disciplines_image: {
                        required: true,
                        fileSize: true, // Adding the fileSize validation rule
                        fileType: true
                    },
                },
                messages: {
                    category_name: {
                        required: "This field is required"
                    },
                    short_name: {
                        required: "This field is required"
                    },
                    scientific_disciplines_image: {
                       required: "This field is required",
                       fileSize: "File size must be less than 300 KB", // Adjust the message according to your file size limit
                       fileType: "Please upload only webm, svg or gif files"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#scientific_disciplines_form_submit').html('Please Wait...');
                    $("#scientific_disciplines_form_submit").attr("disabled", true);
                    var url = "{{ route('scientificdisciplines.store') }}";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {                                                            
                            window.location.reload();
                        }
                    });
                }
            });
        } 

if ($("#scientific_disciplines_form_update").length > 0) {
            $("#scientific_disciplines_form_update").validate({
                rules: {
                    category_name: {
                        required: true
                    },
                    short_name: {
                        required: true
                    },
                    scientific_disciplines_image: {
                        fileSize: true, // Adding the fileSize validation rule
                        fileType: true
                    },
                },
                messages: {
                    category_name: {
                        required: "This field is required"
                    },
                    short_name: {
                        required: "This field is required"
                    },
                    scientific_disciplines_image: {
                       fileSize: "File size must be less than 300 KB", // Adjust the message according to your file size limit
                       fileType: "Please upload only webm, svg or gif files"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    const category_id_update = $('#category_id_update').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#scientific_disciplines_form_submit_update').html('Please Wait...');
                    $("#scientific_disciplines_form_submit_update").attr("disabled", true);
                    var url = "{{ route('scientificdisciplines.update', ':category_id_update22') }}";
                    url = url.replace(':category_id_update22', category_id_update);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {                                                            
                            window.location.reload();
                        }
                    });
                }
            });
        } 

if ($("#scientific_sub_disciplines_form").length > 0) {
            $("#scientific_sub_disciplines_form").validate({
                rules: {
                    majorcategory_id: {
                        required: true
                    },
                    subcategory_id: {
                        required: true
                    },
                    sub_discipline_description: {
                        required: true
                    },
                },
                messages: {
                    majorcategory_id: {
                        required: "This field is required"
                    },
                    subcategory_id: {
                        required: "This field is required"
                    },
                    sub_discipline_description: {
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

                    $('#scientific_sub_disciplines_form_submit').html('Please Wait...');
                    $("#scientific_sub_disciplines_form_submit").attr("disabled", true);
                    var url = "{{ route('scientificsubdisciplines.store') }}";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {                                                            
                            window.location.reload();
                        }
                    });
                }
            });
        } 

if ($("#scientific_sub_disciplines_form_update").length > 0) {
            $("#scientific_sub_disciplines_form_update").validate({
                rules: {
                    majorcategory_id: {
                        required: true
                    },
                    subcategory_id: {
                        required: true
                    },
                    sub_discipline_description: {
                        required: true
                    },
                },
                messages: {
                    majorcategory_id: {
                        required: "This field is required"
                    },
                    subcategory_id: {
                        required: "This field is required"
                    },
                    sub_discipline_description: {
                        required: "This field is required"
                    },
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    const sub_category_update = $('#sub_category_update').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#scientific_sub_disciplines_form_submit_update').html('Please Wait...');
                    $("#scientific_sub_disciplines_form_submit_update").attr("disabled", true);
                    
                    var url = "{{ route('scientificsubdisciplines.update', ':sub_category_update22') }}";
                    url = url.replace(':sub_category_update22', sub_category_update);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {                                                            
                            window.location.reload();
                        }
                    });
                }
            });
        } 
</script>