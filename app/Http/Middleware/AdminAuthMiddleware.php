<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
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
        if (!empty(Auth::user())) {
            //if we go to login or register page after login with admin account
            if (url()->current() == route('auth#loginPage') || url()->current() == route('auth#registerPage')) {
                return back();
            }
            if (Auth::user()->role == 'user') {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        }
        return $next($request);
    }
}
