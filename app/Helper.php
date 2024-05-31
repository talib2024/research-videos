<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Majorcategory;
use App\Models\videohistory;
use App\Models\Videoupload;
function profile_progress_count($user_id)
{
    $point = 0;
    $record = DB::table('users')->where('id',$user_id)->first();
    if(!empty($record->name))
    {
        $point = $point + 10;
    }
    if(!empty($record->last_name))
    {
        $point = $point + 10;
    }
    if(!empty($record->phone))
    {
        $point = $point + 10;
    }
    if(!empty($record->email ))
    {
        $point = $point + 10;
    }
    if(!empty($record->country_id))
    {
        $point = $point + 10;
    }
    if(!empty($record->city))
    {
        $point = $point + 10;
    }
    if(!empty($record->zip_code))
    {
        $point = $point + 10;
    }
    if(!empty($record->address))
    {
        $point = $point + 10;
    }
    if(!empty($record->profile_pic))
    {
        $point = $point + 5;
    }
    if(!empty($record->institute_name))
    {
        $point = $point + 5;
    }
    if(!empty($record->position))
    {
        $point = $point + 5;
    }
    if(!empty($record->degree))
    {
        $point = $point + 5;
    }
    return $point;
}
function loggedin_as($role_id)
{
    $loggedin_role = DB::table('roles')->where('id',$role_id)->first();
    return $loggedin_role->role;
}
function switch_role_session($role_id)
{
    $switch_role = Session::put('loggedin_role', $role_id);
    return $switch_role;
}

function video_uploads($request,$sortingOption)
{
    // Fetch all subcategories
    $allSubcategories = DB::table('subcategories')->select('id','subcategory_name')->get();
    $video_pagination_for_users = video_pagination_for_users();

    $video_list = DB::table('videouploads')
    ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
    ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('video_views', 'video_views.video_id', '=', 'videouploads.id')
    ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    ->select(
        'videouploads.id',
        'videouploads.full_video_url',
        'videouploads.short_video_url',
        'videouploads.unique_number',
        'videouploads.video_price',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videouploads.subcategory_id',
        'majorcategories.id as majorcategories_id',
        'videouploads.rv_coins_price',
        'majorcategories.category_name',
        'watchlaterlists.type as watch_list_type',
        DB::raw('COUNT(DISTINCT likeunlikecounters.id) as likecount'),
        DB::raw('COUNT(DISTINCT video_views.id) as video_view_count'),
        DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
    );
// Filter by discipline if selected
$disciplineFilterBy = $request->input('disciplines_filter_by');
if ($disciplineFilterBy) {
    $video_list->where('videouploads.majorcategory_id', $disciplineFilterBy);
}
$video_type_filter_byFilterBy = $request->input('video_type_filter_by');
if ($video_type_filter_byFilterBy) {
    $video_list->where('videouploads.videotype_id', $video_type_filter_byFilterBy);
}

// Check if the user is logged in
if (Auth::check()) {
    $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
        ->leftJoin('transcations', function ($join) {
            $join->on('transcations.item_id', '=', 'videouploads.id')
                ->where('transcations.user_id', '=', Auth::user()->id)
                ->where('transcations.item_type', '=', 'video');
        })
        ->leftJoin('transcations as subscription_data', function ($join) {
            $join->on('subscription_data.user_id', '=', 'videouploads.user_id')
                ->where('subscription_data.user_id', '=', Auth::user()->id)
                ->where('subscription_data.item_type', '=', 'subscription')
                ->where('subscription_data.is_payment_done', '=', 1)
                ->whereDate('subscription_data.subscription_start_date', '<=', now())
                ->whereDate('subscription_data.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
        ->leftJoin('transcations as subscription_data_institute', function ($join) {
            $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                ->where('subscription_data_institute.is_payment_done', '=', 1)
                ->where('subscription_data_institute.is_active', '=', 1)
                ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
} else {
    $video_list->addSelect(DB::raw('0 as hasPaid'));
    $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
    $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
}

$video_list = $video_list
    ->where('videouploads.is_published', 1)
    ->groupBy(
        'videouploads.id',
        'videouploads.full_video_url',
        'videouploads.short_video_url',
        'videouploads.unique_number',
        'videouploads.video_price',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videouploads.subcategory_id',
        'majorcategories_id',
        'videouploads.rv_coins_price',
        'majorcategories.category_name',
        'watch_list_type',
        'hasPaid',
        'is_subscription_valid',
        'is_subscription_valid_institute'
    );
    // Apply sorting based on the selected option
    if($sortingOption == null || empty($sortingOption))
    {
        $sortby = DB::table('sortingoptionforpublishedvideos')->select('sort_by')->where('status',1)->first();
        switch ($sortby->sort_by) {
            case 'last_published':
                $video_list->orderByDesc('historycurrentstatus_created_at');
                break;
            case 'most_liked':
                $video_list->orderByDesc('likecount');
                break;
            case 'most_viewed':
                $video_list->orderByDesc('video_view_count');
                break;
            case 'disciplines':
                $video_list->orderBy('majorcategories.category_name', 'ASC');
                break;
            // Add more cases for other sorting options as needed
        }
    }
    else
    {
        switch ($sortingOption) {
            case 'last_published':
                $video_list->orderByDesc('historycurrentstatus_created_at');
                break;
            case 'most_liked':
                $video_list->orderByDesc('likecount');
                break;
            case 'most_viewed':
                $video_list->orderByDesc('video_view_count');
                break;
            case 'disciplines':
                $video_list->orderBy('majorcategories.category_name', 'ASC');
                break;
            // Add more cases for other sorting options as needed
        }
    }
    //->get();
    //$video_list = $video_list->paginate( config('constants.pagination.video_items_per_page') );
    $video_list = $video_list->paginate( $video_pagination_for_users->video_items_per_page );

    return [
        'video_list' => $video_list,
        'all_subcategories' => $allSubcategories,
    ];
}
function video_uploads_except_this_id($video_id,$selected_video_majorcategory_id,$sortingOption)
{
    // Fetch all subcategories
    $allSubcategories = DB::table('subcategories')->select('id','subcategory_name')->get();

    $video_list = DB::table('videouploads')
    ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
    ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('video_views', 'video_views.video_id', '=', 'videouploads.id')
    ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    ->select(
        'videouploads.id',
        'videouploads.full_video_url',
        'videouploads.short_video_url',
        'videouploads.unique_number',
        'videouploads.video_price',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videouploads.subcategory_id',
        'majorcategories.id as majorcategories_id',
        'videouploads.rv_coins_price',
        'majorcategories.category_name',
        'watchlaterlists.type as watch_list_type',
        DB::raw('COUNT(DISTINCT likeunlikecounters.id) as likecount'),
        DB::raw('COUNT(DISTINCT video_views.id) as video_view_count'),
        DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
    );

// Check if the user is logged in
if (Auth::check()) {
    $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
        ->leftJoin('transcations', function ($join) {
            $join->on('transcations.item_id', '=', 'videouploads.id')
                ->where('transcations.user_id', '=', Auth::user()->id)
                ->where('transcations.item_type', '=', 'video');
        })
        ->leftJoin('transcations as subscription_data', function ($join) {
            $join->on('subscription_data.user_id', '=', 'videouploads.user_id')
                ->where('subscription_data.user_id', '=', Auth::user()->id)
                ->where('subscription_data.item_type', '=', 'subscription')
                ->where('subscription_data.is_payment_done', '=', 1)
                ->whereDate('subscription_data.subscription_start_date', '<=', now())
                ->whereDate('subscription_data.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
        ->leftJoin('transcations as subscription_data_institute', function ($join) {
            $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                ->where('subscription_data_institute.is_payment_done', '=', 1)
                ->where('subscription_data_institute.is_active', '=', 1)
                ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
} else {
    $video_list->addSelect(DB::raw('0 as hasPaid'));
    $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
    $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
}
$video_list->where('videouploads.id', '!=', $video_id);
$video_list->where('videouploads.majorcategory_id', '=', $selected_video_majorcategory_id);

$video_list = $video_list
    ->where('videouploads.is_published', 1)
    ->groupBy(
        'videouploads.id',
        'videouploads.full_video_url',
        'videouploads.short_video_url',
        'videouploads.unique_number',
        'videouploads.video_price',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videouploads.subcategory_id',
        'majorcategories_id',
        'videouploads.rv_coins_price',
        'majorcategories.category_name',
        'watch_list_type',
        'hasPaid',
        'is_subscription_valid',
        'is_subscription_valid_institute'
    );
    // Apply sorting based on the selected option
    switch ($sortingOption) {
        case 'last_published':
            $video_list->orderByDesc('historycurrentstatus_created_at');
            break;
        case 'most_liked':
            $video_list->orderByDesc('likecount');
            break;
        case 'most_viewed':
            $video_list->orderByDesc('video_view_count');
            break;
        case 'disciplines':
            $video_list->orderBy('majorcategories.category_name', 'ASC');
            break;
        default:
            $video_list->orderBy('videouploads.id', 'DESC');
        // Add more cases for other sorting options as needed
    }
    $video_list = $video_list->limit(5);
    $video_list = $video_list->get();
   // $video_list = $video_list->paginate( config('constants.pagination.video_items_per_page') );

    return [
        'video_list' => $video_list,
        'all_subcategories' => $allSubcategories,
    ];
}
function video_uploads_except_this_id_other_videos($video_id,$sortingOption)
{
    // Fetch all subcategories
    $allSubcategories = DB::table('subcategories')->select('id','subcategory_name')->get();

    $video_list = DB::table('videouploads')
    ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
    ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('video_views', 'video_views.video_id', '=', 'videouploads.id')
    ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    ->select(
        'videouploads.id',
        'videouploads.full_video_url',
        'videouploads.short_video_url',
        'videouploads.unique_number',
        'videouploads.video_price',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videouploads.subcategory_id',
        'majorcategories.id as majorcategories_id',
        'videouploads.rv_coins_price',
        'majorcategories.category_name',
        'watchlaterlists.type as watch_list_type',
        DB::raw('COUNT(DISTINCT likeunlikecounters.id) as likecount'),
        DB::raw('COUNT(DISTINCT video_views.id) as video_view_count'),
        DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
    );

// Check if the user is logged in
if (Auth::check()) {
    $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
        ->leftJoin('transcations', function ($join) {
            $join->on('transcations.item_id', '=', 'videouploads.id')
                ->where('transcations.user_id', '=', Auth::user()->id)
                ->where('transcations.item_type', '=', 'video');
        })
        ->leftJoin('transcations as subscription_data', function ($join) {
            $join->on('subscription_data.user_id', '=', 'videouploads.user_id')
                ->where('subscription_data.user_id', '=', Auth::user()->id)
                ->where('subscription_data.item_type', '=', 'subscription')
                ->where('subscription_data.is_payment_done', '=', 1)
                ->whereDate('subscription_data.subscription_start_date', '<=', now())
                ->whereDate('subscription_data.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
        ->leftJoin('transcations as subscription_data_institute', function ($join) {
            $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                ->where('subscription_data_institute.is_payment_done', '=', 1)
                ->where('subscription_data_institute.is_active', '=', 1)
                ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
} else {
    $video_list->addSelect(DB::raw('0 as hasPaid'));
    $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
    $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
}
$video_list->where('videouploads.id', '!=', $video_id);

$video_list = $video_list
    ->where('videouploads.is_published', 1)
    ->groupBy(
        'videouploads.id',
        'videouploads.full_video_url',
        'videouploads.short_video_url',
        'videouploads.unique_number',
        'videouploads.video_price',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videouploads.subcategory_id',
        'majorcategories_id',
        'videouploads.rv_coins_price',
        'majorcategories.category_name',
        'watch_list_type',
        'hasPaid',
        'is_subscription_valid',
        'is_subscription_valid_institute'
    );
    // Apply sorting based on the selected option
    switch ($sortingOption) {
        case 'last_published':
            $video_list->orderByDesc('historycurrentstatus_created_at');
            break;
        case 'most_liked':
            $video_list->orderByDesc('likecount');
            break;
        case 'most_viewed':
            $video_list->orderByDesc('video_view_count');
            break;
        case 'disciplines':
            $video_list->orderBy('majorcategories.category_name', 'ASC');
            break;
        default:
            $video_list->orderBy('videouploads.id', 'DESC');
        // Add more cases for other sorting options as needed
    }
    $video_list = $video_list->limit(5);
    $video_list = $video_list->get();
   // $video_list = $video_list->paginate( config('constants.pagination.video_items_per_page') );

    return [
        'video_list' => $video_list,
        'all_subcategories' => $allSubcategories,
    ];
}
function major_category()
{
    $majorCategory = Majorcategory::select('id','category_name','category_image')->where('status',1)->orderBy('sequence')->get();
    return $majorCategory;
}

function watch_list($user_id,$sortingOption) 
{
    // Fetch all subcategories
    $allSubcategories = DB::table('subcategories')->select('id','subcategory_name')->get();
    $video_pagination_for_users = video_pagination_for_users();

    $video_list = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('video_views', 'video_views.video_id', '=', 'videouploads.id')
        ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
        ->select(
            'videouploads.id',
            'videouploads.full_video_url',
            'videouploads.short_video_url',
            'videouploads.unique_number',
            'videouploads.video_price',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'videouploads.subcategory_id',
            'videouploads.rv_coins_price',
            'majorcategories.id as majorcategories_id',
            'majorcategories.category_name',
            'watchlaterlists.type as watch_list_type',
            DB::raw('COUNT(DISTINCT likeunlikecounters.id) as likecount'),
            DB::raw('COUNT(DISTINCT video_views.id) as video_view_count'),
            DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
        );

    // Check if user is logged in
    if (Auth::check()) {
        $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
            ->leftJoin('transcations', function ($join) {
                $join->on('transcations.item_id', '=', 'videouploads.id')
                    ->where('transcations.user_id', '=', Auth::user()->id)
                    ->where('transcations.item_type', '=', 'video');
            })
            ->leftJoin('transcations as subscription_data', function ($join) {
                $join->on('subscription_data.user_id', '=', 'videouploads.user_id')
                    ->where('subscription_data.user_id', '=', Auth::user()->id)
                    ->where('subscription_data.item_type', '=', 'subscription')
                    ->where('subscription_data.is_payment_done', '=', 1)
                    ->whereDate('subscription_data.subscription_start_date', '<=', now())
                    ->whereDate('subscription_data.subscription_end_date', '>=', now());
            })
            ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
            ->leftJoin('transcations as subscription_data_institute', function ($join) {
                $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                    ->where('subscription_data_institute.is_payment_done', '=', 1)
                    ->where('subscription_data_institute.is_active', '=', 1)
                    ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                    ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
            })
            ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
    } else {
        $video_list->addSelect(DB::raw('0 as hasPaid'));
        $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
        $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
    }

    $video_list = $video_list
        ->where('watchlaterlists.user_id',$user_id)
        ->where('watchlaterlists.type',1)
        ->where('videouploads.is_published',1)
        ->groupBy(
            'videouploads.id',
            'videouploads.full_video_url',
            'videouploads.short_video_url',
            'videouploads.unique_number',
            'videouploads.video_price',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'videouploads.subcategory_id',
            'majorcategories_id',
            'videouploads.rv_coins_price',
            'majorcategories.category_name',
            'watch_list_type',
            'hasPaid',
            'is_subscription_valid',
            'is_subscription_valid_institute'
        );
        // Apply sorting based on the selected option
        switch ($sortingOption) {
            case 'last_published':
                $video_list->orderByDesc('historycurrentstatus_created_at');
                break;
            case 'most_liked':
                $video_list->orderByDesc('likecount');
                break;
            case 'most_viewed':
                $video_list->orderByDesc('video_view_count');
                break;
            case 'disciplines':
                $video_list->orderBy('majorcategories.category_name', 'ASC');
                break;
            // Add more cases for other sorting options as needed
        }
        //$video_list = $video_list->get();
        //$video_list = $video_list->paginate( config('constants.pagination.video_items_per_page') );
        $video_list = $video_list->paginate( $video_pagination_for_users->video_items_per_page );

    return [
        'video_list' => $video_list,
        'all_subcategories' => $allSubcategories,
    ];
}
function video_uploads_by_user($user_id)
{
    // $video_list = DB::table('videouploads')
    //     ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
    //     ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
    //     ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
    //     ->select('videouploads.id','videouploads.created_at', 'videouploads.uploaded_video', 'videouploads.membershipplan_id', 'videouploads.video_title', 'majorcategories.category_name','watchlaterlists.type as watch_list_type', DB::raw('COUNT(likeunlikecounters.id) as likecount'))
    //     ->where('videouploads.user_id',$user_id)
    //     ->groupBy('videouploads.id','videouploads.created_at', 'videouploads.uploaded_video', 'videouploads.membershipplan_id', 'videouploads.video_title', 'majorcategories.category_name','watch_list_type')
    //     ->get();
    // return $video_list;
    $video_list = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
        ->select(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'watchlaterlists.type as watch_list_type',
            DB::raw('COUNT(likeunlikecounters.id) as likecount'),
            DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
            DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
            DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
        )
        ->where('videouploads.user_id',$user_id)
        ->groupBy(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'watch_list_type'
        )
        ->get();
    return $video_list;
}
function single_video_details($video_id)
{
    $video_list = DB::table('videouploads')
                ->leftjoin('majorcategories','majorcategories.id','=','videouploads.majorcategory_id')
                ->leftjoin('videotypes','videotypes.id','=','videouploads.videotype_id')
                ->leftjoin('users','users.id','=','videouploads.user_id')
                ->leftjoin('membershipplans','membershipplans.id','=','videouploads.membershipplan_id')
                ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
                ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
                ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
                ->select('videouploads.*','membershipplans.plan','majorcategories.category_name','majorcategories.short_name','videotypes.video_type','users.name as author_name','users.last_name as author_lastName','watchlaterlists.type as watch_list_type','videohistories.created_at as videohistories_created_at',
                DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
                DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
                )
                ->where('videouploads.id',$video_id)
                ->first();
    return $video_list;
}
function video_based_on_category($majorcategory_id,$sortingOption)
{
    // Fetch all subcategories
    $allSubcategories = DB::table('subcategories')->select('id','subcategory_name')->get();
    $video_pagination_for_users = video_pagination_for_users();

    $video_list = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('video_views', 'video_views.video_id', '=', 'videouploads.id')
        ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
        ->select(
            'videouploads.id',
            'videouploads.full_video_url',
            'videouploads.short_video_url',
            'videouploads.unique_number',
            'videouploads.video_price',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'videouploads.subcategory_id',
            'majorcategories.id as majorcategories_id',
            'videouploads.rv_coins_price',
            'majorcategories.category_name',
            'watchlaterlists.type as watch_list_type',
            DB::raw('COUNT(DISTINCT likeunlikecounters.id) as likecount'),
            DB::raw('COUNT(DISTINCT video_views.id) as video_view_count'),
            DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
        );

    // Check if user is logged in
    if (Auth::check()) {
        $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
            ->leftJoin('transcations', function ($join) {
                $join->on('transcations.item_id', '=', 'videouploads.id')
                    ->where('transcations.user_id', '=', Auth::user()->id)
                    ->where('transcations.item_type', '=', 'video');
            })
            ->leftJoin('transcations as subscription_data', function ($join) {
                $join->on('subscription_data.user_id', '=', 'videouploads.user_id')
                    ->where('subscription_data.user_id', '=', Auth::user()->id)
                    ->where('subscription_data.item_type', '=', 'subscription')
                    ->where('subscription_data.is_payment_done', '=', 1)
                    ->whereDate('subscription_data.subscription_start_date', '<=', now())
                    ->whereDate('subscription_data.subscription_end_date', '>=', now());
            })
            ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
            ->leftJoin('transcations as subscription_data_institute', function ($join) {
                $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                    ->where('subscription_data_institute.is_payment_done', '=', 1)
                    ->where('subscription_data_institute.is_active', '=', 1)
                    ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                    ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
            })
            ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
    } else {
        $video_list->addSelect(DB::raw('0 as hasPaid'));
        $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
        $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
    }

    $video_list = $video_list
        ->where('videouploads.majorcategory_id',$majorcategory_id)
        ->where('videouploads.is_published',1)
        ->groupBy(
            'videouploads.id',
            'videouploads.full_video_url',
            'videouploads.short_video_url',
            'videouploads.unique_number',
            'videouploads.video_price',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'videouploads.subcategory_id',
            'majorcategories_id',
            'videouploads.rv_coins_price',
            'majorcategories.category_name',
            'watch_list_type',
            'hasPaid',
            'is_subscription_valid',
            'is_subscription_valid_institute'
        );
        // Apply sorting based on the selected option
        switch ($sortingOption) {
            case 'last_published':
                $video_list->orderByDesc('historycurrentstatus_created_at');
                break;
            case 'most_liked':
                $video_list->orderByDesc('likecount');
                break;
            case 'most_viewed':
                $video_list->orderByDesc('video_view_count');
                break;
            case 'disciplines':
                $video_list->orderBy('majorcategories.category_name', 'ASC');
                break;
            // Add more cases for other sorting options as needed
        }
        //->get();
        //$video_list = $video_list->paginate( config('constants.pagination.video_items_per_page') );
        $video_list = $video_list->paginate( $video_pagination_for_users->video_items_per_page );

        return [
            'video_list' => $video_list,
            'all_subcategories' => $allSubcategories,
        ];
}
function category_name($category_id)
{
    $category_name = Majorcategory::where('id',$category_id)->first();
    return $category_name;
}
function video_assigned_for_editor($majorcategory_id)
{
    $video_list = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('videohistories', function ($join) {
            $join->on('videohistories.videoupload_id', '=', 'videouploads.id')
                ->where('videohistories.created_at', '=', DB::raw("(SELECT MAX(created_at) FROM videohistories WHERE videohistories.videoupload_id = videouploads.id)"));
        })
        ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id') // Added join for historystatus
        ->select(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'videohistorystatuses.option as historycurrentstatus_name',
            'videohistorystatuses.text_to_show_on_history as historycurrentstatus_text',
            DB::raw('(SELECT MAX(videohistories.created_at) FROM videohistories WHERE videohistories.videoupload_id = videouploads.id) AS historycurrentstatus_created_at'),
            DB::raw('(SELECT MAX(videohistories.videoupload_id) FROM videohistories WHERE videohistories.videoupload_id = videouploads.id) AS latest_videoupload_id')
        )
        ->where('videouploads.majorcategory_id', $majorcategory_id)
        ->orderBy('videouploads.created_at', 'asc')
        ->groupBy(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'historycurrentstatus_name',
            'historycurrentstatus_text',
            'historycurrentstatus_created_at'
        )
        ->get();

    return $video_list;
}

function editor_chief_option()
{
    $editor_chief_option = DB::table('videohistorystatuses')
    ->where(function ($query) {
        $query->where('is_option_to_show_first_time', '=', NULL)
            ->orWhere('is_option_to_show_first_time', '=', 'yes');
    })
    ->where('option_show_to_role', '=', 'editor-in-chief')
    ->get();

return $editor_chief_option;
}
function editorial_member_option()
{
    $editorial_member_option = DB::table('videohistorystatuses')
    ->where(function ($query) {
        $query->where('is_option_to_show_first_time', '=', NULL)
            ->orWhere('is_option_to_show_first_time', '=', 'yes');
    })
    ->where('option_show_to_role', '=', 'editor-in-chief')
    ->where('id', '!=', 4)
    ->get();

return $editorial_member_option;
}
function editorial_member_list($majorcategory_id)
{
    $editorial_member_list = DB::table('userprofiles')
        ->select('users.id','users.name','users.email')
        ->leftJoin('users', 'users.id', '=', 'userprofiles.user_id')
        ->where('editorrole_id',2)
        ->where('majorcategory_id',$majorcategory_id)
        ->get();
    return $editorial_member_list;
}
function publisher_list()
{
    $publisher_list = DB::table('users')
        ->select('users.id','users.name','users.email')
        ->leftJoin('userroles', 'userroles.user_id', '=', 'users.id')
        ->where('userroles.role_id',5)
        ->get();
    return $publisher_list;
}
function reviewer_list($majorcategory_id,$video_id)
{
    $proposed_reviewers_list = DB::table('videouploads')
            ->join('coauthors', 'coauthors.videoupload_id', '=', 'videouploads.id')
            ->where('videouploads.majorcategory_id', $majorcategory_id)
            ->where('coauthors.email', '!=', null)
            ->where('coauthors.authortype_id', 4)
            ->where('coauthors.videoupload_id', $video_id)
            ->where('coauthors.is_proposed_reviewer', 1)
            ->groupBy('coauthors.email')
            ->pluck('coauthors.email');

    $non_proposed_reviewers_list = DB::table('videouploads')
            ->join('coauthors', 'coauthors.videoupload_id', '=', 'videouploads.id')
            ->where('videouploads.majorcategory_id', $majorcategory_id)
            ->where('coauthors.email', '!=', null)
            ->where('coauthors.authortype_id', 4)
            ->where('coauthors.videoupload_id', $video_id)
            ->where('coauthors.is_proposed_reviewer', 0)
            ->groupBy('coauthors.email')
            ->pluck('coauthors.email');

    $general_reviewers_list = DB::table('videouploads')
            ->join('coauthors', 'coauthors.videoupload_id', '=', 'videouploads.id')
            ->where('videouploads.majorcategory_id', $majorcategory_id)
            ->where('coauthors.email', '!=', null)
            ->where('coauthors.authortype_id', 4)
            ->where('coauthors.videoupload_id','!=', $video_id)
            ->groupBy('coauthors.email')
            ->pluck('coauthors.email');

    // Concatenate "(proposed reviewer)" to each email in proposed_reviewers_list
    $proposed_reviewers_list = $proposed_reviewers_list->map(function ($email) {
        return $email . ' (Proposed Reviewer)';
    });

    return $proposed_reviewers_list->concat($general_reviewers_list)->concat($non_proposed_reviewers_list);
}
function get_condition_to_delete_record_for_author($video_id)
{
    $lastRecord = DB::table('videohistories')
        ->where('videoupload_id', $video_id)
        ->latest('id')
        ->first();

    $totalRecords = DB::table('videohistories')
        ->where('videoupload_id', $video_id)
        ->count();

    return [
        'lastRecord' => $lastRecord,
        'totalRecords' => $totalRecords,
    ];
}
function video_assigned_for_editor_member($user_id)
{
    $video_list_for_editor_member = DB::table('videouploads')
    ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
    ->leftJoin('userprofiles', 'userprofiles.majorcategory_id', '=', 'videouploads.majorcategory_id')
    ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
    ->select(
        'videouploads.id',
        'videouploads.unique_number',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'majorcategories.category_name',
        'watchlaterlists.type as watch_list_type',
        DB::raw('COUNT(likeunlikecounters.id) as likecount'),
        DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
        DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
        DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at'),
        DB::raw('(SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_videohistorystatus_id'),
        DB::raw('(SELECT send_to_user_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_send_to_user_id')
    )
    // ->where('videohistories.videohistorystatus_id', 4)
    // ->where('videohistories.send_to_user_id', $user_id)
    ->where('videouploads.currently_assigned_to_editorial_member', $user_id)
    ->orderBy('videouploads.created_at', 'asc')
    ->groupBy(
        'videouploads.id',
        'videouploads.unique_number',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'majorcategories.category_name',
        'watch_list_type'
    )
    ->get();

return $video_list_for_editor_member;

}
function assigned_task_count_editor_member($user_id)
{
    $assigned_task_count_editor_member = DB::table('videouploads')
        ->leftJoin('videohistories', function ($join) use ($user_id) {
            $join->on('videohistories.videoupload_id', '=', 'videouploads.id')
                ->where('videouploads.currently_assigned_to_editorial_member', $user_id);
        })
        ->select('videohistories.*')
        ->whereRaw('videohistories.id IN (SELECT MAX(id) FROM videohistories GROUP BY videoupload_id)')
        ->latest('videohistories.created_at')
        ->get();

    $total_count = count($assigned_task_count_editor_member);
    $active_count = 0;
    $non_active_count = 0;

    foreach ($assigned_task_count_editor_member as $check_last_record) {
        if (
            isset($check_last_record->videohistorystatus_id) &&
            !in_array(
                $check_last_record->videohistorystatus_id,
                ['18', '3','23', '24', '19','26','6']
            ) &&
            //$check_last_record->send_to_user_id == Auth::id()
            ($check_last_record->send_from_user_id == $user_id || $check_last_record->send_to_user_id == $user_id)
        ) {
            $active_count++;
        }
        elseif (
            isset($check_last_record->videohistorystatus_id) &&
            (
                $check_last_record->corresponding_author_status == '1'
            ) &&
            ($check_last_record->send_to_user_id == $user_id)
        ) {
            $active_count++;
        }
        elseif (
            isset($check_last_record->videohistorystatus_id) &&
            (
                $check_last_record->withdraw_reviewer == '1'
            ) &&
            ($check_last_record->send_to_user_id == $user_id)
        ) {
            $active_count++;
        }
        else {
            $non_active_count++;
        }
    }
    return [
        'total_count' => $total_count,
        'active_count' => $active_count,
        'non_active_count' => $non_active_count,
    ];
}
function assigned_task_count_reviewer($email)
{
    $assigned_task_count_reviewer = DB::table('videohistories')
    ->select('videohistories.*')
    ->whereIn('videohistories.id', function ($query) {
        $query->select(DB::raw('MAX(id)'))
            ->from('videohistories')
            ->groupBy('videoupload_id', 'reviewer_email', 'send_from_as');
    })
    ->where('videohistories.send_from_as', 'Reviewer')
    ->where('videohistories.reviewer_email', $email)
    ->get();
// echo '<pre>';
// print_r($assigned_task_count_reviewer);exit;
    $total_count = count($assigned_task_count_reviewer);
    $active_count = 0;
    $non_active_count = 0;

    foreach ($assigned_task_count_reviewer as $check_last_record) {
        if (
            in_array(
                $check_last_record->videohistorystatus_id,
                ['7']
            ) &&
            $check_last_record->send_from_as == 'Reviewer'
            &&
            //$check_last_record->reviewer_email == Auth::user()->email
            $check_last_record->withdraw_reviewer == '0'
            &&
            $check_last_record->reviewer_email == $email
            // &&
            // $check_last_record->videohistorystatus_id == '5'
            &&
            $check_last_record->withdraw_reviewer == '0'
            &&
            $check_last_record->is_pass_to_other_than_reviewer == 0
        ) {
            $active_count++;
        }
        
        else {
            $non_active_count++;
        }
    }
    return [
        'total_count' => $total_count,
        'active_count' => $active_count,
        'non_active_count' => $non_active_count,
    ];
}

function video_assigned_for_publisher($user_id)
{
    // $video_assigned_for_publisher = DB::table('videouploads')
    //     ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
    //     ->leftJoin('userprofiles', 'userprofiles.majorcategory_id', '=', 'videouploads.majorcategory_id')
    //     ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
    //     ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
    //     ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    //     ->select('videouploads.id','videouploads.created_at', 'videouploads.uploaded_video', 'videouploads.membershipplan_id', 'videouploads.video_title', 'majorcategories.category_name','watchlaterlists.type as watch_list_type', DB::raw('COUNT(likeunlikecounters.id) as likecount'))
    //     ->where('videohistories.videohistorystatus_id',6)
    //     ->where('videohistories.send_to_user_id',$user_id)
    //     ->where('videohistories.send_from_as','editor-in-chief')
    //     ->where('videohistories.send_to_as','Publisher')
    //     ->orderBy('videouploads.created_at','desc')
    //     ->groupBy('videouploads.id','videouploads.created_at', 'videouploads.uploaded_video', 'videouploads.membershipplan_id', 'videouploads.video_title', 'majorcategories.category_name','watch_list_type')
    //     ->get();
    // return $video_assigned_for_publisher;

    $video_assigned_for_publisher = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('userprofiles', 'userprofiles.majorcategory_id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
        ->select(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'watchlaterlists.type as watch_list_type',
            DB::raw('COUNT(likeunlikecounters.id) as likecount'),
            DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
            DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
            DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
        )
        ->where('videohistories.videohistorystatus_id',6)
        ->where('videohistories.send_to_user_id',$user_id)
        ->where('videohistories.send_from_as','editorial-member')
        ->where('videohistories.send_to_as','Publisher')
        ->orderBy('videouploads.created_at','desc')
        ->groupBy(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'watch_list_type'
        )
        ->get();
    return $video_assigned_for_publisher;
}
function statictics_member_only($user_id)
{
    $video_views_count = DB::table('video_views')->where('user_id',$user_id)->count();
    $statictics_like_unlike = DB::table('likeunlikecounters')->where('user_id',$user_id)->where('type',1)->count();

    return [
        'video_views_count' => $video_views_count,
        'statictics_like_unlike' => $statictics_like_unlike
    ];
}
function publisher_option()
{
    $publisher_option = DB::table('videohistorystatuses')
        ->where('option_show_to_role','=','publisher')
        ->get();
    return $publisher_option;
}
function reviewer_option()
{
    $reviewer_option = DB::table('videohistorystatuses')
        ->where('option_show_to_role','=','Reviewer')
        ->get();
    return $reviewer_option;
}
function video_assigned_for_reviewer($email)
{
    // $video_assigned_for_reviewer = DB::table('videouploads')
    //     ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
    //     ->leftJoin('userprofiles', 'userprofiles.majorcategory_id', '=', 'videouploads.majorcategory_id')
    //     ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
    //     ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
    //     ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    //     ->select('videouploads.id','videouploads.created_at', 'videouploads.uploaded_video', 'videouploads.membershipplan_id', 'videouploads.video_title', 'majorcategories.category_name','watchlaterlists.type as watch_list_type', DB::raw('COUNT(likeunlikecounters.id) as likecount'))
    //     ->where('videohistories.videohistorystatus_id',7)
    //     ->where('videohistories.reviewer_email',$email)
    //     ->orderBy('videouploads.created_at','desc')
    //     ->groupBy('videouploads.id','videouploads.created_at', 'videouploads.uploaded_video', 'videouploads.membershipplan_id', 'videouploads.video_title', 'majorcategories.category_name','watch_list_type')
    //     ->get();
    // return $video_assigned_for_reviewer;

    $video_assigned_for_reviewer = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('userprofiles', 'userprofiles.majorcategory_id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
        ->select(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'watchlaterlists.type as watch_list_type',
            DB::raw('COUNT(likeunlikecounters.id) as likecount'),
            DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
            DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
            DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
        )
        ->where('videohistories.videohistorystatus_id',7)
        ->where('videohistories.reviewer_email',$email)
        ->orderBy('videouploads.created_at','desc')
        ->groupBy(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'watch_list_type'
        )
        ->get();
    return $video_assigned_for_reviewer;
}
function video_assigned_for_corr_author($email)
{
    $video_assigned_for_corr_author = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('userprofiles', 'userprofiles.majorcategory_id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
        ->select(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'watchlaterlists.type as watch_list_type',
            DB::raw('COUNT(likeunlikecounters.id) as likecount'),
            DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
            DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
            DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
        )
        ->where('videohistories.videohistorystatus_id',26)
        ->where('videohistories.corresponding_author_email',$email)
        ->orderBy('videouploads.created_at','desc')
        ->groupBy(
            'videouploads.id',
            'videouploads.unique_number',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'majorcategories.category_name',
            'watch_list_type'
        )
        ->get();
    return $video_assigned_for_corr_author;
}
function passed_by_name($id,$videohistorystatus_id,$user_id)
{
    $passed_by_name = DB::table('videohistories')
                        ->select('users.id as passed_by_id','users.name as passed_by_name','users.email as passed_by_email')
                        ->leftJoin('users', 'users.id','=', 'videohistories.send_from_user_id')
                        ->where('videohistories.videoupload_id', $id)
                        ->where('videohistories.videohistorystatus_id',$videohistorystatus_id)
                        ->where('videohistories.send_to_user_id',$user_id)
                        ->orderBy('videohistories.id','DESC')
                        ->first();
    return $passed_by_name;
}
// function editorial_member_option()
// {
//     $editorial_member_option = DB::table('videohistorystatuses')
//         ->where('option_show_to_role','=','editorial-member')
//         ->where('is_option_to_show_first_time','=','no')
//         ->get();
//     return $editorial_member_option;
// }
function accept_deny_option()
{
    $accept_deny_option = DB::table('videohistorystatuses')
        ->where('option_show_to_role','=','accept_deny_option')
        ->get();
    return $accept_deny_option;
}
function accept_deny_option_reviewer()
{
    $accept_deny_option = DB::table('videohistorystatuses')
        ->where('option_show_to_role','=','accept_deny_option_reviewers')
        ->get();
    return $accept_deny_option;
}
function accept_deny_option_corr_author()
{
    $accept_deny_option = DB::table('videohistorystatuses')
        ->where('option_show_to_role','=','accept_deny_option_corr_author')
        ->get();
    return $accept_deny_option;
}
function pass_revise_option()
{
    $pass_revise_option = DB::table('videohistorystatuses')
        ->whereIn('id',[22,23])
        ->get();
    return $pass_revise_option;
}
function check_last_record($id)
{
    $check_last_record = DB::table('videohistories')
                    ->where('videoupload_id', $id)
                    ->latest('created_at')
                    ->first();
    return $check_last_record;
}
function video_history($id)
{
    $video_history = DB::table('videohistories')
                        ->leftJoin('videohistorystatuses','videohistorystatuses.id','=','videohistories.videohistorystatus_id')
                        ->leftJoin('users as send_from_user','send_from_user.id','=','videohistories.send_from_user_id')
                        ->leftJoin('users as send_to_user','send_to_user.id','=','videohistories.send_to_user_id')
                        ->select('videohistorystatuses.option','videohistorystatuses.text_to_show_on_history','videohistories.id as videohistories_id','videohistories.message','videohistories.message_visibility','videohistories.videohistorystatus_id','videohistories.send_from_as','videohistories.send_to_as','videohistories.reviewer_email','videohistories.corresponding_author_email','videohistories.created_at','videohistories.corresponding_author_status','videohistories.withdraw_reviewer','videohistories.is_pass_to_other_than_reviewer','send_from_user.name as send_from_user_name','send_from_user.email as send_from_user_email','send_to_user.name as send_to_user_name','send_to_user.email as send_to_user_email')
                        ->where('videohistories.videoupload_id','=', $id)
                        ->orderBy('videohistories.created_at','desc')
                        ->get();
    return $video_history;

}
function editor_chief_details($majorcategory_id)
{
    $editor_chief_details = DB::table('userprofiles')
                            ->select('users.id as user_id','users.email as editor_chief_email')
                            ->leftJoin('users','users.id','=','userprofiles.user_id')
                            ->where('editorrole_id',1)
                            ->where('majorcategory_id',$majorcategory_id)
                            ->first();
    return $editor_chief_details;
}
function social_share($url)
{
    $shareComponent = \Share::page(
        $url,
        //'Your share text comes here',
    )
    ->facebook()
    ->twitter()
    ->linkedin()
    ->whatsapp()
    ->getRawLinks();
    return $shareComponent;
}
function search_videos($request) {
    // Fetch all subcategories
    $allSubcategories = DB::table('subcategories')->select('id','subcategory_name')->get();
    $video_pagination_for_users = video_pagination_for_users();

    $video_list = DB::table('videouploads')
    ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
    ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('coauthors', 'coauthors.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('video_views', 'video_views.video_id', '=', 'videouploads.id')
    ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    ->select(
        'videouploads.id',
        'videouploads.full_video_url',
        'videouploads.short_video_url',
        'videouploads.unique_number',
        'videouploads.video_price',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videouploads.subcategory_id',
        'majorcategories.id as majorcategories_id',
        'videouploads.rv_coins_price',
        'majorcategories.category_name',
        'watchlaterlists.type as watch_list_type',
        DB::raw('COUNT(DISTINCT likeunlikecounters.id) as likecount'),
        DB::raw('COUNT(DISTINCT video_views.id) as video_view_count'),
        DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
        //DB::raw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid'),
        //DB::raw('MAX(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid')
    );

// Check if user is logged in
if (Auth::check()) {
    $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
        ->leftJoin('transcations', function ($join) {
            $join->on('transcations.item_id', '=', 'videouploads.id')
                ->where('transcations.user_id', '=', Auth::user()->id)
                ->where('transcations.item_type', '=', 'video');
        })
        ->leftJoin('transcations as subscription_data', function ($join) {
            $join->on('subscription_data.item_id', '=', 'videouploads.id')
                ->where('subscription_data.user_id', '=', Auth::user()->id)
                ->where('subscription_data.item_type', '=', 'subscription')
                //->where('subscription_data.is_payment_done', '=', 1)
                ->whereDate('subscription_data.subscription_start_date', '<=', now())
                ->whereDate('subscription_data.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
        //->groupBy('transcations.is_payment_done'); // Include the column in GROUP BY
        ->leftJoin('transcations as subscription_data_institute', function ($join) {
            $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                ->where('subscription_data_institute.is_payment_done', '=', 1)
                ->where('subscription_data_institute.is_active', '=', 1)
                ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
} else {
    $video_list->addSelect(DB::raw('0 as hasPaid'));
    $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
    $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
}

// Apply search conditions
if ($request->filled('search_value')) {
        $searchValue = $request->input('search_value');
        $video_list->where(function ($query) use ($searchValue) {
            $query->where('videouploads.video_title', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.unique_number', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.keywords', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.majorcategory_id', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.videotype_id', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.videosubtype_id', 'LIKE', "%$searchValue%")
                ->orWhere('coauthors.name', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.references', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.abstract', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.subcategory_id', 'LIKE', "%$searchValue%")
                ->orWhere('videouploads.membershipplan_id', 'LIKE', "%$searchValue%")
                ;
        });
    }

    // Additional conditions
    if ($request->video_title && !empty($request->video_title)) {
        $video_list->where('videouploads.video_title', 'LIKE', "%" . $request->video_title . "%");
    }
    
    if ($request->unique_number && !empty($request->unique_number)) {
        $video_list->where('videouploads.unique_number', 'LIKE', "%" . $request->unique_number . "%");
    }

    if ($request->keywords && !empty($request->keywords)) {
        $video_list->where('videouploads.keywords', 'LIKE', "%" . $request->keywords . "%");
    }

    if ($request->majorcategory_id && !empty($request->majorcategory_id)) {
        $video_list->where('videouploads.majorcategory_id', 'LIKE', "%" . $request->majorcategory_id . "%");
    }

    if ($request->videotype_id && !empty($request->videotype_id)) {
        $video_list->where('videouploads.videotype_id', 'LIKE', "%" . $request->videotype_id . "%");
    }

    if ($request->videosubtype_id && !empty($request->videosubtype_id)) {
        $video_list->where('videouploads.videosubtype_id', 'LIKE', "%" . $request->videosubtype_id . "%");
    }

    if ($request->author_name && !empty($request->author_name)) {
        $video_list->where('coauthors.name', 'LIKE', "%" . $request->author_name . "%");
    }

    if ($request->references && !empty($request->references)) {
        $video_list->where('videouploads.references', 'LIKE', "%" . $request->references . "%");
    }
    if ($request->abstract && !empty($request->abstract)) {
        $video_list->where('videouploads.abstract', 'LIKE', "%" . $request->abstract . "%");
    }
    if ($request->subcategory_id_search && !empty($request->subcategory_id_search)) {
        $video_list->where('videouploads.subcategory_id', 'LIKE', "%" . $request->subcategory_id_search . "%");
    }
    if ($request->online_publishing_licence && !empty($request->online_publishing_licence)) {
        $video_list->where('videouploads.membershipplan_id', 'LIKE', "%" . $request->online_publishing_licence . "%");
    }
    

$video_list = $video_list
    ->where('videouploads.is_published', 1)
    ->groupBy(
        'videouploads.id',
        'videouploads.full_video_url',
        'videouploads.short_video_url',
        'videouploads.unique_number',
        'videouploads.video_price',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videouploads.subcategory_id',
        'majorcategories_id',
        'videouploads.rv_coins_price',
        'majorcategories.category_name',
        'watch_list_type',
        'hasPaid',
        'is_subscription_valid',
        'is_subscription_valid_institute'
    )
    //->get();
    //->paginate( config('constants.pagination.video_items_per_page') );
    ->paginate( $video_pagination_for_users->video_items_per_page );

    return [
        'video_list' => $video_list,
        'all_subcategories' => $allSubcategories,
    ];



}
function search_all_videos($request)
{
    // Fetch all subcategories
    $allSubcategories = DB::table('subcategories')->select('id','subcategory_name')->get();
    $video_pagination_for_users = video_pagination_for_users();

    $video_list = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('coauthors', 'coauthors.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('video_views', 'video_views.video_id', '=', 'videouploads.id')
        ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
        ->select(
            'videouploads.id',
            'videouploads.full_video_url',
            'videouploads.short_video_url',
            'videouploads.unique_number',
            'videouploads.video_price',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'videouploads.subcategory_id',
            'majorcategories.id as majorcategories_id',
            'videouploads.rv_coins_price',
            'majorcategories.category_name',
            'watchlaterlists.type as watch_list_type',
            DB::raw('COUNT(DISTINCT likeunlikecounters.id) as likecount'),
            DB::raw('COUNT(DISTINCT video_views.id) as video_view_count'),
            DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
            //DB::raw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid'),
            //DB::raw('MAX(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid')
        );
    // Check if user is logged in
    if (Auth::check()) {
        $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
            ->leftJoin('transcations', function ($join) {
                $join->on('transcations.item_id', '=', 'videouploads.id')
                    ->where('transcations.user_id', '=', Auth::user()->id)
                    ->where('transcations.item_type', '=', 'video');
            })
            ->leftJoin('transcations as subscription_data', function ($join) {
                $join->on('subscription_data.item_id', '=', 'videouploads.id')
                    ->where('subscription_data.user_id', '=', Auth::user()->id)
                    ->where('subscription_data.item_type', '=', 'subscription')
                    //->where('subscription_data.is_payment_done', '=', 1)
                    ->whereDate('subscription_data.subscription_start_date', '<=', now())
                    ->whereDate('subscription_data.subscription_end_date', '>=', now());
            })
            ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
            //->groupBy('transcations.is_payment_done'); // Include the column in GROUP BY
            
        ->leftJoin('transcations as subscription_data_institute', function ($join) {
            $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                ->where('subscription_data_institute.is_payment_done', '=', 1)
                ->where('subscription_data_institute.is_active', '=', 1)
                ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
        })
        ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
    } else {
        $video_list->addSelect(DB::raw('0 as hasPaid'));
        $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
        $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
    }
    
    if ($request->filled('search_value')) {
        $searchValue = $request->input('search_value');
        // Fetch subcategories matching the search criteria
        $matchingSubcategories = DB::table('subcategories')
            ->where('subcategory_name', 'LIKE', "%$searchValue%")
            ->pluck('id');
        $matchingSubcategories = $matchingSubcategories->toArray();

        // Fetch major categories matching the search criteria
        $matchingMajorCategories = DB::table('majorcategories')
        ->where('category_name', 'LIKE', "%$searchValue%")
        ->pluck('id');
        $matchingMajorCategories = $matchingMajorCategories->toArray();

        // Fetch video type matching the search criteria
        $video_type = DB::table('videotypes')
        ->where('video_type', 'LIKE', "%$searchValue%")
        ->pluck('id');
        $video_type = $video_type->toArray();

        // Fetch video sub type matching the search criteria
        $video_sub_type = DB::table('videosubtypes')
        ->where('video_sub_type', 'LIKE', "%$searchValue%")
        ->pluck('id');
        $video_sub_type = $video_sub_type->toArray();

        // Fetch online publishing matching the search criteria
        $membershipplans_search = DB::table('membershipplans')
        ->where('plan', 'LIKE', "%$searchValue%")
        ->pluck('id');
        $membershipplans_search = $membershipplans_search->toArray();

        $video_list = $video_list->where(function ($query) use ($searchValue,$matchingSubcategories,$matchingMajorCategories,$video_type,$video_sub_type,$membershipplans_search) {
            $query->where('videouploads.video_title', 'LIKE', "%$searchValue%")
                  ->orWhere('videouploads.unique_number', 'LIKE', "%$searchValue%")
                  ->orWhere('videouploads.keywords', 'LIKE', "%$searchValue%")
                  ->orWhereIn('videouploads.majorcategory_id', $matchingMajorCategories)
                  ->orWhereIn('videouploads.videotype_id', $video_type)
                  ->orWhereIn('videouploads.videosubtype_id', $video_sub_type)
                  ->orWhere('coauthors.name', 'LIKE', "%$searchValue%")
                  ->orWhere('coauthors.name', 'LIKE', "%$searchValue%")
                    ->orWhere('videouploads.references', 'LIKE', "%$searchValue%")
                    ->orWhere('videouploads.abstract', 'LIKE', "%$searchValue%")
                    ->orWhereIn('videouploads.membershipplan_id', $membershipplans_search)
                    ->orWhere(function ($query) use ($matchingSubcategories) {
                        foreach ($matchingSubcategories as $subcategory) {
                            $query->whereRaw('json_contains(videouploads.subcategory_id, \'["' . $subcategory . '"]\')');
                        }
                    });
        });
        //exit;
        $video_list = $video_list->where('videouploads.is_published',1);
    }

    $video_list = $video_list
        ->where('videouploads.is_published', 1)
        ->groupBy(
            'videouploads.id',
            'videouploads.full_video_url',
            'videouploads.short_video_url',
            'videouploads.unique_number',
            'videouploads.video_price',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'videouploads.subcategory_id',
            'majorcategories_id',
            'videouploads.rv_coins_price',
            'majorcategories.category_name',
            'watch_list_type',
            'hasPaid',
            'is_subscription_valid',
            'is_subscription_valid_institute'
        )
        //->get();
        //->paginate( config('constants.pagination.video_items_per_page') );
        ->paginate( $video_pagination_for_users->video_items_per_page );

        return [
            'video_list' => $video_list,
            'all_subcategories' => $allSubcategories,
        ];
}
function get_video_price($video_id)
{
    $get_video_price = DB::table('videouploads')
                            ->select('video_price','rv_coins_price')
                            ->where('id',$video_id)
                            ->where('membershipplan_id',1)
                            ->first();
    return $get_video_price;
}
function generate_rvoi_link($short_name,$videohistories_created_at,$unique_number)
{
    $rvoi_link = 'https://rvoi.org/'.$short_name.'/'.date('M', strtotime($videohistories_created_at)).'/'.date('Y', strtotime($videohistories_created_at)).'/'.$unique_number;
    return $rvoi_link;
}
function get_eligible_user($majorcategory_id,$subcategory_id)
{    
        // Find eligible members in the specified category
        $eligibleMembers = DB::table('users')
        ->leftJoin('userprofiles', 'userprofiles.user_id', '=', 'users.id')
        ->where('userprofiles.majorcategory_id', $majorcategory_id)
        ->where(function ($query) use ($subcategory_id) {
            foreach ($subcategory_id as $subcat) {
                $query->orWhereJsonContains('userprofiles.subcategory_id', $subcat);
            }
        })
        ->pluck('users.id');

            $assignedVideosCount = DB::table('videohistories')
                ->whereIn('send_to_user_id', $eligibleMembers)
                ->whereIn('videohistorystatus_id', [1,25]) // Assuming 1 represents the status for assignment
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('videohistories')
                        ->groupBy('videoupload_id');
                })
                ->groupBy('send_to_user_id')
                ->select('send_to_user_id', DB::raw('COUNT(*) as count'))
                ->get();
            // Check conditions and assign the video to a user
            $assignedUserId = null;

            if ($eligibleMembers->count() > $assignedVideosCount->count()) {
                // There are extra eligible members without any assigned videos
                $unassignedMembers = $eligibleMembers->diff($assignedVideosCount->pluck('send_to_user_id'));
                $assignedUserId = $unassignedMembers->random();
            } elseif ($eligibleMembers->count() == $assignedVideosCount->count()) {
                // All eligible members have videos
                $minCount = $assignedVideosCount->min('count');
                $minCountUsers = $assignedVideosCount->where('count', $minCount);

                if ($minCountUsers->count() == $assignedVideosCount->count()) {
                    // All users have an equal minimum count, assign randomly
                    $assignedUserId = $eligibleMembers->random();
                } else {
                    // Assign to the user with the minimum count
                    $assignedUserId = $minCountUsers->random();
                }
            }
    return $assignedUserId;
}

function get_eligible_user_to_pass_another_member($majorcategory_id,$subcategory_id)
{    
        // Find eligible members in the specified category
            $eligibleMembers = DB::table('users')
                            ->leftJoin('userprofiles', 'userprofiles.user_id', '=', 'users.id')
                            ->where('userprofiles.majorcategory_id', $majorcategory_id)
                            ->where('userprofiles.user_id','!=',Auth::user()->id)
                            ->where(function ($query) use ($subcategory_id) {
                                foreach ($subcategory_id as $subcat) {
                                    $query->orWhereJsonContains('userprofiles.subcategory_id', $subcat);
                                }
                            })
                            ->pluck('users.id');

    if ($eligibleMembers->isEmpty()) 
    {
        return 'norecord';
    }
    else
    {
    
            $assignedVideosCount = DB::table('videohistories')
                ->whereIn('send_to_user_id', $eligibleMembers)
                ->whereIn('videohistorystatus_id', [1,25]) // Assuming 1 represents the status for assignment
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('videohistories')
                        ->groupBy('videoupload_id');
                })
                ->groupBy('send_to_user_id')
                ->select('send_to_user_id', DB::raw('COUNT(*) as count'))
                ->get();

            // Check conditions and assign the video to a user
            $assignedUserId = null;

            if ($eligibleMembers->count() > $assignedVideosCount->count()) {
                // There are extra eligible members without any assigned videos
                $unassignedMembers = $eligibleMembers->diff($assignedVideosCount->pluck('send_to_user_id'));
                $assignedUserId = $unassignedMembers->random();
            } elseif ($eligibleMembers->count() == $assignedVideosCount->count()) {
                // All eligible members have videos
                $minCount = $assignedVideosCount->min('count');
                $minCountUsers = $assignedVideosCount->where('count', $minCount);

                if ($minCountUsers->count() == $assignedVideosCount->count()) {
                    // All users have an equal minimum count, assign randomly
                    $assignedUserId = $eligibleMembers->random();
                } else {
                    // Assign to the user with the minimum count
                    $assignedUserId = $minCountUsers->random();
                }
            }
    return $assignedUserId;
        }
}

function get_user_details($user_id)
{
    $get_user_details = DB::table('users')
                            ->select('users.*','userprofiles.total_rv_coins','userprofiles.user_description','userprofiles.wallet_id')
                            ->leftJoin('userprofiles','userprofiles.user_id','=','users.id')
                            ->where('users.id',$user_id)
                            ->first();
    return $get_user_details;
}
function subscriptionplans_details($id)
{
    $subscriptionplans_details = DB::table('subscriptionplans')
                            ->where('id',$id)
                            ->first();
    return $subscriptionplans_details;
}
function single_video_status($status_id)
{
    $single_video_status = DB::table('videohistorystatuses')
                ->select('option')
                ->where('id',$status_id)
                ->first();
    return $single_video_status;
}
function get_subscription_plan($subscription_plan_id)
{
    $subscription_plan_id = DB::table('subscriptionplans')
                                ->where('id',$subscription_plan_id)
                                ->where('status',1)
                                ->first();
    return $subscription_plan_id;
}
function subcategory_list($category_id)
{
    $subcategory_list = DB::table('subcategories')
                                ->where('majorcategory_id',$category_id)
                                ->where('status',1)
                                ->get();
    return $subcategory_list;
}
function statictics_for_author($user_id)
{
    $total_submitted_count = VideoHistory::where('send_from_user_id', $user_id)
                                         ->where('send_from_as', 'Author')
                                         ->count();

    $other_count = VideoUpload::leftJoin('videohistories', function ($join) use ($user_id) {
                                    $join->on('videohistories.videoupload_id', '=', 'videouploads.id')
                                         ->where('videouploads.user_id', $user_id);
                                })
                                ->select('videohistories.*')
                                ->whereRaw('videohistories.id IN (SELECT MAX(id) FROM videohistories GROUP BY videoupload_id)')
                                ->latest('videohistories.created_at')
                                ->get();

    // Filter the $other_count collection based on conditions
    $accepted_count = $other_count->filter(function ($item) {
        return $item->videohistorystatus_id == 18;
    })->count();

    $rejected_count = $other_count->filter(function ($item) {
        return $item->corresponding_author_status == 1 || in_array($item->videohistorystatus_id, [19, 28]);
    })->count();

    $in_review_count = $other_count->filter(function ($item) {
        return !in_array($item->videohistorystatus_id, [18, 19, 28]) && $item->corresponding_author_status != 1;
    })->count();

    $result = [
        'total_submitted_count' => $total_submitted_count,
        'total_videos_accepted' => $accepted_count,
        'total_videos_rejected' => $rejected_count,
        'total_videos_in_review' => $in_review_count,
    ];
    return $result;
}


function statictics_for_publisher($user_id)
{
    $video_assigned_for_publisher = DB::table('videouploads')
    ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
    ->select(
        'videouploads.id',
        'videouploads.unique_number',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
        DB::raw('(SELECT id FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_id'),
        DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
        DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
    )
    ->where('videohistories.videohistorystatus_id', 6)
    ->where('videohistories.send_to_user_id', $user_id)
    ->where('videohistories.send_from_as', 'editorial-member')
    ->where('videohistories.send_to_as', 'Publisher')
    ->groupBy(
        'videouploads.id',
        'videouploads.unique_number',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videohistories.videohistorystatus_id'
    )
    ->get();

$totalVideos = 0;
$totalVideosAssigned = 0;
$totalVideosPublished = 0;
$totalVideosUnpublished = 0;
$totalVideosRevised = 0;
$totalVideosInHold = 0;
$totalVideosInReview = 0;

foreach ($video_assigned_for_publisher as $video) {
    // Check the videohistorystatus_id and update counters accordingly
    $totalVideos++;
    switch ($video->historycurrentstatus_id) {
        case 6:
            $totalVideosAssigned++;
            break;
        
        case 18:
            $totalVideosPublished++;
            break;

        case 19:
            $totalVideosUnpublished++;
            break;

        case 23:
            $totalVideosRevised++;
            break;

        case 24:
            $totalVideosInHold++;
            break;
        // case !in_array($video->historycurrentstatus_id, ['18', '19', '6', '24']):
        //     $totalVideosInReview++;
        //     break;
        // Add more cases if needed

        default:
            // Check for total_videos_in_review
            // if (!in_array($video->historycurrentstatus_id, ['18', '19', '6', '24'])) {
            //     $totalVideosInReview++;
            // }
            // Handle other cases if needed
            break;
    }
}


// Build the result array with the counts
$result = [
    'total_videos_received' => $totalVideos,
    'total_videos_assigned' => $totalVideosAssigned,
    'total_videos_published' => $totalVideosPublished,
    'total_videos_unpublished' => $totalVideosUnpublished,
    'total_videos_pending' => $totalVideosRevised,
    'total_videos_in_review' => $totalVideosInHold,
    // Add more counts as needed
];
    return $result;
}
function statictics_for_corr_author($email)
{
    $video_results = DB::table('videouploads')
    ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
    ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
    ->select(
        'videouploads.id',
        'videouploads.unique_number',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
        DB::raw('(SELECT id FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_id'),
        DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
        DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
    )
    ->where('videohistories.videohistorystatus_id',26)
    ->where('videohistories.corresponding_author_email',$email)
    ->groupBy(
        'videouploads.id',
        'videouploads.unique_number',
        'videouploads.created_at',
        'videouploads.uploaded_video',
        'videouploads.membershipplan_id',
        'videouploads.video_title',
        'videohistories.videohistorystatus_id'
    )
    ->get();

$total_videos_accepted_by_you = 0;
$total_videos_accepted = 0;
$total_videos_rejected = 0;
$total_videos_in_review = 0;

foreach ($video_results as $video) {
    // Check the videohistorystatus_id and update counters accordingly
    $total_videos_accepted_by_you++;
    switch ($video->historycurrentstatus_id) {
        case 18:
            $total_videos_accepted++;
            break;

        case 19:
        case 28:
            $total_videos_rejected++;
            break;

        case !in_array($video->historycurrentstatus_id, ['18', '19', '28']):
            $total_videos_in_review++;
            break;
        // Add more cases if needed

        default:
            // Check for total_videos_in_review
            // if (!in_array($video->historycurrentstatus_id, ['18', '19', '6', '24'])) {
            //     $totalVideosInReview++;
            // }
            // Handle other cases if needed
            break;
    }
}


// Build the result array with the counts
$result = [
    'total_videos_accepted_by_you' => $total_videos_accepted_by_you,
    'total_videos_accepted' => $total_videos_accepted,
    'total_videos_rejected' => $total_videos_rejected,
    'total_videos_in_review' => $total_videos_in_review,
    // Add more counts as needed
];
    return $result;
}
// function statictics_for_editorial_member($user_id)
// {
//     $video_result = DB::table('videouploads')
//     ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
//     ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
//     ->select(
//         'videouploads.id',
//         'videouploads.unique_number',
//         'videouploads.created_at',
//         'videouploads.uploaded_video',
//         'videouploads.membershipplan_id',
//         'videouploads.video_title',
//         DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
//         DB::raw('(SELECT id FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_id'),
//         DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
//         DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
//     )
//     ->where('videouploads.currently_assigned_to_editorial_member', $user_id)
//     ->groupBy(
//         'videouploads.id',
//         'videouploads.unique_number',
//         'videouploads.created_at',
//         'videouploads.uploaded_video',
//         'videouploads.membershipplan_id',
//         'videouploads.video_title'
//     )
//     ->get();
// // echo '<pre>';
// // print_r($video_result);exit;
// $totalVideos = 0;
// $totalVideosPending = 0;
// $totalVideosInReview = 0;
// $totalVideosforPublication = 0;

// foreach ($video_result as $video) {
//     // Check the videohistorystatus_id and update counters accordingly
//     $totalVideos++;
//     switch ($video->historycurrentstatus_id) {
//         case 4:
//             $totalVideosPending++;
//             break;

//         case !in_array($video->historycurrentstatus_id, ['4','18', '19', '24']):
//             $totalVideosInReview++;
//             break;
        
//         case 18:
//             $totalVideosforPublication++;
//             break;
//         // Add more cases if needed

//         default:
//             // Check for total_videos_in_review
//             // if (!in_array($video->historycurrentstatus_id, ['18', '19', '6', '24'])) {
//             //     $totalVideosInReview++;
//             // }
//             // Handle other cases if needed
//             break;
//     }
// }


// // Build the result array with the counts
// $result = [
//     'total_videos_assigned' => $totalVideos,
//     'total_videos_pending' => $totalVideosPending,
//     'total_videos_review_process' => $totalVideosInReview,
//     'total_videos_accepted_for_publication' => $totalVideosforPublication,
//     // Add more counts as needed
// ];
//     return $result;

// }

function statictics_for_editorial_member($user_id)
{
    $video_result = DB::table('videouploads')
        ->leftJoin('videohistories', function ($join) use ($user_id) {
            $join->on('videohistories.videoupload_id', '=', 'videouploads.id')
                ->where('videouploads.currently_assigned_to_editorial_member', $user_id);
        })
        ->select('videohistories.*')
        ->whereRaw('videohistories.id IN (SELECT MAX(id) FROM videohistories GROUP BY videoupload_id)')
        ->latest('videohistories.created_at')
        ->get();
// echo '<pre>';
// print_r($video_result);exit;
        $totalVideos = count($video_result);
        $totalVideosRejected = 0;
        $totalVideosInReview = 0;
        $totalVideosforPublication = 0;

    foreach ($video_result as $check_last_record) {
        if (
            isset($check_last_record->videohistorystatus_id) && $check_last_record->corresponding_author_status == '1'
            )
         {
            $totalVideosRejected++;
        }
        if (
            isset($check_last_record->videohistorystatus_id) &&
            !in_array(
                $check_last_record->videohistorystatus_id,
                ['18', '3','23', '24', '19','26','6']
            ) &&
            ($check_last_record->send_from_user_id == $user_id || $check_last_record->send_to_user_id == $user_id)
        ) {
            $totalVideosInReview++;
        }
        if (
            isset($check_last_record->videohistorystatus_id) &&
            (
                ($check_last_record->videohistorystatus_id == '6') ||
            ($check_last_record->videohistorystatus_id == '18') ||
            ($check_last_record->videohistorystatus_id == '19') ||
            ($check_last_record->videohistorystatus_id == '23') ||
            ($check_last_record->videohistorystatus_id == '24')
            ) 
        ) {
            $totalVideosforPublication++;
        }
    }
    $result = [
        'total_videos_assigned' => $totalVideos,
        'total_videos_pending' => $totalVideosRejected,
        'total_videos_review_process' => $totalVideosInReview,
        'total_videos_accepted_for_publication' => $totalVideosforPublication,
        // Add more counts as needed
    ];
    return $result;
}

// function statictics_for_reviewer($email)
// {
//     $video_result = DB::table('videouploads')
//     ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
//     ->leftJoin('videohistorystatuses', 'videohistorystatuses.id', '=', 'videohistories.videohistorystatus_id')
//     ->select(
//         'videouploads.id',
//         'videouploads.unique_number',
//         'videouploads.created_at',
//         'videouploads.uploaded_video',
//         'videouploads.membershipplan_id',
//         'videouploads.video_title',
//         DB::raw('(SELECT `option` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_name'),
//         DB::raw('(SELECT id FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_id'),
//         DB::raw('(SELECT `text_to_show_on_history` FROM videohistorystatuses WHERE id = (SELECT videohistorystatus_id FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1)) as historycurrentstatus_text'),
//         DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
//     )
//     ->where('videohistories.videohistorystatus_id',7)
//     ->where('videohistories.reviewer_email',$email)
//     ->groupBy(
//         'videouploads.id',
//         'videouploads.unique_number',
//         'videouploads.created_at',
//         'videouploads.uploaded_video',
//         'videouploads.membershipplan_id',
//         'videouploads.video_title'
//     )
//     ->get();
// // echo '<pre>';
// // print_r($video_result);exit;
// $totalVideos = 0;
// $totalVideosAcceptedForReviews = 0;
// $totalVideosRejectedForReviews = 0;
// $totalVideosPendingForReviews = 0;
// $totalVideosunderProcess = 0;
// $totalVideosforAcceptedForPublication = 0;
// $totalVideosforPublishedByPublisher = 0;
// $totalVideosforUnPublishedByPublisher = 0;

// $total_videos_Accepted_For_Publication = 0;
// $total_videos_Rejected_For_Publication = 0;

// foreach ($video_result as $video) {
//     // Check the videohistorystatus_id and update counters accordingly
//     $totalVideos++;
//     switch ($video->historycurrentstatus_id) {

//         case 22:
//             $total_videos_Accepted_For_Publication++;
//             break;

//         case 28:
//             $total_videos_Rejected_For_Publication++;
//             break;
//         // case 28:
//         //     $totalVideosRejectedForReviews++;
//         //     break;

//         // case 7:
//         //     $totalVideosPendingForReviews++;
//         //     break;

//         // case 22:
//         //     $totalVideosforAcceptedForPublication++;
//         //     break;

//         // case 18:
//         //     $totalVideosforPublishedByPublisher++;
//         //     break;

//         // case 19:
//         //     $totalVideosforUnPublishedByPublisher++;
//         //     break;

//         // case !in_array($video->historycurrentstatus_id, ['7','28', '22', '18','19']):
//         //     $totalVideosunderProcess++;
//         //     break;
//         // Add more cases if needed

//         default:
//             // Check for total_videos_in_review
//             // if (!in_array($video->historycurrentstatus_id, ['18', '19', '6', '24'])) {
//             //     $totalVideosInReview++;
//             // }
//             // Handle other cases if needed
//             break;
//     }
// }


// // Build the result array with the counts
// $result = [
//     'total_invitation_accepted' => $totalVideos,
//     'total_videos_Accepted_For_Publication' => $total_videos_Accepted_For_Publication,
//     'total_videos_Rejected_For_Publication' => $total_videos_Rejected_For_Publication,
//     // 'total_videos_assigned' => $totalVideos,
//     // 'totalVideosAcceptedForReviews' => $totalVideosAcceptedForReviews,
//     // 'totalVideosRejectedForReviews' => $totalVideosRejectedForReviews,
//     // 'totalVideosPendingForReviews' => $totalVideosPendingForReviews,
//     // 'totalVideosunderProcess' => $totalVideosunderProcess,
//     // 'totalVideosforAcceptedForPublication' => $totalVideosforAcceptedForPublication,
//     // 'totalVideosforPublishedByPublisher' => $totalVideosforPublishedByPublisher,
//     // 'totalVideosforUnPublishedByPublisher' => $totalVideosforUnPublishedByPublisher,
//     // Add more counts as needed
// ];
//     return $result;

// }
function statictics_for_reviewer($email)
{
    $video_result = DB::table('videohistories')  
        ->select('videohistories.videohistorystatus_id AS historycurrentstatus_id') 
        ->where('videohistories.reviewer_email',$email)
        ->get();
// echo '<pre>';
// print_r($video_result);exit;
$totalVideos = 0;
$total_videos_Accepted_For_Publication = 0;
$total_videos_Rejected_For_Publication = 0;

foreach ($video_result as $video) {
    // Check the videohistorystatus_id and update counters accordingly
    //$totalVideos++;
    switch ($video->historycurrentstatus_id) {

        case 7:
            $totalVideos++;
            break;

        case 22:
            $total_videos_Accepted_For_Publication++;
            break;

        case 28:
            $total_videos_Rejected_For_Publication++;
            break;        

        default:
            // Check for total_videos_in_review
            // if (!in_array($video->historycurrentstatus_id, ['18', '19', '6', '24'])) {
            //     $totalVideosInReview++;
            // }
            // Handle other cases if needed
            break;
    }
}


// Build the result array with the counts
$result = [
    'total_invitation_accepted' => $totalVideos,
    'total_videos_Accepted_For_Publication' => $total_videos_Accepted_For_Publication,
    'total_videos_Rejected_For_Publication' => $total_videos_Rejected_For_Publication,
];
    return $result;

}
function get_majorcategories($majorcategory_id)
{
    $result = DB::table('majorcategories')->where('id',$majorcategory_id)->first();
    return $result;
}

function checkUserSubscriptionPlan()
{
    if(Auth::user())
    {
        if(Auth::user()->is_organization == '0' || Auth::user()->is_organization == '1')
        {
            $user_id = Auth::user()->id;
        }
        elseif(Auth::user()->is_organization == '2')
        {
            $user_id = Auth::user()->related_main_organisation_id;
        }

        $subscription_details = DB::table('transcations')
                ->where('transcations.user_id', '=', $user_id)
                ->where('transcations.item_type', '=', 'subscription')
                ->where('transcations.is_payment_done', '=', 1)
                ->whereDate('transcations.subscription_start_date', '<=', now())
                ->whereDate('transcations.subscription_end_date', '>=', now())
                ->first();
        if($subscription_details)
        {
            $subscription_plan = 1;
        }
        else
        {
            $subscription_plan = 0;
        }        
    }
    else
    {
        $subscription_plan = 0;
    } 
    return $subscription_plan;
}
function video_based_on_sub_category($subcategory_id,$sortingOption)
{
    // Fetch all subcategories
    $allSubcategories = DB::table('subcategories')->select('id','subcategory_name')->get();
    $video_pagination_for_users = video_pagination_for_users();

    $video_list = DB::table('videouploads')
        ->leftJoin('majorcategories', 'majorcategories.id', '=', 'videouploads.majorcategory_id')
        ->leftJoin('likeunlikecounters', 'likeunlikecounters.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('watchlaterlists', 'watchlaterlists.videoupload_id', '=', 'videouploads.id')
        ->leftJoin('video_views', 'video_views.video_id', '=', 'videouploads.id')
        ->leftJoin('videohistories', 'videohistories.videoupload_id', '=', 'videouploads.id')
        ->select(
            'videouploads.id',
            'videouploads.full_video_url',
            'videouploads.short_video_url',
            'videouploads.unique_number',
            'videouploads.video_price',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'videouploads.subcategory_id',
            'majorcategories.id as majorcategories_id',
            'videouploads.rv_coins_price',
            'majorcategories.category_name',
            'watchlaterlists.type as watch_list_type',
            DB::raw('COUNT(DISTINCT likeunlikecounters.id) as likecount'),
            DB::raw('COUNT(DISTINCT video_views.id) as video_view_count'),
            DB::raw('(SELECT created_at FROM videohistories WHERE videoupload_id = videouploads.id ORDER BY created_at DESC LIMIT 1) historycurrentstatus_created_at')
        );

    // Check if user is logged in
    if (Auth::check()) {
        $video_list->selectRaw('(CASE WHEN transcations.is_payment_done = 1 THEN 1 ELSE 0 END) as hasPaid')
            ->leftJoin('transcations', function ($join) {
                $join->on('transcations.item_id', '=', 'videouploads.id')
                    ->where('transcations.user_id', '=', Auth::user()->id)
                    ->where('transcations.item_type', '=', 'video');
            })
            ->leftJoin('transcations as subscription_data', function ($join) {
                $join->on('subscription_data.user_id', '=', 'videouploads.user_id')
                    ->where('subscription_data.user_id', '=', Auth::user()->id)
                    ->where('subscription_data.item_type', '=', 'subscription')
                    ->where('subscription_data.is_payment_done', '=', 1)
                    ->whereDate('subscription_data.subscription_start_date', '<=', now())
                    ->whereDate('subscription_data.subscription_end_date', '>=', now());
            })
            ->addSelect(DB::raw('(CASE WHEN subscription_data.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid'))
            ->leftJoin('transcations as subscription_data_institute', function ($join) {
                $join->where('subscription_data_institute.email_type', '=', substr(Auth::user()->email, strpos(Auth::user()->email, '@')))
                    ->where('subscription_data_institute.is_payment_done', '=', 1)
                    ->where('subscription_data_institute.is_active', '=', 1)
                    ->whereDate('subscription_data_institute.subscription_start_date', '<=', now())
                    ->whereDate('subscription_data_institute.subscription_end_date', '>=', now());
            })
            ->addSelect(DB::raw('(CASE WHEN subscription_data_institute.id IS NOT NULL THEN 1 ELSE 0 END) as is_subscription_valid_institute'));
    } else {
        $video_list->addSelect(DB::raw('0 as hasPaid'));
        $video_list->addSelect(DB::raw('0 as is_subscription_valid'));
        $video_list->addSelect(DB::raw('0 as is_subscription_valid_institute'));
    }

    $video_list = $video_list
        ->where(function ($query) use ($subcategory_id) {
            $query->whereJsonContains('videouploads.subcategory_id', $subcategory_id)
                  ->orWhereJsonContains('videouploads.subcategory_id', '["'.$subcategory_id.'"]');
        })
        ->where('videouploads.is_published',1)
        ->groupBy(
            'videouploads.id',
            'videouploads.full_video_url',
            'videouploads.short_video_url',
            'videouploads.unique_number',
            'videouploads.video_price',
            'videouploads.created_at',
            'videouploads.uploaded_video',
            'videouploads.membershipplan_id',
            'videouploads.video_title',
            'videouploads.subcategory_id',
            'majorcategories_id',
            'videouploads.rv_coins_price',
            'majorcategories_id',
            'majorcategories.category_name',
            'watch_list_type',
            'hasPaid',
            'is_subscription_valid',
            'is_subscription_valid_institute'
        );
        // Apply sorting based on the selected option
        switch ($sortingOption) {
            case 'last_published':
                $video_list->orderByDesc('historycurrentstatus_created_at');
                break;
            case 'most_liked':
                $video_list->orderByDesc('likecount');
                break;
            case 'most_viewed':
                $video_list->orderByDesc('video_view_count');
                break;
            case 'disciplines':
                $video_list->orderBy('majorcategories.category_name', 'ASC');
                break;
            // Add more cases for other sorting options as needed
        }
        //->get();
        //$video_list = $video_list->paginate( config('constants.pagination.video_items_per_page') );
        $video_list = $video_list->paginate( $video_pagination_for_users->video_items_per_page );

        return [
            'video_list' => $video_list,
            'all_subcategories' => $allSubcategories,
        ];
}
function sub_category_name($id)
{
    $result = DB::table('subcategories')->where('id',$id)->first();
    return $result;
}
function subcategoryVideos()
{
    $results = DB::table('majorcategories')
    ->join('subcategories', 'majorcategories.id', '=', 'subcategories.majorcategory_id')
    ->select('majorcategories.id as majorcategories_id','majorcategories.category_name', 'subcategories.id as subcategories_id', 'subcategories.subcategory_name')
    ->orderBy('majorcategories.id') // optional: order by majorcategories.id to group by major category
    ->orderBy('subcategories.subcategory_name')
    ->get();

    $groupedCategories = [];

    foreach ($results as $row) 
    {
        $majorCategoryName = $row->category_name;
        $majorCategoryId = $row->majorcategories_id;

        // If major category name is not in the grouped array, add it
        if (!isset($groupedCategories[$majorCategoryId])) {
            $groupedCategories[$majorCategoryId] = [
                'major_category_name' => $majorCategoryName,
                'subcategories' => [],
            ];
        }
    
        // Add the subcategory to the corresponding major category in the array
        $groupedCategories[$majorCategoryId]['subcategories'][$row->subcategories_id] = $row->subcategory_name;
    }
    return $groupedCategories;
}
function subcategoryDetails()
{
    $results = DB::table('majorcategories')
    ->join('subcategories', 'majorcategories.id', '=', 'subcategories.majorcategory_id')
    ->select('majorcategories.id as majorcategories_id','majorcategories.category_name', 'subcategories.id as subcategories_id', 'subcategories.subcategory_name', 'subcategories.description')
    ->orderBy('majorcategories.id') // optional: order by majorcategories.id to group by major category
    ->orderBy('subcategories.subcategory_name')
    ->get();

    $groupedCategories = [];

    foreach ($results as $row) 
    {
        $majorCategoryName = $row->category_name;
        $majorCategoryId = $row->majorcategories_id;

        // If major category name is not in the grouped array, add it
        if (!isset($groupedCategories[$majorCategoryId])) {
            $groupedCategories[$majorCategoryId] = [
                'major_category_name' => $majorCategoryName,
                'subcategories' => [],
            ];
        }
    
        // Add the subcategory to the corresponding major category in the array
        $groupedCategories[$majorCategoryId]['subcategories'][$row->subcategory_name] = $row->description;
    }
    return $groupedCategories;
}
function update_rvcoins($user_id,$coins)
{
    $result = DB::update('UPDATE userprofiles SET total_rv_coins = total_rv_coins + :value WHERE user_id = :user_id', [
        'value' => $coins,
        'user_id' => $user_id,
    ]);
    return $result;
}
function rvcoins_history($id)
{
    $result = DB::table('rvcoins')
            ->leftJoin('rvcoinsrewardtypes', 'rvcoins.rvcoinsrewardtype_id', '=', 'rvcoinsrewardtypes.id')
            ->select('rvcoins.*','rvcoinsrewardtypes.reward_type')
            ->where('rvcoins.user_id',$id)->get();
    return $result;
}
function purchase_history($id)
{
    $result = DB::table('transcations')
                ->select('transcations.*','videouploads.id as videouploads_id','videouploads.unique_number')
                ->leftJoin('videouploads', 'transcations.item_id', '=', 'videouploads.id')
                ->where('transcations.user_id',$id)->get();
    return $result;
}
function video_type()
{
    $result = DB::table('videotypes')->where('status',1)->get();
    return $result;
}
function check_highest_priority($majorcategory_id)
{
    $result = DB::table('userprofiles')
                    ->where('highest_priority',1)
                    ->where('majorcategory_id',$majorcategory_id)
                    ->first();
    return $result;
}
function show_hide_section()
{
    $result = DB::table('hideshowsections')->select('section_name','status')->get();
    // echo '<pre>';
    // print_r($result['0']->section_name);exit;
    return $result;
}
function author_details($authortype_id,$video_id)
{
    $result = DB::table('coauthors')
                    ->where('authortype_id',$authortype_id)
                    ->where('videoupload_id',$video_id)
                    ->get();
    return $result;
}
function video_history_record_based_on_id($id)
{
    $result = DB::table('videohistories')
                    ->where('id',$id)
                    ->first();
    return $result;
}
function video_pagination_for_users()
{
    $result = DB::table('paginationoptionforpublishedvideos')->select('video_items_per_page')->first();
    return $result;
}
?>