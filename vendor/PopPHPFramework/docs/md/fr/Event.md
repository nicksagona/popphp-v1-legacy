Pop PHP Framework
=================

Documentation : Event
---------------------

Home

La composante de l'Ã©vÃ©nement fournit un moyen d'attacher et de
dÃ©clencher des Ã©vÃ©nements dans le cycle de vie d'une application. Le
principal avantage est la possibilitÃ© d'Ã©tendre une application en
accrochant la fonctionnalitÃ© en elle par l'intermÃ©diaire des
fermetures et des classes qui sont attachÃ©s comme des Ã©vÃ©nements.

Voici un exemple d'attacher et de dÃ©clenchement d'un Ã©vÃ©nement Ã
l'aide des fermetures. Le second reÃ§oit le rÃ©sultat de la premiÃ¨re.

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
