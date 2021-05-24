<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware for verifying user authorization.
 */
class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request Http request
     * @param  Closure  $next
     *
     * @throws AuthenticationException
     *
     * @return Closure
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard()->guest()) {
            throw new AuthenticationException();
        }
        
        return $next($request);
    }
}
