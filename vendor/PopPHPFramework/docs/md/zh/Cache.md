Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

的缓存组件允许进行简单的存储持久性数据通过四种方法：

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

缓存组件的目的是加快访问数据，是比较静态的和不经常更改。由上面列出的方法之一，通过将其存储，存取速度可以增加，因为一个更昂贵的过程调用可被避免，如访问一个大型数据库或外部web地址来检索数据。

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
