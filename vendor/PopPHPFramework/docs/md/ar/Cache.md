Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

العنصر ذاكرة التخزين المؤقت يسمح لسهولة التخزين للبيانات الثابتة عبر
أربعة أساليب:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

والهدف من هذا المكون هو الكاش لتسريع الوصول إلى البيانات التي هي أكثر
ثابت لا يتغير وكثير من الأحيان. عن طريق تخزين من قبل إحدى الطرق المذكورة
أعلاه، يمكن زيادة السرعة لأنه يمكن تجنب مكالمة عملية أكثر تكلفة، مثل
الوصول إلى قاعدة بيانات كبيرة أو عنوان ويب لاسترداد البيانات الخارجية

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
