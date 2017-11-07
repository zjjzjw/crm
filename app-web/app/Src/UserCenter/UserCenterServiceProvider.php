<?php namespace Huifang\Web\Src\UserCenter;

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
            'Huifang\Web\Src\UserCenter\Service\UserCenterService',
            'Huifang\Web\Src\UserCenter\Service\UserCenterServiceImpl'
        );
    }
}