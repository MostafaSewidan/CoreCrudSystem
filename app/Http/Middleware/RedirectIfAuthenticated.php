<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $route = $request->route()->getName();
        $guards = empty($guards) ? [null] : $guards;
        switch ($route) {

            case 'dashboard.login':
                if (Auth::guard('admin')->check()) {
                    return redirect(route('dashboard.home'));
                }
                break;

            case 'doctor.login':
                if (Auth::guard('doctor')->check()) {
                    return redirect(route('doctor.home'));
                }
                break;
        }
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
