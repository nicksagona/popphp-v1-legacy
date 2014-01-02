Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

Кэш компонент позволяет легко хранения постоянных данных через четыре
метода:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

Цель кэш компонента для ускорения доступа к данным, который является
более статичным и не меняется часто. По ее хранения одного из методов,
перечисленных выше, скорость доступа может быть увеличено, поскольку
более дорогой процесс вызова можно избежать, такие как доступ к большой
базе данных или внешних веб-адрес для получения данных.

    use Pop\Cache;
    $test = 'This is my test variable. It contains a string.';

    $cache = Cache\Cache::factory(new Cache\Adapter\File('../tmp'), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Memcached(), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Sqlite('../tmp/cache.sqlite'), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Apc(), 30);

    $cache->save('test', $test);

    // Load the value
    if (!($var = $cache->load('test'))) {
        echo "It's either not there or expired.";
    } else {
        echo $var;
    }

    // Clear the cache
    $cache->clear();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
