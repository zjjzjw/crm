<?php namespace Huifang\Crm\Src\UserCenter;

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
            'Huifang\Crm\Src\UserCenter\Service\UserCenterService',
            'Huifang\Crm\Src\UserCenter\Service\UserCenterServiceImpl'
        );
    }
}