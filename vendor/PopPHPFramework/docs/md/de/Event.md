Pop PHP Framework
=================

Documentation : Event
---------------------

Home

Der Event-Komponente bietet einen Weg zu befestigen und lösen Ereignisse
im Lebenszyklus einer Anwendung. Der Hauptvorteil ist die Möglichkeit,
eine Anwendung durch Einhaken Funktionalität in sie über Schließungen
und Klassen, die als Ereignisse verbunden sind verlängern.

Hier ist ein Beispiel der Befestigung und das Auslösen eines Ereignisses
mit Verschlüssen. Die zweite Funktion erhält das Ergebnis von der
ersten.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

Hier ist ein Beispiel mit einer Klasse.

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
