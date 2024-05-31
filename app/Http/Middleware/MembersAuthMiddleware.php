<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class MembersAuthMiddleware
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
        // Get the user's role
        //$userRole = Auth::user()->role_id;
        $userRole = Session::get('loggedin_role');

        // Check the user's role and redirect accordingly
        if($userRole == 6) {
            return $next($request);
        }
        abort(403, 'Unauthorized Access!'); 
    }
}
