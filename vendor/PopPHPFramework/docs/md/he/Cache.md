Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

רכיב המטמון מאפשר אחסון הקל של נתונים מתמשכים באמצעות ארבע שיטות:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

מטרתו של רכיב המטמון היא להאיץ גישה לנתונים שיותר סטטי ואינו משתנים
לעתים קרובות. על ידי אחסונו על ידי אחת מהשיטות המפורטות לעיל, מהירות
גישה יכולה להיות מוגברת, מאחר שניתן להימנע משיחת תהליך יקרה יותר, כגון
גישה למסד נתונים גדול או כתובת אינטרנט חיצונית כדי לאחזר את הנתונים.

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
