Pop PHP Framework
=================

Documentation : Cache
---------------------

El componente de Caché permite el fácil almacenamiento de datos persistentes a través de tres métodos:

* a file on disk
* a sqlite database
* memcache

El objetivo del componente de memoria caché es acelerar el acceso a los datos que son más estáticos y no cambian a menudo. Mediante el almacenamiento de ella por uno de los métodos mencionados anteriormente, la velocidad de acceso se puede aumentar debido a una llamada de proceso más costoso se puede evitar, como el acceso a una gran base de datos o una dirección web externa para recuperar los datos.

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
