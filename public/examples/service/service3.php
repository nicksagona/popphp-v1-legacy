<?php

require_once '../../bootstrap.php';

use Pop\Service\Locator;

class Foo
{

    public function bar($val)
    {
        return new \Pop\Config(array('test' => $val));
    }

    public static function baz($val)
    {
        return new \Pop\Config(array('test' => $val));
    }

}

try {
    $locator = new Locator();

    // Load the services manually via the setter
    $locator->set('config1', 'Foo->bar', array(123))
            ->set('config2', 'Foo::baz', array(456));

    // Get a service
    print_r($locator->get('config1'));
    print_r($locator->get('config2'));
    print_r($locator);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
