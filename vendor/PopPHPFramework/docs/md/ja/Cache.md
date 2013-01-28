Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

Cacheã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?4ã?¤ã?®ãƒ¡ã‚½ãƒƒãƒ‰ã‚’ä»‹ã?—ã?¦æ°¸ç¶šçš„ã?ªãƒ‡ãƒ¼ã‚¿ã‚’ç°¡å?˜ã?«æ
¼ç´?ã?§ã??ã‚‹ã‚ˆã?†ã?«ï¼š

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

Cacheã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?®ç›®çš„ã?¯ã€?ã‚ˆã‚Šé?™çš„ã?§ã?‚ã‚Šã€?é
»ç¹?ã?«å¤‰æ›´ã?•ã‚Œã?ªã?„ãƒ‡ãƒ¼ã‚¿ã?¸ã?®ã‚¢ã‚¯ã‚»ã‚¹ã‚’ã‚¹ãƒ”ãƒ¼ãƒ‰ã‚¢ãƒƒãƒ—ã?™ã‚‹ã?“ã?¨ã?§ã?™ã€‚ã‚ˆã‚Šé«˜ä¾¡ã?ªãƒ—ãƒ­ã‚»ã‚¹ã?®å‘¼ã?³å‡ºã?—ã?Œã?“ã?®ã‚ˆã?†ã?ªå¤§è¦?æ¨¡ã?ªãƒ‡ãƒ¼ã‚¿ãƒ™ãƒ¼ã‚¹ã‚„ãƒ‡ãƒ¼ã‚¿ã‚’å?–å¾—ã?™ã‚‹ã?Ÿã‚?ã?«ã€?å¤–éƒ¨ã?®Webã‚¢ãƒ‰ãƒ¬ã‚¹ã?«ã‚¢ã‚¯ã‚»ã‚¹ã?™ã‚‹ã?¨ã€?å›žé?¿ã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã?¾ã?™ã?®ã?§ã€?ä¸Šè¨˜ã?„ã?šã‚Œã?‹ã?®æ–¹æ³•ã?§ã??ã‚Œã‚’æ
¼ç´?ã?™ã‚‹ã?“ã?¨ã?«ã‚ˆã‚Šã€?ã‚¢ã‚¯ã‚»ã‚¹é€Ÿåº¦ã‚’å?‘ä¸Šã?•ã?›ã‚‹ã?“ã?¨ã?Œã?§ã??ã‚‹ã€‚

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
