Pop PHP Framework
=================

Documentation : Cache
---------------------

缓存组件允许容易通过三种方法的持久性数据存储：


* a file on disk
* a sqlite database
* memcache

缓存组件的目的是加快访问数据是静态和不经常更改。上面列出的方法之一，它通过储存，存取速度可以增加，因为更昂贵的过程调用，如访问一个大型数据库或外部的网络地址来检索数据，可避免。

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
