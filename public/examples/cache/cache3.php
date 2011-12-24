<?php

require_once '../../bootstrap.php';

use Pop\Cache\Cache,
    Pop\Cache\File,
    Pop\Cache\Memcached,
    Pop\Cache\Sqlite;

try {
    $cache = Cache::factory(new File('../tmp'), 30);
    //$cache = Cache::factory(new Memcached(), 30);
    //$cache = Cache::factory(new Sqlite('../tmp/cache.sqlite'), 30);

    $cache->clear();
    echo 'Cache cleared.' . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>