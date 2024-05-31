 <div class="video-block section-padding">
                <div class="row">
                    <div class="col-md-12">
                    <h6>Total active task:</h6>
                    <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Total assigned videos</th>
                            <th>Non-active task</th>
                            <th>Active task</th>
                        </tr>
                        <tr>
                            <td>{{ $assigned_task_count_editor_member['total_count'] }}</td>
                            <td>{{ $assigned_task_count_editor_member['non_active_count'] }}</td>
                            <td>{{ $assigned_task_count_editor_member['active_count'] }}</td>
                        </tr>
                    </thead>
                    </table>
                        <div class="main-title">
                            {{-- <div class="btn-group float-right right-action">
                                <a href="#" class="right-action-link text-gray" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Last
                                        published</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Most
                                        liked</a>
                                </div>
                            </div> --}}
                            <h6>Videos assigned for you:</h6>
                        </div>
                    </div>

                    @if ($video_list_for_editor_member->isNotEmpty())
                    <div class="common-history-form-box table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                @include('frontend.include.account_table.thead')
                                <tbody>                        
                                    @foreach ($video_list_for_editor_member as $video_list)
                                        @include('frontend.include.account_table.tbody')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-lg-12 mb-4">
                            <div class="form-box">
                                <h5>No videos assigned for you!</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>


<!-- start modal -->
<div id="modalPassToanotherMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row d-flex justify-content-between mx-1 mx-sm-3 mb-0 pb-0 border-0">
                <div class="tabs active" id="tab01">
                    <h6 class="text-muted">Pass to another editorial member</h6>
                </div>
            </div>
            <div class="line"></div>
            <div class="modal-body p-0">
                <fieldset class="show" id="tab011">
                    <div class="bg-light px-3">
                        <form id="PassToanotherMemberForm" autoComplete="off">
                            @csrf
                            <input type="hidden" value="" name="video_id" id="video_id" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="message">Message<b class="red">*</b></label>
                                        <textarea id="message" name="message" class="form-control border-form-control" ></textarea>
                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Captcha</label>
                                            <div class="captcha_video">
                                                <span>{!! captcha_img() !!}</span>
                                                <button type="button" class="btn btn-danger captchaButton_video" class="reload_video" id="reload_video">
                                                        &#x21bb;
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <label>Enter Captcha<b class="required">*</b></label><span class="required">{{ $errors->first('captcha') }}</span>
                                            <input id="captcha_video" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                            <span class="custom_error required" id="captcha_wiretransfer-error"></span>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row" style="margin:10px 0 0 165px">
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-outline-primary" id="PassToanotherMemberUpdate">Pass</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </fieldset>

            </div>
            <div class="line"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPassToanotherMemberSuccess" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
                </div>
            
            <div class="modal-body">
                
                <div class="thank-you-pop">
                    <img src="{{ asset('frontend/img/Green-Round-Tick.png') }}" alt="">
                    <h1>Thank You!</h1>
                    <p>Passed successfully to the other editorial member.</p>							
                </div>
                    
            </div>
            
        </div>
    </div>
</div>
<!-- End modal -->

@push('pushjs')
<script>
 if ($("#PassToanotherMemberForm").length > 0) {
            $("#PassToanotherMemberForm").validate({
                rules: {
                    message: {
                        required: true
                    },
                },
                messages: {
                    message: {
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

                    $('#PassToanotherMemberUpdate').html('Please Wait...');
                    $("#PassToanotherMemberUpdate").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('pass.to.another.editorial.member') }}',
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            $('#PassToanotherMemberUpdate').html('Upload Details');
                            $("#PassToanotherMemberUpdate"). attr("disabled", false);
                            /*$("#captcha_wiretransfer-error").html('');
                            var errors = JSON.parse(xhr.responseText).errors;
                            $.each(errors, function(key, value) {
                                $("#" + key + "_wiretransfer-error").html(value[0]);
                            });
                            reloadCaptcha_video();
                            $('#PassToanotherMemberUpdate').html('Upload Details');
                            $("#PassToanotherMemberUpdate"). attr("disabled", false);*/
                        }
                    });
                }
            })
        } 


$(document).on("click", ".passToAnotherMember", function () {
     const video_id = $(this).data('video_id');
     $('#video_id').val(video_id);
     $('#modalPassToanotherMember').modal('show');
});
</script>

@if (session('success'))
<script>
$(document).ready(function(){
   $('#modalPassToanotherMemberSuccess').modal('toggle');
});
</script>
@endif
@endpush