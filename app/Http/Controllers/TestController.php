<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use Hhxsv5\LaravelS\Swoole\Task\Event;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function test()
    {
        $success = Event::fire(new TestEvent('event data'));

        var_dump($success);
    }

    public function testCache()
    {
        $res = Cache::get('test');
        Cache::forever('key', 'value');
        Cache::forget('test');
    }
}