<?php

namespace Huifang\Web\Providers;

use Huifang\Web\Src\Auth\UserCenterUserProvider;
use Auth;
use Illuminate\Support\ServiceProvider;

class UserCenterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $user_center_service = app('Huifang\Web\Src\UserCenter\Service\UserCenterService');
        $model = config('auth.model');
        Auth::extend('user_center', function ($app) use ($user_center_service, $model) {
            return new UserCenterUserProvider($user_center_service, $model);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
