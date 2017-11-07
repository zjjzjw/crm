<?php

namespace Huifang\Web\Providers;

use Huifang\Web\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        $config_permissions = config('permissions');
        $collect_names = collect(array_keys($config_permissions));
        $collect_names->each(function ($item) use ($gate) {
            $gate->define($item, function ($user) use ($item) {
                /** @var User $user */
                return $user->hasPermission($item);
            });
        });

    }
}