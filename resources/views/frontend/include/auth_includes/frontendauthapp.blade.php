<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <title>ResearchVideos</title>
      @include('frontend.include.cssurls')
   </head>
   <body class="login-main-body">
      <section class="login-main-wrapper">
         <div class="container-fluid pl-0 pr-0">
            <div class="row no-gutters authBackgroundSection">

@yield('content')

            </div>
         </div>
      </section>
@include('frontend.include.jsurls')

<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: '{{ route("reload.captcha") }}',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

// Start for organisation js
$("input[name=organization_type]").change(function() {
    const organization_type = $(this).val();
    organization_div_show_hide(organization_type)
});

const selected_organization_type =  $('input[name="organization_type"]:checked').val();
organization_div_show_hide(selected_organization_type)

function organization_div_show_hide(organization_type)
{
    if(organization_type == 1)
    {
        $(".main_organization_div").show();
        $(".employee_of_organization_div").hide();
    }
    else if(organization_type == 2)
    {
        $(".main_organization_div").hide();
        $(".employee_of_organization_div").show();
    }
}

var route_name = "{{ route('organization.name.search') }}";

$(document).ready(function(){
        $('#employee_institute_name').on('keyup',function(){
            var query= $(this).val(); 
            $.ajax({
                url:route_name,
                type:"GET",
                data:{'search':query},
                success:function(data){ 
                    $('#employee_institute_name_list').html(data);
                }
            });
             //end of ajax call
        });
    });

$(document).ready(function () {
    // Handle row click event
    $(document).on('click', '.employee_institute_name_list_table th', function () {
        // Get the data-id attribute from the clicked cell
        var selectedInstituteId = $(this).data('id');
        // Get the text content of the clicked cell
        var selectedInstituteText = $(this).text();

        // Update the search box and hidden field with the selected values
        $('#employee_institute_name').val(selectedInstituteText);
        $('#institute_id').val(selectedInstituteId);
        $('#employee_institute_name_list').empty();
        // Hide the dropdown
        $('.employee_institute_name_list_table th').closest('.dropdown').removeClass('open');
    });
});
// End for organisation js

document.addEventListener("contextmenu", (e) => e.preventDefault(), false);
</script>
@stack('pushjs')
   </body>

</html>