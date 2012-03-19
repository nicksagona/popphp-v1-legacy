Pop PHP Framework
=================

Documentation : Cache
---------------------

المكون التخزين المؤقت يسمح لتخزين البيانات بسهولة المستمرة عبر ثلاث طرق:


* a file on disk
* a sqlite database
* memcache

والهدف من هذا العنصر هو مخبأ لتسريع الوصول إلى البيانات التي هي أكثر ثابتة ولا تغيير في كثير من الأحيان. عن طريق تخزين من قبل واحدة من الطرق المذكورة أعلاه، ويمكن زيادة السرعة لأنه لا يمكن تجنب مكالمة عملية أكثر تكلفة، مثل الوصول إلى قاعدة بيانات كبيرة أو عنوان ويب خارجي لاسترداد البيانات.


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

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
