<?php namespace Huifang\Site\Src\UserCenter;

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
            'Huifang\Site\Src\UserCenter\Service\UserCenterService',
            'Huifang\Site\Src\UserCenter\Service\UserCenterServiceImpl'
        );
    }
}