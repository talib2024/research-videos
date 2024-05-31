<style>
            div#social-links {
                margin: 0 auto;
                max-width: 500px;
            }
            div#social-links ul li {
                display: inline-block;
            }          
            div#social-links ul li a {
                padding: 4px;
                /*padding: 20px;
                border: 1px solid #ccc;
                margin: 1px;
                font-size: 30px;
                color: #222;
                background-color: #ccc;*/
            }
        </style>
<div class="video-view" style="position:relative;">
    <span title="Likes">
        <i class="fas fa-thumbs-up cursor_pointer mouse_hover" onclick="likeCounter(this)" data-videoId="{{ $video_list->id }}" data-like="1"></i>
        <span
            id="likecountCustom{{ $video_list->id }}">{{ isset($video_list->likecount) ? $video_list->likecount : $likecount }}</span>
    </span>
    <span class="mx-1" title="Views">
        <i class="fa fa-eye cursor_pointer mouse_hover" aria-hidden="true"></i>&nbsp;<span id="videoview{{ $video_list->id }}">{{ isset($video_list->video_view_count) ? $video_list->video_view_count : $video_view_count }}</span>
    </span>
    <span class="mx-2" title="Publication date">
        &nbsp;<i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($video_list->historycurrentstatus_created_at)->format('Y/m/d') }}
    </span>
    <span class="me-2">
        @php $shareComponent = social_share(route('video.details',$video_list->id)); @endphp
        &nbsp;<a href="{{ $shareComponent['facebook'] }}" target="_BLANK" title="Share on Facebook"><i class="fab fa-facebook customSocialIcon"></i></a>
        &nbsp;<a href="{{ $shareComponent['whatsapp'] }}" target="_BLANK" title="Share on Whatsapp"><i class="fab fa-whatsapp customSocialIcon"></i></a>
        &nbsp;<a href="{{ $shareComponent['twitter'] }}" target="_BLANK" title="Share on Twitter"><i class="fab fa-twitter customSocialIcon"></i></a>
        &nbsp;<a href="{{ $shareComponent['linkedin'] }}" target="_BLANK" title="Share on Linkedin"><i class="fab fa-linkedin customSocialIcon"></i></a>
        &nbsp;<a href="https://www.instagram.com/accounts/login/" target="_BLANK" title="Share on Instagram"><i class="fab fa-instagram customSocialIcon"></i></a>
    </span>
    @if ($video_list->membershipplan_id == 1)
        <span class="mx-2 lock-icon" title="Regular">
            <i class="fas fa-lock"></i>
        </span>
    @elseif($video_list->membershipplan_id == 2)
        <span class="mx-2 lock-open-icon" title="Open access">
            <i class="fas fa-lock-open"></i>
        </span>
    @endif
    
    @auth
    @if (isset($video_list->watch_list_type) &&
            !empty($video_list->watch_list_type) &&
            ($video_list->watch_list_type == 1))
        <span class="mx-2">
            <i class="fas fa-plus-circle fa-fw" style="display:none;" id="addWatchLater{{ $video_list->id }}"
                title="Watch later" onclick="watchlater(this)" data-videoId="{{ $video_list->id }}"
                data-isadded="0"></i>
            <i class="fas fa-check-circle text-success" id="alreadyAddedWatchLater{{ $video_list->id }}"
                title="Added in watch list" onclick="watchlater(this)" data-videoId="{{ $video_list->id }}"
                data-isadded="1"></i>
        </span>
    @else
        <span class="mx-1">
            <i class="fas fa-plus-circle fa-fw" id="addWatchLater{{ $video_list->id }}" title="Watch later"
                onclick="watchlater(this)" data-videoId="{{ $video_list->id }}" data-isadded="0"></i>
            <i class="fas fa-check-circle text-success" style="display:none;"
                id="alreadyAddedWatchLater{{ $video_list->id }}" title="Added in watch list" onclick="watchlater(this)"
                data-videoId="{{ $video_list->id }}" data-isadded="1"></i>
        </span>
    @endif
    @if(Route::currentRouteName() != 'watch.list')
    <span class="mx-1 lock-open-icon">
            <a href="{{ route('watch.list') }}">Go to watchlist</a>
    </span>
    @endif
    @endif
    <span class="mx-1" title="Cite this video">
           <a href="#" name="cite" class="popover-trigger" data-video-id="{{ Crypt::encrypt($video_list->id) }}"><i class="fa fa-quote-left"> Cite</i></a>
    </span>
</div>


<!-- export modal -->

<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content background_color">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">Download Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Export into: <a href="#" id="confirmDownload">BibTex</a>
            </div>
           
        </div>
    </div>
</div>

<!-- export modal -->