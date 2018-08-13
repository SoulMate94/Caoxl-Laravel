<?php

// Cache service re-packing from Laravel
// @caoxl

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;
use App\Contract\Service\Cachable;

class Laravel implements Cachable
{
    public function get(string $key): string
    {
        return (string) Cache::get($key);
    }

    public function set(string $key, string $value, int $seconds): Cachable
    {
        Cache::put($key, $value, ($seconds/60));

        return $this;
    }

    public function flush(string $key): string
    {
        $value = null;

        if (Cache::has($key)) {
            $value = Cache::get($key);
            Cache::forget($key);
        }

        return (string) $value;
    }

    public function delete(string $key): bool
    {
        if (Cache::has($key)) {
            return Cache::forget($key);
        }

        return true;
    }
    public function incrementToday(string $key, int $step = 1): int
    {
        $times   = intval(Cache::get($key));
        $times  += $step;
        $minutes = ($this->seconds_left_today() / 60);

        Cache::put($key, $times, $minutes);

        return $times;
    }

    private function seconds_left_today() : int
    {
        $tomorrow = strtotime(date('Y-m-d', strtotime('+1 day')));

        return $tomorrow - time();
    }
}