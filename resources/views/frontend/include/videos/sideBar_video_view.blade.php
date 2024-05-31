<div class="video-card video-card-list">
    <div class="video-card-image video-card-image-sideBar">
    {{-- <video style="position:unset !important;" class="img-fluid myVideoRightSideBar video-js vjs-default-skin" id="content_video{{ $video_list->id }}" preload="auto" controls="false" controlsList="nodownload"
        data-video-id="{{ Crypt::encrypt($video_list->id) }}">
        @if (Auth::check())
            @if ($video_list->membershipplan_id == 2 || ($video_list->membershipplan_id == 1 && $video_list->hasPaid == 1) || ($video_list->is_subscription_valid == 1) || ($checkUserSubscriptionPlan == 1))
            <source src="{{ $video_list->full_video_url }}" type="video/mp4" class="full-video-sidebar">
            @else
            <source src="{{ $video_list->short_video_url }}" type="video/mp4" class="short-video-sidebar">
            @endif
        @else
            <source src="{{ $video_list->short_video_url }}" type="video/mp4" class="short-video-sidebar">
        @endif
    </video> --}}

    <img src="{{ route('show_video_images',['unique_number' => $video_list->unique_number]) }}" alt="No image">
    <div class="overlay"
        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
        <p align="center">You need to login and pay to continue watching this video.</p>
        <p align="center"><a href="{{ route('member.login') }}" class="btn btn-primary">Login</a></p>
    </div>
    <div class="freeoverlay"
        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
        <p align="center">You need to login to continue watching this video.</p>
        <p align="center"><a href="{{ route('member.login') }}" class="btn btn-primary">Login</a></p>
    </div>
    <div class="paymentoverlay"
        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
        <p align="center">Please pay to continue watching this video.</p>
        @if (Auth::check() && Auth::user()->is_organization == 0)
            <p align="center"><a href="#" data-paypal_video_id="{{ Crypt::encrypt($video_list->id) }}"
                data-paypal_video_price="{{ $video_list->video_price }}" data-video_amount_RVcoins="{{ $video_list->rv_coins_price }}" data-user_total_coins="{{ $loggedIn_user_details->total_rv_coins }}" class="paymentButton btn btn-primary">Pay Now</a></p>
        @else
            <p align="center"><a href="{{ route('subscription') }}" data-paypal_video_id="{{ Crypt::encrypt($video_list->id) }}"
                data-paypal_video_price="{{ $video_list->video_price }}" class="btn btn-primary">Pay Now</a></p>
        @endif
    </div>
    <div id="overlay_counter{{ $video_list->id }}"
        style="display:none; position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 0, 0, 0.5); color: #fff; padding: 20px;">
        <p id="overlay_counter_msg{{ $video_list->id }}"></p>
    </div>
    </div>
    <div class="video-card-body video-card-bg">
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
        </div>
        {{-- @include('frontend.include.video_options') --}}
    </div>
</div>