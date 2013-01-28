Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

×¨×›×™×‘ ×”×ž×˜×ž×•×Ÿ ×ž×?×¤×©×¨ ×?×—×¡×•×Ÿ ×”×§×œ ×©×œ × ×ª×•× ×™×?
×ž×ª×ž×©×›×™×? ×‘×?×ž×¦×¢×•×ª ×?×¨×‘×¢ ×©×™×˜×•×ª:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

×ž×˜×¨×ª×• ×©×œ ×¨×›×™×‘ ×”×ž×˜×ž×•×Ÿ ×”×™×? ×œ×”×?×™×¥ ×’×™×©×” ×œ×
×ª×•× ×™×? ×©×™×•×ª×¨ ×¡×˜×˜×™ ×•×?×™× ×• ×ž×©×ª× ×™×? ×œ×¢×ª×™×?
×§×¨×•×‘×•×ª. ×¢×œ ×™×“×™ ×?×—×¡×•× ×• ×¢×œ ×™×“×™ ×?×—×ª ×ž×”×©×™×˜×•×ª
×”×ž×¤×•×¨×˜×•×ª ×œ×¢×™×œ, ×ž×”×™×¨×•×ª ×’×™×©×” ×™×›×•×œ×” ×œ×”×™×•×ª
×ž×•×’×‘×¨×ª, ×ž×?×—×¨ ×©× ×™×ª×Ÿ ×œ×”×™×ž× ×¢ ×ž×©×™×—×ª ×ª×”×œ×™×š
×™×§×¨×” ×™×•×ª×¨, ×›×’×•×Ÿ ×’×™×©×” ×œ×ž×¡×“ × ×ª×•× ×™×? ×’×“×•×œ ×?×•
×›×ª×•×‘×ª ×?×™× ×˜×¨× ×˜ ×—×™×¦×•× ×™×ª ×›×“×™ ×œ×?×—×–×¨ ×?×ª ×”×
×ª×•× ×™×?.

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
