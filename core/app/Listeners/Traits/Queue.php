<?php namespace Xinfang\Listeners\Traits;

use \Carbon\Carbon;

trait Queue
{
    /**
     * 队列名
     *
     * @var string
     */
    protected $queue_name = 'xinfang_task';

    /**
     * 异步队列
     *
     * @param $default_queue
     * @param $job
     * @param $data
     * @param null $queue
     */
    public function queue($default_queue, $job, $data, $queue = null)
    {
        \Queue::push($job, $data, $this->queue_name);
    }

    public static function later(Carbon $carbon, $job, $data)
    {
        \Queue::later($carbon, $job, $data, 'xinfang_task');
    }
}
