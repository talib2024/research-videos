<div class="row">
    <div class="col-12">
        <div class="main-title">
            <h6>History of video ID: <b class="required">{{ $video_list->unique_number }}</b></h6>
        </div>

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                {{-- <h6>Total active task:</h6> --}}
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Remark</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($video_history as $video_history_value)
                            <tr>
                                {{-- <td>{!! ($video_history_value->send_from_user_email == Auth::user()->email) ? '<b class="required">You</b>' : $video_history_value->send_from_user_email .' ('.$video_history_value->send_from_as.')'  !!}</td> --}}
                                <td>
                                    @if(!empty($video_history_value->reviewer_email) && $video_history_value->send_from_as == 'Reviewer')
                                        {{-- {!! ($user_role_id == '2' || $user_role_id == '7') ? ' ('.$video_history_value->send_from_as.')' : $video_history_value->reviewer_email .' ('.$video_history_value->send_from_as.')'  !!} --}}
                                        {{-- @if($user_role_id == '2' || $user_role_id == '7')
                                            {!! ' ('.$video_history_value->send_from_as.')'  !!}
                                        @elseif($user_role_id == '4' && $video_history_value->reviewer_email != Auth::user()->email)
                                            {!! ' ('.$video_history_value->send_from_as.')'  !!}
                                        @else --}}
                                            {!! $video_history_value->reviewer_email .' ('.$video_history_value->send_from_as.')'  !!}
                                        {{-- @endif --}}

                                    @elseif(!empty($video_history_value->corresponding_author_email) && $video_history_value->send_from_as == 'Corresponding-Author')
                                        {!! $video_history_value->corresponding_author_email .' ('.$video_history_value->send_from_as.')'  !!}
                                    @else
                                        {{-- {!! ($video_history_value->send_from_user_email == Auth::user()->email) ? '<b class="required">You</b>' : $video_history_value->send_from_user_email .' ('.$video_history_value->send_from_as.')'  !!} --}}
                                        {!! $video_history_value->send_from_user_email .' ('.$video_history_value->send_from_as.')'  !!}
                                    @endif
                                </td>
                                {{-- <td>{!! ($video_history_value->send_to_user_email == Auth::user()->email) ? '<b class="required">You</b>' : $video_history_value->send_to_user_email .' ('.$video_history_value->send_to_as.')'  !!}</td> --}}
                                <td>
                                    @if(!empty($video_history_value->reviewer_email) && $video_history_value->send_to_as == 'Reviewer')
                                        @if($video_history_value->videohistorystatus_id == '7' || $video_history_value->videohistorystatus_id == '8' || $video_history_value->videohistorystatus_id == '26' || $video_history_value->videohistorystatus_id == '27' || $video_history_value->videohistorystatus_id == '18' || $video_history_value->videohistorystatus_id == '19' || $video_history_value->videohistorystatus_id == '24' )
                                        {!! '-' !!}
                                        @else
                                        {{-- {!! ($user_role_id == '2' || $user_role_id == '7') ? ' ('.$video_history_value->send_to_as.')' : $video_history_value->reviewer_email .' ('.$video_history_value->send_to_as.')'  !!} --}}
                                            {{-- @if($user_role_id == '2' || $user_role_id == '7')
                                                {!! ' ('.$video_history_value->send_to_as.')'  !!}
                                            @elseif($user_role_id == '4' && $video_history_value->reviewer_email != Auth::user()->email)
                                                {!! ' ('.$video_history_value->send_to_as.')'  !!}
                                            @else --}}
                                                {!! $video_history_value->reviewer_email .' ('.$video_history_value->send_to_as.')'  !!}
                                            {{-- @endif --}}
                                        @endif
                                    @elseif(!empty($video_history_value->corresponding_author_email) && $video_history_value->send_to_as == 'Corresponding-Author')
                                        @if($video_history_value->videohistorystatus_id == '7' || $video_history_value->videohistorystatus_id == '8' || $video_history_value->videohistorystatus_id == '26' || $video_history_value->videohistorystatus_id == '27' || $video_history_value->videohistorystatus_id == '18' || $video_history_value->videohistorystatus_id == '19' || $video_history_value->videohistorystatus_id == '24' )
                                        {!! '-' !!}
                                        @else
                                        {!! $video_history_value->corresponding_author_email .' ('.$video_history_value->send_to_as.')'  !!}
                                        @endif
                                    @else
                                        {{-- {!! ($video_history_value->send_to_user_email == Auth::user()->email) ? '<b class="required">You</b>' : $video_history_value->send_to_user_email .' ('.$video_history_value->send_to_as.')'  !!} --}}
                                        @if($video_history_value->videohistorystatus_id == '7' || $video_history_value->videohistorystatus_id == '8' || $video_history_value->videohistorystatus_id == '26' || $video_history_value->videohistorystatus_id == '27' || $video_history_value->videohistorystatus_id == '18' || $video_history_value->videohistorystatus_id == '19' || $video_history_value->videohistorystatus_id == '24' )
                                        {!! '-' !!}
                                        @else
                                        {!! $video_history_value->send_to_user_email .' ('.$video_history_value->send_to_as.')'  !!}
                                        @endif
                                    @endif
                                </td>
                                @if($video_history_value->corresponding_author_status == 1)
                                    <td>Rejected</td>
                                @elseif($video_history_value->videohistorystatus_id == 7 && $video_history_value->withdraw_reviewer == 1)
                                    <td>{{ $video_history_value->text_to_show_on_history }} (Withdrew Reviewer)</td>
                                @elseif($video_history_value->videohistorystatus_id == 7 && $video_history_value->is_pass_to_other_than_reviewer == 1)
                                    <td>{{ $video_history_value->text_to_show_on_history }}</td>
                                @else
                                    <td>{{ $video_history_value->text_to_show_on_history }}</td>
                                @endif
                                <td>{{ \Carbon\Carbon::parse($video_history_value->created_at)->format('Y/m/d  H:i:s') }}</td>
                                @if($user_role_id == '3' || $user_role_id == '4' || $user_role_id == '5')
                                    <td><a href="#" class="view-message" data-message-id="{{ $video_history_value->videohistories_id }}">View message</a></td>
                                @elseif(($user_role_id == '2' || $user_role_id == '7') && ($video_history_value->message_visibility == 1))
                                    <td><a href="#" class="view-message" data-message-id="{{ $video_history_value->videohistories_id }}">View message</a></td>
                                @else
                                    <td>-</td>
                                @endif
                            </tr>                            
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<div id="modalHistoryMessages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg" style="overflow-y: initial !important;">
        <div class="modal-content background_color">
            <div class="modal-header row d-flex justify-content-between mx-1 mx-sm-3 mb-0 pb-0 border-0">
                <div class="tabs active" id="tab011">
                    <h6>History message:</h6>
                </div>
            </div>
            <div class="line"></div>
            <div class="modal-body p-0" style="height: 550px; overflow-y: auto;">
                <fieldset class="show" id="tab011">
                    <div class="background_color">
                        <p class="mb-4 mt-0 mr-4 ml-4 pt-1 messageheading authParaFontSize"></p>
                    </div>
                </fieldset>

            </div>
            <div class="line"></div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>
@push('pushjs')
    <script>
        $(document).ready(function() {
            $('.view-message').click(function(e) {
                e.preventDefault();
                var messageId = $(this).data('message-id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('show.history.messages') }}", // Replace this with your route to fetch message details
                    type: 'POST',
                    data: {'historyid': messageId},
                    success: function(response) {
                        console.log(response);
                        // Populate modal body with message details
                        if(response.record.message != null && response.record.message != 'null')
                            $('.messageheading').html(response.record.message);
                        else
                            $('.messageheading').html('no messages');
                        // Open the modal
                        $('#modalHistoryMessages').modal('show');
                    },
                    error: function(xhr) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });
        });

 
    </script>
@endpush
