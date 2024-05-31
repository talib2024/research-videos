<div class="video-card-image">
{{-- <video class="img-fluid myVideo video-js vjs-default-skin" id="content_video{{ $video_list->id }}" preload="none" controls
        data-video-id="{{ Crypt::encrypt($video_list->id) }}" data-setup='{}'> --}}
    @php
        if (Auth::check())
        {
            if ($video_list->membershipplan_id == 2 || ($video_list->membershipplan_id == 1 && $video_list->hasPaid == 1) || ($video_list->is_subscription_valid == 1) || ($video_list->is_subscription_valid_institute == 1) || ($checkUserSubscriptionPlan == 1))
            {
                $src = "route('video.player.show', ['filename' => $video_list->unique_number.'_cropped.m3u8','type' => 'cropped','video_id' => $video_list->unique_number])";
            }
            else
            {
                $src = "route('video.player.show', ['filename' => $video_list->unique_number.'.m3u8','type' => 'full','video_id' => $video_list->unique_number])";
            }   
        }
        else
        {
            $src = "route('video.player.show', ['filename' => $video_list->unique_number.'.m3u8','type' => 'full','video_id' => $video_list->unique_number])";
        }
    @endphp
    <video class="img-fluid myVideo video-js vjs-default-skin" id="content_video{{ $video_list->id }}" preload="none" controls disablepictureinpicture
        data-video-id="{{ Crypt::encrypt($video_list->id) }}" data-membershipplan-id="{{ $video_list->membershipplan_id }}" src="{{ $src }}" poster="{{ route('show_video_images',['unique_number' => $video_list->unique_number]) }}">
        @if (Auth::check())
            @if ($video_list->membershipplan_id == 2 || ($video_list->membershipplan_id == 1 && $video_list->hasPaid == 1) || ($video_list->is_subscription_valid == 1) || ($video_list->is_subscription_valid_institute == 1) || ($checkUserSubscriptionPlan == 1))
            <source src="{{ route('video.player.show', ['filename' => $video_list->unique_number.'.m3u8','type' => 'full','video_id' => $video_list->unique_number]) }}" type="application/x-mpegURL" class="full-video">
            @else            
            <source src="{{ route('video.player.show', ['filename' => $video_list->unique_number.'_cropped.m3u8','type' => 'cropped','video_id' => $video_list->unique_number]) }}" type="application/x-mpegURL" class="short-video">
            @endif
        @else
            <source src="{{ route('video.player.show', ['filename' => $video_list->unique_number.'_cropped.m3u8','type' => 'cropped','video_id' => $video_list->unique_number]) }}" type="application/x-mpegURL" class="short-video">
        @endif
    </video>
    <div class="overlay"
        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
        <p align="center" class="auth_P">You need to login and pay to continue watching this video.</p>
        <p align="center" class="auth_P"><a href="{{ route('member.login') }}" class="btn btn-primary">Login</a></p>
    </div>
    <div class="freeoverlay"
        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
        <p align="center" class="auth_P">You need to login to continue watching this video.</p>
        <p align="center" class="auth_P"><a href="{{ route('member.login') }}" class="btn btn-primary">Login</a></p>
    </div>
    <div class="paymentoverlay"
        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
        <p align="center" class="auth_P">Please pay to continue watching this video.</p>
        @if (Auth::check() && Auth::user()->is_organization == 0)
            <p align="center" class="auth_P"><a href="#" data-paypal_video_id="{{ Crypt::encrypt($video_list->id) }}"
                data-paypal_video_price="{{ $video_list->video_price }}" data-video_amount_RVcoins="{{ $video_list->rv_coins_price }}" data-user_total_coins="{{ $loggedIn_user_details->total_rv_coins }}" class="paymentButton btn btn-primary">Pay Now</a></p>
        @else
            <p align="center" class="auth_P"><a href="{{ route('subscription') }}" data-paypal_video_id="{{ Crypt::encrypt($video_list->id) }}"
                data-paypal_video_price="{{ $video_list->video_price }}" class="btn btn-primary">Pay Now</a></p>
        @endif
    </div>
    <div id="overlay_counter{{ $video_list->id }}"
        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
        <p id="overlay_counter_msg{{ $video_list->id }}"></p>
    </div>
</div>
<div class="video-card-body">
    <div class="video-title">
        <a href="{{ route('video.details', $video_list->id) }}">{{ $video_list->video_title }} - {{ $video_list->unique_number }}</a>
    </div>
    <div class="video-page text-success">
        @php
            $subcategoryIds = json_decode($video_list->subcategory_id);
            $matchingSubcategories = $all_subcategories->whereIn('id', $subcategoryIds);
            $subcategoryLinks = [];
            foreach ($matchingSubcategories as $subcategory) 
            {
                $subcategoryLinks[] = '<a href="' . route('sub.category.wise.video', [$subcategory->id]) . '" class="gray-color">' . $subcategory->subcategory_name . '</a>';
            }
            $subcategoryNames = implode(', ', $subcategoryLinks);
            //$subcategoryNames = $matchingSubcategories->pluck('subcategory_name')->implode(', ');
        @endphp
        <a href="{{ route('category.wise.video',$video_list->majorcategories_id) }}"><b class="gray-color">{{ $video_list->category_name }}</b></a> - <span class="gray-color">{!! $subcategoryNames !!}</span>
        <span class="mx-3">&nbsp;</span>
        <span class="mx-2">&nbsp;</span>
        <span>&nbsp;</span>

        {{-- @if (Auth::check())
            @if ($video_list->membershipplan_id == 2 || ($video_list->membershipplan_id == 1 && $video_list->hasPaid == 1) || ($video_list->is_subscription_valid == 1))       
                <a href="#" class="btn btn-primary" style="padding: 0 5px 0 5px;font-size: 13px;visibility:hidden;">&nbsp;</a>
            @else  
                @if (Auth::check() && Auth::user()->is_organization == 0)
                <a href="#" data-paypal_video_id="{{ Crypt::encrypt($video_list->id) }}" data-video_amount_RVcoins="{{ $video_list->rv_coins_price }}" data-paypal_video_price="{{ $video_list->video_price }}" data-user_total_coins="{{ $loggedIn_user_details->total_rv_coins }}" class="paymentButton btn btn-primary" style="padding: 0 5px 0 5px;font-size: 13px;">Pay Now</a>
                @else
                <a href="{{ route('subscription') }}" class="btn btn-primary" style="padding: 0 5px 0 5px;font-size: 13px;">Pay Now</a>
                @endif
            @endif
        @else
            <a href="{{ route('member.login') }}" class="btn btn-primary" style="padding: 0 5px 0 5px;font-size: 13px;">Login</a>
        @endif --}}
    </div>
    @include('frontend.include.video_options')
</div>
