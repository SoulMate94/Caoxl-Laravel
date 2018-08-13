<?php

namespace App\Listeners;

use Hhxsv5\LaravelS\Swoole\Task\Event;
use Hhxsv5\LaravelS\Swoole\Task\Listener;

class TestListener extends Listener
{
    /**
     * 构造函数
     * TestListener constructor.
     */
    public function __construct()
    {
    }

    public function handle(Event $event)
    {
        // TODO: Implement handle() method.
        \Log::info(__CLASS__ . ':handle start', [$event->getData()]);

        sleep(2);
    }
}