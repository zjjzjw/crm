<?php

namespace Huifang\Console\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{

    protected $all_time_start;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function timeStart()
    {
        $this->all_time_start = microtime(true);
    }

    protected function timeEnd()
    {
        echo "\n" . get_class($this) . '执行时间:' . number_format((microtime(true) - $this->all_time_start) * 1000, 2) . "ms\n";
    }

    protected function log($msg)
    {
        $out_put = date('Y-m-dTH:i:s ') . var_export($msg, true) . "\n";
        echo $out_put;
        \Log::info($out_put);
    }
}
