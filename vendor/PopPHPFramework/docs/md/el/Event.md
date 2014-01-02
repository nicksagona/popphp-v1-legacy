Pop PHP Framework
=================

Documentation : Event
---------------------

Home

Το στοιχείο Event παρέχει έναν τρόπο για να συνδέσετε και να προκαλέσει
τα γεγονότα στο πλαίσιο του κύκλου ζωής της αίτησης. Το κύριο
πλεονέκτημα είναι η δυνατότητα να επεκτείνουν την εφαρμογή, συνδέοντας
τη λειτουργικότητα σε αυτό μέσω του κλεισίματος και τάξεις που
επισυνάπτονται ως γεγονότα.

Εδώ είναι ένα παράδειγμα από τη σύνδεση και την ενεργοποίηση ενός
γεγονότος με το κλείσιμο. Το δεύτερο λαμβάνει το αποτέλεσμα από το
πρώτο.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

Εδώ είναι ένα παράδειγμα χρησιμοποιώντας μια τάξη.

    use Pop\Event\Manager;

    class Foo
    {
        public $value;

        public function __construct($arg = null)
        {
            $this->value = $arg;
        }

        public static function factory($arg)
        {
            return new self($arg);
        }

        public function bar($arg)
        {
            $this->value = $arg;
            return $this;
        }
    }

    $manager = new Manager();

    $manager->attach('pre', 'Foo::factory', 2);

    // OR
    //$manager->attach('pre', 'Foo->bar', 2);

    $manager->attach('pre', function($result) { echo 'Hello, ' . $result->value . '<br />' . PHP_EOL; }, 1);
    $manager->trigger('pre', array('arg' => 'World'));

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
