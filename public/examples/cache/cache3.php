<?php

require_once '../../bootstrap.php';

use Pop\Cache;

try {
    //$cache = Cache\Cache::factory(new Cache\Adapter\File('../tmp'), 30);
    //$cache = Cache\Cache::factory(new Cache\Memcached(), 30);
    //$cache = Cache\Cache::factory(new Cache\Sqlite('../tmp/cache.sqlite'), 30);
    $cache = Cache\Cache::factory(new Cache\Adapter\Apc(), 30);

    $cache->clear();
    echo 'Cache cleared.' . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
