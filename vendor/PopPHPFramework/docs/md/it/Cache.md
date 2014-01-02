Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

Il componente della cache consente di facile memorizzazione di dati
persistenti tramite quattro metodi:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

L'obiettivo della componente cache è quello di accelerare l'accesso ai
dati che è più statico e non cambia spesso. Depositandolo con uno dei
metodi sopra elencati, velocità di accesso può essere aumentata a causa
di una chiamata più costoso processo può essere evitato, come accedere
un database grande o un indirizzo web esterno per recuperare i dati.

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
