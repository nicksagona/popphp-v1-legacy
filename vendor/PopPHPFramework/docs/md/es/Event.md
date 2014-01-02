Pop PHP Framework
=================

Documentation : Event
---------------------

Home

El componente de sucesos proporciona una manera de unir y activar
eventos en el ciclo de vida de una aplicación. La ventaja principal es
la capacidad de extender una aplicación enganchando funcionalidad en
ella a través de cierres y clases que se adjuntan como eventos.

He aquí un ejemplo de unión y activación de un evento mediante cierres.
La segunda recibe el resultado de la primera.

    use Pop\Event\Manager;

    $manager = new Manager();

    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);

    $manager->trigger('pre', array('name' => 'World'));

Aquí hay un ejemplo usando una clase.

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
