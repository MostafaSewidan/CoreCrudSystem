<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfInstalled
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
            return $next($request);
        }

        return redirect()->route('installation');
    }
}
