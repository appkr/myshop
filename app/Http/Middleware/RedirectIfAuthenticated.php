<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(
                route($this->getRouteName($guard))
            );
        }

        return $next($request);
    }

    private function getRouteName(string $guard)
    {
        return ($guard == 'members')
            ? 'members.dashboard'
            : 'customers.dashboard';
    }
}
