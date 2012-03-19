Pop PHP Framework
=================

Documentation : Cache
---------------------

Η συνιστώσα Cache επιτρέπει την εύκολη αποθήκευση των δεδομένων μέσω επίμονης τρεις μεθόδους:


* a file on disk
* a sqlite database
* memcache

Ο στόχος του στοιχείου Cache είναι να επιταχυνθεί η πρόσβαση στα δεδομένα που είναι πιο στατικός και δεν αλλάζει συχνά. Με την αποθήκευσή του με μία από τις μεθόδους που αναφέρονται παραπάνω, η ταχύτητα πρόσβασης μπορεί να αυξηθεί, διότι ένα πιο ακριβό κλήση διαδικασία μπορεί να αποφευχθεί, όπως πρόσβαση σε μια μεγάλη βάση δεδομένων ή μια εξωτερική διεύθυνση ιστού για να ανακτήσετε δεδομένα.


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
