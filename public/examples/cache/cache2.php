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

    if (!($var = $cache->load('test'))) {
        echo 'It\'s either not there or expired.';
    } else {
        var_dump($var);
    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>