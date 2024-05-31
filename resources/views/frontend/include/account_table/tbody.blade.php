<tr>
    <td>{{ $video_list->unique_number }}</td>
    @if($user_role_id == '2' || $user_role_id == '5') 
    <td>{{ $video_list->category_name }}</td>
    @endif
    <td>{{ \Carbon\Carbon::parse($video_list->created_at)->format('Y/m/d  H:i:s') }}</td>
    <td>{{ $video_list->historycurrentstatus_text }}</td>
    <td>{{ ($video_list->historycurrentstatus_created_at) ? \Carbon\Carbon::parse($video_list->historycurrentstatus_created_at)->format('Y/m/d  H:i:s') : '' }}</td>
    {{-- @if($user_role_id == '3')
        @if((isset($video_list->historycurrentstatus_videohistorystatus_id) && $video_list->historycurrentstatus_videohistorystatus_id != '18' && $video_list->historycurrentstatus_videohistorystatus_id != '7' && $video_list->historycurrentstatus_videohistorystatus_id != '3' && $video_list->historycurrentstatus_videohistorystatus_id != '24' && $video_list->historycurrentstatus_videohistorystatus_id != '19' && $video_list->historycurrentstatus_send_to_user_id == Auth::id()))
            <td><a href="#" data-video_id="{{ Crypt::encrypt($video_list->id) }}" class="passToAnotherMember btn butn">Pass</a></td>
        @else
            <td>-</td>
        @endif
    @endif --}}
    <td><a href="{{ route('video.edit', $video_list->id) }}" class="btn butn"><i class="fas fa-eye"></i></a></td>
</tr>