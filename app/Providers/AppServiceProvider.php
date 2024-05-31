<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\MajorCatogryViewComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Subcategory;
use App\Models\Majorcategory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        View::composer(
            '*', MajorCatogryViewComposer::class
           );

        // Add another query for every page
        View::composer('*', function ($view) {
            $data = checkUserSubscriptionPlan();
            $view->with('checkUserSubscriptionPlan', $data);
        });

        // Add another query for every page
        View::composer('*', function ($view) {
             $data = subcategoryVideos();
            $view->with('subcategoryVideos', $data);
        });

        view()->composer('*', function($view)
        {
            if (Auth::check()) {
                $data = get_user_details(Auth::user()->id);
                $view->with('loggedIn_user_details', $data);
            }else {
                $data = null;
                $view->with('loggedIn_user_details', $data);
            }
        });

        View::composer('*', function ($view) {
            $data = video_type();
           $view->with('video_type_records', $data);
        });

        View::composer('*', function ($view) {
            $data = show_hide_section();
           $view->with('show_hide_section_record', $data);
        });

        Paginator::useBootstrap();
    }
}
