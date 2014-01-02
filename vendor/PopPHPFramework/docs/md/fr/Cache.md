Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

La composante cache permet de stocker facilement des données
persistantes par quatre méthodes:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

L'objectif de la composante cache est d'accélérer l'accès aux données
qui ne sont plus statiques et ne changent pas souvent. En les stockant
par l'une des méthodes énumérées ci-dessus, la vitesse d'accès peut être
augmentée en raison d'un appel de processus plus coûteux peuvent être
évités, tels que l'accès à une vaste base de données ou une adresse Web
externe pour récupérer les données.

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
