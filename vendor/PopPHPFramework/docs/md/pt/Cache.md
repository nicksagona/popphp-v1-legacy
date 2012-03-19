Pop PHP Framework
=================

Documentation : Cache
---------------------

O componente Cache permite a facilidade de armazenamento de dados persistentes através de três métodos:

* a file on disk
* a sqlite database
* memcache

O objetivo do componente Cache é para acelerar o acesso a dados que é mais estática e não muda com freqüência. Ao armazená-lo por um dos métodos listados acima, a velocidade de acesso pode ser aumentada porque uma chamada processo mais caro pode ser evitado, como acessar um banco de dados grande ou um endereço web externo para recuperar dados.

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
