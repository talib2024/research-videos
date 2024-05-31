<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // For remove session for advanced search
        $excludedRoutes = ['show.advance.search', 'show.all.search'];
        // Check if the current route is in the excluded list
        if (!in_array($request->route()->getName(), $excludedRoutes)) {
            session()->forget('advance_search_request');
        }
        // End for remove session for advanced search

        if (Auth::check() && (Auth::user()->status == 0 || Auth::user()->status == 2)) {
            Session::flush();
            Auth::logout();
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
