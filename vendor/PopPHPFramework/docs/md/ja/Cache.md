Pop PHP Framework
=================

Documentation : Cache
---------------------

Cacheコンポーネントは、3つのメソッドを介して永続的なデータの容易な貯蔵のためにできます。


* a file on disk
* a sqlite database
* memcache

Cacheコンポーネントの目的は、より静的であり、頻繁に変更されないデータへのアクセスをスピードアップすることです。より高価なプロセスの呼び出しはこのような大規模なデータベースやデータを取得するために、外部のWebアドレスへのアクセスなど、回避することができますので、上記のいずれかの方法でそれを格納することによって、アクセス速度を向上させることができる。


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
