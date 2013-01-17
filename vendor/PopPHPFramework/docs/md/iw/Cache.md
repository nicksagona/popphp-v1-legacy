Pop PHP Framework
=================

Documentation : Cache
---------------------

רכיב מטמון מאפשר אחסון קל של נתונים מתמשך באמצעות שלוש שיטות:

* a file on disk
* a sqlite database
* memcache

המטרה של הרכיב הוא מטמון כדי להאיץ גישה לנתונים סטטי יותר ואינו משתנה לעיתים קרובות. על ידי אחסונם על ידי אחת מהשיטות המפורטות לעיל, מהירות גישה יכולה להיות מוגברת בגלל שיחת תהליך יקר יותר ניתן להימנע, כגון גישה מסד נתונים גדול או כתובת אינטרנט חיצוני כדי לאחזר נתונים.

<pre>
use Pop\Cache\Cache,
    Pop\Cache\File,
    Pop\Cache\Memcached,
    Pop\Cache\Sqlite;

$test = 'This is my test variable. It contains a string.';

// Create Cache object, using either Memcached, File or Sqlite
$cache = Cache::factory(new Memcached(), 30);
//$cache = Cache::factory(new File('../tmp'), 30);
//$cache = Cache::factory(new Sqlite('../tmp/cache.sqlite'), 30);

// Save value to cache
$cache->save('test', $test);

// Load the value from cache
if (!($var = $cache->load('test'))) {
    echo 'The value is either not there or expired.';
} else {
    var_dump($var);
}

// Clear the cache
$cache->clear();
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
