Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

Die Cache-Komponente ermöglicht die einfache Speicherung von
persistenten Daten über vier Methoden:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

Das Ziel des Cache-Komponente ist zu beschleunigen den Zugriff auf
Daten, die mehr statisch ist und nicht oft ändern. Durch Speicherung von
einer der oben genannten Methoden können Zugriffsgeschwindigkeit erhöht,
da ein teurer Prozess Anruf kann vermieden, wie den Zugriff auf eine
große Datenbank oder einer externen Web-Adresse zum Abrufen von Daten
werden kann.

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
