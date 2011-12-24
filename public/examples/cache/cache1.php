<?php

require_once '../../bootstrap.php';

use Pop\Cache\Cache,
    Pop\Cache\File,
    Pop\Cache\Memcached,
    Pop\Cache\Sqlite;

try {
    $test = 'This is my test variable. It contains a string.';

    $cache = Cache::factory(new File('../tmp'), 30);
    //$cache = Cache::factory(new Memcached(), 30);
    //$cache = Cache::factory(new Sqlite('../tmp/cache.sqlite'), 30);

    $cache->save('test', $test);
    echo 'Value saved to cache.' . PHP_EOL . PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>