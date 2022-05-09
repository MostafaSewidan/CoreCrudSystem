<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('APP_INSTALLED') && env('APP_INSTALLED') == true) {
            return redirect()->route('dashboard.home');
        }

        return $next($request);
    }
}
