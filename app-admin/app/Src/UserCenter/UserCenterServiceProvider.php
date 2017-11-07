<?php namespace Huifang\Admin\Src\UserCenter;

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
            'Huifang\Admin\Src\UserCenter\Service\UserCenterService',
            'Huifang\Admin\Src\UserCenter\Service\UserCenterServiceImpl'
        );
    }
}