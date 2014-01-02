Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

Cacheコンポーネントは、4つのメソッドを介して永続的なデータを簡単に格納できるように：

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

Cacheコンポーネントの目的は、より静的であり、頻繁に変更されないデータへのアクセスをスピードアップすることです。より高価なプロセスの呼び出しがこのような大規模なデータベースやデータを取得するために、外部のWebアドレスにアクセスすると、回避することができますので、上記いずれかの方法でそれを格納することにより、アクセス速度を向上させることができる。

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
