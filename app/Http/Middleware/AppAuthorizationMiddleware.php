<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\AppAuthorization;


class AppAuthorizationMiddleware
{
    use AppAuthorization;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->authorizeToken($request);
        return $next($request);
    }
}
