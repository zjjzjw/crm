<?php

namespace Huifang\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SignatureMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
