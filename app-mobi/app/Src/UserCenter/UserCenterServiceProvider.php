<?php namespace Huifang\Mobi\Src\UserCenter;

use Illuminate\Support\ServiceProvider;


class UserCenterServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Huifang\Mobi\Src\UserCenter\Service\UserCenterService',
            'Huifang\Mobi\Src\UserCenter\Service\UserCenterServiceImpl'
        );
    }
}