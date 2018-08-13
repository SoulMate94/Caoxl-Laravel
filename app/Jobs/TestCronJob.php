<?php

namespace App\Jobs\Timer;

use Hhxsv5\LaravelS\Swoole\Timer\CronJob;

class TestCronJob extends CronJob
{
    protected $i = 0;

    public function __construct()
    {
    }

    public function interval()
    {
        return 1000; // 每1秒运行一次
    }
    public function isImmediate()
    {
        return false;  // 是否立即执行第一次，false则等待间隔时间后执行第一次
    }
    public function run()
    {
        \Log::info(__METHOD__, ['start', $this->i, microtime(true)]);
        // do something
        $this->i++;
        \Log::info(__METHOD__, ['end', $this->i, microtime(true)]);

        if ($this->i >= 10) { // 运行10次后不再执行
            \Log::info(__METHOD__, ['stop', $this->i, microtime(true)]);
            $this->stop(); // 终止此任务
        }
        // throw new \Exception('an exception');// 此时抛出的异常上层会忽略，并记录到Swoole日志，需要开发者try/catch捕获处理
    }
}