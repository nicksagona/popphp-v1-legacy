Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

ÐšÑ?Ñˆ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ð¾Ð·Ð²Ð¾Ð»Ñ?ÐµÑ‚ Ð»ÐµÐ³ÐºÐ¾ Ñ…Ñ€Ð°Ð½ÐµÐ½Ð¸Ñ?
Ð¿Ð¾Ñ?Ñ‚Ð¾Ñ?Ð½Ð½Ñ‹Ñ… Ð´Ð°Ð½Ð½Ñ‹Ñ… Ñ‡ÐµÑ€ÐµÐ· Ñ‡ÐµÑ‚Ñ‹Ñ€Ðµ Ð¼ÐµÑ‚Ð¾Ð´Ð°:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

Ð¦ÐµÐ»ÑŒ ÐºÑ?Ñˆ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð° Ð´Ð»Ñ? ÑƒÑ?ÐºÐ¾Ñ€ÐµÐ½Ð¸Ñ?
Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿Ð° Ðº Ð´Ð°Ð½Ð½Ñ‹Ð¼, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ð¹ Ñ?Ð²Ð»Ñ?ÐµÑ‚Ñ?Ñ?
Ð±Ð¾Ð»ÐµÐµ Ñ?Ñ‚Ð°Ñ‚Ð¸Ñ‡Ð½Ñ‹Ð¼ Ð¸ Ð½Ðµ Ð¼ÐµÐ½Ñ?ÐµÑ‚Ñ?Ñ? Ñ‡Ð°Ñ?Ñ‚Ð¾. ÐŸÐ¾
ÐµÐµ Ñ…Ñ€Ð°Ð½ÐµÐ½Ð¸Ñ? Ð¾Ð´Ð½Ð¾Ð³Ð¾ Ð¸Ð· Ð¼ÐµÑ‚Ð¾Ð´Ð¾Ð²,
Ð¿ÐµÑ€ÐµÑ‡Ð¸Ñ?Ð»ÐµÐ½Ð½Ñ‹Ñ… Ð²Ñ‹ÑˆÐµ, Ñ?ÐºÐ¾Ñ€Ð¾Ñ?Ñ‚ÑŒ Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿Ð°
Ð¼Ð¾Ð¶ÐµÑ‚ Ð±Ñ‹Ñ‚ÑŒ ÑƒÐ²ÐµÐ»Ð¸Ñ‡ÐµÐ½Ð¾, Ð¿Ð¾Ñ?ÐºÐ¾Ð»ÑŒÐºÑƒ Ð±Ð¾Ð»ÐµÐµ
Ð´Ð¾Ñ€Ð¾Ð³Ð¾Ð¹ Ð¿Ñ€Ð¾Ñ†ÐµÑ?Ñ? Ð²Ñ‹Ð·Ð¾Ð²Ð° Ð¼Ð¾Ð¶Ð½Ð¾ Ð¸Ð·Ð±ÐµÐ¶Ð°Ñ‚ÑŒ,
Ñ‚Ð°ÐºÐ¸Ðµ ÐºÐ°Ðº Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿ Ðº Ð±Ð¾Ð»ÑŒÑˆÐ¾Ð¹ Ð±Ð°Ð·Ðµ Ð´Ð°Ð½Ð½Ñ‹Ñ…
Ð¸Ð»Ð¸ Ð²Ð½ÐµÑˆÐ½Ð¸Ñ… Ð²ÐµÐ±-Ð°Ð´Ñ€ÐµÑ? Ð´Ð»Ñ? Ð¿Ð¾Ð»ÑƒÑ‡ÐµÐ½Ð¸Ñ?
Ð´Ð°Ð½Ð½Ñ‹Ñ….

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
