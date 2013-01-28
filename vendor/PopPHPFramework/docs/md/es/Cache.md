Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

El componente de CachÃ© permite el fÃ¡cil almacenamiento de datos
persistentes a travÃ©s de cuatro mÃ©todos:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

El objetivo del componente de cachÃ© es acelerar el acceso a los datos
que son mÃ¡s estÃ¡ticos y no cambian a menudo. Mediante el
almacenamiento de Ã©l por uno de los mÃ©todos mencionados anteriormente,
la velocidad de acceso puede incrementarse debido a una llamada de
proceso mÃ¡s caro puede ser evitado, tales como acceder a una gran base
de datos o una direcciÃ³n web externo para recuperar los datos.

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
