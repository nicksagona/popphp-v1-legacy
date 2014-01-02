Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

O componente Cache permite o armazenamento fácil dos dados persistentes
através de quatro métodos:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

O objetivo do componente de cache é acelerar o acesso a dados que é mais
estática e não muda frequentemente. Armazenando-o por um dos métodos
acima referidos, a velocidade de acesso pode ser aumentada porque uma
chamada processo mais dispendioso pode ser evitado, como o acesso a uma
base de dados de grandes dimensões ou um endereço Web externo para
recuperar dados.

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
