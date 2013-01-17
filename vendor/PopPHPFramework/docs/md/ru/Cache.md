Pop PHP Framework
=================

Documentation : Cache
---------------------

Кэш компонент позволяет легко хранения постоянных данных с помощью трех методов:

* a file on disk
* a sqlite database
* memcache

Цель кэш компонента для ускорения доступа к данным, более статичны и не меняются часто. Сохраняя это один из методов, перечисленных выше, скорость доступа может быть увеличено, так как более дорогой процесс вызова можно избежать, таких как доступ к большой базе данных или внешних веб-адрес для получения данных.

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
