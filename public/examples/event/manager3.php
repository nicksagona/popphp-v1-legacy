<?php

require_once '../../bootstrap.php';

use Pop\Event\Manager;

class Foo
{

    public function __construct($val = null)
    {
        if (null !== $val) {
            echo 'Hello, ' . $val . '.';
        }
    }

    public function bar($val)
    {
        echo 'How are you, ' . $val . '?';
    }

    public static function baz($val)
    {
        echo 'Goodbye, ' . $val . '.';
    }

}

try {
    $manager = new Manager();
    $manager->attach('pre', function() { return 'World'; }, 2);
    //$manager->attach('pre', array(new Foo, 'bar'), 2);
    $manager->attach('pre', 'Foo', 2);
    //$manager->attach('pre', 'Foo->bar', 2);
    //$manager->attach('pre', 'Foo::baz', 2);
    $manager->trigger('pre', array('val' => 'World'));
} catch (\Exception $e) {
    echo $e->getMessage();
}

