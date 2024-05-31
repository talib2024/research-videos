<div class="video-view">
    <span>
         <i class="fas fa-thumbs-up" onclick="likeCounter(this)" data-videoId="{{ $video_list->id }}" data-like="1"></i>
         <span id="likecountCustom{{ $video_list->id }}">{{ isset($video_list->likecount) ? $video_list->likecount : $likecount }}</span>
    </span>
    <span class="mx-2">         
        &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
    </span>
    <span class="me-2">
        &nbsp;<i class="fab fa-facebook customSocialIcon"></i>
        &nbsp;<i class="fab fa-whatsapp customSocialIcon"></i>
        &nbsp;<i class="fab fa-twitter customSocialIcon"></i>
        &nbsp;<i class="fab fa-linkedin customSocialIcon"></i>
    </span>
    <span class="mx-3 lock-icon">
        <i class="fas fa-lock"></i>
    </span>
    <span class="mx-2">
        <i class="fas fa-plus-circle fa-fw" id="addWatchLater{{ $video_list->id }}" title="Watch later" onclick="watchlater(this)" data-videoId="{{ $video_list->id }}" data-isadded="0"></i>
        <i class="fas fa-check-circle text-success" id="alreadyAddedWatchLater{{ $video_list->id }}" title="Added in watch list" onclick="watchlater(this)" data-videoId="{{ $video_list->id }}" data-isadded="1"></i>
    </span>
</div>
