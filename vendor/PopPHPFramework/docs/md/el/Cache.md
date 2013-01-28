Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

Î¤Î¿ ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Cache ÎµÏ€Î¹Ï„Ï?Î­Ï€ÎµÎ¹ Ï„Î·Î½ ÎµÏ?ÎºÎ¿Î»Î·
Î±Ï€Î¿Î¸Î®ÎºÎµÏ…ÏƒÎ· Ï„Ï‰Î½ Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½ Î¼Î­ÏƒÏ‰ ÎµÏ€Î¯Î¼Î¿Î½Î·Ï‚
Ï„Î­ÏƒÏƒÎµÏ?Î¹Ï‚ Î¼ÎµÎ¸ÏŒÎ´Î¿Ï…Ï‚:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

ÎŸ ÏƒÏ„ÏŒÏ‡Î¿Ï‚ Ï„Î¿Ï… ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÎ¿Ï? Cache ÎµÎ¯Î½Î±Î¹ Î½Î±
ÎµÏ€Î¹Ï„Î±Ï‡Ï…Î½Î¸ÎµÎ¯ Î· Ï€Ï?ÏŒÏƒÎ²Î±ÏƒÎ· ÏƒÏ„Î± Î´ÎµÎ´Î¿Î¼Î­Î½Î±
Ï€Î¿Ï… ÎµÎ¯Î½Î±Î¹ Ï€Î¹Î¿ ÏƒÏ„Î±Ï„Î¹ÎºÏŒÏ‚ ÎºÎ±Î¹ Î´ÎµÎ½ Î±Î»Î»Î¬Î¶ÎµÎ¹
ÏƒÏ…Ï‡Î½Î¬. ÎœÎµ Ï„Î·Î½ Î±Ï€Î¿Î¸Î®ÎºÎµÏ…ÏƒÎ· Î¼Îµ Î¼Î¯Î± Î±Ï€ÏŒ Ï„Î¹Ï‚
Î¼ÎµÎ¸ÏŒÎ´Î¿Ï…Ï‚ Ï€Î¿Ï… Î±Î½Î±Ï†Î­Ï?Î¿Î½Ï„Î±Î¹ Ï€Î±Ï?Î±Ï€Î¬Î½Ï‰, Î·
Ï„Î±Ï‡Ï?Ï„Î·Ï„Î± Ï€Ï?ÏŒÏƒÎ²Î±ÏƒÎ·Ï‚ Î¼Ï€Î¿Ï?ÎµÎ¯ Î½Î± Î±Ï…Î¾Î·Î¸ÎµÎ¯
ÎµÏ€ÎµÎ¹Î´Î® Î¼Î¹Î± Ï€Î¹Î¿ Î´Î±Ï€Î±Î½Î·Ï?Î® Î´Î¹Î±Î´Î¹ÎºÎ±ÏƒÎ¯Î±
ÎºÎ»Î®ÏƒÎ·Ï‚ Î¼Ï€Î¿Ï?ÎµÎ¯ Î½Î± Î±Ï€Î¿Ï†ÎµÏ…Ï‡Î¸ÎµÎ¯, ÏŒÏ€Ï‰Ï‚
Ï€Ï?ÏŒÏƒÎ²Î±ÏƒÎ· ÏƒÎµ Î¼Î¹Î± Î¼ÎµÎ³Î¬Î»Î· Î²Î¬ÏƒÎ· Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½ Î®
Î­Î½Î± ÎµÎ¾Ï‰Ï„ÎµÏ?Î¹ÎºÏŒ Î´Î¹ÎµÏ?Î¸Ï…Î½ÏƒÎ· Î¹ÏƒÏ„Î¿Ï? Î³Î¹Î± Ï„Î·Î½
Î±Î½Î¬ÎºÏ„Î·ÏƒÎ· Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½.

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
