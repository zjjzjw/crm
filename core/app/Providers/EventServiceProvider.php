<?php

namespace Huifang\Providers;

use Xinfang\Listeners\Business\CustomerChangeListener;
use Xinfang\Listeners\Business\PrivateBuyerCallListener;
use Xinfang\Listeners\Business\CallNumListener;
use Xinfang\Listeners\Business\CallTimeListener;
use Xinfang\Listeners\Business\ManagerLookListener;
use Xinfang\Listeners\Business\ManagerVisitListener;
use Xinfang\Listeners\Business\OutboundOptListener;
use Xinfang\Listeners\Business\VisitChangeListener;
use Xinfang\Listeners\Statistics\StatisticsListener;
use Xinfang\Listeners\VisitListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

    }
}
