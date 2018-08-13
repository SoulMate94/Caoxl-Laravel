<?php

// Cache Service Interface
// @caoxl

namespace App\Contract\Service;

interface Cachable
{
    // Get cached value by given key
    public function get(string $key) : string;

    // Cache given value by key for seconds
    public function set(string $key, string $value, int $seconds) : Cachable;

    // Get cached value by given key
    // And delete that cache when fetch it successfully
    public function flush(string $key) : string;

    // Delete cached value by given key
    public function delete(string $key) : bool;

    public function incrementToday(string $key, int $step = 1) : int;
}
