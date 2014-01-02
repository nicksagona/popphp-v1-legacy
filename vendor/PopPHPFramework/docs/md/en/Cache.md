Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

The Cache component allows for the easy storage of persistent data via
four methods:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

The goal of the Cache component is to speed up access to data that is
more static and does not change often. By storing it by one of the
methods listed above, access speed can be increased because a more
expensive process call can be avoided, such as accessing a large
database or an external web address to retrieve data.

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
