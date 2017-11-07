<?php

namespace Huifang\Mobi\Http\Middleware;

use Huifang\Service\Role\TokenService;
use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        TokenService::setHeaders($request);
        TokenService::checkToken();
        return $next($request);
    }


}
