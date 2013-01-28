Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

La composante cache permet de stocker facilement des donnÃ©es
persistantes par quatre mÃ©thodes:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

L'objectif de la composante cache est d'accÃ©lÃ©rer l'accÃ¨s aux
donnÃ©es qui ne sont plus statiques et ne changent pas souvent. En les
stockant par l'une des mÃ©thodes Ã©numÃ©rÃ©es ci-dessus, la vitesse
d'accÃ¨s peut Ãªtre augmentÃ©e en raison d'un appel de processus plus
coÃ»teux peuvent Ãªtre Ã©vitÃ©s, tels que l'accÃ¨s Ã une vaste base de
donnÃ©es ou une adresse Web externe pour rÃ©cupÃ©rer les donnÃ©es.

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
