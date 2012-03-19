Pop PHP Framework
=================

Documentation : Cache
---------------------

Il componente della cache consente di facile memorizzazione di dati persistenti attraverso tre metodi:

* a file on disk
* a sqlite database
* memcache

L'obiettivo della componente Cache è quello di accelerare l'accesso ai dati che è più statico e non cambia spesso. Memorizzando dal uno dei metodi elencati sopra, la velocità di accesso può essere aumentata a causa di una chiamata più costoso processo può essere evitato, come ad esempio accedere a un database di grandi dimensioni o un indirizzo web esterno per recuperare i dati.

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
