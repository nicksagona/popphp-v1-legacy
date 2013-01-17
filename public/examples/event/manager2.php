<?php

require_once '../../bootstrap.php';

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

try {
    $manager = new Manager();
    $manager->attach('pre', 'Foo::factory', 2);
    $manager->attach('pre', array(new Foo, 'bar'), 2);
    $manager->attach('pre', function($result) { echo 'Hello, ' . $result->value . '<br />' . PHP_EOL; }, 1);
    $manager->trigger('pre', array('arg' => 'World'));
} catch (\Exception $e) {
    echo $e->getMessage();
}

