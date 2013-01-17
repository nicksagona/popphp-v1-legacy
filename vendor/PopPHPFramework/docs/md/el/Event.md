Pop PHP Framework
=================

Documentation : Event
---------------------

Το στοιχείο Event παρέχει έναν τρόπο για να συνδέσετε και να προκαλέσει τα γεγονότα στο πλαίσιο του κύκλου ζωής της αίτησης. Το κύριο πλεονέκτημα είναι η δυνατότητα να επεκτείνουν την εφαρμογή, συνδέοντας τη λειτουργικότητα σε αυτό μέσω του κλεισίματος και τάξεις που επισυνάπτονται ως γεγονότα.

Εδώ είναι ένα παράδειγμα από τη σύνδεση και την ενεργοποίηση ενός γεγονότος με το κλείσιμο. Το δεύτερο λαμβάνει το αποτέλεσμα από το πρώτο.

<pre>
use Pop\Event\Manager;

$manager = new Manager();

$manager-&gt;attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
$manager-&gt;attach('pre', function($result) { echo $result . '&lt;br /&gt;' . PHP_EOL; }, 1);

$manager-&gt;trigger('pre', array('name' =&gt; 'World'));
</pre>

Εδώ είναι ένα παράδειγμα χρησιμοποιώντας μια τάξη.

<pre>
use Pop\Event\Manager;

class Foo
{
    public $value;

    public function __construct($arg = null)
    {
        $this-&gt;value = $arg;
    }

    public static function factory($arg)
    {
        return new self($arg);
    }

    public function bar($arg)
    {
        $this-&gt;value = $arg;
        return $this;
    }
}

$manager = new Manager();

$manager-&gt;attach('pre', 'Foo::factory', 2);

// OR
//$manager-&gt;attach('pre', array(new Foo, 'bar'), 2);

$manager-&gt;attach('pre', function($result) { echo 'Hello, ' . $result-&gt;value . '&lt;br /&gt;' . PHP_EOL; }, 1);
$manager-&gt;trigger('pre', array('arg' =&gt; 'World'));
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
