Pop PHP Framework
=================

Documentation : Cache
---------------------

La composante Cache permet le stockage des données persistantes facile via trois méthodes:


* a file on disk
* a sqlite database
* memcache

L'objectif de la composante du cache est d'accélérer l'accès aux données qui est plus statique et ne change pas souvent. En les stockant par l'une des méthodes énumérées ci-dessus, la vitesse d'accès peut être augmenté en raison d'un appel procédé plus coûteux peuvent être évités, tels que l'accès à une vaste base de données ou une adresse Web externe pour récupérer des données.


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
