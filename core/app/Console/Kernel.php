<?php

namespace Huifang\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\DetectEnvironment::class,
        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \Huifang\Bootstrap\ConfigureLogging::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\SetRequestForConsole::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Huifang\Console\Commands\Inspire::class,
        \Huifang\Console\Commands\TestJob::class,
        \Huifang\Console\Commands\ImportSale::class,
        \Huifang\Console\Commands\TransferData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }
}
