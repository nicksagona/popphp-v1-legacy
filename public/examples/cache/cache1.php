<?php

require_once '../../bootstrap.php';

use Pop\Cache;

try {
    $test = 'This is my test variable. It contains a string.';

    $cache = Cache\Cache::factory(new Cache\Adapter\File('../tmp'), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Memcached(), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Sqlite('../tmp/cache.sqlite'), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Apc(), 30);

    $cache->save('test', $test);
    echo 'Value saved to cache.';

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
