Pop PHP Framework
=================

Documentation : Cache
---------------------

Der Cache-Komponente ermöglicht die einfache Speicherung von dauerhaften Daten über drei Methoden:

* a file on disk
* a sqlite database
* memcache

Das Ziel des Cache-Komponente ist, um schnelleren Zugriff auf Daten, die eher statisch ist und sich nicht oft ändern. Durch Speicherung von einem der oben aufgeführten Methoden können Zugriffsgeschwindigkeit erhöht, weil ein teurer Prozess Anruf kann vermieden werden, wie den Zugriff auf eine große Datenbank oder eine externe Web-Adresse zum Abrufen von Daten werden kann.

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
