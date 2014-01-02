Pop PHP Framework
=================

Documentation : Event
---------------------

Home

La composante de l'événement fournit un moyen d'attacher et de
déclencher des événements dans le cycle de vie d'une application. Le
principal avantage est la possibilité d'étendre une application en
accrochant la fonctionnalité en elle par l'intermédiaire des fermetures
et des classes qui sont attachés comme des événements.

Voici un exemple d'attacher et de déclenchement d'un événement à l'aide
des fermetures. Le second reçoit le résultat de la première.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

Voici un exemple en utilisant une classe.

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
