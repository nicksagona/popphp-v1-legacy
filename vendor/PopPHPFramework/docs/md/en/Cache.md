Pop PHP Framework
=================

Documentation : Cache
---------------------

The Cache component allows for the easy storage of persistent data via three methods:

* a file on disk
* a sqlite database
* memcache

The goal of the Cache component is to speed up access to data that is more static and does not change often. By storing it by one of the methods listed above, access speed can be increased because a more expensive process call can be avoided, such as accessing a large database or an external web address to retrieve data.

<pre>
use Pop\Cache\Cache
    Pop\Cache\Memcached;

$test = 'This is my test variable. It contains a string.';

// Create Cache object
$cache = Cache::factory(new Memcached(), 30);

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
