Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

çš„ç¼“å­˜ç»„ä»¶å…?è®¸è¿›è¡Œç®€å?•çš„å­˜å‚¨æŒ?ä¹…æ€§æ•°æ?®é€šè¿‡å››ç§?æ–¹æ³•ï¼š

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

ç¼“å­˜ç»„ä»¶çš„ç›®çš„æ˜¯åŠ
å¿«è®¿é—®æ•°æ?®ï¼Œæ˜¯æ¯”è¾ƒé?™æ€?çš„å’Œä¸?ç»?å¸¸æ›´æ”¹ã€‚ç”±ä¸Šé?¢åˆ—å‡ºçš„æ–¹æ³•ä¹‹ä¸€ï¼Œé€šè¿‡å°†å…¶å­˜å‚¨ï¼Œå­˜å?–é€Ÿåº¦å?¯ä»¥å¢žåŠ
ï¼Œå›
ä¸ºä¸€ä¸ªæ›´æ˜‚è´µçš„è¿‡ç¨‹è°ƒç”¨å?¯è¢«é?¿å…?ï¼Œå¦‚è®¿é—®ä¸€ä¸ªå¤§åž‹æ•°æ?®åº“æˆ–å¤–éƒ¨webåœ°å?€æ?¥æ£€ç´¢æ•°æ?®ã€‚

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
