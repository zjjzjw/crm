<?php

namespace Huifang\Web\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                //如果是ajax,不限制
                $errors = array(
                    '1' => ['权限不足'],
                );
                return response($errors, 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }
        return $next($request);
    }
}
