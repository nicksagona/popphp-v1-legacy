Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

Το συστατικό Cache επιτρέπει την εύκολη αποθήκευση των δεδομένων μέσω
επίμονης τέσσερις μεθόδους:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

Ο στόχος του συστατικού Cache είναι να επιταχυνθεί η πρόσβαση στα
δεδομένα που είναι πιο στατικός και δεν αλλάζει συχνά. Με την αποθήκευση
με μία από τις μεθόδους που αναφέρονται παραπάνω, η ταχύτητα πρόσβασης
μπορεί να αυξηθεί επειδή μια πιο δαπανηρή διαδικασία κλήσης μπορεί να
αποφευχθεί, όπως πρόσβαση σε μια μεγάλη βάση δεδομένων ή ένα εξωτερικό
διεύθυνση ιστού για την ανάκτηση δεδομένων.

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
