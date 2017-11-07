<?php

namespace Huifang\Console\Commands;

use Huifang\Jobs\SendReminderEmail;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Inspiring;

class TestJob extends BaseCommand
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('111111111');
        $job = (new SendReminderEmail())->onQueue('high');
        $this->dispatch($job);
    }
}
